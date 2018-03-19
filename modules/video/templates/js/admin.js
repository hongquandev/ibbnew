var Video = function() {
}

Video.prototype = {
	submit : function(frm) {
			
		var validation = new Validation(frm);
		if (validation.isValid())//&& isSpclChar() && isSpclPageTitlte()
		{
			jQuery(frm).submit();
		}
		
	}
}



function searchVideo() {
	var search_query = document.getElementById('search_text').value;
	if (search_query.length > 0) {
		store_cms.load({params:{start:0, limit:20,search_query :search_query}});
	} else {
		Ext.Msg.alert('Warning.','Please entry some chars to search.');		
	}
}


