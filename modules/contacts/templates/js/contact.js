var ContactForm = function(form) {
	this.form = form;
}

ContactForm.prototype = {

	isSubmit:function(form) {
		var _val = jQuery('#is_submit',form).val();
		if (_val == 1) {
			return true;
		}
		return false;
	},
	
	submit:function(form) {
	
		var validation = new Validation(form);
		var ok = validation.isValid();
		
		if (ok) {
			jQuery('#is_submit',form).val(1);
			jQuery(form).submit();
			return true;
		}
		jQuery('#is_submit',form).val(0);
		return false;
	}

}

