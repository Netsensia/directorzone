$(document).ready(function() {
	$(document).delegate('.form_multitable_addrow', 'click', function() {
		var widgetId = $(this).attr('data-widgetid');
		
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

