
function allCo(min_=0) {
	$.ajax({
	url: './../../api_v2/items/items.php',
	type: 'get',
	data: {comments:'all',min_id:min_,sort:'desc',limit:12},
	success:function (r) {
		if (r.status=='success') {
			if (r.data.length>0) {}
			$.each(r.data,function(index, el) {
				html = '<div class="box" comment_id="'+el.id+'">';
				html += '<article class="media">';
				html += '<div class="media-left">';
				html += '<figure class="image is-64x64">';
				html += '<img data-src="'+el.imagen+'" alt="Image">';
				html += '</figure>';
				html += '</div>';
				html += '<div class="media-content">';
				html += '<div>';
				html += '<p>';
				html += '<strong>'+el.nombre+'</strong>';
				html += '<br>';
				html += "Comentario: - "+el.comentario;
				html += '</p>';
				html += '<nav class="level is-mobile">';
				html += '</div>';
				html += '<nav class="level is-mobile">';
				html += '<div class="level-left">';
				html += '<a class="level-item" href="/view.php?id='+el.post_id+'">';
				html += '	<span class="icon is-small">';
				html += '		<i class="fas fa-reply" aria-hidden="true"></i>';
				html += '	</span>';
				html += '</a>';
				html += '</div>';
				html += '</nav>';
				html += '</div>';
				html += '</article>';
				html += '</div>';
				if (!$('.load-comentarios').find('[comment_id="'+el.id+'"]')[0]) {
					$('.load-comentarios').append(html);
				}
			});
		}
	}
});
}

$(function(){
	$(document)
	.on('click', '[href="#load_more"]', function(event) {
		event.preventDefault();
		min_id = $('.load-comentarios').find('[comment_id]');
		min_id = (min_id.length>0) ? min_id.last().attr('comment_id') : 0;
		allCo(min_id);
	});
	allCo();
});
