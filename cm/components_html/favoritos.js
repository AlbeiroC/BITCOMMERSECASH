// Favoritos JS
$(function () {
	setTimeout(function () {
		$('.favorites-panels')
		.cargarProductos({
			data:{
				query:'favoritos',
				limit:4,
				order:'desc',
			},
			clase:'is-half',
		});
	},100);
	$(document)
	.on('click', '[href="#load_more"]', function(event) {
		event.preventDefault();
		$('.favorites-panels')
		.cargarProductos({
			data:{
				query:'favoritos',
				limit:4,
				order:'desc',
			},
			clase:'is-half',
		});
	});
});
// Fin de Favoritos JS