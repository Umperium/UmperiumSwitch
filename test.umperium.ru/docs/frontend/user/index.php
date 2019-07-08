<?php 
defined('_JEXEC') or die();

function Frontend_User_Part()
{
	global $DBH;
	global $ROUTE;
	
	/* Выход */
	if($ROUTE['controller'] == 'user'  && $ROUTE['action'] == 'logout' && $ROUTE['id'] == 'logout') {
		unset($_SESSION['user']);
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /"); 
		exit();
	}
	
	/* Вход */
	if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'auth' && $ROUTE['id'] == 'auth') {
		
		$title = 'Авторизация';
		$name = 'Авторизация';
		
		require_once(ROOT_PATH."/frontend/user/tmp/formSuccess.php");
		return false;
	}
	
	/* Регистрация */
	if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'reg' && $ROUTE['id'] == 'reg') {
		
		$title = 'Регистрация';
		$name = 'Регистрация';
		
		require_once(ROOT_PATH."/frontend/user/tmp/formSuccess.php");
		return false;
	}
	
	/* Подтверждение */
	if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'confirmation' && $ROUTE['id'] != 'confirmation') {
		
		$title = 'Подтверждение регистрации';
		$name = 'Подтверждение регистрации';
		
		require_once(ROOT_PATH."/frontend/user/tmp/formSuccess.php");
		return false;
	}
	
	/* Восстановление пароля */
	if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'recovery' && $ROUTE['id'] == 'recovery') {
		
		$title = 'Восстановление пароля';
		$name = 'Восстановление пароля';
		
		require_once(ROOT_PATH."/frontend/user/tmp/formSuccess.php");
		return false;
	}
	
	/* Восстановление пароля */
	if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'rank' && $ROUTE['id'] == 'rank') {
		
		$title = 'Ранг авторов';
		$name = 'Ранг авторов';
		
		require_once(ROOT_PATH."/frontend/user/tmp/rankSuccess.php");
		return false;
	}
	
	if($ROUTE['controller'] == 'user' && is_numeric($ROUTE['action']) && is_numeric($ROUTE['id']) ) {
		
		$title = 'Автор';
		$name = 'Автор';
		
		require_once(ROOT_PATH."/frontend/user/tmp/showSuccess.php");
		return false;
	}

	if(Frontend_User_ifAuth()) {
		
		/* Изменение профиля */
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'edit' && $ROUTE['id'] == 'edit') {

			$title = 'Изменение профиля';
			$name = 'Изменение профиля';

			require_once(ROOT_PATH."/frontend/user/tmp/listSuccess.php");
			return false;
		}
		
		/* Изменение профиля */
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'post' && $ROUTE['id'] == 'post') {

			$title = 'Моя лента';
			$name = 'Моя лента';

			require_once(ROOT_PATH."/frontend/user/tmp/listSuccess.php");
			return false;
		}
		
		/* Изменение профиля */
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'score' && $ROUTE['id'] == 'score') {

			$title = 'Мой счет';
			$name = 'Мой счет';

			require_once(ROOT_PATH."/frontend/user/tmp/listSuccess.php");
			return false;
		}
		
	} else {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /user/auth"); 
		exit();
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}

