<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/backend/lock.php");

function Backend_Setting_Route() {
	try{
		$title = "Настройки";
		
		if(isset($_GET['action'])) { 
			$action = $_GET['action']; 
			if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

			switch ($action) {
				case 'edit':
					$name = "Редактировать";
					$breadcrumbs = '<a href="/backend/setting">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/setting/tmp/showSuccess.php");
					return false;
				break;
			}
		} else { 
			$name = "";
			$breadcrumbs = '<a href="/backend/setting">'.$title.'</a>';

			require_once(ROOT_PATH."/backend/setting/tmp/showSuccess.php");
			return false;
		}
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /404"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Список */
function Backend_Setting_List() {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."setting");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."setting");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/backend/setting/tmp/_list.php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Редактирование */
function Backend_Setting_Edit($id) {
	global $DBH;
	
	try{
		$warning = '';
		
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {
			
			if(isset($_POST['type']))			{ $type = $_POST['type']; }
			if(isset($_POST['slug']))			{ $slug = $_POST['slug']; }
			if(isset($_POST['value_old']))		{ $value_old = $_POST['value_old']; }
			
			if($type=='text' || $type=='textarea' || $type=='number') {
				if(isset($_POST['value']))			{ $value = $_POST['value']; }
			}
			if($type=='boolean') {
				if(isset($_POST['value']))			{ $value = $_POST['value'];}   else { $value=0; }
			}
			if($type=='file') {
				$uploaddir = ROOT_PATH.SETTING_UPLOADS;
				
				if(isset($_FILES['value']['tmp_name'])) {
					unlink($uploaddir.'/'.$value_old);
					$ext = pathinfo($_FILES['value']['name'], PATHINFO_EXTENSION);
					$value = $slug.".".$ext;
					$uploadfile = $uploaddir."/".$value; // дирректория
					copy($_FILES['value']['tmp_name'],$uploadfile);
				}
			}
			
			$data = array( 'value' => $value, 'id' => $id);
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."setting SET value = :value WHERE id = :id");

			if($UPDATE->execute($data)) {	
				$UPDATE = null;
				
				$warning = 'Запись обновлена';
				
				switch ($save) {
					case 3:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/setting'></head></html>";
						return false;
					break;
				}
			}
		}

		$data = array( 'id' => $id); 
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."setting WHERE id = :id ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();
		
		require_once(ROOT_PATH."/backend/setting/tmp/_edit.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

Backend_Setting_Route();
?>