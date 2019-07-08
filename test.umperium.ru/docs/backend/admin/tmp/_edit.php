<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<div class="web-form">
		<form action="" method="post">

			<div class="field">
				<label>Имя <i class="fa fa-asterisk"></i></label>
				<input type="text" name="name" value="<?php echo $row['name']; ?>" required />
			</div>
			
			<div class="field">
				<label>E-mail </label>
				<input type="email" name="email" value="<?php echo $row['email']; ?>" />
			</div>
			
			<div class="field">
				<label class="tooltip" data-tooltip="Латинские, цифры, -, без пробелов">Логин <i class="fa fa-asterisk"></i></label>
				<input type="text" name="login" value="<?php echo $row['login']; ?>" required />
			</div>
			
			<div class="field">
				<label>Пароль </label>
				<input type="password" name="password" value="" />
			</div>
			
			<input name="id" type="hidden" value="<?php echo $row['id']; ?>"  />
			<input name="salt" type="hidden" value="<?php echo $row['salt']; ?>" />
			<input name="old_password" type="hidden" value="<?php echo $row['password']; ?>" />
			
			<div class="button">
				<button type="submit" name="save" class="btn green" value="true"><i class="far fa-save"></i> Сохранить</button>
				<button type="submit" name="save_add" class="btn green" value="true"><i class="far fa-save"></i> Сохранить и добавить</button>
				<button type="submit" name="save_back" class="btn green" value="true"><i class="far fa-save"></i> Сохранить и вернутся к списку</button>
			</div>

		</form>
	</div>
</div>

<?php if(!empty($warning)) { ?>
<div class="pop-overlay limit" style="display:block">
	<div class="overlay"></div>
	<div class="pop-wrapper">
		<div class="pop-content"><?php echo $warning; ?></div>
	</div>
</div>
<?php } ?>