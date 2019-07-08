<div class="card shadow-none border mb-0">
	<div class="card-header-review" role="tab" id="heading-<?php echo $reply_id; ?>">
		<h5 style="color:#fff;">
			<a data-toggle="collapse" href="#collapse-<?php echo $reply_id; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $reply_id; ?>" class="">
				Ответы на комментарии ( <?php echo $items; ?> )
			</a>
		</h5>
	</div>

	<div id="collapse-<?php echo $reply_id; ?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?php echo $reply_id; ?>" >
		<?php  
		while ( $row = $RESULT->fetch() ) { 
			if(empty($row['user_image'])) { 
				$user_image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
			} else {
				$user_image = USER_UPLOADS.'/'.substr($row['user_image'],0,2).'/'.$row['user_image'];
			}
			$user_name = $row['l_name'].' '.$row['f_name'];
			$comment = $row['comment'];
		?>
		<div class="card-body">
			<div class="media ">

				<a href="/user/<?php echo $row['user_id']; ?>"><img class="d-flex mr-3 rounded-circle" src="<?php echo $user_image; ?>" alt="<?php echo $user_name; ?>" height="64" width="64"></a>
				<div class="media-body">
					
					<?php if(isset($_SESSION['user'])) {
						if($row['user_id'] == $_SESSION['user']->id || $row['post_user_id'] == $_SESSION['user']->id) { ?>
						
						<a style="float: right" href="?delete=<?php echo $row['id']; ?>">удалить</a>
						
						<?php 
						}
					}
					?>
					
					<img style="height: 25px;width: 25px; border-radius: 50%!important;" src="<?php echo FRONTEND_PATH; ?>/images/flags/flbru.png" alt="">
					<small><?php Time_Ago($row['published']); ?> назад</small>

					<?php $color = ''; 
					if( $row['user_power']>0) { $color = 'color:#00a500'; } 
					if( $row['user_power']<0) { $color = 'color:#ff4c6c'; } 
					?>

					<h5 class="mt-0 font-18"><img style="height:25px; width:25px;" src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png" alt=""> <a href="/user/<?php echo $row['user_id']; ?>"><?php echo $user_name; ?></a> <span style="<?php echo $color; ?>"> <?php echo $row['user_power']; ?></span></h5>
					<p class="mb-0"><?php echo $comment; ?></p>


				</div>

			</div>
		</div>
		<?php } ?>
	</div>
</div>	 