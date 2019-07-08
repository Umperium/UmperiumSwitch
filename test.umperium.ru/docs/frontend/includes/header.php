<?php 
if(isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
	
	if(empty($user->f_name)) { 
		$user->f_name = 'Пользователь'; 
	}
	if(empty($user->image)) { 
		$user->image = FRONTEND_PATH.'/images/no-avatar.jpg'; 
	}
}
?>

<style type="text/css">
    @media (max-width: 745px) {
        .urhgrihg {
            display: none !important;
        }
    }

    @media (max-width: 485px) {
        .urhgrihg {
            display: none !important;
        }
    }

</style>

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="/" class="logo">
                    <img src="<?php echo FRONTEND_PATH; ?>/images/logo.png" alt="" class="logo-large">
                </a>
				
            </div>
			<div class="menu-extras topbar-custom">
            <ul class="list-inline float-right mb-0">

				<li class="list-inline-item  float-left mr-10">
				<div id="navigation">
				<ul class="navigation-menu text-center">
					<li>
					<a href="/user/rank" class="btn btn-link waves-effect" style="padding-left: 25px;">Лидеры мнений</a>
					</li>
					<li>
					<a href="/post/elite" class="btn btn-link waves-effect">Элита</a>
					</li>
					<li>
					<a href="/group/" class="btn btn-link waves-effect">Сообщества</a>
					</li>

					<li>
					<a href="/post/repost" class="btn btn-link waves-effect">Битва мнений</a>
					</li>
					

				</ul>
				</div>
				</li>
	
				<li class="list-inline-item  notification-list">
                <a href="/post/add" class="btn btn-link waves-effect"><img style="height:32px; width:32px;" src="<?php echo FRONTEND_PATH; ?>/images/writing.png" alt="user"></a>
				</li>
                <!-- language-->


                <?php if(isset($_SESSION['user'])) { ?>
                <!-- notification-->
                <!-- User-->
                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="/classes/thumb.php?src=<?php echo $user->image; ?>&amp;h=36&amp;w=36&amp;zc=1" alt="<?php echo $user->f_name; ?>" class="rounded-circle img-thumbnail img-fluid">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5>Привет, <?php echo $user->f_name; ?></h5>
                        </div>
                        <a class="dropdown-item" href="/user/post"><i class="dripicons-home m-r-5 "></i> Моя страница</a>
                        <a class="dropdown-item" href="/user/edit"><i class="dripicons-user m-r-5 "></i> Мой профиль</a>
                        <a class="dropdown-item" href="/user/score"><i class="dripicons-stack m-r-5 "></i> Мой счет</a>


						<a class="dropdown-item" href="/group/add"><i class="dripicons-stack m-r-5 "></i> Добавить группу</a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/user/logout"><i class="mdi mdi-logout m-r-5 text-muted"></i> Выйти</a>
                    </div>
                </li>
                <?php } else { ?>

                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="/classes/thumb.php?src=<?php echo FRONTEND_PATH; ?>/images/no-login.jpg&amp;h=36&amp;w=36&amp;zc=1" alt="<?php echo $user->f_name; ?>" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->


                        <a href="/user/reg" class="dropdown-item">Регистрация</a>
                        <a href="/user/auth" class="dropdown-item">Вход</a>

                    </div>
                </li>
                <?php } ?>


				<li class="menu-item list-inline-item">
				<!-- Mobile menu toggle-->
				<a class="navbar-toggle nav-link">
					<div class="lines">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</a>
				<!-- End mobile menu toggle-->
				</li>

            </ul>

			</div>


        </div>


		<?php /*
        <div class="container d-flex justify-content-center py-2">
            <a href="/" class="dev-logo text-white text-center"> <p class="mb-0" style="padding:.3rem; 2rem; background-color:#3b5998;">На главную</p>
<!--                <img src="<?php echo FRONTEND_PATH; ?>/images/logo.png" alt="" class="dev-logo">-->
            </a>
        </div>
		*/?>
        <div class="clearfix"></div>

    </div>
    </div>
    </div>
</header>