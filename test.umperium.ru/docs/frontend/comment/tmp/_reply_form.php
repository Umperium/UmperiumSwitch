<form action="" method="post">
	<div class="form-group ">
		
		<label class="mb-2 pb-1">Комментарий</label>
		<textarea name="comment" class="form-control" required placeholder="Выскажите мнение"></textarea>
		<input type="hidden" name="reply_id" value="<?php echo $reply_id; ?>" />
	</div>
	

	<div class="form-group mb-0">
		<button name="add_comment" type="submit" value="true" class="btn btn-primary waves-effect waves-light mb-4">Отправить</button>
	</div>
</form>
