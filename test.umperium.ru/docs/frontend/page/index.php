<?php 
defined('_JEXEC') or die();

function Frontend_Page_Part() {
	global $DBH;
	global $ROUTE;

	$data = array('slug' => $ROUTE['id'], 'is_active' => 1);

	$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."page WHERE slug = :slug AND is_active = :is_active ");
	$CHECK->execute($data);

	if ($CHECK->fetchColumn() > 0) {

		$data = array('slug' => $ROUTE['id'], 'is_active' => 1);
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."page WHERE slug = :slug AND is_active = :is_active");
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);   
		$RESULT->execute($data);
		$row = $RESULT->fetch();

		$name = $row['name'];
		$title = $row['title'];
		$keywords = $row['keywords'];
		$description = $row['description'];
		$content = $row['content'];
		$pageId = $row['id'];
		$tmp = $row['tmp'];

		require_once(ROOT_PATH."/frontend/page/tmp/".$tmp.".php");
		return false;

		$RESULT = null;
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}
?>