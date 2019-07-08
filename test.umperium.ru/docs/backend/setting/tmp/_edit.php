<?php defined('_JEXEC') or die(); ?>
<div class="block">
	<div class="web-form">
		<form action="" method="post" enctype="multipart/form-data">

			<div class="field">
				<label>Название <i class="fa fa-asterisk"></i></label>
				<input type="text" value="<?php echo $row['name']; ?>" readonly />
			</div>
			
			<div class="field">
				<label style="display: block">Значение</label>
				<?php if($row['type']=='text') { ?>
					<input type="text" name="value" value="<?php echo $row['value']!=''?$row['value']:''; ?>" required />
				<?php } ?>
				<?php if($row['type']=='boolean') { ?>
					<input type="checkbox" name="value" value="<?php echo $row['value']==1?1:0; ?>" />
				<?php } ?>
				<?php if($row['type']=='textarea') { ?>
					<textarea name="value"><?php echo $row['value']!=''?$row['value']:''; ?></textarea>
				<?php } ?>
				<?php if($row['type']=='number') { ?>
					<input type="number" name="value" value="<?php echo $row['value']!=''?$row['value']:''; ?>" />
				<?php } ?>
				<?php if($row['type']=='file') { ?>
					<input name="value" type="file" />
					<div class="htooltip">
						<span><img src="/plugins/thumb.php?src=<?php echo SETTING_UPLOADS.'/'.$row['value'];?>&w=90&h=90" alt=""></span>
						<?php echo SETTING_UPLOADS.'/'.$row['value'];?>
					</div>
				<?php } ?>
			</div>
			
			<input name="type" type="hidden" value="<?php echo $row['type']; ?>" readonly />
			<input name="slug" type="hidden" value="<?php echo $row['slug']; ?>" readonly />
			<input name="value_old" type="hidden" value="<?php echo $row['value']; ?>" readonly />
			
			<div class="button">
				<button type="submit" name="save" class="btn green" value="true"><i class="far fa-save"></i> Сохранить</button>
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