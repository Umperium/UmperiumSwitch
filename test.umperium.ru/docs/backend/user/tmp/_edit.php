<?php defined('_JEXEC') or die(); ?>

<div class="tab-control clearfix">
	<ul>
		<li><a href="#tab-user" class="active">Клиент</a></li>
		<li><a href="#tab-post">Посты</a></li>
	</ul>
</div>

<div class="block" >
	<div class="web-form">
		<form action="" method="post">
			
			<div class="tab-item active" id="tab-user">

				<div class="field">
					<label>Фамилия</label>
					<input type="text" name="l_name" value="<?php echo $row['l_name']; ?>" />
				</div>
				
				<div class="field">
					<label>Имя</label>
					<input type="text" name="f_name" value="<?php echo $row['f_name']; ?>" />
				</div>
				
				<div class="field">
					<label>E-mail</label>
					<input type="email" name="email" value="<?php echo $row['email']; ?>" readonly />
				</div>
				
				<div class="field">
					<label>Пол</label>
					<select name="sex">
						<option value="male" <?php echo $row['sex']=='male'?'selected':''; ?>>Мужской</option>
						<option value="female" <?php echo $row['sex']=='female'?'selected':''; ?>>Женский</option>
					</select>
				</div>
				
				<div class="field">
					<label>Город</label>
					<input type="text" name="city" value="<?php echo $row['city']; ?>" />
				</div>
				
				<div class="field">
					<label>Счет</label>
					<input type="number" name="score" value="<?php echo $row['score']; ?>" />
				</div>
				
				<div class="field">
					<label><input type="checkbox" name="is_vip" value="1" <?php echo $row['is_vip']==1?'checked':''; ?>> VIP</label>
				</div>
				
				<div class="field">
					<label>Категория</label>
					<select name="category_id">
						<option value="1" <?php echo $row['category_id']==1?'selected':''; ?>>Власть</option>
						<option  value="2" <?php echo $row['category_id']==2?'selected':''; ?>>Эксперты</option>
						<option value="3" <?php echo $row['category_id']==3?'selected':''; ?>>Экономика</option>
						<option value="4" <?php echo $row['category_id']==4?'selected':''; ?>>Общество</option>
					</select>
				</div>
				
				<div class="button">
					<button type="submit" name="save" class="btn green" value="true"><i class="far fa-save"></i> Сохранить</button>
					<button type="submit" name="save_add" class="btn green" value="true"><i class="far fa-save"></i> Сохранить и добавить</button>
					<button type="submit" name="save_back" class="btn green" value="true"><i class="far fa-save"></i> Сохранить и вернутся к списку</button>
				</div>
				
			</div>
			
			<div class="tab-item" id="tab-post">
			
			</div>
			
			<input name="id" type="hidden" value="<?php echo $row['id']; ?>"  />
			
		</form>
	</div>
</div>


<?php if(!empty($warning)) { ?>
<div class="pop-overlay limit" style="display:block">
	<div class="overlay"></div>
	<div class="pop-wrapper">
		<div class="pop-content"><?php echo $warning; ?></div>
	</div>
</div>
<?php } ?>