$(document).ready(function() {
	$.fn.editable.defaults.mode = 'popup';
	
	$('table.form_multitable').each(function() {

		var numColumns = $(this).find('tr td').length;
		var editableMode = numColumns < 2 ? 'inline' : 'popup';

		$(this).find('select').each(function() {
			$(this).prepend($('<option>', {
			    value: -1,
			    text: 'Please select...'
			}));
			$(this).val(-1);
		});
		
		setEditableElements($(this), editableMode);
		
	});
	
	function setEditableElements(tableEl, editableMode) {
		tableEl.find('.form_multitable_edit').each(function() {
			$(this).editable({
				pk: 1,
				url: '',
				mode: editableMode,
				success: function(response, newValue) {
					$(this).attr('data-value', newValue);
			    }
			});
		});
	}
	
	$(document).delegate('.form_multitable_addrow', 'click', function() {
		var widgetId = $(this).attr('data-widgetid');
		
		var tableEl = $('table[data-widgetid="' + widgetId + '"]');
		
		var lastRow = $(tableEl).find('tr:last');
	    var newRow = $(lastRow).clone().insertAfter(lastRow);
	    
	    var deleteIconTd = $(newRow).find('td:last-child');
	    $(deleteIconTd).css('visibility', 'visible');
	    
	    setEditableElements(tableEl, 'popup');
	});
	
	$(document).delegate('.form_multitable_deleterow', 'click', function() {
		var id = $(this).parent().parent().remove();
	});
	
	$(document).delegate('.form_multitable_edit', 'click', function() {
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

