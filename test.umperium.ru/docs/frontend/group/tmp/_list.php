<?php  
$i=0;
$now = date("Y-m-d");
while ( $row = $RESULT->fetch() ) { 
	$i++;
	if(empty($row['image'])) { 
		$image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
	} else {
		$image = GROUP_UPLOADS.'/'.substr($row['image'],0,2).'/'.$row['image'];
	}
	$name = $row['name'];
	
	
	if($now == date("Y-m-d",strtotime($row['published']))) {
		$published = date("H:i",strtotime($row['published']));
	} else {
		$published = date("Y/m/d в H:i",strtotime($row['published']));
	}
	
?>

<div class="col-sm-8 mx-auto"> 

<div class="card">

	<div class="card-body">
		<div class="row"> 

			<div class="col-sm-2"><a href="/group/<?php echo $row['id']; ?>">
				<img style="height:45px; width:45px; border-radius:50% !important; " src="<?php echo $image; ?>" alt="user" ></a>	</div>
				<div class="col-sm-7">

					<a href="/group/<?php echo $row['id']; ?>"><h5 style="margin-top: 5px"><?php echo $name; ?></h5></a></div>
				<div class="col-sm-3">
	<div style="margin-top: 5px">
		<?php if(isset($_SESSION['user']) && $_SESSION['user']!=$row['id']) { ?>
		<a href="#" id="alertify-subscribe" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $name; ?>" data-subscribe="<?php echo $_SESSION['user']->id; ?>">Подписаться</a>
		<?php } ?>
		
	</div>
	</div>

	
				
			
</div>
		</div>
	
		


	</div>
		</div>

<?php } ?>