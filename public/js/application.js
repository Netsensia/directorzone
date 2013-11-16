$(function(){
	$('select').each( function () {
		toggleSelectOther($(this).attr('id'));
	});
	
	$('select').change( function() {
		toggleSelectOther($(this).attr('id'));
	});
	
	$('.date-entry').datepicker( { changeYear: true, yearRange: "1920:2013", dateFormat: "yy-mm-dd",  inline: true,  
        showOtherMonths: true,  
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']} );
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
