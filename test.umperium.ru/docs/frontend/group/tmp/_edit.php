<div class="row">

<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<h4 class="mt-0 header-title">Изменить информацию</h4>

			<form action="" method="post">
				
				<?php if(!empty($warning_info)) { ?>
				<div class="alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $warning_info; ?>
				</div>
				<?php } ?>
				
				<div class="form-group">
					<label class="mb-2 pb-1">Название</label>
					<input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required data-parsley-maxlength="6" placeholder="Иван">
				</div>
				
				<div class="form-group mb-0">
					<button name="edit_info" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Сохранить</button>
				</div>
				
			</form>

		</div>
	</div>
</div>
</div>