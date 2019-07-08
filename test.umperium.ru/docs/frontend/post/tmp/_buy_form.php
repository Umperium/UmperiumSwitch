<?php 
$disable = true;
$score = 0;
if(isset($_SESSION['user'])) {
	$score = $_SESSION['user']->score;
} 
?>
<div class="modal fade bs-buy" data-score="<?php echo $score; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog  slideInUp  animated">
		<div class="modal-content">
			<div class="modal-header">
				<h2>Купить</h2>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<div class="p-3">
					
					<form action="/post/buy" method="post" id="buy-form">
					
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Цена</label>
							<input id="price-post" type="number" name="price" value="" class="form-control" placeholder="Умпериалов" required readonly>
						</div>
						<input id="id-post" type="hidden" name="id" value="" required readonly>
					</div>

					<div class="alert alert-info alert-dismissible" style="display:none">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Нехватает  умп
					</div>
				
					<button name="buy" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Купить</button>
			
					
					</form>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>