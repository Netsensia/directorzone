$(document).ready(function() {
	$(document).delegate('.form_multitable_addrow', 'click', function() {
		var widgetId = $(this).attr('data-widgetid');
		var widgetData = jQuery.parseJSON( $('#' + widgetId).val() );
		var newRow = '<tr>';
		
		$.each(widgetData.fields, function(key, value) {
			switch(value.type) {
			    case 'select':
			        newRow += '<td><select class="netsensia_form_widget"></select></td>';
			        break;
			    case 'text':
			    	newRow += '<td><a href="#" class="netsensia_form_widget">Edit</a></td>';
			        break;
			    default:
			}
		});
		
		newRow += '<td id="asdasd"><a class="form_multitable_deleterow" href="#"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
		$("table[data-widgetid='" + widgetId + "'] tr:last").after(newRow);
		
	});
	
	$(document).delegate('.form_multitable_deleterow', 'click', function() {
		var id = $(this).parent().parent().remove();
	});
	
	$(document).delegate('input[name="form-submit"]', 'click', function() {
		$('.form_multitable').each(function() {
			
			var widgetId = $(this).attr('data-widgetid');
			var widgetData = jQuery.parseJSON( $('#' + widgetId).val() );
			
			var rowCount = 0;
			
			widgetData.rowValues = [];
			
			$('table[data-widgetid="' + widgetId + '"] > tbody  > tr').each(function() {
				rowCount ++;
				if (rowCount > 1) {
					var rowValueArray = [];
					$(this).children('td').each(function () {
						rowValueArray.push($(this).val());
					});
					widgetData.rowValues.push(rowValueArray);
				}
				
			});
			
			var newJson = JSON.stringify(widgetData);
			$('input[id="' + widgetId + '"]').val(newJson);
		});
	});
});

