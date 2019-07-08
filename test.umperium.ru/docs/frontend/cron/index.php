<?php 
defined('_JEXEC') or die();

function Frontend_Cron_Part()
{
	global $DBH;
	global $ROUTE;

	if($ROUTE['controller'] == 'cron' && $ROUTE['action'] == 'post' && $ROUTE['id'] == 'update') {
		Frontend_Cron_Post_Update();
		die();
	}

	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}

function Frontend_Cron_Post_Update()
{
	global $DBH;

	$promo_to = date("Y-m-d H:i:s");

	$data = array( 'promo_to' => $promo_to, 'is_promo' => 1 );
	$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."post WHERE promo_to < :promo_to AND is_promo = :is_promo ");
	$CHECK->execute($data);
	
	if ($CHECK->fetchColumn() > 0) {
		$data = array( 'promo_to' => $promo_to, 'is_promo' => 0 );
		$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."post SET is_promo = :is_promo WHERE promo_to < :promo_to");
		$UPDATE->execute($data);
	}
	
}
?>