var Option = function(form){
	this.form = form;
}

Option.prototype = {
	callback_func :[],
	
	submit: function(next) {
		var validation = new Validation(this.form);

		var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}
		
		var ok2 = validation.isValid();
		
		if (ok == true && ok2 == true) {
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},

	flushCallback: function(){
		this.callback_func = [];
	},
	
	reset: function(url) {
		Common.emptyValues(this.form,'id',['title','order',{key:'option_id',value:0}]);
		jQuery(this.form+' [id=active]').attr('checked',false);
		//jQuery(this.form+' [id=is_active]').attr('checked',true);
		jQuery(this.form).attr('action',url);
	}
}
