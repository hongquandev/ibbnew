function searchPageReport() {
	var search_query = document.getElementById('search_text').value;
	if (search_query.length > 0) {
		store_pagereport.load({params:{start:0, limit:20,search_query :search_query}});
	} else {
		Ext.Msg.alert('Warning.','Please entry some chars to search.');		
	}
}


