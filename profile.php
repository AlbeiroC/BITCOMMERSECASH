<?php
	include( './cm/function.beta.php');
	$need_show = 'inicio,ajustes,bitsend,salir';
	login_required();
	$user = is_session();
	$page = (!empty($_GET['page'])) ? strtolower(trim($_GET['page'])) : 'product';
	$page_php = './cm/components_html/'.$page.'.php';
	$page_js = './cm/components_html/'.$page.'.js';
?>
<!DOCTYPE html>
<html class="">
<!-- Primera parte -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" 						content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta property="og:title"					content="BitCommerseCash">
	<meta property="og:image"					content="https://bitcommersecash.com/img/og/facebook_860x451.png">
	<meta property="og:description"				content="Bitcommercash es una pagina web de ventas online con excelente idea de negocio, basado en la implementacion de BTC como medio de pago." />
	<meta property="og:type"					content="article:published" />
	<meta property="og:url"						content="https://bitcommersecash.com/" />		
	
	<link rel="stylesheet"						hrf="https://www.jqueryscript.net/demo/Powerful-Lightweight-jQuery-Tag-Management-Plugin-tagEditor/jquery.tag-editor.css">
	<link rel="stylesheet"	type="text/css"		href="https://fonts.googleapis.com/css?family=Lobster">
	<link rel="stylesheet"	type="text/css"		href="./fonts/google.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/select2.min.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/bulma-plugins.css">
	<link rel="stylesheet"	type="text/css"		href="./css/jquery.tipsy.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/dropzone.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/easy-autocomplete.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/easy-autocomplete.themes.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/comentarios.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/jquery.dialog.css" />
	<link rel="stylesheet"	type="text/css"		href="./css/bulma.css">
	<link rel="stylesheet"	type="text/css"		href="./css/menu.css" />
	<link rel="icon" 		type="text/css"		href="./img/logo/favicon.png">
	<title><?php echo $user['data']['user']['nombre']; ?></title>
