<?php 



session_start();
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

// Системные переменные
define( '_JEXEC', 1 );
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);

define('URL_FRONTEND', 'http://'.$_SERVER['HTTP_HOST']);
define('URL_BACKEND', 'http://'.$_SERVER['HTTP_HOST'].'/backend');

define('FRONTEND_PATH', URL_FRONTEND.'/assets');
define('BACKEND_PATH', URL_BACKEND.'/style');
define('PLUGINS_PATH', URL_FRONTEND.'/plugins');


if(isset($_GET['referral'])) {
	$_SESSION['referral_id'] = $_GET['referral'];
}

// UPLOADS DIR
define('SETTING_UPLOADS', '/uploads/setting');

define('POST_UPLOADS', '/uploads/post');
define('USER_UPLOADS', '/uploads/user');
define('GROUP_UPLOADS', '/uploads/group');

// DB
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PREFIX', 'grid_');
define('DB_NAME', 'h811183702_test');
define('DB_USER', 'h811183702_test');
define('DB_PASS', 'ADr5J-nW');
define('DB_ENCODE', 'UTF8');

define('CODEPAGE', 'utf-8');
define('COPYRING', 'PIXELATION.RU GRID');
define('SITE_NAME', 'Умпериум');
define('SITE_MAIL', 'leon-pro@mail.ru');

// CONNECT BD
try {  
	# MySQL через PDO_MYSQL  
	$DBH = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);  
	$DBH->exec("SET NAMES ".DB_ENCODE);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
}  
catch(PDOException $e) {  
	echo $e->getMessage();  
}

// SETTINGS
/*
global $DBH;
$RESULT = $DBH->query("SELECT * FROM ".DB_PREFIX."setting");
$RESULT->setFetchMode(PDO::FETCH_ASSOC);
while($row = $RESULT->fetch()) {
	if($row['slug'] == 'header') { define('HEADER', $row['value']);}
	if($row['slug'] == 'footer') { define('FOOTER', $row['value']);}
}
*/
include_once ($_SERVER['DOCUMENT_ROOT']."/function.php");
$ROUTE = Route();

include_once (ROOT_PATH."/frontend/page/index.php");
include_once (ROOT_PATH."/frontend/user/index.php");
include_once (ROOT_PATH."/frontend/post/index.php");
include_once (ROOT_PATH."/frontend/comment/index.php");
include_once (ROOT_PATH."/frontend/trend/index.php");
include_once (ROOT_PATH."/frontend/tag/index.php");
include_once (ROOT_PATH."/frontend/cron/index.php");
include_once (ROOT_PATH."/frontend/group/index.php");
?>