function Frontend_User_ifAuth() {
	if(isset($_SESSION['user'])) {
		global $DBH;
		
		$user = $_SESSION['user'];
		
		
		$data = array( 'email' => $user->email, 'password' => $user->password);
		$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."user WHERE email = :email AND password = :password ");
		$CHECK->execute($data);
		
		if($CHECK->fetchColumn() > 0) {	
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function Frontend_User_Auth()
{
	global $DBH;
	
	$warning = '';
	
	if(isset($_POST['auth'])) {
		
		if(isset($_POST['email']))		{$email = $_POST['email'];}
		if(isset($_POST['password']))	{$password = $_POST['password'];}

		// ВХОД
		if(!empty($password) && !empty($email)) {
			
			$data = array('email' => $email);
			$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user WHERE email = :email ");
			$CHECK->execute($data);
			
			if ($CHECK->fetchColumn() > 0) {
			
				$data = array('email' => $email);
				$RESULT = $DBH->prepare("SELECT id,email,password,salt,is_active FROM ".DB_PREFIX."user WHERE email = :email ");
				$RESULT->execute($data);
				$RESULT->setFetchMode(PDO::FETCH_ASSOC);
				$row = $RESULT->fetch();

				if($row['is_active'] == 0) {
					$warning = "Ваша почта не подтверждена, проверьте ваш почтовый ящик и подтвердите свой аккаунт";
				}
				else {
					$password = $password.$row['salt'];
					$password = hash('sha256', $password);
					$password = substr($password, 0, 192);

					if($password == $row['password']) {
						Frontend_User_Session_Update($row['id']);
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/'></head></html>";
						return false;
					} else {
						$warning = "Неверно введен пароль";
					}
				}
			} else {
				$warning = "Неверно введен e-mail";
			}
		}
	}
	require_once(ROOT_PATH."/frontend/user/tmp/_auth.php");
	return false;
}

function Frontend_User_Reg()
{
	global $DBH;


	$success = '';
	$warning = '';
	
	// РЕГИСТРАЦИЯ
	if(isset($_POST['reg'])) {

		if(isset($_POST['email']))		{$email = $_POST['email'];}
		if(isset($_POST['password']))	{$password = $_POST['password'];}
		
		$referral_id = '';
		if(isset($_SESSION['referral_id'])) {  $referral_id = $_SESSION['referral_id']; }

		$data = array('email' => $email);
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user WHERE email = :email ");
		$CHECK->execute($data);
		
		if($CHECK->fetchColumn() < 1) {
			
			$salt = uniqid(mt_rand());
			$password = $password.$salt;
			$password = hash('sha256', $password);
			$password = substr($password, 0, 192);
			

			// check agent
			$agent_id = 0;
			if (!empty($referral_id)) {
				$data = array('referral_id' => $referral_id);
				
				$RESULT_AGENT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user WHERE referral_id = :referral_id ");
				$RESULT_AGENT->execute($data);
				$RESULT_AGENT->setFetchMode(PDO::FETCH_ASSOC);
				$row_agent = $RESULT_AGENT->fetch();

				if(!empty($row_agent['id'])) {
					$agent_id = $row_agent['id'];
					
				}
			}

			$referral_id = mt_rand(100000, 999999).uniqid(mt_rand());
			$referral_id = hash('sha256', $referral_id);
			$referral_id = substr($referral_id, 0, 8);
			
			$data = array( 'email' => $email, 'password' => $password, 'salt' => $salt, 'published' => date("Y-m-d H:i:s"), 'referral_id' => $referral_id, 'agent_id' => $agent_id);

			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."user ( email, password, salt,  published, referral_id, agent_id) VALUES ( :email, :password, :salt, :published, :referral_id, :agent_id)");

			if($INSERT->execute($data)) {
				$insert_id = $DBH->lastInsertId();
				$success = "<h3>Спасибо за регистрацию</h3><p>Для активации аккаунта, пожалуйста, перейдите по ссылке в письме, отправленном на ваш адрес ".$email."</p>";
				
				$subject = "Подтверждение регистрации на сайте «" . SITE_NAME . "»";
				$body = '<html><body><h1>Поздравляем!</h1><p>
				Вы успешно зарегистрировались на сайте!<br />
				Рады видеть в нашей команде и благодарим за оказанное доверие.
				<br /><br />
				Перейдите по <a href="'.URL_FRONTEND.'/user/confirmation/'.$salt.'">ссылке</a>, чтобы подтвердить регистрацию.</p></body></html>';
				
				SimpleMail($email,'noreply@umperium.ru','«Умпериум»',$subject,$body);
				
				echo "<html><head><meta http-equiv='Refresh' content='5;URL=/user/auth'></head></html>";
			}
		} else {
			$warning = "E-mail уже зарегистрирован<br>Выберите другой e-mail";
		}
		unset($_POST['reg']);
	}

	require(ROOT_PATH."/frontend/user/tmp/_reg.php");
	return false;
}

function Frontend_User_Confirmation($salt)
{
	global $DBH;
	
	$success = '';
	$warning = '';
	
	$data = array('salt' => $salt, 'is_active' => 0 );
	$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user WHERE salt = :salt AND is_active = :is_active ");
	$CHECK->execute($data);
	if ($CHECK->fetchColumn() > 0) {
		$data = array( 'salt' => $salt, 'is_active' => 1);
		$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET is_active = :is_active WHERE salt = :salt");
		if($UPDATE->execute($data)) {	
			echo "E-mail подтвержден";
			echo "<html><head><meta http-equiv='Refresh' content='5;URL=/user/auth'></head></html>";
		}
	} else {
		echo "E-mail не подтвержден!!!";
		echo "<html><head><meta http-equiv='Refresh' content='5;URL=/user/auth'></head></html>";
	}
}

function Frontend_User_Recovery()
{
	global $DBH;
	
	$success = "";
	$warning = "";
	
	if(isset($_POST['recovery'])) {
		
		if(isset($_POST['email']))		{$email = $_POST['email'];}

		$data = array('email' => $email);
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user WHERE email = :email ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();
		
		if($row['is_active']== 0) {
			$warning = "Ваша почта не подтверждена, проверьте ваш почтовый ящик и подтвердите свой аккаунт";
		} else {
		
			if ($row['id']) {

				$salt = uniqid(mt_rand());
				$password_new = mt_rand(100000, 999999);
				$password = $password_new.$salt;
				$password = hash('sha256', $password);
				$password = substr($password, 0, 192);

				$data = array( 'password' => $password, 'salt' => $salt, 'id' => $row['id']);
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET password = :password, salt = :salt WHERE id = :id");
				if($UPDATE->execute($data)) {	
					$UPDATE = null;

					$subject = "Восстановление пароля на сайте «" . SITE_NAME . "»";
					$body = '<h1>Уважаемый пользователь</h1><p>Ваш новый пароль: <strong>'.$password_new.'</strong></p>';
					
					//echo $body;
					
					SimpleMail($email,'noreply@umperium.ru','«Умпериум»',$subject,$body);
					
					$warning = "Пароль для входа выслан на Ваш e-mail";
					echo "<html><head><meta http-equiv='Refresh' content='5;URL=/'></head></html>";
				}
			} else {
				$warning = "Неверный e-mail адрес<br>Проверьте правильность написание e-mail";
			}
		}
		
	}
	require_once(ROOT_PATH."/frontend/user/tmp/_recovery.php");
	return false;
}


function Frontend_User_Edit($tmp)
{
	global $DBH;
	
	$user = $_SESSION['user'];
	
	$warning_profile = '';
	$warning_info = '';
	$warning_image = '';
	
	if(isset($_POST['edit_profile']))	{

		if(isset($_POST['email']))			{$email = $_POST['email'];}
		
		if(isset($_POST['salt']))			{$salt = $_POST['salt'];}
		if(isset($_POST['password']))		{$password = $_POST['password'];}
		if(isset($_POST['old_password']))	{$old_password = $_POST['old_password'];}

		
		if(isset($_POST['referral_id']))			{$referral_id = $_POST['referral_id'];}
		
		if(empty($password)) { 
			$password = $old_password; 
		} else {
			$salt = uniqid(mt_rand());
			$password = $password.$salt;
			$password = hash('sha256', $password);
			$password = substr($password, 0, 192);
		}
		
		/* Проверка совпадения */
		$data = array( 'email' => $email, 'id' => $user->id );
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user WHERE email = :email AND id != :id ");
		$CHECK->execute($data);

		if($CHECK->fetchColumn() > 0) {
			$warning_profile = 'Этот E-mail занят другим пользователем';
		} else {
			if (isset($email)) {

				$data = array( 'email' => $email, 'password' => $password, 'salt' => $salt, 'referral_id' => $referral_id, 'id' => $user->id );
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET email = :email, password = :password, salt = :salt, referral_id = :referral_id WHERE id = :id");

				if($UPDATE->execute($data)) {	
					$UPDATE = null;
					Frontend_User_Session_Update($user->id);
				}
				$warning_profile = 'Информация сохранена';
			}
		}
	}
	
	if(isset($_POST['edit_info']))	{
		
		if(isset($_POST['l_name']))			{$l_name = $_POST['l_name'];}
		if(isset($_POST['f_name']))			{$f_name = $_POST['f_name'];}
		
		if(isset($_POST['sex']))			{$sex = $_POST['sex'];}
		if(isset($_POST['country_id']))		{$country_id = $_POST['country_id'];}
		if(isset($_POST['city']))			{$city = $_POST['city'];}
		
		if(isset($_POST['residence']))		{$residence = $_POST['residence'];}
		if(isset($_POST['work']))			{$work = $_POST['work'];}
		if(isset($_POST['about']))			{$about = $_POST['about'];}
		
		
		if(isset($_POST['vk']))			{$vk = $_POST['vk'];}
		if(isset($_POST['facebook']))			{$facebook = $_POST['facebook'];}
		if(isset($_POST['odnoklassniki']))			{$odnoklassniki = $_POST['odnoklassniki'];}
		if(isset($_POST['instagram']))			{$instagram = $_POST['instagram'];}
		if(isset($_POST['twitter']))			{$twitter = $_POST['twitter'];}
		
		
		if(isset($_POST['birthday']))			{$birthday = date("Y-m-d", strtotime($_POST['birthday']));}

		if (isset($l_name)) {
			
			$data = array(
				'l_name' => $l_name, 'f_name' => $f_name, 'sex' => $sex, 'country_id' => $country_id, 'city' => $city, 'residence' => $residence, 'work' => $work, 'about' => $about, 'birthday' => $birthday, 'vk' => $vk, 'facebook' => $facebook, 'odnoklassniki' => $odnoklassniki, 'instagram' => $instagram, 'twitter' => $twitter, 'id' => $user->id
			);

			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET l_name = :l_name, f_name = :f_name, sex = :sex, country_id = :country_id, city = :city, residence = :residence, work = :work, about = :about, birthday = :birthday, vk = :vk, facebook = :facebook, odnoklassniki = :odnoklassniki, instagram = :instagram, twitter = :twitter WHERE id = :id");
			
			if($UPDATE->execute($data)) {	
				$UPDATE = null;
				$warning_info = 'Информация сохранена';
				Frontend_User_Session_Update($user->id);
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
					unlink(ROOT_PATH.USER_UPLOADS.'/'.$folder.'/'.$image);
				}

				$file = substr(md5(microtime()),0, 16).'.'.$ext;
				$folder = substr($file,0, 2);

				$dir = ROOT_PATH.USER_UPLOADS.'/'.$folder;
				if(!is_dir($dir)) {
					mkdir($dir, 0755);
				}

				$uploadfile = $dir."/".$file; // директория

				if(copy($_FILES['file']['tmp_name'],$uploadfile)) {

					$data_file = array( 'image' => $file, 'id' => $user->id);
					$UPDATE_FILE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET image = :image WHERE id = :id");
					$UPDATE_FILE->execute($data_file);
					
					$warning_image = 'Картинка сохранена';
					Frontend_User_Session_Update($user->id);
					
					echo "<html><head><meta http-equiv='Refresh' content='0;URL=/user/edit'></head></html>";
				}
			}
		}
	}
	
	$data = array('id' => $user->id);

	$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user WHERE id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();
	
	$data = array('is_active' => 1);
	$RESULT_COUNTRY = $DBH->prepare("SELECT * FROM ".DB_PREFIX."country WHERE is_active = :is_active ");
	$RESULT_COUNTRY->execute($data);
	$RESULT_COUNTRY->setFetchMode(PDO::FETCH_ASSOC);

	if(empty($row['referral_id'])) {
		$referral_id = mt_rand(100000, 999999).uniqid(mt_rand());
		$referral_id = hash('sha256', $referral_id);
		$referral_id = substr($referral_id, 0, 8);
	} else {
		$referral_id = $row['referral_id'];
	}

	include(ROOT_PATH."/frontend/user/tmp/".$tmp.".php");
	$RESULT=null;
}


