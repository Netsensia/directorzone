$(document).ready(function() {

	function getName(allOptions, id)
	{
		for (var i=0; i<allOptions.length; i++) {
			var childParentCombo = allOptions[i].value;
			var split = childParentCombo.split(',');
			var childId = split[0];
			var parentId = split[1];
			if (childId == id) {
				return allOptions[i].label;
 			}
		}
	}
	
	function getOptions(allOptions, targetParentId)
	{
		var items = [];
		
		for (var i=0; i<allOptions.length; i++) {
			var childParentCombo = allOptions[i].value;
			var split = childParentCombo.split(',');
			var childId = split[0];
			var parentId = split[1];
			if (parentId == targetParentId) {
				var childName = getName(allOptions, childId);
				items[items.length] = [childId, childName];
			}
		}
		
		return items;
	}
	
	function getSelectHtml(widgetId, parentId, allOptions)
	{
		var selectOptions = getOptions(allOptions, parentId);
		
    	var selectHtml = '<div class="hierarchy-widget-group"><select id="' + widgetId + '_' + parentId + '" class="form-control" data-widgetId="' + widgetId + '">';
    	selectHtml += '<option value="-1">Please select...</option>';
    	var count = 0;
    	for (var i=0; i<selectOptions.length; i++) {
    		selectHtml += '<option value="' + selectOptions[i][0] + '">' + selectOptions[i][1] + '</option>';
    		count++;
    	}
    	selectHtml += '</select></div>';
    	
    	return count > 0 ? selectHtml : '';
	}
	
	$('input[id^=netsensiaWidget_hierarchy]').each(function() {
		
		var widgetId = $(this).attr('id');
    	var allOptions = $.parseJSON($(this).attr('data-hierarchyvalues'));
    	var widgetValue = $.parseJSON($(this).val());
    	
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls');
    	var labelDiv = $('div[data-netsensia-group=' + widgetId + '] label.control-label');
    	
    	$(labelDiv).html(widgetValue.label);
    	$(widgetDiv).append('<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span></div>');
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls div.input-group');
    	
    	$(widgetDiv).append(getSelectHtml(widgetId, -1, allOptions));

    });
	
	$(document).delegate('select[id^=netsensiaWidget_hierarchy]', 'change', function() {
		
		$(this).parent().nextAll('div').each(function() {
			$(this).remove();
		})
		
		var widgetId = $(this).attr('data-widgetId');
		var widgetEl = $('input#' + widgetId);
		var allOptions = $.parseJSON($(widgetEl).attr('data-hierarchyvalues'));
		var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls div.input-group');
		var selectedId = $(this).val();
		$(widgetDiv).append(getSelectHtml(widgetId, selectedId, allOptions));
		
		var widgetValue = $.parseJSON($(widgetEl).val());

		widgetValue.value = selectedId;
		$(widgetEl).val(JSON.stringify(widgetValue));
		
	});
	
});

