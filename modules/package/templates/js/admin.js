var Package = function(form){
	this.form = form;
}

Package.prototype = {
	callback_func :[],
	
	submit: function(next) {
		var validation = new Validation(this.form);

        var ok2 = validation.isValid();

		var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}
		
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
		Common.emptyValues(this.form, 'id', ['title', 'price_dl', 'price', 'order', {key : 'package_id', value : 0}]);
		jQuery(this.form + ' [id=active]').attr('checked',false);
		jQuery(this.form+' [id=is_active]').attr('checked',true);
		jQuery(this.form).attr('action',url);
	},

    resetAllElement:function(url){
        jQuery('input',this.form).each(function(){
            if (jQuery(this).attr('type') == 'text'){
                jQuery(this).val('');
            }
        });
        jQuery(this.form + ' [id=active]').attr('checked',true);
		jQuery(this.form +' [id=is_active]').attr('checked',true);
		jQuery(this.form).attr('action',url);
    }
}