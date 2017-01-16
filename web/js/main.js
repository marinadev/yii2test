$(document).ready(function() {
	$.each($('img'), function() {
		updateView($(this));
	});

	$('.rotate').on('click', function() {
		img = $(this).parent().parent().find('img');
		$.ajax({
			url: "index.php?r=image/rotate",
			data: { id : $(img).data('id') },
			success: function(result) {
				angle = result;
				updateAngle($(img), angle);
				updateView($(img));
			}
		});
	});

	$('.delete').on('click', function() {
		img = $(this).parent().parent().find('img');
		idImage = $(img).data('id');
		$.ajax({
			url: "index.php?r=image/remove",
			data: { id : idImage },
			success: function(result) {
				if(result)
					$(img).parent().remove();
			}
		});
	});
});

function updateView(obj) {
	w = $(obj).width();
	h = $(obj).height();
	the_margin = (w > h ? (w-h)/2 : 0);
	$(obj).css('marginTop', the_margin);
	$(obj).css('marginBottom', the_margin);
	$(obj).parent().css('paddingTop', the_margin);
	$(obj).parent().css('paddingBottom', the_margin);
}

function updateAngle(obj, angle) {
	$(obj).css("transform", "rotate(" + parseInt(angle, 10) + "deg)");
}