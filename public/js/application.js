$(function(){
	$('select').each( function () {
		toggleSelectOther($(this).attr('id'));
	});
	
	$('select').change( function() {
		toggleSelectOther($(this).attr('id'));
	});
});

function toggleSelectOther(id)
{
	var text = $('select#' + id + ' option:selected').text();
	if (text == 'Other') {
		displayState = 'block';
	} else {
		displayState = 'none';
	}
	
	$('div#' + id + 'other').css('display', displayState);

}
