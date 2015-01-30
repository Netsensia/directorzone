$(function(){
	$('select').each( function () {
		toggleSelectOther($(this).attr('id'));
	});
	
	$('select').change( function() {
		toggleSelectOther($(this).attr('id'));
	});
	
	$('.date-entry').each( function () {
		$(this).val($(this).val().substring(0,10));
	});
	
	$(document).on('focus', '.date-entry', function() {
		$(this).datepicker({
			changeYear: true, yearRange: "1920:2020",
			dateFormat: "yy-mm-dd",
			inline: true,
			defaultDate: 0,
	        showOtherMonths: true,  
	        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
		});
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
