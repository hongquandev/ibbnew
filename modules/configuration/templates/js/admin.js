var Config = function() {
}

Config.prototype = {
	submit : function(frm) {
		
		//#frm
		//alert('1');
		
		var validation = new Validation(frm);
		if (validation.isValid()) {

		//	alert(frm);
			jQuery(frm).submit();
			//document.getElementById('frmCreatexxx').submit= true;
			
			//alert('SSSSSSSSSSS');
		}		
	}
}


