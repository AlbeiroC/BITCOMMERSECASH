function allIm(min_=0) {
	$.ajax({
		url: './../../api_v2/imbox/imbox.php',
		data: {imbox: 'all',min_id:min_},
		success:function (r) {
			if (r.status=='success') {
				$.each(r.data,function(index, el) {
					html  = '<a class="panel-block box" comment_id="'+el.id+'" href="/contact/'+el.referencia+'">';
					html += '<nav class="level" style="width:  100%;overflow-x: hidden;">';
					html += '<div class="level-left">';
					html += '<div class="level-item">';
					html += '<span class="panel-icon">';
					html += '<i class="fab fa-facebook-messenger" aria-hidden="true"></i>';
					html += '</span>';
					html += '</div>';
					html += '<div class="level-item has-text-weight-bold has-text-grey-dark">';
					html += el.user_by;
					html += '</div>';
					html += '</div>';
					html += '<span class="is-hidden-mobile" style="margin-right: 10px;"></span>';
					html += '<div class="level-right">';
					html += '<div class="level-item">';
					html += el.texto;
					html += '</div>';
					html += '</div>';
					html += '</nav>';
					html += '</a>';
					if (!$('.imbox-list').find('[comment_id="'+el.id+'"]')[0]) {
						$('.imbox-list').append(html);
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
		min_id = $('.imbox-list').find('[comment_id]');
		min_id = (min_id.length>0) ? min_id.last().attr('comment_id') : 0;
		allIm(min_id);
	});
	allIm();
});
