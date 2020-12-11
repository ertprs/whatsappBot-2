$( ".btn_top" ).click(function() {
	$(".mapsPv").removeClass('out');
	$(".mapsPv").addClass('in');
});

$( ".btn_bottom" ).click(function() {
	$(".mapsPv").removeClass('in');
	$(".mapsPv").addClass('out');
});