<?php 
// Подключение настроек сайта
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php");

if(isset($_SESSION['online'])) {
	if(strtotime("-1 minutes") > $_SESSION['online']) {
		$_SESSION['online'] = time();
		Frontend_Cron_Post_Update();
	}
} else {
	$_SESSION['online'] = time();
}



switch ($ROUTE['controller'])
{  
	case '':
		Frontend_Page_Part();
	break;
	case 'user':
		Frontend_User_Part();          
	break;
	case 'post':
		Frontend_Post_Part();          
	break;
	case 'comment':
		Frontend_Comment_Part();          
	break;
	case 'trend':
		Frontend_Trend_Part();          
	break;
	case 'tag':
		Frontend_Tag_Part();          
	break;
	case 'cron':
		Frontend_Cron_Part();          
	break;
	case 'group':
		Frontend_Group_Part();          
	break;
	default:
		Frontend_Page_Part();          
}
?>