
function validFileParner()
{
	var extensions = new Array("jpg","jpeg","gif","png");

	var image_file = document.frmAgent.image_file.value;
	
	var image_length = document.frmAgent.image_file.value.length;
	
	var pos = image_file.lastIndexOf('.') + 1;
	
	var ext = image_file.substring(pos, image_length);
	
	var final_ext = ext.toLowerCase();
	for (i = 0; i < extensions.length; i++)
	{
		if (document.frmAgent.image_file.value.length) {
			if(extensions[i] == final_ext)
			{
				//showMess("This image will be resized width : 185px height: 154px ");	
				return true;
			}
			
		}
		
		if (document.frmAgent.image_file.value.length == 0) {
				return true;			
		}
	}		
		//alert("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
		$("#image_file").replaceWith($("#image_file").clone(true));
		$("#image_file").val(""); 
        showMess("You must upload an image file with one of the following extensions: "+ extensions.join(', ') +".");
		//document.frmAgent.image_file.value = '';
		return false;
		
}

