$(function(){
	$('select').change( function() {
		var id = $(this).attr('id');
		var text = $('select#' + id + ' option:selected').text();
		if (text == 'Other') {
			displayState = 'block';
		} else {
			displayState = 'none';
		}
		
		$('div#' + id + '_other').css('display', displayState);
	});
});
