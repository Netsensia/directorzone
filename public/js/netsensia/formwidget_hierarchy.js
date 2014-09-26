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
	
	function getChildren(value, allOptions)
	{
		var children = [];
		for (var i=0; i<allOptions.length; i++)	{
			var childParentCombo = allOptions[i].value;
			var split = childParentCombo.split(',');
			var childId = split[0];
			var parentId = split[1];
			if (parentId == value) {
				children[children.length] = childId;
			}
		}
		return children;
	}
	
	function isFamily(value, ultimateId, allOptions)
	{
		if (value == ultimateId) {
			return true;
		}
		
		var children = getChildren(value, allOptions);
		
		for (var i=0; i<children.length; i++) {
			var child = children[i];
			if (isFamily(child, ultimateId, allOptions)) {
				return true;
			}
		}
		
		return false;
	}
	
	function getSelectHtml(widgetId, parentId, allOptions, ultimateId)
	{
		var selectOptions = getOptions(allOptions, parentId);
		var selectedId = -1;
		
    	var selectHtml = '<div class="hierarchy-widget-group"><select id="' + widgetId + '_' + parentId + '" class="form-control" data-widgetId="' + widgetId + '">';
    	selectHtml += '<option value="-1">Please select...</option>';
    	var count = 0;
    	for (var i=0; i<selectOptions.length; i++) {
    		var value = selectOptions[i][0];
    		var selectedText = '';
    		
    		if (isFamily(value, ultimateId, allOptions)) {
    			selectedText = ' selected ';
    			selectedId = value;
    		}
    		
    		selectHtml += '<option ' + selectedText + ' value="' + selectOptions[i][0] + '">' + selectOptions[i][1] + '</option>';
    		count++;
    	}
    	selectHtml += '</select></div>';
    	
    	if (count == 0) {
    		selectHtml = '';
    	}
    	
    	return {selectHtml: selectHtml, selectedId: selectedId};
	}
	
	$('input[id^=netsensiaWidget_hierarchy]').each(function() {
		
		var widgetId = $(this).attr('id');
    	var allOptions = $.parseJSON($(this).attr('data-hierarchyvalues'));
    	var widgetValue = $.parseJSON($(this).val());
    	var selectedId = widgetValue.value;
    	
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls');
    	var labelDiv = $('div[data-netsensia-group=' + widgetId + '] label.control-label');
    	
    	$(labelDiv).html(widgetValue.label);
    	$(widgetDiv).append('<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span></div>');
    	var widgetDiv = $('div[data-netsensia-group=' + widgetId + '] div.controls div.input-group');
    	
    	var parentId = -1;
    	do 
    	{
    		var result = getSelectHtml(widgetId, parentId, allOptions, selectedId);
    		$(widgetDiv).append(result.selectHtml);
    		parentId = result.selectedId;
		} // keep going if we have a value set and it's not the ultimate selection
    	while (result.selectedId != selectedId && result.selectedId != -1)
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
		var result = getSelectHtml(widgetId, selectedId, allOptions, selectedId);
		$(widgetDiv).append(result.selectHtml);
		
		var widgetValue = $.parseJSON($(widgetEl).val());

		widgetValue.value = selectedId;
		$(widgetEl).val(JSON.stringify(widgetValue));
		
	});
	
	$('input[name="form-submit"]').click(function (event) {
		
		var complete = true;
		$('input[id^=netsensiaWidget_hierarchy]').each(function() {
			
			var widgetId = $(this).attr('id');
			var widgetEl = $('input#' + widgetId);
			var widgetValue = $.parseJSON($(widgetEl).val());
			
			$('select[data-widgetid=' + widgetId + ']').each(function() {
				if ($(this).val() == -1) {
					alert(widgetValue.messageWhenEmpty);
					event.stopPropagation();
					complete = false;
				}
			});
			
			if (complete) {
				$(widgetEl).val(widgetValue.value);
				$(widgetEl).attr('name', widgetValue.name + 'id');
				$(widgetEl).attr('id', 'processDirectly_' + $(widgetEl).attr('id'));
			
			}
		});

		return complete;
	});
	
});

