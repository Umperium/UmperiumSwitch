<?php 
defined('_JEXEC') or die();

function Frontend_Trend_Part()
{
	global $DBH;
	global $ROUTE;

	/* Показать */
	if($ROUTE['controller'] == 'trend' && $ROUTE['action'] == $ROUTE['id']) {
			
		$data = array('slug' => $ROUTE['id'], 'is_active' => 1);
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."trend WHERE slug = :slug AND is_active = :is_active ");
		$CHECK->execute($data);
		
		if ($CHECK->fetchColumn() > 0) {
			
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."trend WHERE slug = :slug AND is_active = :is_active ");
			$RESULT->execute($data);
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);
			$row = $RESULT->fetch();
			
			$trend = $row['name'];
			
			$title = 'В тренде '.$row['name'];
			$name = 'В тренде '.$row['name'];
			$id = $row['id'];

			require_once(ROOT_PATH."/frontend/trend/tmp/showSuccess.php");
			return false;
		}
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}




function Frontend_Trend_List($tmp,$count)
{
	global $DBH;

	if(empty($count))	    {$count = 10;}
	if(empty($tmp))		    {$tmp = 'list';}
	
	$date = date("Y-m-d H:i:s");
	
	$data = array('date_from' => $date, 'date_to' => $date, 'is_active' => 1);
	$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."trend WHERE date_from < :date_from AND date_to > :date_to AND is_active = :is_active");
	$CHECK->execute($data);
	$items = $CHECK->fetchColumn();	
	if ($items > 0) {
		
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."trend WHERE date_from < :date_from AND date_to > :date_to AND is_active = :is_active ORDER BY sort ASC LIMIT $count");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	}
	

	if ($items > 0) {
		include(ROOT_PATH."/frontend/trend/tmp/".$tmp.".php");
	}

}


function Frontend_Trend_Post_List($q,$tmp,$count,$pager=false)
{
	global $DBH;

	if(empty($count))	    {$count = 10;}
	if(empty($tmp))		    {$tmp = 'list';}
	
	
	require_once(ROOT_PATH."/classes/LinguaStemRu.php");
	
	$stemmer = new LinguaStemRu();
	$stem_str=$stemmer->stem_word($q);
	
	$search_req = " AND ( ";
	$search_array = explode(" ", $stem_str);
	
	$search_str=preg_replace("/[^а-яА-Яa-zA-z0-9\-]/ui","%",$stem_str); //заменяем все знаки кроме цифр и букв на % (любое кол-во любых символов)

	// массив колонок по которым ищем и их коэффицент релевантности
	$search_columns=array(
	  DB_PREFIX."post.name" =>'40',
	  DB_PREFIX."post.content"=>'60'
	);

	$select =", ( 0";
	$search_req_arr=array();

	
	foreach($search_columns as $col=>$coeff) {
	  // полнотекстовый
	  $select.= " + IF ($col LIKE '".$search_str."', $coeff*3, 0)";
	  $search_req_arr[]= " $col LIKE '%".$search_str."%'";

	  // для отдельного слова
	  $word_coeff=round(($coeff/count($search_array)),2);

	  foreach($search_array as $word) {
		$select .= "+ IF ($col LIKE '%".$word."%', ".$word_coeff.", 0)";
		$search_req_arr[] = "$col LIKE '%".$word."%'";
	  }
	}
	$select.=") AS `relevant`";
	$search_req .=implode(" OR ",$search_req_arr);
	$search_req .= ")";


	$search_req = ' AND ( '.DB_PREFIX.'post.name LIKE "%'.$q.'%" OR  '.DB_PREFIX.'post.content LIKE "%'.$q.'%"  )';


	$CHECK = $DBH->prepare("SELECT count(*)  FROM ".DB_PREFIX."post WHERE 1 $search_req ");
	$CHECK->execute();
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
		WHERE 1 $search_req
		ORDER BY ".DB_PREFIX."post.published LIMIT $start, $count");
		$RESULT->execute();
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	}

	if ($items > 0) {
		include(ROOT_PATH."/frontend/trend/tmp/".$tmp.".php");
		if($pager) { include(ROOT_PATH."/frontend/includes/pager.php"); }
	}

}


?>