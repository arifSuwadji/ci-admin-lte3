$(document).ready(function(){
    $(".cek").on("click", function(){
		$(".content-wrapper").find('input[type="checkbox"].halaman').iCheck('check');
	});

	$(".batal").on("click", function(){
		$(".content-wrapper").find('input[type="checkbox"].halaman').iCheck('uncheck');
	});
});