</head>
<!-- Primera parte -->
<body>
	<?php include('./cm/nav.php'); ?>
	<!-- Cabezera de la seccion de perfil -->
	<div class="container is-fluid" style="margin-bottom: 60px;">
		<?php 
			if (!empty($_SESSION['notification'])) {
				echo '<div class="notification is-'.$_SESSION['notification']['icon'].'"><button class="delete"></button>';
				echo urldecode($_SESSION['notification']['texto']);
				echo '</div>';
				unset($_SESSION['notification']);
			
			}
		?>
			<div class="hero is-primary is-bg-animated">
			<div class="hero-body" style="padding-bottom: 0px;padding-top: 0px; min-height: 200px;">
				<div class="columns">
					<div class="column is-2-desktop is-offset-5-desktop is-4-mobile is-offset-4-mobile" style="position: relative;">
						<div class="box" style="padding: 5px;position: absolute;height: auto;width: 100%;top: 100px;left: 0px;">
							<figure class="image">
								<img class="user-data-user-imagen" data-src="" style="position: relative;border-radius: 5px;max-height: 150px;">
							</figure>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Fin de Cabezera de la seccion de perfil -->
	<!-- Opciones del perfil -->
	<div class="container is-fluid">
		<div class="columns is-multiline is-mobile" style="padding-left: 10px;padding-right: 10px;">
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=product" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span> <i class="fa fa-plus"></i> </span>
		    				</span>
							<div> <div>Publicar</div> </div>
						</div>
					</div>
				</a>
			</div>
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=my_gallery" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span class="hidden user-data-user-publicaciones">
		    						<i class="fa fa-refresh fa-sync fa-spin"></i>
		    					</span>
		    					<span class="show"> <i class="fa fa-eye"></i> </span>
		    				</span>
							<div class="hidden"> Mis Productos </div>
							<div class="show"> Revisar </div>
						</div>
					</div>
				</a>
			</div>
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=favoritos" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span class="show user-data-user-favoritos">
		    						<i class="fa fa-refresh fa-sync fa-spin"></i>
		    					</span>
		    					<span class="hidden">
		    						<i class="fa fa-heart has-text-danger"></i>
		    					 </span>
		    				</span>
							<div class="">
								<div class="hidden">Favoritos</div>
								<div class="show">Revisar</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=comentarios" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span>
		    						<i class="fa fa-comments"></i>
		    					</span>
		    				</span>
							<div class="">
								<div class="hidden">Comentarios</div>
								<div class="show">Leer</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=imbox" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span>
		    						<i class="fa fa-comment"></i>
		    					</span>
		    				</span>
							<div class="">
								<div class="hidden">Mensajes</div>
								<div class="show">Leer</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="column is-6-mobile">
				<a class="pricing-table" href="profile.php?page=settings" style="width: 100%;">
					<div class="pricing-plan is-active">
						<div class="plan-price on-hover">
							<span class="plan-price-amount">
		    					<span>
		    						<i class="fa fa-cogs"></i>
		    					</span>
		    				</span>
							<div class="">
								<div>Ajustes</div>
							</div>
						</div>
					</div>
					</a>
			</div>
		</div>
	</div>
	<!-- Fin de Opciones del perfil -->
	<div class="container is-fluid has-text-light">
		<div class="columns">
			<div class="column is-panel-loader is-two-thirds-tablet is-two-thirds-desktop is-full-mobile has-text-black-ter">
				<?php include($page_php); ?>
			</div>
		</div>
	</div>
	<script sync src="./js/cookie.js"></script>
	<script sync src="./js/bulma-steps.min.js"></script>
	<script sync src="./js/jquery-3.1.1.slim.min.js"></script>
	<script sync src="./js/jquery.min.js"></script>
	<script sync src="./js/jquery.easy-autocomplete.js"></script>
	<script sync src="./js/jquery.dialog.js"></script>
	<script sync src="./js/dropzone.js"></script>
	<script sync>Dropzone.autoDiscover = false;</script>

	<script sync defer src="./js/fontawesome-all.min.js"></script>
	<script sync src="./js/moment.min.js"></script>
	<script sync src="./js/moment-with-locales.min.js"></script>
	<script sync src="./js/jquery.number.min.js"></script>
	<script sync src="./js/popper.min.js"></script>
	<script sync src="./js/jquery.tipsy.js"></script>
	<script sync src="./js/functions.js"></script>
	<script sync src="./js/plugins.js"></script>
	<script sync src="./api_v2/user/info.js"></script>
	<script sync src="./api_v2/items/items.js"></script>
	<script async ajax-loader src="<?php echo $page_js; ?>"></script>
	<script async>
			function delStep2(json) {
				if (typeof json == 'object') {
					if (!empty(json.code)) {
						switch (json.code) {
							case 1:
								dialog.alert({
									message:"Eliminado exitosamente.",
									button:"Cerrar",
									callback:function () {
										push(false,false,"manage,product_id,delete");
										window.location.reload();
									}
								});
							break;
							case 400:
									switch (json.response) {
									case "token":
										dialog.prompt({
											message:"Indica tu clave de seguridad: ",
												input: {
											type: "password",
											placeholder: "Clave de acceso a BitCommerseCash"
										},
										callback:function (tk) {
											var s = (tk.length>0) ? deleteProduct(json.data,tk) : false;
										}
										});
										break;
									default:
											dialog.alert({
											message:"No tienes permisos para realizar esta accion.",
											button:"Cerrar",
											callback:function () {
												window.location.reload();
											}
										});
									break;
								}
								break;
							case 404:
								dialog.alert({
									message:"No hemos conseguido este item.",
									button:"Cerrar",
									callback:function () {
										window.location.reload();
									}
								});
							break;
							case 500:
								dialog.alert({
									message:"Estamos presentando un error en el servidor, intenta de nuevo en un momento.",
									button:"Cerrar",
									callback:function () {
										window.location.reload();
									}
								});
							break;
						}
					}
				}
				return false;
			}
			function deleteProduct(item,tk=false) {
				to_delete = item.item.id;
				$.ajax({
					url: './api_v2/items/items.php',
					error:function (err) {},
					data: {deleteItem: to_delete,token:tk},
					success:function (json) {
						delStep2(json);
					}
				});
			}
			function editProduct(json) {
				if (typeof json == 'object') {
					if (!json.is_my) {
						return false;
					}
					$('form[key] [name="producto"]')
					.val(json.producto)
					.parents('form').prepend('<input type="hidden" name="updated" value="'+json.id_producto+'" />');
					$('form[key] [name="descripcion"]').val(json.descripcion);
					$('form[key] [name="stock"]').val(json.existencias);
					$('form[key] [name="usd_price"]')
					.val(json.precio_usd);
					setTimeout(function () {
						$('form[key] [name="usd_price"]')
						.trigger('blur')
							.trigger('keyup');
					},1500);
					$.each(json.imagen,function(index, el) {
						$('[name="file-uploads"]')
						.parent('.column')
						.before('<div class="column is-2 img_thumb_'+index+'" style="min-width: 70px;text-align:center;"><img class="button" id="thumb_'+index+'" src="'+el+'" style="width: 70px; height: 50px;"></div>');
					});
					$.each(json.payments,function(index, el) {
						$('[name="payment[]"][value="'+el.toLowerCase()+'"]').prop('checked',true);
						});
					json.destination = json.destination.split(",");
					$.each(json.destination,function(index, el) {
						$('[name="shipping[]"][value="'+el+'"]').prop('checked',true);
					});
					}
				return false;
			}
		$(function(){
			<?php
				if (!empty($_GET['manage'])&&!empty($_GET['product_id'])) {
					$item = itemInfo($_GET['product_id'],true);
					echo 'var producto = ';
					print_r($item);
					echo ";";
					if (is_array(json_decode($item,true))) {
						echo (!empty($_GET['delete'])) ? "	deleteProduct(producto);" : " editProduct(producto);";
					}
				}
			?>				
		});
	</script>
</body>
</html>