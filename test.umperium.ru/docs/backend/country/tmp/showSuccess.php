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
<link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>/JQueryUi/jquery-ui.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>/DataTables/css/jquery.dataTables.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo PLUGINS_PATH; ?>/Buttons/css/buttons.dataTables.min.css" type="text/css" media="screen" />

<script src="<?php echo PLUGINS_PATH; ?>/CKEditor/ckeditor.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>

<div id="wrapper">

<?php include_once (ROOT_PATH."/backend/includes/header.php"); ?>
<?php include_once (ROOT_PATH."/backend/includes/aside.php"); ?>

<main id="center">

	<div class="page-title">
		<div class="block">
			<div class="breadcrumbs">
				<?php echo $breadcrumbs; ?>
			</div>
		</div>
	</div>
	
	<div class="action-block">
		<a href="?action=add" class="btn green"><i class="fa fa-plus"></i> Добавить</a>
		<a href="?action=sort" class="btn blue"><i class="fa fa-random"></i> Сортировать</a>
	</div>

	<?php 
	if(isset($_GET['action'])) { $action = $_GET['action']; } else { $action = ''; }
	if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

	switch ($action) {
		case 'add':	
			Backend_Country_Add();
		break;
		case 'edit':
			Backend_Country_Edit($id);
		break;
		case 'sort':
			Backend_Country_Sort();
		break;
		default:
			Backend_Country_List();
	}
	?>
</main>
<?php include_once (ROOT_PATH."/backend/includes/footer.php"); ?>
</div>

<script src="<?php echo PLUGINS_PATH; ?>/JQuery/jquery-3.3.1.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/JQueryUi/jquery-ui.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/DataTables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/Buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/JSZip/jszip.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/PDFMake/pdfmake.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/PDFMake/vfs_fonts.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/Buttons/js/buttons.print.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/Buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo PLUGINS_PATH; ?>/NestedSortable/jquery.nestedSortable.js"></script>

<script src="<?php echo BACKEND_PATH; ?>/js/js.js"></script>
</body>
</html>