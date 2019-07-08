<?php
$publ_link = preg_replace("~(.*?)\?page=\d+$~", '$1', $_SERVER['REQUEST_URI']);
$href = '';
foreach($_GET as $key => $value) {
  if($key!='page') {
	$href.= '&'.$key.'='.$value;
  }
}
$nextpage = '<a class="more" href="?page='.($page + 1).$href.' ">Еще</a>';
// Вывод меню если страниц больше одной
if ($page < $total ) {
	echo $nextpage;
}

?>