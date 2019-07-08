<?php defined('_JEXEC') or die(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title><?php echo $title; ?></title>

	<link rel="shortcut icon" href="<?php echo FRONTEND_PATH; ?>/images/favicon.ico">
	
	<!-- Dropzone css -->
	<link href="<?php echo FRONTEND_PATH; ?>/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
	<link href="<?php echo FRONTEND_PATH; ?>/plugins/dropify/css/dropify.min.css" rel="stylesheet">

	<link href="<?php echo FRONTEND_PATH; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="<?php echo FRONTEND_PATH; ?>/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

	<link href="<?php echo FRONTEND_PATH; ?>/css/icons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo FRONTEND_PATH; ?>/css/style.css" rel="stylesheet" type="text/css">
	
</head>
<body>

<?php include_once(ROOT_PATH."/frontend/includes/header.php"); ?>

<div class="wrapper">
	<div class="container-fluid">
		<div class="card">
            <div class="card-body">
            
				<div class="row">
					<div class="col-sm-4">
						<?php if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'edit' && is_numeric($ROUTE['id'])) { Frontend_Group_Show($ROUTE['id'],'_show'); } ?>
					</div>
					<div class="col-sm-8">
						<?php 
						if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'edit' && is_numeric($ROUTE['id'])) {
							Frontend_Group_Edit($ROUTE['id'],'_edit');
						}
						if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'add' && $ROUTE['id'] == 'add') {
							Frontend_Group_Add('_add');
						}
						if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'post' && $ROUTE['id'] == 'post') {
							
							?>
							<!-- Nav tabs -->
							 <ul class="nav nav-pills nav-justified" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#new" role="tab">новые записи</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#comment" role="tab">самые обсуждаемые</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#power" role="tab">рекомендую пользователи</a>
								</li>

							</ul>
							<br>
							<div class="tab-content">
								<div class="tab-pane active p-3" id="new" role="tabpanel">
									<?php Frontend_Post_List($_SESSION['user']->id,'_list',10,false); ?>
								</div>
								<div class="tab-pane  p-3" id="comment" role="tabpanel">
									<?php Frontend_Post_Comment_List($_SESSION['user']->id,'_list',10,false); ?>
								</div>
								<div class="tab-pane  p-3" id="power" role="tabpanel">
									<?php Frontend_Post_Power_List($_SESSION['user']->id,'_list',10,false); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
		
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

<?php if($ROUTE['controller'] == 'group' && $ROUTE['action'] == 'edit' && is_numeric($ROUTE['id'])) {
 Frontend_Group_Edit($ROUTE['id'],'_edit_avatar'); 
} ?>

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

<!-- Dropzone js -->
<script src="<?php echo FRONTEND_PATH; ?>/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


<script src="<?php echo FRONTEND_PATH; ?>/plugins/dropzone/dist/dropzone.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/dropify/js/dropify.min.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/pages/upload.init.js"></script>

<script>
jQuery('#datepicker').datepicker();
</script>



<!-- App js -->
<script src="<?php echo FRONTEND_PATH; ?>/js/app.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/pages/alertify-init.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/plugins/alertify/js/alertify.js"></script>
<script src="<?php echo FRONTEND_PATH; ?>/js/promo.js"></script>

</body>
</html>