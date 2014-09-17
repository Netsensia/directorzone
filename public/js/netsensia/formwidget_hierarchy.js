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
	
	$("input[id^=netsensiaWidget_hierarchy]").each(function() {
    	var widgetId = $(this).attr('id');
    	var allOptions = $.parseJSON($(this).attr('data-hierarchyvalues'));
    	var widgetValue = $.parseJSON($(this).val());
    	var parentId = -1;
    	var selectOptions = getOptions(allOptions, parentId);
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls');
    	var labelDiv = $('div[data-netsensia-group=' + widgetId + '] label.control-label');
    	$(labelDiv).html(widgetValue.label);
    	$(widgetDiv).append('<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>');
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls div.input-group');
    	
    	var selectHtml = '<select id="' + widgetId + '_parentId" class="form-control">';
    	for (var i=0; i<selectOptions.length; i++) {
    		selectHtml += '<option value="' + selectOptions[i][0] + '">' + selectOptions[i][1] + '</option>';
    	}
    	selectHtml += '</select>';
    	
    	$(widgetDiv).append(selectHtml);

    });
	
});

