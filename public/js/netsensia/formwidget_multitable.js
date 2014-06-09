$(document).ready(function() {
	$('.form_multitable_addrow').click(function() {
		var widgetId = $(this).attr('data-widgetid');
		var widgetData = jQuery.parseJSON( $('#' + widgetId).val() );
		var newRow = '<tr>';
		$.each(widgetData.fields, function(key, value) {
			switch(value.type) {
			    case 'select':
			        newRow += '<td><select></select></td>';
			        break;
			    case 'text':
			    	newRow += '<td><a href="#">Edit</a></td>';
			        break;
			    default:
			}
		});
		
		newRow += '</tr>';
		$("table[data-widgetid='" + widgetId + "'] tr:last").after(newRow);
		
	});
});

