<div class="card">
	<div class="card-body">

		<h4 class="mt-0 header-title">Добавить коментарий</h4>
		<form action="" method="post">

			<?php if(!empty($warning)) { ?>
			<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $warning; ?>
			</div>
			<?php } ?>

			<div class="form-group ">
				<label class="mb-2 pb-1">Комментарий</label>
				<textarea name="comment" class="form-control" required placeholder="Выскажите мнение"></textarea>
			</div>

			<div class="form-group mb-0">
				<button name="add_comment" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Отправить</button>
			</div>
		</form>

	</div>
</div>