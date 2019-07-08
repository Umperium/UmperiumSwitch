<?php $route = Route(); ?>
<aside id="aside">
	<div class="nav-wrapper scrollbar">
		<nav>
			<ul>
				<li>
					<a href="/backend/country" class="<?php echo $route['id']=='country'?'active':''; ?>"><i class="fa fa-city"></i>Страны</a>
				</li>
				<li>
					<a href="/backend/user" class="<?php echo $route['id']=='user'?'active':''; ?>">
						<i class="fa fa-user"></i>Пользователи
					</a>
				</li>
				<li>
					<a href="/backend/trend" class="<?php echo $route['id']=='trend'?'active':''; ?>">
						<i class="fab fa-slack-hash"></i>Тренды
					</a>
				</li>
				<li>
					<a href="/backend/post_complain" class="<?php echo $route['id']=='post_complain'?'active':''; ?>">
						<i class="fas fa-ribbon"></i>Жалобы
					</a>
				</li>
				<li>
					<a href="/"><i class="fa fa-desktop"></i> Перейти на сайт</a>
				</li>
				<li><a href="/user/logout"><i class="fa fa-sign-out-alt"></i>Выход</a></li>
			</ul>
		</nav>
	</div>
</aside>