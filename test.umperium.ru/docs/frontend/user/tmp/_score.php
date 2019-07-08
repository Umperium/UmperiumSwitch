					   <ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link show active" data-toggle="tab" href="#home" role="tab" aria-selected="true">мой счет</a>
			</li>
			<li class="nav-item">
				<a class="nav-link show" data-toggle="tab" href="#profile" role="tab" aria-selected="false">мои ставки</a>
			</li>
			<li class="nav-item">
				<a class="nav-link show" data-toggle="tab" href="#messages" role="tab" aria-selected="false">история</a>
			</li>
			<li class="nav-item">
				<a class="nav-link show" data-toggle="tab" href="#settings" role="tab" aria-selected="false">что такое умпериалы и ставки?</a>
			</li>
		</ul> 
		
<div class="tab-content">
	<div class="tab-pane p-3 show active" id="home" role="tabpanel">
		<p class="font-14 mb-0">

</p><div class="row">

<div class="col-lg-8 mx-auto">
<div class="card">
<div class="card-body">

<h4 class="text-lightdark">Ваш баланс</h4>
<div class="umpval"><?php echo $row['score'];?> </div>



<p class="text-muted mb-4 font-14">Один - <code>умпериал </code>это 1 российский рубль</p>
<div class="general-label">
	<form class="form-inline" role="form">


		<div class="form-group m-l-10">
			<label class="sr-only" for="exampleInputPassword2">Сумма</label>
			<input type="password" class="form-control ml-2" id="exampleInputPassword2" placeholder=" Сумма (руб)">
		</div>
		<div class="form-group ml-2">

		</div>
		<button type="submit" class="btn btn-success ml-2">Пополнить баланс</button>
	</form>           
</div>
</div><!--end card-body--></div>
<!--end card-->

</div>

</div>
				<p></p>
	</div>
	<div class="tab-pane p-3 show" id="profile" role="tabpanel">
		<div class="col-sm-12">
		
		
	<?php Frontend_User_Post_Promo('_post_promo'); ?>



</div>
	</div>
	<div class="tab-pane p-3 show" id="messages" role="tabpanel">
		<p class="font-14 mb-0">

		</p>
	</div>
	<div class="tab-pane p-3 show" id="settings" role="tabpanel">
		<p class="font-14 mb-0">
			 По умолчанию стоимость размещения составляет </p><div class="umpval">100</div> умпериалов.
Время размещения объекта промотирования (записи, журнала или сообщества) составляет максимум 1 час. Если место размещения уже занято, пользователь может перекупить его, предложив более высокую цену, при этом надбавка должна быть кратна <div class="umpval">100</div>

Любой пользователь может перекупить место в Аукционном Промо, предложив цену хотя бы на <div class="umpval">100</div>  больше. Автор смещенной записи, журнала или сообщества в этом случае получит неизрасходованный остаток средств.
		<p></p>
	</div>
</div>