<?php  
$i=0;
while ( $row = $RESULT->fetch() ) { 
	$i++;
	if(empty($row['user_image'])) { 
		$user_image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
	} else {
		$user_image = USER_UPLOADS.'/'.substr($row['user_image'],0,2).'/'.$row['user_image'];
	}
	$user_name = $row['l_name'].' '.$row['f_name'];
?>

<div class="card">
	<div class="card-body dev-list-day">
		<h5 style=" color:#6c757d;font-weight: bold;">Пост дня: </h5>
		<a href="/post/<?php echo $row['slug']; ?>" class="btn btn-link waves-effect">
			<?php echo $row['name']; ?>
			<img src="<?php echo FRONTEND_PATH; ?>/images/users/fl.png" class="ml-2" height="16" alt="">&nbsp;<?php echo $row['comment']; ?>
		</a>
	</div>
</div>

<?php } ?>