var CMS = function() {
}

CMS.prototype = {
	submit : function(frm) {
			
		var validation = new Validation(frm);
		if (validation.isValid())//&& isSpclChar() && isSpclPageTitlte()
		{
			jQuery(frm).submit();
		}
		
	}
}


function isSpclChar() {
	var iChars = "!@#$%^&*()+=[]\\\';,./{}|\":<>?";
	for (var i = 0; i < document.frmCreate.title_alias.value.length; i++) {
    	if (iChars.indexOf(document.frmCreate.title_alias.value.charAt(i)) != -1) {
  			alert ("The box Alias Title has special characters. \nThese are not allowed.\n");
    		return false;
        } 
    }	
	return true;
}   

function isSpclPageTitlte() {
	var iChars = "!@#$%^&*()+=[]\\\';,./{}|\":<>?";
	for (var i = 0; i < document.frmCreate.title.value.length; i++) {
    	if (iChars.indexOf(document.frmCreate.title.value.charAt(i)) != -1) {
  			alert ("The box Page Title has special characters. \nThese are not allowed.\n");
    		return false;
        } 
    }	
	return true;
}

function Check(evt)
{
	if(evt.keyCode == 32)
	{
		alert("Space not allowed");
		document.getElementById("title_alias").value='';
		return false;
	}
	return true;
}

function checkIt() {
  /*  var v = document.getElementById("title").value;
    if(!v.match(/^[- a-z-A-Z]+$/)) {
        alert(v + ' contains invalid characters');
        return false;
    }
    return true; */
}

function searchCms() {
	var search_query = document.getElementById('search_text').value;
	if (search_query.length > 0) {
		store_cms.load({params:{start:0, limit:20,search_query :search_query}});
	} else {
		Ext.Msg.alert('Warning.','Please entry some chars to search.');		
	}
}