function Frontend_User_Show($id,$tmp)
{
	global $DBH;
	global $ROUTE;
	

	if(isset($_POST['subscribe']) && isset($_POST['id'])) {
		$subscribe = $_POST['subscribe'];
		$id = $_POST['id'];

		$data = array('subscribe_id' => $subscribe, 'user_id' => $id );
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user_subscribe WHERE subscribe_id = :subscribe_id AND user_id = :user_id ");
		$CHECK->execute($data);
		$items = $CHECK->fetchColumn();
		if($items < 1) {
			$data = array('subscribe_id' => $subscribe, 'user_id' => $id, 'published' => date("Y-m-d H:i:s"));
			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."user_subscribe ( subscribe_id, user_id, published) VALUES ( :subscribe_id, :user_id, :published)");
			$INSERT->execute($data);
		}
	}

	$data = array('id' => $id);
	
	$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."user.*, ".DB_PREFIX."country.code FROM ".DB_PREFIX."user 
	INNER JOIN ".DB_PREFIX."country ON ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id 
	WHERE ".DB_PREFIX."user.id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();

	/* Проверка совпадения */
	$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."post WHERE user_id = :id ");
	$CHECK->execute($data);
	$count_post = $CHECK->fetchColumn();
	
	$view = 0;
	$RESULT_VIEW = $DBH->prepare("SELECT * FROM ".DB_PREFIX."post WHERE user_id = :id ");
	$RESULT_VIEW->execute($data);
	$RESULT_VIEW->setFetchMode(PDO::FETCH_ASSOC);
	while($row_view = $RESULT_VIEW->fetch()) {
		$view = $view+$row_view['view'];
	}


	include(ROOT_PATH."/frontend/user/tmp/".$tmp.".php");
	$RESULT=null;
}


