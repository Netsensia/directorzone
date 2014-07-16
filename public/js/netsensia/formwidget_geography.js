$(document).ready(function() {
	
	$(document).delegate('.treeexpand', 'click', function () {
		var tree = getTree($(this));
		var id = $(this).attr('id');
		alert(tree.items[0].name);
		alert(id);
	});
	
	function getTree(el)
	{
		var id = $(el).attr('data-widgetid');
		var input = $('#' + id);
		var value = $(input).val();
		var tree = value.tree;
	}
});

