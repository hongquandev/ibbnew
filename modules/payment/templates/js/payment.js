var Payment = function(form, is_submit) {
	this.callback_func  = [];
	this.is_submit = typeof is_submit == 'string' ? is_submit : '';
	this.form = typeof form != 'undefined' ? form : '';
}

Payment.prototype = {
	
	gotoStep:function(url) {
		document.location = url;
	}
	
	,isSubmit:function(form) {
		if (typeof form == 'string') {
			this.form = form;
		}
		var _val = jQuery('#' + this.is_submit,this.form).val();
		if (_val == 1) {
			return true;
		}
		return false;
	}
	
	,submit:function(form) {
		if (typeof form == 'string' && form.length > 0) {
			this.form = form;
		}
		
        var validation = new Validation(this.form);

		var _ok = validation.isValid();
        var ok = true;
		if (this.callback_func['valid'] && this.callback_func['valid'].length > 0) {
			for (var i = 0; i < this.callback_func['valid'].length ;i++) {
				if (this.callback_func['valid'][i]() == false) {
                     ok = false;
				}
			}
		}
		
        if (_ok && ok) {
			jQuery('#' + this.is_submit,this.form).val(1);
			jQuery(this.form).submit();
			return true;
		}
		
		jQuery('#'+ this.is_submit,this.form).val(0);
		return false;
	}
	
	,addCallbackFnc: function(key, fnc) {
		if (!this.callback_func[key]) {
			this.callback_func[key] = [];
		}
		this.callback_func[key].push(fnc);
	}
	
	,flushCallback: function() {
		this.callback_func = [];
	}
}
