<div class="card">
	<div class="card-body">

		<h4 class="mt-0 header-title">Комментарии ( <span style="color:#527c94"><?php echo $items; ?></span> )</h4>

		<!-- Nav tabs -->	
		<div class="col-sm-6 ml-auto">
			<ul class="nav nav-pills nav-justified" role="tablist">

				<li class="nav-item waves-effect waves-light">
					<a class="nav-link show active" data-toggle="tab" href="#profile-1" role="tab" aria-selected="true">Топ</a>
				</li>

				<li class="nav-item waves-effect waves-light">
					<a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">По порядку</a>
				</li>
			</ul>
		</div>

		<!-- Tab panes -->
		<div class="tab-content">

			<div class="tab-pane p-3 show active" id="profile-1" role="tabpanel">
				<p class="font-14 mb-0">
					<div class="card-body">
						
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
						
						<div class="media mb-4">
							
							<a href="/user/<?php echo $row['user_id']; ?>"><img class="d-flex mr-3 rounded-circle" src="<?php echo $user_image; ?>" alt="<?php echo $user_name; ?>" height="64" width="64"></a>
							<div class="media-body">

								<div class="row">
									<div class="col-sm-11">
									
									
										<?php  if(isset($_SESSION['user'])) {
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

									<div class="col-sm-1 ml-auto "> 
										<div class="sila">
											<h5>
												<a href="#" class="power-comment" data-id="<?php echo $row['id']; ?>" data-power="down">
													<img src="<?php echo FRONTEND_PATH; ?>/images/brain/brain-minus.png" alt="">
												</a>
												
												<?php $color = ''; 
												if( $row['power']>0) { $color = 'color:#00a500'; } 
												if( $row['power']<0) { $color = 'color:#ff4c6c'; } 
												?>

												<span class="power-count" style="<?php echo $color; ?>"><?php echo $row['power']; ?></span>
												
												<a href="#" class="power-comment" data-id="<?php echo $row['id']; ?>" data-power="up">
													<img src="<?php echo FRONTEND_PATH; ?>/images/brain/brain-plus.png" alt="">
												</a>

												
											</h5>
										</div>
									</div>
								</div>

								<br>
								<a data-toggle="collapse" href="#reply-<?php echo $row['id']; ?>" aria-expanded="true" aria-controls="reply-<?php echo $row['id']; ?>" class="btn btn-link waves-effect mb-2">Ответить</a>
			
								<div id="reply-<?php echo $row['id']; ?>" class="collapse" role="tabpanel">
									<?php Frontend_Comment_Add($id,$row['id'],'_reply_form'); ?>
								</div>
								<?php Frontend_Comment_List($id,$row['id'],'_reply_list',500,true); ?>
							   
							</div>
							
						</div>
						
						<?php } ?>
						
					</div>
				</p>
			</div>

		</div>

	</div>
</div>