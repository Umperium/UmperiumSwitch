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
	
	if($now == date("Y-m-d",strtotime($row['published']))) {
		$published = date("H:i",strtotime($row['published']));
	} else {
		$published = date("Y/m/d в H:i",strtotime($row['published']));
	}
?>
<div class="card">
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
							<a href="/post/complain/<?php echo $row['id']; ?>" class="dropdown-item">Пожаловаться</a>
							<?php }
						}
						?>

					</div>
				</div>  
			</div>

		</div>
		
		<div class="row"> 
			<div class="col-sm-12">
				<h4>#<?php echo $i; ?>&nbsp;&nbsp;<a href="/post/<?php echo $row['slug']; ?>" ><?php echo $row['name']; ?></a></h4>

				<?php if(!empty($row['image'])) { ?>
				<a href="/post/<?php echo $row['slug']; ?>" ><img src="<?php echo $row['image']; ?>" style="width:100%; "></a><br><br>
				<?php }  ?>

				<a href="/post/<?php echo $row['slug']; ?>" ><?php echo Truncate($row['content'],320); ?></a>
				<br><br>
			</div> 
		</div>
		
		
		
		<div class="row"> 
			<div class="col-10">
				<div class="flagcoment">
					<a href="/post/<?php echo $row['slug']; ?>" >
						<svg  style="margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17" id="reply"  width="16" height="16"><g fill="currentColor" fill-rule="evenodd"><path d="M14.802.024H3.147C1.412.024 0 1.415 0 3.126v7.087c0 1.71 1.412 3.102 3.147 3.102h7.423l3.358 3.24a.75.75 0 0 0 1.27-.539V13.29c1.55-.192 2.75-1.5 2.75-3.077V3.126c0-1.71-1.41-3.102-3.146-3.102zm1.888 10.189c0 1.026-.847 1.861-1.888 1.861h-.233a.625.625 0 0 0-.629.62v2.188l-2.664-2.626a.634.634 0 0 0-.445-.182H3.147c-1.041 0-1.888-.835-1.888-1.861V3.126c0-1.026.847-1.861 1.888-1.861h11.655c1.041 0 1.888.835 1.888 1.86v7.088z"></path><path d="M13.607 4.417H4.342a.625.625 0 0 0-.63.62c0 .343.283.62.63.62h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62zm0 3.474H4.342a.625.625 0 0 0-.63.62c0 .344.283.621.63.621h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62z"></path></g></svg>
<?php echo $row['comment']; ?>
						<?php 
						if($row['comment'] > 0) {
							$array_lang = Frontend_Comment_Country_Percent($row['id']);
							$percent = 100/$row['comment'];
							foreach($array_lang AS $key => $item) {
								?>
								<img style="height:20px; width:20px;" src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $key; ?>.png" alt=""><?php echo $percent*$item; ?>%  
								<?php
							}
						}
						?>
					</a>
				</div>
			</div>
			
			<div class="col-xs-1"> 
				<div class="sila">
					<h5>
						<a <?php if(isset($_SESSION['user'])) {?>href="#" class="power"<?php } else { ?>href="/user/auth"<?php } ?> data-id="<?php echo $row['id']; ?>" data-power="down">
							<img src="<?php echo FRONTEND_PATH; ?>/images/brain/brain-minus.png" alt="">
						</a>
						<?php $color = ''; 
						if( $row['power']>0) { $color = 'color:#00a500'; } 
						if( $row['power']<0) { $color = 'color:#ff4c6c'; } 
						?>
						<span class="power-count" style="<?php echo $color; ?>"><?php echo $row['power']; ?></span>
						<a <?php if(isset($_SESSION['user'])) {?>href="#" class="power"<?php } else { ?>href="/user/auth"<?php } ?> data-id="<?php echo $row['id']; ?>" data-power="up">
							<img src="<?php echo FRONTEND_PATH; ?>/images/brain/brain-plus.png" alt="">
						</a>
						
					</h5>
				</div>
			</div>
			
			
		</div>
		
		


	</div>
</div>
<?php } ?>