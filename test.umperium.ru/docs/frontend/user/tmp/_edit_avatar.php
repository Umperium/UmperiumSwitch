<?php if($row['id'] == $_SESSION['user']->id ) { ?>
<div  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog slideInUp  animated">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Изменить аватар</h2>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="p-3">
					
					<form action="" method="post" enctype="multipart/form-data">
						<h4 class="mt-0 header-title">Аватар</h4>

						<?php if(!empty($warning_image)) { ?>
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $warning_image; ?>
						</div>
						<?php } ?>

						<input type="file" name="file" id="input-file-now" class="dropify" />                                                   

						<div class="text-center m-t-15">
							<input type="hidden" name="image" value="<?php echo $row['image']; ?>" />
							<button name="edit_image" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Сохранить</button>
						</div>                                        
					</form>

				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?php } ?>