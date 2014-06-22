/*
 * JavaScript Pretty Date
 * Copyright (c) 2011 John Resig (ejohn.org)
 * Licensed under the MIT and GPL licenses.
 */

// Takes an ISO time and returns a string representing how
// long ago the date represents.
function prettyDate(time){
	var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
	
	if ( isNaN(day_diff) || day_diff < 0 )
		return;
	
	if (day_diff == 0) {
	    if (diff < 60) return "just now";
        if (diff < 120) return "1 minute ago";
		if (diff < 3600) return Math.round( diff / 60 ) + " minutes ago";
		if (diff < 7200) return "1 hour ago";
	    if (diff < 86400) return Math.round( diff / 3600 ) + " hours ago";	
	}
			
	if (day_diff == 1) return "Yesterday";
	if (day_diff < 7) return day_diff + " days ago";
	if (day_diff < 11) return "1 week ago";
	if (day_diff < 50) Math.round( day_diff / 7 ) + " weeks ago";
	if (day_diff < 330) {
		var months = Math.round( day_diff / 30 );
		if (months == 1) {
			return "1 month ago";
		} else {
			return  months + " months ago";
		}
	}
	
	return Math.ceil( day_diff / 365 ) + " years ago";
}

// If jQuery is included in the page, adds a jQuery plugin to handle it as well
if ( typeof jQuery != "undefined" )
	jQuery.fn.prettyDate = function(){
		return this.each(function(){
			var date = prettyDate(this.title);
			if ( date )
				jQuery(this).text( date );
		});
	};