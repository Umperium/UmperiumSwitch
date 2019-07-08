<div class="card">
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

	<div class="card-body">
		<div class="row"> 

			<div class="col-sm-1"><a href="/user/<?php echo $row['user_id']; ?>">
				<img style="height:45px; width:45px; border-radius:50% !important; " src="<?php echo $user_image; ?>" alt="user" ></a>
			</div>
			<div class="col-sm-4 mr-auto">
				<a href="/user/<?php echo $row['user_id']; ?>"><span class="badge badge-danger"><?php echo $user_name; ?></span>
				&nbsp;&nbsp;<img style="height:15px; width:15px;" src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png" alt="">
				</a><br>
				<span class="badge badge-default"><?php echo $published; ?></span>
			</div>
			
			<div class="col-sm-1 ml-auto"> 
				<div class="dropdown mb-2 mb-md-0">
					<a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i style="font-size: 25px; color: #b0b6bb; cursor: pointer;" class="ti-more"></i>
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 27px, 0px); top: 0px; left: 0px; will-change: transform;">

						<?php 
						if(isset($_SESSION['user'])) {
						if($row['user_id'] == $_SESSION['user']->id) { ?>
							<a href="/post/edit/<?php echo $row['id']; ?>" class="dropdown-item">Изменить</a>
							<a href="/post/delete/<?php echo $row['id']; ?>" class="dropdown-item">Удалить</a>
						<?php } else { ?>
							<a class="dropdown-item complain" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg-2" data-id="<?php echo $row['id']; ?>">Пожаловаться</a>
							<?php }
						}
						?>

					</div>
				</div>  
			</div>

		</div>
		
		<div class="row"> 
	
			<div class="col-sm-12">
				<h4><a href="<?php echo $link; ?>" <?php if($link=='') { ?> class="buy-btn" data-id="<?php echo $row['id']; ?>" data-price="<?php echo $price; ?>" data-toggle="modal" data-animation="bounce" data-target=".bs-buy" <?php } ?>><?php echo $row['name']; ?></a><?php echo $lock; ?></h4>


				<a href="<?php echo $link; ?>" <?php if($link=='') { ?> class="buy-btn" data-id="<?php echo $row['id']; ?>" data-price="<?php echo $price; ?>" data-toggle="modal" data-animation="bounce" data-target=".bs-buy" <?php } ?>><?php echo Truncate($row['content'],320); ?></a>
				<br>
				
			</div> 
		</div>

	</div>

<?php } ?>
</div>