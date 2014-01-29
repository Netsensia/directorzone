function netsensia_Pager(page, size, id, route, rowFunc)
{
	$("li#next").click(function() {
		page ++;
		loadTable(page, size, id, route, rowFunc);
	});
	
	$("li#previous").click(function() {
		if (!$(this).hasClass('disabled')) {
    		page --;
    		loadTable(page, size, id, route, rowFunc);
		}
	});
	
	loadTable(page, size, id, route, rowFunc);
}

function loadTable(page, size, id, route, rowFunc)
{
	var tableSelector = 'table#' + id;
	
	$(tableSelector).find("tr:gt(0)").remove();

	$(tableSelector + ' tr:last').after(
		'<tr>' +
		'<td style="text-align:center" colspan="5"><img src="/img/ajax/ajax-loader.gif"></td>' +
		'</tr>'
    );
	
	var url;
	var joinChar = '?';
	
	if (route.indexOf('?') != -1) {
		joinChar = '&';
	}
	
	url = route + joinChar + 'page=' + page + '&size=' + size;
	
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
