<?php

$publ_link = preg_replace("~(.*?)\?page=\d+$~", '$1', $_SERVER['REQUEST_URI']);

$href = '';
foreach($_GET as $key => $value) {
  if($key!='page') {
	$href.= '&'.$key.'='.$value;
  }
}

// Проверяем нужны ли стрелки назад
$pervpage = '<li><a title="Предыдущая" href="?page='.($page - 1).$href.' ">Предыдущая</a></li>';

// Проверяем нужны ли стрелки вперед
$nextpage = '<li><a title="Следующая" href="?page='.($page + 1).$href.' ">Следующая</a></li>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = '<li><a href="?page='.($page - 5).$href.' ">'.($page - 5).'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="?page='.($page - 4).$href.' ">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="?page='.($page - 3).$href.' ">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="?page='.($page - 2).$href.' ">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="?page='.($page - 1).$href.' ">'.($page - 1).'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="?page='.($page + 5).$href.' ">'.($page + 5).'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="?page='.($page + 4).$href.' ">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="?page='.($page + 3).$href.' ">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="?page='.($page + 2).$href.' ">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="?page='.($page + 1).$href.' ">'.($page + 1).'</a></li>';

// Вывод меню если страниц больше одной
if ($total > 1)
{
Error_Reporting(E_ALL & ~E_NOTICE);
echo '<div class="pager"><ul>';
echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<li><span>'.$page.'</span></li>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
echo '</ul></div>';
}

?>