function Frontend_User_Post_Promo($tmp) {
	global $DBH;
	
	$user = $_SESSION['user'];
	
	try{
		$data = array('user_id' => $user->id);
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user_post_promo WHERE user_id = :user_id ");
		$CHECK->execute($data);
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$data = array('user_id' => $user->id);
			$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."user_post_promo.*, ".DB_PREFIX."post.name, ".DB_PREFIX."post.slug
			FROM ".DB_PREFIX."user_post_promo 
			INNER JOIN ".DB_PREFIX."post ON ".DB_PREFIX."post.id = ".DB_PREFIX."user_post_promo.post_id 
			WHERE ".DB_PREFIX."user_post_promo.user_id = :user_id
			ORDER BY ".DB_PREFIX."user_post_promo.published DESC LIMIT 100");
			$RESULT->execute($data);
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/frontend/user/tmp/".$tmp.".php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}


function Frontend_User_Rank($tmp) {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."user.*, ".DB_PREFIX."country.code
			FROM ".DB_PREFIX."user 
			INNER JOIN ".DB_PREFIX."country ON ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id 
			ORDER BY capital DESC LIMIT 100");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/frontend/user/tmp/".$tmp.".php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}


function Frontend_User_Session_Update($id)
{
	global $DBH;
	
	$data = array('id' => $id);

	$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user WHERE id = :id ");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	$row = $RESULT->fetch();

	$user = new stdClass();
	$user->id   	  = $row['id'];
	$user->l_name     = $row['l_name'];
	$user->f_name     = $row['f_name'];
	$user->email      = $row['email'];
	$user->login      = $row['login'];
	$user->score      = $row['score'];
	$user->password   = $row['password'];
	
	$RESULT_POST = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user_post_buy WHERE user_id =  ".$row['id']);
	$RESULT_POST->execute();
	$RESULT_POST->setFetchMode(PDO::FETCH_ASSOC);
	
	$post = array();
	while ( $row_post = $RESULT_POST->fetch() ) { 
	
		echo $row_post['post_id'];

		$post[] = $row_post['post_id'];
	}
	$user->post   = $post;

	if(empty($row['image'])) { 
		$user->image = '';
	} else {
		$user->image = USER_UPLOADS.'/'.substr($row['image'],0,2).'/'.$row['image'];
	}

	$_SESSION['user'] = $user; // храним юзера
}

?>