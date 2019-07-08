<div class="row">
<div class="col-lg-6">
	<div class="card">
		<div class="card-body">
			<h4 class="mt-0 header-title">Изменить профиль</h4>

			<form action="" method="post">
				
				<?php if(!empty($warning_profile)) { ?>
				<div class="alert alert-info alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $warning_profile; ?>
				</div>
				<?php } ?>
				
				<div class="form-group mb-0">
					<label class="mb-2 pb-1">Изменить основной email</label>
					<input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required data-parsley-minlength="6" placeholder="mail@mail.ru">
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Пароль</label>
					<input type="password" name="password" id="password" class="form-control" value="" data-parsley-minlength="6" placeholder="пароль">
				</div>
				
				<div class="form-group mb-0" >
					<label class="my-2 py-1">Подтвердите пароль</label>
					<input type="password" name="password_repeat" id="password-repeat" class="form-control" value="" data-parsley-minlength="6" placeholder="пароль">
				</div>

				<div class="form-group ">
					<label class="my-2 py-1">Реферальная ссылка</label>
					<input type="text" class="form-control" value="<?php echo URL_FRONTEND; ?>/user/reg?referral=<?php echo $referral_id; ?>" readonly  >
				</div>

				<input type="hidden" name="old_password" value="<?php echo $row['password']; ?>">
				<input type="hidden" name="salt" value="<?php echo $row['salt']; ?>">
				<input type="hidden" name="referral_id" value="<?php echo $referral_id; ?>">

				<div class="form-group mb-0">
					<button name="edit_profile" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Сохранить</button>
				</div>
			</form>

		</div>
	</div>
</div>
<div class="col-lg-6">
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
				
				<div class="form-group mb-0">
					<label class="mb-2 pb-1">Имя</label>
					<input type="text" name="f_name" class="form-control" value="<?php echo $row['f_name']; ?>" required data-parsley-maxlength="6" placeholder="Иван">
				</div>
				<div class="form-group mb-0">
					<label class="my-2 py-1">Фамилия</label>
					<input type="text" name="l_name" class="form-control" value="<?php echo $row['l_name']; ?>" required data-parsley-maxlength="6" placeholder="Иванов">
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Дата рождения</label>
					<input type="text" name="birthday" class="form-control" value="<?php  echo $row['birthday']=="0000-00-00"?date("m/d/Y"):date("m/d/Y", strtotime($row['birthday'])); ?>" placeholder="mm/dd/yyyy" required id="datepicker">
				</div>
				
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Страна</label>
					<select class="form-control" name="country_id">
						<?php while ( $row_country = $RESULT_COUNTRY->fetch() ) {  ?>
						<option value="<?php echo $row_country['id'] ?>" <?php echo $row_country['id']==$row['country_id']?'selected':''; ?>><?php echo $row_country['name'] ?></option>
						<?php } ?>
					</select>
				</div>

				<div class="form-group mb-0">
					<label class="my-2 py-1">Город</label>
					<input type="text" name="city" class="form-control" value="<?php echo $row['city']; ?>" required data-parsley-length="[5,10]" placeholder="Россия">
				</div>

				<div class="form-group mb-0">
					<label class="my-2 py-1">Пол</label>
					<select class="form-control" name="sex">
						<option value="male" <?php echo $row['sex']=='male'?'selected':''; ?>>Мужской</option>
						<option value="female" <?php echo $row['sex']=='female'?'selected':''; ?>>Женский</option>
					</select>
				</div>

				<div class="form-group mb-0">
					<label class="my-2 py-1">Место жительства</label>
					<input type="text" name="residence" class="form-control" value="<?php echo $row['residence']; ?>"   >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Место работы</label>
					<input type="text" name="work" class="form-control" value="<?php echo $row['work']; ?>"  >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">VK</label>
					<input type="url" name="vk" class="form-control" value="<?php echo $row['vk']; ?>"   >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Facebook</label>
					<input type="url" name="facebook" class="form-control" value="<?php echo $row['facebook']; ?>"   >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Оdnoklassniki</label>
					<input type="url" name="odnoklassniki" class="form-control" value="<?php echo $row['odnoklassniki']; ?>"   >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Instagram</label>
					<input type="url" name="instagram" class="form-control" value="<?php echo $row['instagram']; ?>"   >
				</div>
				
				<div class="form-group mb-0">
					<label class="my-2 py-1">Twitter</label>
					<input type="url" name="twitter" class="form-control" value="<?php echo $row['twitter']; ?>"   >
				</div>
				
				
				
				<div class="form-group">
					<label class="my-2 py-1">О себе</label>
					<textarea  name="about" class="form-control"  ><?php echo $row['about']; ?></textarea>
				</div>
				
				<div class="form-group mb-0">
					<button name="edit_info" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Сохранить</button>
				</div>
				
			</form>

		</div>
	</div>
</div>
</div>