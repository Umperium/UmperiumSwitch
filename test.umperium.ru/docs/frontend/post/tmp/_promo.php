<?php
$diff = strtotime($row['promo_to']) - time();
$minutes = round( $diff / 60 );

if ($items > 0) { 

	if(empty($row['user_image'])) { 
		$user_image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
	} else {
		$user_image = USER_UPLOADS.'/'.substr($row['user_image'],0,2).'/'.$row['user_image'];
	}
	$user_name = $row['l_name'].' '.$row['f_name'];

?>

<div class="card" id="promo-wrapper">
	<div class="card-header">
		<div class="row"> 
			<div class="col-12">
					<h6 style="color:#fff;padding:0 55px 0 55px; display:inline"><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp;PRодвижение </h6>
			
				<button type="button" class="btn-sm btn-dark waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">
					Выкупить за <?php echo $row['score']+100; ?> <img src="<?php echo FRONTEND_PATH; ?>/images/umpico.svg" style="height:16px" alt="умпериалы"> - осталось <?php echo $minutes; ?> мин
				</button>
				
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="row"> 
		 <div class="col-sm-1"><a href="/user/<?php echo $row['user_id']; ?>">
                        <img style="height:45px; width:45px; border-radius:50% !important; "
                             src="<?php echo $user_image; ?>" alt="user"></a>
                </div>
                <div class="col-sm-4 mr-auto">
                    <a href="/user/<?php echo $row['user_id']; ?>"><span
                                class="badge badge-danger"><?php echo $user_name; ?></span>
                        &nbsp;&nbsp;<img style="height:15px; width:15px;"
                                         src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png"
                                         alt="">
                    </a><br>
                    <span class="badge badge-default"><?php echo $published; ?></span>
                </div>

			

			
					<!-- Time_Ago($row['published']); -->
					<!-- назад -->
			<div class="col-sm-1 ml-auto"> 
				<div class="dropdown mb-2 mb-md-0">
					<a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i style="font-size: 25px; color: #b0b6bb; cursor: pointer;" class="ti-more"></i></a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position:absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
						<a class="dropdown-item" id="alertify-success-callback" href="#">Подписаться</a>
						<a class="dropdown-item" href="#"></a>
					</div>
				</div>
			</div>
<div class="anons">
                    <?php
                    echo print_post_from_json_main($row['json']);
                    ?>
					</div>
		</div>
		
		<div class="row"> 
			<div class="col-sm-11">
				<h4><a href="/post/<?php echo $row['slug']; ?>" ><?php echo $row['name']; ?></a></h4>
				<?php echo Truncate($row['content'],320); ?>
			</div> 
			<div class="col-sm-2 ml-auto "> 
				<div class="sila">
                        <h5>
                            <a <?php if (isset($_SESSION['user'])) { ?>href="#" class="power"
                               <?php } else { ?>data-toggle="modal" data-animation="bounce"
                               data-target=".bs-example-modal-lg-3"<?php } ?> data-id="<?php echo $row['id']; ?>"
                               data-power="down"><img src="http://test.umperium.ru/assets/images/brain-minus.png"
                                                      alt="">
                            </a>
                            <?php $color = '';
                            if ($row['power'] > 0) {
                                $color = 'color:#00a500';
                            }
                            if ($row['power'] < 0) {
                                $color = 'color:#ff4c6c';
                            }
                            ?>
                            <span class="power-count" style="<?php echo $color; ?>"><?php echo $row['power']; ?></span>
                            <a <?php if (isset($_SESSION['user'])) { ?>href="#" class="power"
                               <?php } else { ?>data-toggle="modal" data-animation="bounce"
                               data-target=".bs-example-modal-lg-3"<?php } ?> data-id="<?php echo $row['id']; ?>"
                               data-power="up"><img src="http://test.umperium.ru/assets/images/brain-plus.png" alt="">
                            </a>
                        </h5>
                    </div>
			</div>
		</div>
		
		<div class="row"> 
			<div class="col-12">
				<div class="flagcoment">
					<a href="/post/<?php echo $row['slug']; ?>" >Комментариев (<?php echo $row['comment']; ?>) 
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
		</div>
		
	</div>
</div>  

<?php } else { ?>

<div class="card" id="promo-wrapper">
	<div class="card-header">
		<div class="row"> 
			<div class="col-12">
					<h5 style="color:#fff;padding:0 55px 0 55px; display:inline "><i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp;
PRодвижение </h5>

				<button type="button" class="btn-sm btn-dark waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">
					Выкупить за 100 <img src="<?php echo FRONTEND_PATH; ?>/images/umpico.svg" style="height:16px" alt="умпериалы">
				</button>
			</div>
		</div>
	</div>
</div>  

<?php } ?>