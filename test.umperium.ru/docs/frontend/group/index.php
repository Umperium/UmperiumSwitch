<?php 
defined('_JEXEC') or die();

function Frontend_Group_Part()
{
	global $DBH;
	global $ROUTE;
	
	if($ROUTE['controller'] == 'group' && empty($ROUTE['action']) ) {

		$title = 'Группы';
		$name = 'Группы';

		require_once(ROOT_PATH."/frontend/group/tmp/formSuccess.php");
		return false;
	}

	
	/* Регистрация */
	if($ROUTE['controller'] == 'group' && is_numeric($ROUTE['action'])) {

		$title = 'Группа';
		$name = 'Группа';

		require_once(ROOT_PATH."/frontend/group/tmp/showSuccess.php");
		return false;
	}

	if(Frontend_User_ifAuth()) {
		
		/* Регистрация */
		if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'add' && $ROUTE['id'] == 'add') {

			$title = 'Добавить';
			$name = 'Добавить';

			require_once(ROOT_PATH."/frontend/group/tmp/listSuccess.php");
			return false;
		}
		
		/* Изменение профиля */
		if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'edit' && is_numeric($ROUTE['id'])) {

			$title = 'Изменение профиля';
			$name = 'Изменение профиля';

			require_once(ROOT_PATH."/frontend/group/tmp/listSuccess.php");
			return false;
		}
		
		/* Изменение профиля */
		if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'post' && $ROUTE['id'] == 'post') {

			$title = 'Моя лента';
			$name = 'Моя лента';

			require_once(ROOT_PATH."/frontend/group/tmp/listSuccess.php");
			return false;
		}
		
	} else {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /group/auth"); 
		exit();
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}


function Frontend_Group_Add()
{
	global $DBH;


	$success = '';
	$warning = '';
	
	// РЕГИСТРАЦИЯ
	if(isset($_POST['add'])) {

		if(isset($_POST['name']))		{$name = $_POST['name'];}
			
		$data = array( 'name' => $name);

		$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."group ( name ) VALUES ( :name )");

		if($INSERT->execute($data)) {
			$insert_id = $DBH->lastInsertId();
			
			
			$data = array('subscribe_id' => $_SESSION['user']->id, 'group_id' => $insert_id, 'published' => date("Y-m-d H:i:s"), 'role'=>0);
			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."group_subscribe ( subscribe_id, group_id, published, role) VALUES ( :subscribe_id, :group_id, :published, :role)");
			$INSERT->execute($data);
			
			echo "<html><head><meta http-equiv='Refresh' content='0;URL=/group/".$insert_id."'></head></html>";
		}

		unset($_POST['add']);
	}

	require(ROOT_PATH."/frontend/group/tmp/_add.php");
	return false;
}

function Frontend_Group_Edit($id,$tmp)
{
	global $DBH;
	
	$group = $_SESSION['group'];
	
	$warning_profile = '';
	$warning_info = '';
	$warning_image = '';
	
	if(isset($_POST['edit_info']))	{
		
		if(isset($_POST['name']))		{$name = $_POST['name'];}

		if (isset($name)) {
			
			$data = array('name' => $name, 'id' => $id);
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."group SET name = :name WHERE id = :id");
			
			if($UPDATE->execute($data)) {	
				$UPDATE = null;
				$warning_info = 'Информация сохранена';
			}
		}
	}
	
	if(isset($_POST['edit_image']))	{
		
		if(isset($_POST['image'])) 			{$image = $_POST['image'];}
		
		/* ЗАГРУЗКА ФАЙЛА */
		if(isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {

			$max_file_size = 4;
			$ini_max = str_replace('M', '', ini_get('post_max_size'));
			$upload_max = $ini_max * 1024 * 1024;

			$filetype = array('png','jpg','gif','jpeg','svg');
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

			if(!in_array(strtolower($ext), $filetype)) {
				$warning[] = 'Неверное расширение файла '.$_FILES['file']['name'];
			} elseif (!is_uploaded_file($_FILES['file']['tmp_name'])) {
				$warning[] = 'Нет загруженных файлов';
			} elseif ($_FILES['file']['size'] > $upload_max) {
				$warning[] = "Размер файла превышает $ini_max Mb в php.ini";
			} elseif ($_FILES['file']['size'] > $max_file_size * 1024 * 1024) {
				$warning[] = "Размер файла превышает $max_file_size Mb";
			} else {

				// удаляем старый файл
				if(!empty($image)) {
					$folder = substr($image,0, 2);
					unlink(ROOT_PATH.GROUP_UPLOADS.'/'.$folder.'/'.$image);
				}

				$file = substr(md5(microtime()),0, 16).'.'.$ext;
				$folder = substr($file,0, 2);

				$dir = ROOT_PATH.GROUP_UPLOADS.'/'.$folder;
				if(!is_dir($dir)) {
					mkdir($dir, 0755);
				}

				$uploadfile = $dir."/".$file; // директория

				if(copy($_FILES['file']['tmp_name'],$uploadfile)) {

					$data_file = array( 'image' => $file, 'id' => $id);
					$UPDATE_FILE = $DBH->prepare("UPDATE ".DB_PREFIX."group SET image = :image WHERE id = :id");
					$UPDATE_FILE->execute($data_file);
					
					$warning_image = 'Картинка сохранена';
					
					echo "<html><head><meta http-equiv='Refresh' content='0;URL=/group/edit/".$id."'></head></html>";
				}
			}
		}
	}
	
	$data = array('id' => $id);

	$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."group WHERE id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();
	
	include(ROOT_PATH."/frontend/group/tmp/".$tmp.".php");
	$RESULT=null;
}




