<div class="modal fade bs-example-modal-lg-2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog slideInUp animated">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Пожаловаться</h2>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="p-3">
					
					<form action="" method="post" id="complain-form">
					<div class="form-row">
						<div class="form-group col-sm-6 mx-auto">
							<label>Укажите причину</label>
							<select name="cause">
								<option value="1">Фейковые новости</option>
								<option value="2">Пропаганда наркотиков</option>
								<option value="3">Терроризм</option>
								<option value="4">Материал для взрослых</option>
								<option value="5">Спам</option>
								<option value="6">Призыв к суициду</option>
								<option value="7">Мошенничество</option>
								<option value="8">Травля /Оскорбления</option>
							</select>
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $row['id']; ?>" name="post_id" id="complain_id" />
					
					<?php if(isset($_SESSION['user'])) { ?>
						<button name="complain" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Отправить</button>
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Зарегистрируйтесь
						</div>
						<button name="complain" type="submit" value="true" class="btn btn-primary waves-effect waves-light" disabled>Отправить</button>
					<?php } ?>
					
					</form>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>