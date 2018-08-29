<style>

body {
	background: #F0F0F0;
	font-size: 15px;
	color: #666;
	font-family: 'Roboto', sans-serif;
}
.content {
	height: 200px;
}

.container {
	max-width: 1200px;
	margin: 0 auto;
	width: 100%;
}

.nav-fostrap {
	display: block;
	background: #03A9F4;
	-webkit-box-shadow: 0 1px 20px 0 rgba(0, 0, 0, 0.26);
	-moz-box-shadow: 0 1px 20px 0 rgba(0, 0, 0, 0.26);
	-ms-box-shadow: 0 1px 20px 0 rgba(0, 0, 0, 0.26);
	-o-box-shadow: 0 1px 20px 0 rgba(0, 0, 0, 0.26);
	box-shadow: 0 1px 20px 0 rgba(0, 0, 0, 0.26);
	border-radius: 0px;
}

 ul {
	list-style-type: none;
	margin: 0;
	padding: 0;
	display: block;
}

.nav-fostrap li {
	margin: 0;
	padding: 0;
	display: inline-block;
	color: #fff;
}

.nav-fostrap li a {
	padding: 15px 20px;
	font-size: 14;
	color: #fff;
	display: inline-block;
	outline: 0;
	font-weight: 400;
}

.nav-fostrap li:hover ul.dropdown { display: block; }

.nav-fostrap li ul.dropdown {
	position: absolute;
	display: none;
	width: 200px;
	background: #2980B9;
	-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-ms-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-o-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	padding-top: 0;
}

.nav-fostrap li ul.dropdown li {
	display: block;
	list-style-type: none;
}

.nav-fostrap li ul.dropdown li a {
	padding: 15px 20px;
	font-size: 15px;
	color: #fff;
	display: block;
	font-weight: 400;
}

.nav-fostrap li ul.dropdown li:last-child a { border-bottom: none; }

.nav-fostrap .level-item:hover a {
	background: #2980B9;
	color: #fff !important;
}

.nav-fostrap li:first-child:hover a { border-radius: 3px 0 0 3px; }

.nav-fostrap li ul.dropdown li:hover a { background: rgba(0,0,0, .1); }

.nav-fostrap li ul.dropdown li:first-child:hover a { border-radius: 0; }

