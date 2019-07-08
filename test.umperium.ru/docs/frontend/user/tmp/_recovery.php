<div class="col-12">
	<div class="card">
		<div class="card-body">

			<div class="text-center mt-2 mb-4">
				<a href="/" class="logo logo-admin"><img src="<?php echo FRONTEND_PATH; ?>/images/logo.png" height="20" alt="logo"></a>
			</div>
			<div class="px-3 pb-3">
				<form class="form-horizontal m-t-20" action="" method="post">
					
					<?php if(empty($warning)) { ?>
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Enter your <b>Email</b> and instructions will be sent to you!
					</div>
					<?php } else { ?>
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $warning; ?>
					</div>
					<?php } ?>
					
					<div class="form-group row">
						<div class="col-12">
							<input class="form-control" type="email" name="email" value="" placeholder="Введите E-mail" required />
						</div>
					</div>

					<div class="form-group text-center row m-t-20">
						<div class="col-12">
							<button class="btn btn-danger btn-block waves-effect waves-light" type="submit" name="recovery" value="true">Далее</button>
						</div>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>
