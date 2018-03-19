//BEGIN MESSAGE
var Report = function(form){
	
	this.form = '';
	if (typeof form == 'string') {
		this.form = form;
	}
	this.textarea_reply = false;
}

Report.prototype = {
	goto: function (obj) {
		if (typeof obj == 'object') {
			url = jQuery(obj).val();
		} else {
			url = obj;
		}
		document.location = url;
	},
	
	setIsSubmit: function(key,val) {
		var is_submit = '#is_submit';
		if (typeof key == 'string') {
			is_submit = key;
		}
		
		if (typeof this.form == 'string') {
			jQuery(is_submit,this.form).val(val);
		} else {
			jQuery(is_submit).val(val);
		}
	},
	
	getIsSubmit: function(key) {
		var is_submit = '#is_submit';
		if (typeof key == 'string') {
			is_submit = key;
		}
		
		if (typeof this.form == 'string') {
			return parseInt(jQuery(is_submit,this.form).val());
		} else {
			return parseInt(jQuery(is_submit).val());
		}
	},
	
	isSubmit: function(form) {
		if (typeof form == 'string') {
			this.form = form;
		}
		
		if (this.getIsSubmit() == 1) {
			return true;
		}
		return false;
	},
	
	submit: function (form){
		if (typeof form == 'string') {
			this.form = form;
		}
		
		if (typeof this.form == 'string') {
			
			this.setIsSubmit('#is_submit',1);
			jQuery(this.form).submit();
		}
	},
	
	openImg: function (id) {
		var src = jQuery('#banner_img_'+id).attr('src');
		jQuery('#banner_img_full_'+id).attr('src',src);
		jQuery('#banner_container_'+id).show();
		//jQuery('#banner_container_'+id).css('top',$('#banner_bound_'+id).offset().top-4);
		//jQuery('#banner_container_'+id).css('left',$('#banner_bound_'+id).offset().left);

	},
	
	closeImg: function(id) {
		jQuery('#banner_img_full_'+id).attr('src','');	
		jQuery('#banner_container_'+id).hide();
	},
	
	openWindow: function(url,w,h) {
		var _w = 630;
		var _h = 390;
		
		if (typeof w == 'number') {
			_w = w;
		}
		
		if (typeof h == 'number') {
			_h = h;
		}
		
		window.open(url,"mywindow","menubar=1,resizable=1,width="+_w+",height="+_h);	
	},
	
	redirect: function (url) {
		document.location = url;
	}

}