.nav-fostrap li:hover .arrow-down { border-top: 5px solid #fff; }

.arrow-down {
	width: 0;
	height: 0;
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #def1f0;
	position: relative;
	top: 15px;
	right: -5px;
	content: '';
}
.title-mobile {
	display: none;
}
 @media only screen and (max-width:900px) {

.nav-fostrap {
	background: #fff;
	width: 200px;
	height: 100%;
	display: block;
	position: fixed;
	left: -200px;
	top: 0px;
	-webkit-transition: left 0.25s ease;
	-moz-transition: left 0.25s ease;
	-ms-transition: left 0.25s ease;
	-o-transition: left 0.25s ease;
	transition: left 0.25s ease;
	margin: 0;
	border: 0;
	border-radius: 0;
	overflow-y: auto;
	overflow-x: hidden;
	height: 100%;
}
.title-mobile {
	/*position: fixed;*/
	display: block;
		top: 10px;
		font-size: 20px;
		left: 100px;
		right: 100px;
		text-align: center;
		color: #FFF;
}
.nav-fostrap.visible {
	left: 0px;
	-webkit-transition: left 0.25s ease;
	-moz-transition: left 0.25s ease;
	-ms-transition: left 0.25s ease;
	-o-transition: left 0.25s ease;
	transition: left 0.25s ease;
}

.nav-bg-fostrap {
	display: inline-block;
	vertical-align: middle;
	width: 100%;
	height: 50px;
	margin: 0;
	position: absolute;
	top: 0px;
	left: 0px;
	background: #03A9F4;
	padding: 12px 0 0 10px;
	-webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-ms-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	-o-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
	box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
}

.navbar-fostrap {
	display: inline-block;
	vertical-align: middle;
	height: 50px;
	cursor: pointer;
	margin: 0;
		position: absolute;
		top: 0;
		left: 0;
		padding: 12px;
}

.navbar-fostrap span {
	height: 2px;
	background: #fff;
	margin: 5px;
	display: block;
	width: 20px;
}

.navbar-fostrap span:nth-child(2) { width: 20px; }

.navbar-fostrap span:nth-child(3) { width: 20px; }

.nav-fostrap ul { padding-top: 50px; }

.nav-fostrap li { display: block; }

.nav-fostrap li a {
	display: block;
	color: #999;
	font-weight: 600;
}

.nav-fostrap li:first-child:hover a { border-radius: 0; }

.nav-fostrap li ul.dropdown { position: relative; }

.nav-fostrap li ul.dropdown li a {
	background: #2980B9 !important;
	border-bottom: none;
	color: #fff !important;
}

.nav-fostrap li:hover a {
	color: #ccc !important;
}

.nav-fostrap li ul.dropdown li:hover a {
	background: rgba(0,0,0,.1); !important;
	color: #fff !important;
}

.nav-fostrap li ul.dropdown li a { padding: 10px 10px 10px 30px; }

.nav-fostrap li:hover .arrow-down { border-top: 5px solid #fff; }

.arrow-down {
	border-top: 5px solid #505050;
	position: absolute;
	top: 20px;
	right: 10px;
}

.cover-bg {
	background: rgba(0,0,0,0.5);
	position: fixed;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
}
}
 @media only screen and (max-width:1199px) {

.container { width: 96%; }
}

.fixed-top {
	position: fixed;
	top: 0;
	right: 0;
	left: 0;
}
</style>
<div id="main">
	<div class="container">
		<nav style="position:  fixed; top:  0px; left:  0px; width:  100%; height:  auto;z-index: 9999999;">
			<div class="nav-fostrap">
				<ul class="level">
					<li class="level-left is-flex-desktop">
						<div class="level-item" style="width: auto;">
							<img data-src="./../img/logo/logo_brand_original.png" style="max-height: 30px;width: 100px;height:30px;" class="is-hidden-mobile">
							<img data-src="./../img/logo/logo_brand_inverse.png" style="max-height: 30px;width: 100%;height:45px;margin-top: 10px;" class="is-hidden-desktop">
						</div>
						<div class="level-item" style="width: 100%;">

							<div class="field" style="width: 100%;">
								<form action="/query">
							  		<p class="control has-icons-right">
										<input class="input" type="text" placeholder="Buscar" name="query" value="<?php echo (!empty($_GET['query'])&&strtolower(trim($_GET['query']))!='rand') ? strtolower($_GET['query']) : ""; ?>">
										<span class="icon is-small is-right">
											<i class="fa fa-search"></i>
										</span>
							  		</p>
							  	</form>
							</div>

						</div>
					</li>
					<li class="level-right is-flex-desktop">
						<?php
							$need_show = (!empty($need_show)) ? explode(',', $need_show) : explode(',');
							foreach ($need_show as $index) {
								if (!empty(is_array($pages_links[$index]))&&!empty($pages_links[$index]['start'])) {
									$array = $pages_links[$index];
									$addEd = (!empty($array['added'])) ? $array['added'] : '';
									$icon = (!empty($array['icon'])) ? '<i class="'.$array['icon'].'"></i>' : '<img data-src="'.$array['img'].'" style="height:20px;width:20px;" data-style='."'".'{"background-size":"contain"}'."'".'>';
									$target = (!empty($array['target'])) ? ' target="blank_" ' : '';
									echo '<div class="level-item" style=""><a title="'.$array['titulo'].'" '.$target.' href="'.$array['href'].'" style="width:100%;">';
									echo $icon.$addEd;
									echo '	<span class="is-hidden-tablet">'.$array['titulo'].'</span>';
									echo '</a></div>';
								}
							}

							foreach ($need_show as $index) {
								if (!empty(is_array($pages_links[$index]))&&empty($pages_links[$index]['start'])) {
									$array = $pages_links[$index];
									$icon = (!empty($array['icon'])) ? '<i class="'.$array['icon'].'"></i>' : '<img data-src="'.$array['img'].'" style="height:20px;width:20px;" data-style='."'".'{"background-size":"contain"}'."'".'>';
									$target = (!empty($array['target'])) ? ' target="blank_" ' : '';
									echo '<div class="level-item" style=""><a title="'.$array['titulo'].'" '.$target.' href="'.$array['href'].'" style="width:100%;">';
									echo $icon;
									echo '	<span class="is-hidden-tablet">'.$array['titulo'].'</span>';
									echo '</a></div>';
								}
							}
						?>
					</li>
				</ul>
			</div>
			<div class="nav-bg-fostrap">
				<div class="navbar-fostrap"> <span></span> <span></span> <span></span> </div>
				<a href="" class="title-mobile buffer-contain"></a>
			</div>
		</nav>
</div>
</div>
