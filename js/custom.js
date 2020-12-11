$( ".btn_top" ).click(function() {
	$(".mapsPv").css("height", "80vh");
	$(".btn_top").css("display", "none");
	$(".btn_bottom").css("display", "flex");
	$("#jsres").css("overflow-y", 'auto');
});

$( ".btn_bottom" ).click(function() {
	$(".mapsPv").css("height", "16vh");
	$(".btn_top").css("display", "flex");
	$(".btn_bottom").css("display", "none");
	$("#jsres").css("overflow-y", 'hidden');
});