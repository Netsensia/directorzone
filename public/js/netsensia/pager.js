$(document).ready(function() {
	$('.columnHeading').css('cursor', 'pointer');

	$('.columnHeading').click(function() {
		
		var newColumnNumber = $(this).attr('data-column-number');
		
		if (!$(this).hasClass('fixed-order')) {
			var currentColumnNumber = $('#columnSorter').attr('data-sort-by-column')
			
			if (Math.abs(currentColumnNumber) == Math.abs(newColumnNumber)) {
				newColumnNumber = currentColumnNumber * -1;
			}
		}
		
		$('#columnSorter').attr('data-sort-by-column', newColumnNumber);
	});
});

function rewriteUrlForNewPage(direction)
{
	var currentUrl = document.URL.replace('#', '');
	var pageNumber = currentUrl.match(/\d+$/);
	var newPageNumber = parseInt(pageNumber) + direction;
	var newUrl = currentUrl.replace(/\d+$/, newPageNumber.toString());
	window.history.pushState("object or string", "Title", newUrl);
}

function netsensia_Pager(page, size, id, route, rowFunc)
{

	$("li#next").click(function() {
		page ++;
		rewriteUrlForNewPage(1);
		netsensia_pager_loadTable(page, size, $('#columnSorter').attr('data-sort-by-column'), id, route, rowFunc);
	});
	
	$("li#previous").click(function() {
		if (!$(this).hasClass('disabled')) {
    		page --;
    		rewriteUrlForNewPage(-1);
    		netsensia_pager_loadTable(page, size, $('#columnSorter').attr('data-sort-by-column'), id, route, rowFunc);
		}
	});
	
	netsensia_pager_loadTable(page, size, $('#columnSorter').attr('data-sort-by-column'), id, route, rowFunc);
}

function netsensia_pager_loadTable(page, size, order, id, route, rowFunc)
{

	var tableSelector = 'table#' + id;
	
	$(tableSelector).find("tr:gt(0)").remove();

	$(tableSelector + ' tr:last').after(
		'<tr>' +
		'<td style="text-align:center" colspan="6"><img src="/img/ajax/ajax-loader.gif"></td>' +
		'</tr>'
    );
	
	var url;
	var joinChar = '?';
	
	if (route.indexOf('?') != -1) {
		joinChar = '&';
	}

	url = route + joinChar + 'order=' + order + '&page=' + page + '&size=' + size;
	
	$.ajax({
		url: url
	}).done(function(data) {
		$('table#' + id).find("tr:gt(0)").remove();
				
		$('li#next').removeClass('disabled');
		$('li#previous').removeClass('disabled');
		
		if (data.total <= page * size) {
			$('li#next').addClass('disabled');
		}

		if (page == 1) {
			$('li#previous').addClass('disabled');
		}

		$.each(data.results, function(key, value) {
			newRow = rowFunc(key, value);
    		$('table#' + id + ' tr:last').after(newRow);
    	});

	});
}
