var User = function(form){
	//#form
	this.form = form;
}

User.prototype = {
	submit: function(next) {
		var validation = new Validation(this.form);
		if (validation.isValid()) {
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},
	
	reset: function(url) {
		jQuery(this.form).attr('action',url);
		jQuery(this.form+' [id=active]').attr('checked',true);
		Common.emptyValues(this.form,'name',['firstname','lastname','username','password','email',{key:'user_id',value:0}]);
	},
	
	search: function() {
		var search_query = document.getElementById('search_text').value;
		if (search_query.length > 0) {
			hideMsg();
			self._store.load({params:{start:0, limit:20,search_query :search_query}});
		} else {
			Ext.Msg.alert('Warning.','Please entry some chars to search.');		
		}
	}
}
