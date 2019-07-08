<?php 
$disable = true;

$score = 0;
$new_score =$row['score']+100;

if(isset($_SESSION['user'])) {
	$score = $_SESSION['user']->score;
	
	if($score > $row['score']+100) {
		$disable = false;
	} 
} 
?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog  slideInUp  animated">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Текущая ставка <span class="badge badge-default"><?php echo $row['score']==''?'0':$row['score']; ?> умп</span></h2>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="p-3">
					
					<form action="/post/promo" method="post" id="promo-form">
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Ваша ставка</label>
							<input type="number" name="score" step="100" value="<?php echo $new_score; ?>" min="<?php echo $new_score; ?>" max="<?php echo $score>$new_score?$score:$new_score; ?>" class="form-control" placeholder="min - <?php echo $new_score; ?> умпериалов" required>
						</div>
						<div class="form-group col-md-6">
							<label>Ваш пост</label>
							<input type="url" name="slug" class="form-control" placeholder="URL" required>
						</div>
					</div>
					<p class="card-text">Моя запись соответствует <a href="#"> требованиям Умпериум </a></p>

					
					<?php if($disable) { ?>
						<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Нехватает <?php echo $new_score-$score; ?> умп
						</div>
					
						<button name="promo" type="submit" value="true" class="btn btn-primary waves-effect waves-light" disabled>Поставить</button>
					<?php } else { ?>
						<button name="promo" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Поставить</button>
					<?php } ?>
					
					</form>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>