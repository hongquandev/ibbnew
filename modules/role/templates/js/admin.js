var Role = function(form){
	this.form = form;
}

Role.prototype = {
	submit: function(next) {
		var validation = new Validation(this.form);
		if (validation.isValid()) {
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},
	
	reset : function(url) {
		jQuery(this.form).attr('action',url);
		jQuery(this.form+' [name=active]').attr('checked',true);
		Common.emptyValues(this.form,'name',['title','description','order',{key:'role_id',value:0}]);
	}
}
