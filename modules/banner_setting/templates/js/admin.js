var BannerSetting = function() {
}

BannerSetting.prototype = {
	submit : function(frm) {
		var validation = new Validation(frm);
		if (validation.isValid() && checkNumber()) {
			jQuery(frm).submit();
		}
	}
	
}

function checkNumber() {
	var num = jQuery('#setting_value').val();
	if (num == 0) {
		alert('please input number > 0');
		return false;
	}
	if (num % 3 == 0) {
		return true;	
	} else {
		alert('This number is not divided to 3');
	}
}


