<?php include(ROOT_PATH."/frontend/post/tmp/_complain_form.php"); ?>

<?php Frontend_Post_Promo_Show('_promo_form'); ?>

<?php Frontend_Post_Buy_Show('_buy_form'); ?>

<?php if(!isset($_SESSION['user'])) { ?>
<div class="modal fade bs-example-modal-lg-3"  aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog slideInUp animated">

				<?php Frontend_User_Auth(); ?>

	</div><!-- /.modal-dialog -->
</div>

<?php } ?>