<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.2&appId=1671514922995332&autoLogAppEvents=1"></script>
<div class="col-12">
	<div class="card">
		<div class="card-body">

			<div class="text-center mt-2 mb-4">
				<a href="/" class="logo logo-admin"><img src="<?php echo FRONTEND_PATH; ?>/images/logo-black.png" height="50" alt="logo"></a>

			</div>
				<div class="col-sm-3 mx-auto">
<div class="fb-login-button" data-size="small" data-button-type="login_with" data-auto-logout-link="true" data-use-continue-as="false"></div>
</div>

			<div class="px-3 pb-3">
				<form class="form-horizontal m-t-20" action="" method="post">
					
					<?php if(!empty($warning)) { ?>
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<?php echo $warning; ?>
					</div>
					<?php } ?>
					
					<div class="form-group row">
						<div class="col-12">
							<input class="form-control" type="email" name="email" required placeholder="E-mail">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-12">
							<input class="form-control" type="password" name="password" required placeholder="Пароль">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-12">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customCheck1">
								<label class="custom-control-label" for="customCheck1">Запомнить меня</label>
							</div>
						</div>
					</div>
					
					<div class="form-group text-center row m-t-20">
						<div class="col-12">
							<button class="btn btn-primary waves-effect waves-light" type="submit" name="auth" value="true">Войти</button>
						</div>
					</div>

					<div class="form-group m-t-10 mb-0 row">
						<div class="col-sm-7 m-t-20">
							<a href="/user/recovery" class="text-muted"><i class="mdi mdi-lock"></i> Проблемы со входом?</a>
						</div>
						<div class="col-sm-5 m-t-20">
							<a href="/user/reg" class="text-muted"><i class="mdi mdi-account-circle"></i> Завести блог?</a>
						</div>
                     
					</div>
				</form>
			</div>

		</div>
	</div>
</div>