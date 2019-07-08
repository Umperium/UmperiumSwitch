<?php 
if(isset($_GET['logout'])) { 
	unset($_SESSION['admin']); 
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /backend"); 
	exit();
}

function Backend_Admin_Auth() {
	global $DBH;
	
	try{
	
		$warning = '';

		if(isset($_POST['auth'])) {

			if(isset($_POST['login']))		{$login = $_POST['login'];}
			if(isset($_POST['password']))	{$password = $_POST['password'];}

			// ВХОД
			if(!empty($password) && !empty($login)) {

				$data = array('login' => $login);
				$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."admin WHERE login = :login ");
				$RESULT->execute($data);
				$RESULT->setFetchMode(PDO::FETCH_ASSOC);
				$row = $RESULT->fetch();

				if(!empty($row['id']) && $row['is_active'] == 0) {
					$warning = "Ваша аккаунт не подтвержден";
				}
				else {
					if (empty($row['id'])) {
						$warning = "Неверно введен логин";
					} else {
						$password = $password.$row['salt'];
						$password = hash('sha256', $password);
						$password = substr($password, 0, 192);

						if($password == $row['password']) {

							Backend_Admin_Update($row['id']);

							echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/setting'></head></html>";
							return false;
						} else {
							$warning = "Неверный логин или пароль";
						}
					}
				}
			}
		}
		
		require_once(ROOT_PATH."/backend/admin/tmp/_auth.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

function Backend_Admin_ifAuth() {
	global $DBH;
	try{
		if(isset($_SESSION['admin'])) {
			$user = $_SESSION['admin'];
			
			$data = array( 'login' => $user->login, 'password' => $user->password, 'is_active' => 1);
			$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."admin WHERE login = :login AND password = :password AND is_active = :is_active ");
			$CHECK->execute($data);
			$items = $CHECK->fetchColumn();	
			if($items > 0) {	
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

function Backend_Admin_Update($id) {
	global $DBH;
	
	$data = array('id' => $id);

	$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."admin WHERE id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();

	$admin = new stdClass();
	$admin->id			= $row['id'];
	$admin->email		= $row['email'];
	$admin->name		= $row['name'];
	$admin->login		= $row['login'];
	$admin->password	= $row['password'];
	$admin->image		= '';

	$_SESSION['admin'] = $admin;
}

if(Backend_Admin_ifAuth() == false) {
	$title = "Авторизация";
	$name = "Авторизация";
	require_once(ROOT_PATH."/backend/admin/tmp/authSuccess.php");
	die();
}

?>