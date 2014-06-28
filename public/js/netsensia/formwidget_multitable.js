$(document).ready(function() {
	$.fn.editable.defaults.mode = 'popup';
	
	$('table.widget_multitable').each(function() {

		var numColumns = $(this).find('tr th').length;
		var editableMode = numColumns < 2 ? 'inline' : 'popup';
		
		if (numColumns == 3) {

			$(this).find('th').each(function() {
				$(this).width('33%');
			});
			
		}
		
		$(this).find('input').each(function() {
			$(this).width('60%');
			$(this).attr('name', 'widgetignore[]');
		});
		
		$(this).find('select').each(function() {
			$(this).attr('name', 'widgetignore[]');
			$(this).prepend($('<option>', {
			    value: -1,
			    text: 'Please select...'
			}));
			$(this).val(-1);
		});
		
		setEditableElements($(this), editableMode);
		
	});
	
	function setEditableElements(tableEl, editableMode) {
		tableEl.find('.widget_multitable_edit').each(function() {
			$(this).editable({
				pk: 1,
				autotext:'never',
				url: '',
				mode: editableMode,
				display: function(value, sourceData) {
					$(this).html('Edit');
				},
				success: function(response, newValue) {
					$(this).attr('data-value', newValue);
			    }
			});
		});
	}
	
	$(document).delegate('.widget_multitable_addrow', 'click', function() {
		var widgetId = $(this).attr('data-widgetid');
		var tableEl = $('table[data-widgetid="' + widgetId + '"]');
		var numRows = tableEl.find('tr:visible').length - 1;
		
		var lastRow = $(tableEl).find('tr:last');
		
		if (numRows == 0) {
			$(lastRow).css('display', 'table-row');
		} else {
			var newRow = $(lastRow).clone();
			newRow.children().each(function () {
				$(this).children().each(function() {
					if ($(this).hasClass('editable')) {
						$(this).attr('data-value', '');
						$(this).removeClass('editable-unsaved');
						$(this).attr('style', '');
					}
				});
			});
			newRow.insertAfter(lastRow);
		}
	    
	    setEditableElements(tableEl, 'popup');
	});
	
	$(document).delegate('.widget_multitable_deleterow', 'click', function() {
		
		var widgetId = $(this).attr('data-widgetid');
		var tableEl = $('table[data-widgetid="' + widgetId + '"]');
		var numRows = tableEl.find('tr:visible').length - 1;
		
		if (numRows == 1) {
			$(this).parent().parent().css('display', 'none');
		} else {
			$(this).parent().parent().remove();
		}
		
		return false;
	});
	
	$(document).delegate('.widget_multitable_edit', 'click', function() {
	});
	
	$(document).delegate('input[name="form-submit"]', 'click', function(event) {
		event.preventDefault();
		$('.widget_multitable').each(function() {

			var widgetId = $(this).attr('data-widgetid');
			var widgetData = jQuery.parseJSON( $('#' + widgetId).val() );
			var rowCount = 0;
			
			widgetData.rowValues = [];
			
			$('table[data-widgetid="' + widgetId + '"] > tbody  > tr').each(function() {
				rowCount ++;
				if (rowCount > 1) {
					var rowValueArray = [];
					var isEmpty = true;
					$(this).children('td').each(function () {
						$(this).children().each(function() {
							if ($(this).is('select')) {
								var value = $(this).val();
								rowValueArray.push(value);
								if (value > -1) {
									isEmpty = false;
								}
							}
							
							if ($(this).hasClass('editable')) {
								var value = $(this).attr('data-value');
								rowValueArray.push(value);
								if (value != '') {
									isEmpty = false;
								}
							}
						});
					});
					if (!isEmpty) {
						widgetData.rowValues.push(rowValueArray);
					}
				}
				
			});
			
			var newJson = JSON.stringify(widgetData);
			$('#' + widgetId).val(newJson);
		});
		$(this).parent().submit();
		return false;
	});
});

