<?php $user = $_SESSION['user'];?>
<header id="header" class="clearfix">
	<div class="logo">
	
	</div>
	<a href="#" class="trigger-aside"><i class="fa fa-bars"></i></a>
	
	<div class="user">
		<div class="thumb"></div>
		<div class="name"><?php echo $user->name; ?></div>
	</div>
	
</header>