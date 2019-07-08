<?php defined('_JEXEC') or die(); ?>

<div class="block">
	<div class="web-form">
		<form action="" method="post" autocomplete="off">

			<div class="field">
				<label>Логин <i class="fa fa-asterisk"></i></label>
				<input type="text" name="login" value="" required />
			</div>

			<div class="field">
				<label>Пароль <i class="fa fa-asterisk"></i></label>
				<input type="password" name="password" value="" required />
			</div>
			<div class="button">
				<button type="submit" name="auth" class="btn green" value="true">Отправить</button>
			</div>
		</form>
	</div>
</div>

<?php if(!empty($warning)) { ?>
<div class="pop-overlay" style="display:block">
	<div class="overlay"></div>
	<div class="pop-wrapper">
		<div class="pop-content"><?php echo $warning; ?></div>
	</div>
</div>
<?php } ?>