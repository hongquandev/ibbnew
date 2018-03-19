var Permission = function(form){
	this.form = form;
	this.type = {'add':false, 'view':false, 'edit':false, 'delete':false};
}

Permission.prototype = {
	submit: function(next) {
		var validation = new Validation(this.form);
		if (validation.isValid()) {
			if (next == true) {
				jQuery(this.form+' [name=next]').val(1);
			}
			jQuery(this.form).submit();
		}
	},
	
	roleSelect: function(obj) {
		var id = jQuery(obj).attr('id');
		var _id = '';
		if (id == 'role_id1') {
			_id = '#role_id2';
		} else {
			_id = '#role_id1';
		}
		jQuery(_id).val(jQuery(obj).val());
		
		var _form = jQuery(_id).parents('form:first');
		
		document.location = jQuery(_form).attr('action')+'&role_id='+jQuery(obj).val();
	},
	
	testChecked: function(obj,type) {
		
	},
	
	checkAll: function(obj,type) {
		var _check = false;
		
		jQuery('input[id^='+type+']').each(function(){
			if (jQuery(this).attr('checked') == true) {
				_check = true;
			}
		});
		
		this.type[type] = _check;
		
		if (this.type[type] == false) {//check
			jQuery('input[id^='+type+'_]').each(function(){
				jQuery(this).attr('checked',true);
			});
		} else {//uncheck
			jQuery('input[id^='+type+'_]').each(function(){
				jQuery(this).attr('checked',false);
			});
		}
		
		this.type[type] = !this.type[type];
	}
}
