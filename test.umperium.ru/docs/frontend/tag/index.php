<?php 
defined('_JEXEC') or die();

function Frontend_Tag_Part()
{
	global $DBH;
	global $ROUTE;

	/* Показать */
	if($ROUTE['controller'] == 'tag' ) {
			
		$name = $_GET['name'];
		
		$data = array('name' => $name);
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."tag WHERE name = :name ");
		$CHECK->execute($data);
		
		if ($CHECK->fetchColumn() > 0) {
			
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."tag WHERE name = :name ");
			$RESULT->execute($data);
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);
			$row = $RESULT->fetch();

			
			$title = 'Тег: '.$row['name'];
			$name = 'Тег: '.$row['name'];
			$id = $row['id'];

			require_once(ROOT_PATH."/frontend/tag/tmp/showSuccess.php");
			return false;
		}
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}


function Frontend_Tag_Post_List($pageId,$tmp,$count,$pager=false)
{
	global $DBH;

	if(empty($count))	    {$count = 10;}
	if(empty($tmp))		    {$tmp = 'list';}

	$data = array('id' => $pageId);
	$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."post 
	INNER JOIN ".DB_PREFIX."post_tag ON ".DB_PREFIX."post_tag.post_id = ".DB_PREFIX."post.id 
	WHERE ".DB_PREFIX."post_tag.tag_id = :id ");
	$CHECK->execute($data);
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

		$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."post.*, ".DB_PREFIX."user.l_name, ".DB_PREFIX."user.f_name, ".DB_PREFIX."user.image AS user_image, ".DB_PREFIX."country.code  
		FROM ".DB_PREFIX."post 
		INNER JOIN ".DB_PREFIX."user ON ".DB_PREFIX."user.id = ".DB_PREFIX."post .user_id 
		INNER JOIN ".DB_PREFIX."country ON ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id 
		INNER JOIN ".DB_PREFIX."post_tag ON ".DB_PREFIX."post_tag.post_id = ".DB_PREFIX."post.id 
		WHERE ".DB_PREFIX."post_tag.tag_id = :id
		ORDER BY ".DB_PREFIX."post.published LIMIT $start, $count");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	}

	if ($items > 0) {
		include(ROOT_PATH."/frontend/tag/tmp/".$tmp.".php");
		if($pager) { include(ROOT_PATH."/frontend/includes/pager.php"); }
	}

}


?>