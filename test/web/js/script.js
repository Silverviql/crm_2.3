$(document).ready(function($){
	$('#addCustom').click(function() {
		var html = $(this).parent().html();
		$(this).remove();
		$("#customForm").append('<div>'+html+'</div>');
		return false;
    });
});