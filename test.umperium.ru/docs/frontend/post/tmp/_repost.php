<?php  

$now = date("Y-m-d");

	if(empty($row['user_image'])) { 
		$user_image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
	} else {
		$user_image = USER_UPLOADS.'/'.substr($row['user_image'],0,2).'/'.$row['user_image'];
	}
	$user_name = $row['l_name'].' '.$row['f_name'];
	
	
	if($now == date("Y-m-d",strtotime($row['published']))) {
		$published = date("H:i",strtotime($row['published']));
	} else {
		$published = date("Y/m/d в H:i",strtotime($row['published']));
	}
	
	$lock = '';
	if($row['access_id'] == 2) {
		if(isset($_SESSION['user'])) {
			if( in_array($row['id'], $_SESSION['user']->post) ) {

				$link = '/post/'.$row['slug'];
				$price = '';

			} else {
				$link = '';
				$price = $row['price'];
				$lock = '<img style="height:15px; width:15px;" src="'.FRONTEND_PATH.'/images/padlock.svg" alt="">';
			}
		} else {
			$link = '';
			$price = $row['price'];
			$lock = '<img style="height:15px; width:15px;" src="'.FRONTEND_PATH.'/images/padlock.svg" alt="">';
		}
		
	} else {
		$link = '/post/'.$row['slug'];
		$price = '';
	}
	
?>

<div class="media mt-3">
	<a class="d-flex pr-3" href="/post/<?php echo $row['slug']; ?>">
		<img src="<?php echo $user_image; ?>" alt="Generic placeholder image" height="64" class="rounded-circle">
	</a>
	<div class="media-body">
		<h5 class="mt-0 font-18"><?php echo $row['name']; ?></h5>
		<?php echo Truncate($row['content'],320); ?>
	</div>
</div>
