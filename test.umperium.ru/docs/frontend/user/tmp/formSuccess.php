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
<div class="accountbg"></div>

<div class="wrapper-page">
		
		<?php 
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'auth' && $ROUTE['id'] == 'auth') {
			Frontend_User_Auth();
		}
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'recovery' && $ROUTE['id'] == 'recovery') {
			Frontend_User_Recovery();
		}
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'reg' && $ROUTE['id'] == 'reg') {
			Frontend_User_Reg();
		}
		if($ROUTE['controller'] == 'user' && $ROUTE['action'] == 'confirmation' && $ROUTE['id'] != 'confirmation') {
			Frontend_User_Confirmation($ROUTE['id']);
		}
		?>
	
</div>

<?php include(ROOT_PATH."/frontend/includes/footer.php"); ?>

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