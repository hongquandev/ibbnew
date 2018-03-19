var BANNER = function() {
}

BANNER.prototype = {
	submit : function(frm) {
	
		var validation = new Validation(frm);
		if (validation.isValid() /*&& validFile()*/) {
			jQuery(frm).submit();
		}
	}
}
	
	function bannerSubmit() {
		/*if (document.getElementById('dropDown').innerHTML == 'wrong') {
			alert('ss')
		} else {
		*/	
			var validation = new Validation('#frmCreate');
			if (validation.isValid() /*&& validFile()*/) {
				jQuery('#frmCreate').submit();
			}
		//}
	}
	
	function editPaySubmit() {
		var validation = new Validation('#frmCreate');
			if (validation.isValid() /*&& validFile()*/) {
				jQuery('#frmCreate').submit();
			}
	}
	
	function checkUrlBFront() {
	
		 var theurl=document.frmCreate.url.value;
		 var tomatch= /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		 if (tomatch.test(theurl))
		 {
			 return true;
		 }
		 else
		 {
			 showMess("URL invalid. Try again.");
			 return false; 
		 }
	}	
	
	function validFile()
	{
		var extensions = new Array("jpg","jpeg","gif","png","bmp");

		var image_file = document.frmCreate.image_file.value;
		
		var image_length = document.frmCreate.image_file.value.length;
		
		var pos = image_file.lastIndexOf('.') + 1;
		
		var ext = image_file.substring(pos, image_length);
		
		var final_ext = ext.toLowerCase();
		for (i = 0; i < extensions.length; i++)
		{
			if (document.frmCreate.image_file.value.length) {
				if(extensions[i] == final_ext)
				{
					return true;
				}
				
			}
			
			if (document.frmCreate.image_file.value.length == 0) {
					return true;			
			}
		}	
			$("#image_file").replaceWith($("#image_file").clone(true));
			$("#image_file").val(""); 
			showMess("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
			//document.frmCreate.image_file.value = '';
			return false;
			
			
			
	}
	
	function showMessMorePage() {
		
		jQuery('#rgalert').removeAttr('onclick');
		jQuery('#rgalert').removeAttr('onclick');
		jQuery('#rgalert').removeClass('btn-red').addClass("btn-black");
		showMess("Please contact admin with payment");
		$('#rgalert').unbind('click');
		//history.back(-1);
		jQuery('.btn-red').click(function() {
    		window.location='/?module=banner&action=my-banner';
		});

	}




	
