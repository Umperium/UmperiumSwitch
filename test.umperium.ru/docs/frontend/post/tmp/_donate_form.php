<?php 
$score = 0;

if(isset($_SESSION['user'])) {
	$score = $_SESSION['user']->score;
} 
?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog slideInUp animated">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Пожертвовать автору</h2>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="p-3">
					
					<form action="/post/donate" method="post" id="donate-form">
					<p class="card-text">Введите количество умпериалов, которое вы хотите отправить автору за статью.</p>
					<div class="form-row">
						<div class="form-group col-sm-6 mx-auto">
							<label>Кол-во УМП</label>
							<input type="number" name="score" step="1" value="1" min="1" max="<?php echo $score; ?>" class="form-control" placeholder="min - 1 умпериалов" required>
						</div>
					</div>
					
					<input type="hidden" value="<?php echo $row['user_id']; ?>" name="user_id" />
					
					<?php if($score < 1) { ?>
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							0 умп
						</div>
					
						<button name="donate" type="submit" value="true" class="btn btn-primary waves-effect waves-light" disabled>Отправить</button>
					<?php } else { ?>
						<button name="donate" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Отправить</button>
					<?php } ?>
					
					</form>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>