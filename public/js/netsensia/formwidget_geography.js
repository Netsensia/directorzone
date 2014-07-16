$(document).ready(function() {
	
	$(document).delegate('.treeexpand', 'click', function () {
		var tree = getTree($(this));
		var isLoaded = $(this).attr('data-loaded');
		
		if (!isLoaded) {
			var geographyId = $(this).attr('data-id');
			loadTree(geographyId);
		}
		
	});
	
	function getTree(el)
	{
		var id = $(el).attr('data-widgetid');
		var input = $('#' + id);
		var value = jQuery.parseJSON($(input).val());		

		return value.tree;
	}
	
	function loadTree(geographyId)
	{
		url = '/api/geography/' + geographyId;
		$.ajax({
			url: url
			success: function (data) {
				alert(data);
			}
		}).done(function () {
			
		});
	}
});

