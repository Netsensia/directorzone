$(document).ready(function() {
	
	$(document).delegate('.treeexpand', 'click', function () {
		$(this).attr('src', '/img/tree/dhxmenu_loader.gif');
		var isLoaded = $(this).attr('data-loaded');
		if (isLoaded == "1") {
			$(this).siblings('ul').css('display', 'list-item');
			$(this).attr('src', '/img/tree/minus.gif');
		} else {
			var geographyId = $(this).attr('data-geographyid');
			loadTree(geographyId, $(this));
			$(this).attr('data-loaded', '1');
		}
		$(this).removeClass('treeexpand');
		$(this).addClass('treecollapse');
	});
	
	$(document).delegate('.treecollapse', 'click', function () {
		$(this).siblings('ul').css('display', 'none');
		$(this).addClass('treeexpand');
		$(this).removeClass('treecollapse');
		$(this).attr('src', '/img/tree/plus.gif');
	});
	
	function getTree(el)
	{
		var id = $(el).attr('data-widgetid');
		var input = $('#' + id);
		var value = jQuery.parseJSON($(input).val());		

		return value.tree;
	}
	
	function loadTree(geographyId, imageClicked)
	{
		liParent = $(imageClicked).parent();
		
		var widgetId = $(liParent).parent().attr('data-widgetid');
		url = '/api/geography/children/' + geographyId;
		$.ajax({
			url: url,
			success: function (data) {
				var ul ='<ul class="treepicker" data-widgetid="' + widgetId + '">';
				for (i=0; i<data.length; i++) {
					var name = data[i].geography;
					var childId = data[i].geographyid;
					var hasChildren = data[i].haschildren;
					
					var expandTag = '';
					
					var attrs = 'data-widgetid="' + widgetId + '" style="cursor:pointer" data-geographyid="' + childId + '" ';
					
					if (hasChildren == "1") {
						expandTag = '<img ' + attrs + ' class="treeexpand" src="/img/tree/plus.gif">';
					} else {
						expandTag = '<img ' + attrs + ' class="treecollapse" src="/img/tree/blank.gif">';
					}
					
					attrs = 
			            'data-haschildren="' + hasChildren + '" ' +
			            'data-loaded="0" ' +
			            'data-state="2" ' +
			            'data-widgetid="' + widgetId + '" ' +
			            'style="cursor:pointer" ' +
			            'class="treeitemselect" ' +
			            'data-geographyid="' + childId + '"';
			            
					var checkTag = '<img ' + attrs + ' src="/img/tree/iconUncheckAll.gif">&nbsp;';
					ul += 
						 '<li>' +
						 expandTag +
						 checkTag +
						 name +
						 '</li>';
				}
				ul += '</ul>';
				$(liParent).append(ul);
				$(imageClicked).attr('src', '/img/tree/minus.gif');
			}
		});
	}
});

