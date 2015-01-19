$(document).ready( function(){
	var trs = $("#content tr");
	var lines = trs.length;
	for( var i = 2; i < (lines-1); i++ ){
		var tds = $(trs[i]).find("td");
		$(tds[0]).addClass("icon");
		$(tds[1]).addClass("name");
		$(tds[2]).addClass("last_modified");
		$(tds[3]).addClass("size");
		$(tds[4]).addClass("description");
	}
	var th = $("#content th");
	$(th[0]).addClass("icon");
	$(th[1]).addClass("name");
	$(th[2]).addClass("last_modified");
	$(th[3]).addClass("size");
	$(th[4]).addClass("description");
});