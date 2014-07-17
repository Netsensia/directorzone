$(document).ready(function() {
	
    var STATE_ALL = 0;
    var STATE_SOME = 1;
    var STATE_NONE = 2;
    var STATE_DISABLED = 3;
    
	$(document).delegate('img.treeexpand', 'click', function () {
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
	
	$(document).delegate('img.treecollapse', 'click', function () {
		$(this).siblings('ul').css('display', 'none');
		$(this).addClass('treeexpand');
		$(this).removeClass('treecollapse');
		$(this).attr('src', '/img/tree/plus.gif');
	});
	
	$(document).delegate('img.treeitemselect', 'click', function () {
		
		var currentState = parseInt($(this).attr('data-state'));
		
		if (currentState == STATE_DISABLED) {
			return;
		}

		var parentCheckImage = $(this).parent().parent().siblings('.treeitemselect').first();
		
		if (currentState == STATE_ALL || currentState == STATE_SOME) {
			$(this).attr('data-state', STATE_NONE);
			$(this).attr('src', '/img/tree/iconUncheckAll.gif');
			
			$(this).next().children().each(function () {
				var img = $(this).children('.treeitemselect').first();
				$(img).attr('data-state', STATE_NONE);
				$(img).attr('src', '/img/tree/iconUncheckAll.gif');
			});

			setParentState(parentCheckImage);
		}
		
		if (currentState == STATE_NONE) {
			$(this).attr('data-state', STATE_ALL);
			$(this).attr('src', '/img/tree/iconCheckAll.gif');
			$(this).next().children().each(function () {
				var img = $(this).children('.treeitemselect').first();
				$(img).attr('data-state', STATE_ALL);
				$(img).attr('src', '/img/tree/iconCheckAll.gif');
			});
			
			setParentState(parentCheckImage);
		}
	});
	
	function setParentState(checkImage)
	{
		var numChecked = 0;
		var numBlank = 0;
		var numPartial = 0;
		var state;
		var image;
		
		$(checkImage).next().children().each(function () {
			var img = $(this).children('.treeitemselect').first();
			var state = $(img).attr('data-state');
			
			if (state == STATE_ALL) {
				numChecked ++;
			}
			
			if (state == STATE_NONE) {
				numBlank ++;
			}
			
			if (state == STATE_SOME) {
				numPartial ++;
			}
		});
		
		if (numChecked + numPartial == 0) {
			state = STATE_NONE;
			image = 'iconUncheckAll.gif';
		}
		
		if (numChecked > 0 && numBlank + numPartial == 0) {
			state = STATE_ALL;
			image = 'iconCheckAll.gif';
		}
		
		if (numPartial > 0 || (numChecked > 0 && numBlank > 0)) {
			state = STATE_SOME;
			image = 'iconCheckGray.gif';
		}
		
		$(checkImage).attr('data-state', state);
		$(checkImage).attr('src', '/img/tree/' + image);		
	}
	
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
		var selectorImg = $(imageClicked).siblings('.treeitemselect').first();
		
		var checkState = parseInt($(selectorImg).attr('data-state'));
		var checkImage = '';
		
		switch (checkState) {
			case STATE_ALL: checkImage = 'iconCheckAll.gif'; break;
			case STATE_SOME: checkImage = 'iconCheckGrey.gif'; break;
			case STATE_NONE: checkImage = 'iconUncheckAll.gif'; break;
			case STATE_DISABLED: checkImage = 'iconCheckDis.gif'; break;
		}
		
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
			            'data-state="' + checkState + '" ' +
			            'data-widgetid="' + widgetId + '" ' +
			            'style="cursor:pointer" ' +
			            'class="treeitemselect" ' +
			            'data-geographyid="' + childId + '"';
					
					var checkTag = '<img ' + attrs + ' src="/img/tree/' + checkImage + '">&nbsp;';
					
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

