$(document).ready(function() {
	
	$(document).delegate('.treeexpand', 'click', function () {
		var tree = getTree($(this));
		var isLoaded = $(this).attr('data-loaded');
		if (!isLoaded) {
			var geographyId = $(this).attr('data-id');
			loadTree(geographyId, $(this).parent());
		}
		
	});
	
	function getTree(el)
	{
		var id = $(el).attr('data-widgetid');
		var input = $('#' + id);
		var value = jQuery.parseJSON($(input).val());		

		return value.tree;
	}
	
	function loadTree(geographyId, listItemParent)
	{
		url = '/api/geography/children/' + geographyId;
		$.ajax({
			url: url,
			success: function (data) {
				$(listItemParent).append('<ul class="treepicker">');
				for (i=0; i<data.length; i++) {
					var name = data[i].geography;
					var childId = data[i].geographyid;
					$(listItemParent).append('<li>');
					$(listItemParent).append(name);
					$(listItemParent).append('</li>');
				}
				$(listItemParent).append('</ul>');
			}
		});
	}
});