function Frontend_Group_List($tmp,$count,$pager=false)
{
	global $DBH;

	if(empty($count))	    {$count = 10;}
	if(empty($tmp))		    {$tmp = 'list';}
	

	$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."group ");
	$CHECK->execute();
	$items = $CHECK->fetchColumn();	
	if ($items > 0) {
		if(isset($_GET['page'])) {$page  = $_GET['page']; } else { $page = 0;}
		$total = (($items - 1) / $count) + 1;
		$total =  intval($total);
		// Определяем начало сообщений для текущей страницы
		$page = intval($page);
		// Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
		if(empty($page) or $page < 0) $page = 1;
		if($page > $total) $page = $total;
		// Вычисляем начиная с какого номера следует выводить сообщения
		$start = $page * $count - $count;

		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."group LIMIT $start, $count");
		$RESULT->execute();
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	}
	

	if ($items > 0) {
		include(ROOT_PATH."/frontend/group/tmp/".$tmp.".php");
		if($pager) { include(ROOT_PATH."/frontend/includes/pager.php"); }
	}
}



function Frontend_Group_Show($id,$tmp)
{
	global $DBH;
	global $ROUTE;
	

	if(isset($_POST['subscribe']) && isset($_POST['id'])) {
		$subscribe = $_POST['subscribe'];
		$id = $_POST['id'];

		$data = array('subscribe_id' => $subscribe, 'group_id' => $id );
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."group_subscribe WHERE subscribe_id = :subscribe_id AND group_id = :group_id ");
		$CHECK->execute($data);
		$items = $CHECK->fetchColumn();
		if($items < 1) {
			$data = array('subscribe_id' => $subscribe, 'group_id' => $id, 'published' => date("Y-m-d H:i:s"), 'role'=>1);
			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."group_subscribe ( subscribe_id, group_id, published, role) VALUES ( :subscribe_id, :group_id, :published, :role)");
			$INSERT->execute($data);
		}
	}

	$data = array('id' => $id);

	
	$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."group WHERE ".DB_PREFIX."group.id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();

	/* Проверка совпадения */
	$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."post WHERE group_id = :id ");
	$CHECK->execute($data);
	$count_post = $CHECK->fetchColumn();
	
	$view = 0;
	$RESULT_VIEW = $DBH->prepare("SELECT * FROM ".DB_PREFIX."post WHERE group_id = :id ");
	$RESULT_VIEW->execute($data);
	$RESULT_VIEW->setFetchMode(PDO::FETCH_ASSOC);
	while($row_view = $RESULT_VIEW->fetch()) {
		$view = $view+$row_view['view'];
	}
	
	
	$data = array('id' => $id, 'role' => 0);
	$RESULT_SUBSCRIBE = $DBH->prepare("SELECT * FROM ".DB_PREFIX."group_subscribe WHERE group_id = :id AND role = :role ");
	$RESULT_SUBSCRIBE->execute($data);
	$RESULT_SUBSCRIBE->setFetchMode(PDO::FETCH_ASSOC);
	$array_subscribe = array();
	while($row_sub = $RESULT_SUBSCRIBE->fetch()) {
		$array_subscribe[] = $row_sub['subscribe_id'];
	}
	

	include(ROOT_PATH."/frontend/group/tmp/".$tmp.".php");
	$RESULT=null;
}

?>