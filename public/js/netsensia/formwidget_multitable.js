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
		});
		
		$(this).find('select').each(function() {
			if ($(this).hasClass('select_reference'))
			{
				$(this).css('display', 'none');
			}
			
			if ($(this).hasClass('select_child')) {
				var tier = $(this).attr('data-tier');
				var parentTier = +tier+1;
				var selector = '.select_parent[data-tier=' + parentTier + ']';
				var parent = $(this).siblings(selector);
				var parentVal = parent.val();
				
				showChildrenOfSelectParent(
						$(this),
						parentVal
					);
			}
		});
		
		setEditableElements($(this), editableMode);
		
	});
	
	function showChildrenOfSelectParent(
		childSelectElement,
		selectedParentValue
	)
	{
		if (selectedParentValue == -1) {
			$(childSelectElement).css('display', 'none');
			return;
		}
				
		$(childSelectElement).empty();
		var tier = $(childSelectElement).attr('data-tier');
		var selector = '[data-tier="' + tier + '"]';
		
		childReferenceElement = $(childSelectElement).siblings('.select_reference[data-tier=' + tier + ']');
		
		$(childReferenceElement).children('option').each(function () {
			var parts = $(this).val().split(',');
			var childId = parts[0];
			var parentId = parts[1];
			if (parentId == selectedParentValue) {
				newElement = $(this).clone();
				$(newElement).val(childId);
				$(childSelectElement).append(newElement);
			}
		});
		
		$(childSelectElement).css('display', 'inline-block');
	}
	
	$(document).delegate('.select_parent', 'change', function() {
		showChildrenOfSelectParent(
			$(this).next(),
			$(this).val()
		);
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
					updateWidgetValues();
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
					if ($(this).is('select')) {
						$(this).val(-1);
						if ($(this).hasClass('select_child')) {
							$(this).css('display', 'none');
						}
					}
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
		
		updateWidgetValues();
		
		return false;
	});
	
	function updateWidgetValues()
	{
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
								if (!$(this).hasClass('select_parent') && !$(this).hasClass('select_reference')) {
									var value = $(this).val();
									rowValueArray.push(value);
									if (value > -1) {
										isEmpty = false;
									}
								}
							} else
							if ($(this).hasClass('editable')) {
								var value = $(this).attr('data-value');
								rowValueArray.push(value);
								if (value != '') {
									isEmpty = false;
								}
							} else
							if ($(this).is('input')) {
								var value = $(this).val();
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
	}
	
	$(document).delegate('.netsensia_form_widget', 'change', function(event) {
		updateWidgetValues();
	});

});

