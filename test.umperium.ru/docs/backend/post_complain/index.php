<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/backend/lock.php");

function Backend_Post_Complain_Route() {
	try{
		$title = "Тренды";
		
		if(isset($_GET['action'])) { 
			$action = $_GET['action']; 
			if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

			switch ($action) {
				case 'add':	
					$name = "Добавить";
					$breadcrumbs = '<a href="/backend/post_complain">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/post_complain/tmp/showSuccess.php");
					return false;
				break;
				case 'edit':
					$name = "Редактировать";
					$breadcrumbs = '<a href="/backend/post_complain">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/post_complain/tmp/showSuccess.php");
					return false;
				break;
				case 'sort':
					$name = "Сортировать";
					$breadcrumbs = '<a href="/backend/post_complain">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/post_complain/tmp/showSuccess.php");
					return false;
				break;
				case 'delete':
					Backend_Post_Complain_Delete($id);
					return false;
				break;
				case 'is_active':	
					Backend_Post_Complain_Active($id);
					return false;
				break;
			}
		} else { 
			$name = "";
			$breadcrumbs = '<a href="/backend/post_complain">'.$title.'</a>';

			require_once(ROOT_PATH."/backend/post_complain/tmp/showSuccess.php");
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
function Backend_Post_Complain_List() {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."post_complain");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."post_complain.*, ".DB_PREFIX."post.name, ".DB_PREFIX."user.l_name, ".DB_PREFIX."user.f_name FROM ".DB_PREFIX."post_complain 
			LEFT JOIN ".DB_PREFIX."post ON ".DB_PREFIX."post.id = ".DB_PREFIX."post_complain.post_id
			LEFT JOIN ".DB_PREFIX."user ON ".DB_PREFIX."user.id = ".DB_PREFIX."post_complain.user_id
			ORDER BY ".DB_PREFIX."post_complain.published ASC");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/backend/post_complain/tmp/_list.php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}


/* Удаление */
function Backend_Post_Complain_Delete($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."post_complain WHERE id = :id ");
		$DELETE->execute($data);
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/post_complain"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Активирование */


Backend_Post_Complain_Route();
?>