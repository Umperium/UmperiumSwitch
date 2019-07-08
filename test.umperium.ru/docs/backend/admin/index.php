<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php"); 
include_once ($_SERVER['DOCUMENT_ROOT']."/backend/lock.php");

function Backend_Admin_Route() {
	try{
		$title = "Администраторы";
		
		if(isset($_GET['action'])) { 
			$action = $_GET['action']; 
			if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

			switch ($action) {
				case 'add':	
					$name = "Добавить";
					$breadcrumbs = '<a href="/backend/admin">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';
					
					require_once(ROOT_PATH."/backend/admin/tmp/showSuccess.php");
					return false;
				break;
				case 'edit':
					$name = "Редактировать";
					$breadcrumbs = '<a href="/backend/admin">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/admin/tmp/showSuccess.php");
					return false;
				break;
				case 'delete':
					Backend_Admin_Delete($id);
					return false;
				break;
				case 'is_active':	
					Backend_Admin_Active($id);
					return false;
				break;
			}
		} else { 
			$name = "";
			$breadcrumbs = '<a href="/backend/admin">'.$title.'</a>';
			
			require_once(ROOT_PATH."/backend/admin/tmp/showSuccess.php");
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
function Backend_Admin_List() {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."admin");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."admin");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/backend/admin/tmp/_list.php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Добавление */
function Backend_Admin_Add() {
	global $DBH;
	
	try{
		$warning = '';
	
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_add']))   { $save = 2; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {

			if(isset($_POST['email']))		{ $email = $_POST['email']; }
			if(isset($_POST['name']))		{ $name = $_POST['name']; }

			if(isset($_POST['login']))		{ $login = $_POST['login']; }
			if(isset($_POST['password']))	{ $password = $_POST['password']; }

			$salt = uniqid(mt_rand());
			$password = $password.$salt;
			$password = hash('sha256', $password);
			$password = substr($password, 0, 192);
			
			/* Проверка совпадения */
			$data = array( 'login' => $login, 'email' => $email );
			$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."admin WHERE login = :login OR email = :email ");
			$CHECK->execute($data);
			$items = $CHECK->fetchColumn();
			
			if($items > 0) {
				$warning = 'Данный логин или e-mail уже используются другим пользователем.';
			} else {
				$data = array( 'email' => $email, 'name' => $name, 'login' => $login, 'password' => $password, 'salt' => $salt, 'published' => date("Y-m-d H:i:s")); 
				$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."admin (email, name, login, password, salt, published) VALUES (:email, :name, :login, :password, :salt, :published)");

				if($INSERT->execute($data)) {
					$insert_id = $DBH->lastInsertId();
					
					$warning = 'Запись сохранена';

					switch ($save) {
						case 1:
							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/admin?action=egit&=".$insert_id."'></head></html>";
							return false;
						break;
						case 2:
							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/admin?action=add'></head></html>";
							return false;
						break;
						case 3:
							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/admin'></head></html>";
							return false;
						break;
					}
				}
			}
		}

		require_once(ROOT_PATH."/backend/admin/tmp/_add.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Редактирование */
function Backend_Admin_Edit($id) {
	global $DBH;
	
	try{
		$warning = '';
		
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_add']))   { $save = 2; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {

			if(isset($_POST['email']))			{ $email = $_POST['email']; }
			if(isset($_POST['name']))			{ $name = $_POST['name']; }

			if(isset($_POST['login']))			{ $login = $_POST['login']; }
			if(isset($_POST['salt']))			{ $salt = $_POST['salt'];}
			if(isset($_POST['password']))		{ $password = $_POST['password'];}
			if(isset($_POST['old_password']))	{ $old_password = $_POST['old_password'];}

			if(empty($password)) { 
				$password = $old_password; 
			} else {
				$salt = uniqid(mt_rand());
				$password = $password.$salt;
				$password = hash('sha256', $password);
				$password = substr($password, 0, 192);
			}
			
			/* Проверка совпадения */
			$data = array( 'login' => $login, 'email' => $email, 'id' => $id );
			$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."admin WHERE ( login = :login OR email = :email ) AND id != :id");
			$CHECK->execute($data);
			$items = $CHECK->fetchColumn();
			
			if($items > 0) {
				$warning = 'Данный логин или e-mail уже используются другим пользователем.';
			} else {

				$data = array( 'email' => $email, 'name' => $name, 'login' => $login, 'password' => $password, 'salt' => $salt, 'id' => $id); 
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."admin SET email = :email, name = :name, login = :login, password = :password, salt = :salt WHERE id = :id");

				if($UPDATE->execute($data)) {	
					$UPDATE = null;
					
					$warning = 'Запись обновлена';
					
					Backend_Admin_Update($id);
					
					switch ($save) {
						case 2:
							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/admin?action=add'></head></html>";
							return false;
						break;
						case 3:
							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/admin'></head></html>";
							return false;
						break;
					}
				}
			}
		}

		$data = array( 'id' => $id); 
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."admin WHERE id = :id ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();

		require_once(ROOT_PATH."/backend/admin/tmp/_edit.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Удаление */
function Backend_Admin_Delete($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."admin WHERE id = :id ");
		$DELETE->execute($data);
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/admin"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Активирование */
function Backend_Admin_Active($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		
		$RESULT = $DBH->prepare("SELECT is_active FROM ".DB_PREFIX."admin WHERE id = :id");
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);   
		$RESULT->execute($data);
		$row = $RESULT->fetch();
		
		if ($row['is_active'] == 1) {
			$data = array( 'id' => $id, 'is_active' => 0 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."admin SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		
		if ($row['is_active'] == 0) {
			$data = array( 'id' => $id, 'is_active' => 1 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."admin SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/admin"); 
		exit();
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

Backend_Admin_Route();
?>