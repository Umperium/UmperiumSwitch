<?php  
$i=0;
$now = date("Y-m-d");
while ( $row = $RESULT->fetch() ) { 
	$i++;
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
	
?>

<div class="card text-white card-danger">
	<?php if(!empty($row['image'])) { ?>
	<a href="/post/<?php echo $row['slug']; ?>" ><img class="card-img-top img-fluid" src="<?php echo $row['image']; ?>" style="width:100%; "></a>
	<?php }  ?>
	<div class="card-body">
		<h4 class="card-title font-20 mt-0"><a href="/post/<?php echo $row['slug']; ?>" ><?php echo $row['name']; ?></a></h4>
		<a href="/post/<?php echo $row['slug']; ?>" ><?php echo Truncate($row['content'],55); ?></a>
		<div class="headerinfo"> 
			<div class="col-12 ">
				<a href="/user/<?php echo $row['user_id']; ?>"><span class="badge badge-danger"><?php echo $user_name; ?></span></a>
				<span class="badge badge-default"><?php echo $published; ?></span>
			</div> 
		</div>
	</div>
</div>

<?php } ?>