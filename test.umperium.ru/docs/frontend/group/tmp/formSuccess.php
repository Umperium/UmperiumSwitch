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
		<div class="card">
            <div class="card-body">
		
		<?php 

		
		if($ROUTE['controller'] == 'group' && empty($ROUTE['action']) ) {
			Frontend_Group_List('_list',12,true);
		}
	
		?>
	
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