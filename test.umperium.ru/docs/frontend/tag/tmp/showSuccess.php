<?php defined('_JEXEC') or die(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title><?php echo $title; ?></title>

	<link rel="shortcut icon" href="<?php echo FRONTEND_PATH; ?>/images/favicon.ico">
	
	<link href="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
	<link href="<?php echo FRONTEND_PATH; ?>/plugins/fullcalendar/vanillaCalendar.css" rel="stylesheet" type="text/css"  />

	<link href="<?php echo FRONTEND_PATH; ?>/plugins/morris/morris.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans+SC" rel="stylesheet">

	<link href="<?php echo FRONTEND_PATH; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo FRONTEND_PATH; ?>/css/icons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo FRONTEND_PATH; ?>/css/style.css" rel="stylesheet" type="text/css">
	
</head>
<body>

<?php include_once(ROOT_PATH."/frontend/includes/header.php"); ?>

<div class="wrapper">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-sm-8">
                <?php Frontend_Tag_Post_List($id,'_post_list',24,false); ?>
			</div>
			
			<div class="col-sm-4 ">
			
				<div class="card">
					<div class="card-body">
						<?php Frontend_Trend_List('_list',3); ?>
					</div>
				</div>

				
				<div class="card text-white card-danger">
					<div class="card-body">
						<blockquote class="card-bodyquote">
							<h5>Власть / Политика:</h5>
							<?php Frontend_Post_List_inCategory(1,'_list_in_category',3,false); ?>
						</blockquote>
					</div>
				</div>
				
				<?php Frontend_Post_Day('_list_day',1); ?>
				
				
				<?php ?>
				<div class="card text-white card-warning">
					<div class="card-body">
						<blockquote class="card-bodyquote">
							<h5>Медиа / СМИ</h5>
							<?php Frontend_Post_List_inCategory(2,'_list_in_category',3,false); ?>
						</blockquote>
					</div>
				</div>
				<?php ?>

				<div class="card bg-dark">
					<div class="card-body">
						<h3 class="card-title font-20 mt-0">Реклама Директ</h3>
						<p class="card-text">Реклама</p>
					</div>
				</div>
				
				<?php  ?>
				<div class="card text-white card-success">
					<div class="card-body">
						<blockquote class="card-bodyquote">
							<h5>Бизнес / Экономика</h5>
							<?php Frontend_Post_List_inCategory(3,'_list_in_category',3,false); ?>
						</blockquote>
					</div>
				</div>
				<?php  ?>
				
				<?php  ?>
				<div class="card text-white card-info">
					<div class="card-body">
						<blockquote class="card-bodyquote">
							<h5>Общество / Религия</h5>
							<?php Frontend_Post_List_inCategory(4,'_list_in_category',3,false); ?>
						</blockquote>
					</div>
				</div>
				<?php ?>

				<?php  ?>
				<div class="card text-white card-primary">
					<div class="card-body">
						<blockquote class="card-bodyquote">
							<h5>Корпоративные блоги</h5>
							<?php Frontend_Post_List_inCategory(5,'_list_in_category',3,false); ?>
						</blockquote>
					</div>
				</div>
				<?php ?>
				
				
				
				
				
			
				

			</div>
			
		</div>

	
	</div>
</div>

<!-- Footer -->
<footer class="footer">
        <div class="container-fluid">
            <div class="row grid-col">
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Пользовательское соглашение 


</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">О проекте</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Служба поддержки</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Ссылки на соцссети</a></div>                                                                         
                                    </div>
        </div>
    </footer>
<!-- End Footer -->


<?php Frontend_Post_Promo_Show('_promo_form'); ?>

<!-- jQuery  -->
<script src="<?php echo FRONTEND_PATH; ?>/js/jquery.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/popper.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/modernizr.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/waves.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/jquery.nicescroll.js"></script>

<script src="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="<?php echo FRONTEND_PATH; ?>/plugins/skycons/skycons.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/fullcalendar/vanillaCalendar.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/raphael/raphael-min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/morris/morris.min.js"></script> 
<script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui-slider-pips.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui-slider-pips.min.js?"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/pages/rangeslider-init.js"></script> 

<!-- App js -->
<script src="<?php echo FRONTEND_PATH; ?>/js/app.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/pages/alertify-init.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/alertify/js/alertify.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/promo.js"></script>

</body>
</html>