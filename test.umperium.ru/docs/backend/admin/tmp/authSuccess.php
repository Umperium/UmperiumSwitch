<?php defined('_JEXEC') or die(); ?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<link rel="icon" href="<?php echo BACKEND_PATH; ?>/favicon.ico" />

<link rel="stylesheet" href="<?php echo BACKEND_PATH; ?>/css/normalize.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo BACKEND_PATH; ?>/css/style.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>/FontAwesome/css/all.min.css" type="text/css" media="screen" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body id="auth-page">
<?php Backend_Admin_Auth(); ?>
<script src="<?php echo PLUGINS_PATH; ?>/JQuery/jquery-3.3.1.min.js"></script>
<script src="<?php echo BACKEND_PATH; ?>/js/js.js"></script>
</body>
</html>