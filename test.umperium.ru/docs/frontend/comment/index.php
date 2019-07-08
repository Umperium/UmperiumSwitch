<?php 
defined('_JEXEC') or die();

function Frontend_Comment_Part()
{
	global $DBH;
	global $ROUTE;
	
	if($ROUTE['controller'] == 'comment' && $ROUTE['id'] == 'power') {
		if(Frontend_User_ifAuth()) {
			Frontend_Comment_Power();
			die();
		} else {
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /user/auth"); 
			exit();
		}
	}
	
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: /404"); 
	exit();
}



function Frontend_Comment_Add($id,$reply_id,$tmp)
{
	global $DBH;
	
	if(isset($_SESSION['user'])) {
		$user = $_SESSION['user'];

		$warning = '';
		
		if(isset($_POST['add_comment']))	{

			if(isset($_POST['comment']))			{$comment = $_POST['comment'];}
			if(isset($_POST['reply_id']))			{$reply_id = $_POST['reply_id'];}
			$data = array( 'comment' => $comment, 'post_id' => $id, 'reply_id' => $reply_id, 'user_id' => $user->id, 'published' => date("Y-m-d H:i:s"));
			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."comment ( comment, post_id, reply_id, user_id, published) VALUES ( :comment, :post_id, :reply_id, :user_id, :published)");
			if($INSERT->execute($data)) {
				
				$data = array( 'post_id' => $id);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment WHERE post_id = :post_id ");
				$CHECK->execute($data);
				$items = $CHECK->fetchColumn();

				$data = array( 'id' => $id, 'comment' => $items);
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."post SET comment = :comment WHERE id = :id");
				$UPDATE->execute($data);
				



				$data = array( 'user_id' => $user->id);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment WHERE user_id = :user_id ");
				$CHECK->execute($data);
				$items = $CHECK->fetchColumn();
				
				$data = array( 'id' => $user->id, 'comment' => $items);
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET comment = :comment WHERE id = :id ");
				$UPDATE->execute($data);

				$warning = 'Комментарий добавлен';
				$insert_id = $DBH->lastInsertId();
			}
			unset($_POST['add_comment']);
		}

		include(ROOT_PATH."/frontend/comment/tmp/".$tmp.".php");
		$RESULT=null;
	}
}

function Frontend_Comment_List($id,$reply_id,$tmp,$count,$pager=false)
{
	global $DBH;

	if(empty($count))	    {$count = 10;}
	if(empty($tmp))		    {$tmp = 'list';}
	
	
	if(isset($_SESSION['user'])) {
		
		$data = array( 'id' => $_GET['delete'] );
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."comment WHERE id = :id ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();

		if($row['user_id'] == $_SESSION['user']->id) {
			if(isset($_GET['delete'])) {
				$data = array( 'id' => $_GET['delete'] ); 
				$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."comment WHERE id = :id ");
				$DELETE->execute($data);
				
				$data = array( 'id' => $_GET['delete'] ); 
				$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."comment WHERE reply_id = :id ");
				$DELETE->execute($data);


				$data = array( 'user_id' => $row['user_id']);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment WHERE user_id = :user_id ");
				$CHECK->execute($data);
				$items = $CHECK->fetchColumn();	

				$data = array( 'id' => $row['user_id'], 'comment' => $items);
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET comment = :comment WHERE id = :id ");
				$UPDATE->execute($data);


				$data = array( 'post_id' => $row['post_id']);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment WHERE post_id = :post_id ");
				$CHECK->execute($data);
				$items = $CHECK->fetchColumn();	
				
				$data = array( 'id' => $row['post_id'], 'comment' => $items);
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."post SET comment = :comment WHERE id = :id ");
				$UPDATE->execute($data);

			}
		}
	}
	
	$data = array('post_id' => $id, 'reply_id' => $reply_id);
	$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment WHERE post_id = :post_id AND reply_id = :reply_id ");
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
		
		$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."comment.*, ".DB_PREFIX."user.l_name, ".DB_PREFIX."user.f_name, ".DB_PREFIX."user.image AS user_image, ".DB_PREFIX."user.power AS user_power, ".DB_PREFIX."country.code AS code, ".DB_PREFIX."post.user_id AS post_user_id  
		FROM ".DB_PREFIX."comment 
		LEFT JOIN ".DB_PREFIX."user on ".DB_PREFIX."user.id = ".DB_PREFIX."comment.user_id 
		LEFT JOIN ".DB_PREFIX."country on ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id 
		LEFT JOIN ".DB_PREFIX."post on ".DB_PREFIX."post.id = ".DB_PREFIX."comment.post_id 
		WHERE ".DB_PREFIX."comment.post_id = :post_id AND ".DB_PREFIX."comment.reply_id = :reply_id ORDER BY ".DB_PREFIX."comment.published DESC LIMIT $start, $count");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	}

	if ($items > 0) {
		include(ROOT_PATH."/frontend/comment/tmp/".$tmp.".php");
		if($pager) { include(ROOT_PATH."/frontend/includes/pager.php"); }
	}

}

