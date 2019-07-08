<?php

if(empty($row['image'])) { 
	$image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
} else {
	$image = USER_UPLOADS.'/'.substr($row['image'],0,2).'/'.$row['image'];
}
$name = $row['l_name'].' '.$row['f_name'];

?>


	<div class="card">
		<div class="headerinfo" style="text-align:center;">
			
			<div class="row">
				<div class="col-12">
					<div><img  src="/classes/thumb.php?src=<?php echo $image; ?>&amp;h=200&amp;w=200&amp;zc=1" alt="<?php echo $name; ?>" /></div>
				<?php if($row['id'] == $_SESSION['user']->id ) { ?>
<br>
				<button type="button" class="btn-xs btn-dark waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">
					Изменить
				</button>
				<?php } ?>
				<h4 style="text-align:center;"><?php echo $name; ?></h4>

				</div>
			</div>
			<div class="row">
				<div class="col-12 ">
					<img style="height:25px; width:25px;" src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png" alt="">
				</div>
			</div>
			<div class="row">
				<div class="col-12 ">
				<?php if($row['vk'] != '') { ?>
					<a target="_blank" href="<?php echo $row['vk']; ?>"><i class="ti-vk"></i></a>
					<?php } ?>
					<?php if($row['odnoklassniki'] != '') { ?>
					<a target="_blank" href="<?php echo $row['odnoklassniki']; ?>"><i class="ti-odnoklassniki"></i></a>
					<?php } ?>
					<?php if($row['facebook'] != '') { ?>
					<a target="_blank" href="<?php echo $row['facebook']; ?>"><i class="ti-facebook"></i></a>
					<?php } ?>
					<?php if($row['instagram'] != '') { ?>
					<a target="_blank" href="<?php echo $row['instagram']; ?>"><i class="ti-instagram"></i></a>
					<?php } ?>
					<?php if($row['twitter'] != '') { ?>
					<a target="_blank" href="<?php echo $row['twitter']; ?>"><i class="ti-twitter"></i></a>
					<?php } ?>
				</div>
			</div>
			<div class="row">	
				<div class="col-12">Сила мысли: <?php echo $row['power']; ?></div>
			</div>
			<div class="row">
				<div class="col-12"> <mark>Профи</mark> </div>
			</div>
			
			<div class="row">
				
				<div class="col-3">	
					<svg style="margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17" id="reply" width="15" height="15"><g fill="currentColor" fill-rule="evenodd"><path d="M14.802.024H3.147C1.412.024 0 1.415 0 3.126v7.087c0 1.71 1.412 3.102 3.147 3.102h7.423l3.358 3.24a.75.75 0 0 0 1.27-.539V13.29c1.55-.192 2.75-1.5 2.75-3.077V3.126c0-1.71-1.41-3.102-3.146-3.102zm1.888 10.189c0 1.026-.847 1.861-1.888 1.861h-.233a.625.625 0 0 0-.629.62v2.188l-2.664-2.626a.634.634 0 0 0-.445-.182H3.147c-1.041 0-1.888-.835-1.888-1.861V3.126c0-1.026.847-1.861 1.888-1.861h11.655c1.041 0 1.888.835 1.888 1.86v7.088z"></path><path d="M13.607 4.417H4.342a.625.625 0 0 0-.63.62c0 .343.283.62.63.62h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62zm0 3.474H4.342a.625.625 0 0 0-.63.62c0 .344.283.621.63.621h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62z"></path></g></svg><br>
					<?php echo $row['comment']; ?>
				</div>
				
				<div class="col-3">	
					<i class="ti-eye"></i><br>
					<?php echo $view; ?>
				</div>
				<div class="col-3">	
					<i class="ti-marker-alt"></i><br>
					<?php echo $count_post; ?>
				</div>
				<div class="col-3">	
					топ<br>
					<?php echo $row['view']; ?>
				</div>
				
			</div>
			
			
		</div>

		<ul class="list-group list-group-flush">
			<a class="btn btn-light waves-effect" data-toggle="collapse" href="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
				<i class="mdi mdi-chevron-down"></i>О мыслителе
			</a>

			<div class="collapse " id="collapseExample" style="">
				<div class="card card-body mb-0">
				
					<dl class="row mb-0">
						<dt class="col-sm-5">Дата рождения</dt>
						<dd class="col-sm-7 ml-auto"><?php echo date("d/m/Y", strtotime($row['birthday'])); ?></dd>

						<dt class="col-sm-5">Город</dt>
						<dd class="col-sm-7"><?php echo $row['city']; ?></dd>

						<dt class="col-sm-5">Место жительства</dt>
						<dd class="col-sm-7"><?php echo $row['residence']; ?></dd>

						<dt class="col-sm-5 text-truncate">Место работы</dt>
						<dd class="col-sm-7"><?php echo $row['work']; ?></dd>

						<dt class="col-sm-5">О себе</dt>
						<dd class="col-sm-7"><?php echo $row['about']; ?></dd>
					</dl>
				</div>
			</div>
		</ul>

		<div class="card-body text-center mod-font-size">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']!=$row['id']) { ?>
			<a href="#" id="alertify-subscribe" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $name; ?>" data-subscribe="<?php echo $_SESSION['user']->id; ?>">Подписаться</a>
			<?php } ?>
		</div>

	</div>
	
	<?php if($row['id'] == $_SESSION['user']->id ) { ?>
	<div class="nav flex-column nav-pills text-center" >
		<a class="nav-link waves-effect waves-light <?php echo $ROUTE['action']=='post'?'active':'';?>" href="/user/post" >Моя лента</a>
		<a class="nav-link waves-effect waves-light <?php echo $ROUTE['action']=='score'?'active':'';?>" href="/user/score" >Мой счет</a>
		<a class="nav-link waves-effect waves-light <?php echo $ROUTE['action']=='edit'?'active':'';?>" href="/user/edit">Настройки</a>
		<a class="nav-link waves-effect waves-light <?php echo $ROUTE['action']=='notice'?'active':'';?>" href="/user/notice" >Оповещения</a>
	</div>
	<?php } ?>
	


