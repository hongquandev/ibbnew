var Comment = function(form){
	this.form = form;
}

Comment.prototype = {
	submit: function(next) {
		var validation = new Validation(this.form);
		if (validation.isValid()) {
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},
	
	delete: function() {
		Ext.Msg.show({
				title:'Delete record?'
				,msg:'Do you really want to delete ?'
				,icon:Ext.Msg.QUESTION
				,buttons:Ext.Msg.YESNO
				,scope:this
				,fn:function(response) {
					if('yes' !== response) {
						return ;
					}
					jQuery(this.form+' [name=delete]').val(1);
					jQuery(this.form).submit();
					
				}
		});
		
	},
	
	search : function() {
		var search_query = document.getElementById('search_text').value;
		if (search_query.length > 0) {
			hideMsg();
			self._store.load({params:{start:0, limit:20,search_query :search_query}});
		} else {
			Ext.Msg.alert('Warning.','Please entry some chars to search.');		
		}
		
	}
}

