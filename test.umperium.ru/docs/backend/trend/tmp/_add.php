<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<div class="web-form">
		<form action="" method="post">

			<div class="field">
				<label>Название <i class="fa fa-asterisk"></i></label>
				<input type="text" name="name" value="" required />
			</div>
			
			<div class="field">
				<label>Транслит </label>
				<input type="text" name="slug" value="" />
			</div>
			
			<div class="field">
				<label>Начало тренда <i class="fa fa-asterisk"></i></label>
				<input name="date_from" type="text" value="" required="" class="date-time-input today">
			</div>
			
			<div class="field">
				<label>Конец тренда <i class="fa fa-asterisk"></i></label>
				<input name="date_to" type="text" value="" required="" class="date-time-input today">
			</div>
			
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