function Frontend_Comment_Country_Percent($id)
{
	global $DBH;
	
	$data = array('post_id' => $id);
	$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."country.code FROM ".DB_PREFIX."comment 
	INNER JOIN ".DB_PREFIX."user on ".DB_PREFIX."user.id = ".DB_PREFIX."comment.user_id 
	INNER JOIN ".DB_PREFIX."country on ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id 
	WHERE ".DB_PREFIX."comment.post_id = :post_id");
	$RESULT->execute($data);
	$RESULT->setFetchMode(PDO::FETCH_ASSOC);
	
	$array = array();
	while ( $row = $RESULT->fetch() ) { 
		$array[] = $row['code'];
	}
	$array = array_count_values ($array);
	array_multisort($array, SORT_NUMERIC, SORT_DESC);

	return $array;
	
}




function Frontend_Comment_Power()
{
	global $DBH;
	
	if(isset($_POST['power'])) {

		if(isset($_SESSION['user'])) {

			if(isset($_POST['id']))			{$id = $_POST['id'];}
			if(isset($_POST['power']))	{$power = $_POST['power'];}

			$user_id = $_SESSION['user']->id;

			$data = array('id' => $id);
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."comment WHERE id = :id ");
			$RESULT->execute($data);
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);
			$row = $RESULT->fetch();
			
			if($power == 'up') {
				
				$data = array('comment_id' => $id, 'user_id' => $user_id);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment_power WHERE comment_id = :comment_id AND user_id = :user_id  ");
				$CHECK->execute($data);

				if ( $CHECK->fetchColumn() < 1) {

					$data = array( 'id' => $id, 'power' => 1);
					$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."comment SET power = power + :power WHERE id = :id");
					$UPDATE->execute($data);
					
					$data = array( 'id' => $row['user_id'], 'power' => 1);
					$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET power = power + :power WHERE id = :id");
					$UPDATE->execute($data);

					$data = array( 'comment_id' => $id, 'user_id' => $user_id, 'power' => 1);
					$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."comment_power ( comment_id, user_id, power) VALUES ( :comment_id, :user_id, :power)");
					$INSERT->execute($data);
					
					echo $row['power']+1;
					die();
				}
			}
			if($power == 'down') {

				$data = array('comment_id' => $id, 'user_id' => $user_id);
				$CHECK = $DBH->prepare("SELECT count(*) FROM ".DB_PREFIX."comment_power WHERE post_id = :post_id AND user_id = :user_id  ");
				$CHECK->execute($data);

				if ( $CHECK->fetchColumn() < 1) {

					$data = array( 'id' => $id, 'power' => 1);
					$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."comment SET power = power - :power WHERE id = :id");
					$UPDATE->execute($data);
					
					$data = array( 'id' => $row['user_id'], 'power' => 1);
					$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET power = power - :power WHERE id = :id");
					$UPDATE->execute($data);

					$data = array( 'comment_id' => $id, 'user_id' => $user_id, 'power' => -1);
					$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."comment_power ( comment_id, user_id, power) VALUES ( :comment_id, :user_id, :power)");
					$INSERT->execute($data);
					
					echo $row['power']-1;
					die();
				}
			}
		}
		die(false);
	}
}

?>