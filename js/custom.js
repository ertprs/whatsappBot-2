$( ".btn_top" ).click(function() {
	$(".mapsPv").removeClass('out');
	$(".mapsPv").addClass('in');
	$("#sub_").css("display", "block");

});

$( ".btn_bottom" ).click(function() {
	$(".mapsPv").removeClass('in');
	$(".mapsPv").addClass('out');
	$("#sub_").css("display", "none");

	$('#jsres').animate({
		scrollTop: ($('.marker-link').first().offset().top)
	},700);
});

$(document).ready(function() {
	$(".main").css('max-height', $(window).height());
	$(".main").css('height', $(window).height());
	if ($(window).height() < 600) {
		$("#header > img ").css('max-width', '80%');
	}

});

