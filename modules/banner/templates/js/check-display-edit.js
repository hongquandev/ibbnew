
function disabledOption() {
	var ddl = document.getElementById("page_ids");	
	jQuery("#page_ids").each(function(){
	jQuery("#page_ids option").attr("disabled","disabled"); });
}

function disabledOptionWithCenter() {
	var ddl = document.getElementById("page_id");	
	jQuery("#page_id").each(function(){
	jQuery("#page_id option").attr("disabled","disabled"); });
    
}

function EnabledOptionWithCenter() {
	var ddl = document.getElementById("page_ids");	
	jQuery("#page_ids").each(function(){
	jQuery("#page_ids option").attr("disabled",false); });
}

function EnabledOption() {
	var ddl = document.getElementById("page_id");	
	jQuery("#page_id").each(function(){
	jQuery("#page_id option").attr("disabled",false); });
}

// End Position

function Change() {
	
//	if( !(document.getElementById("page_id")) == null)  {
//		//document.getElementById("page_id").style.display = 'block';
//		jQuery('#page_id').hide();
//	} else {
//		//alert('sss');
//	}
//	if( !(document.getElementById("page_id2")) == null)  {
//		//document.getElementById("page_id2").style.display = 'none';
//		jQuery('#page_id2').show();
//	} else {
//		//alert('sss');
//	}
	jQuery('#page_id').hide();
	jQuery('#page_id2').show();
	//document.getElementById("page_id").style.display = 'none';
	//document.getElementById("page_id2").style.display = 'block';
	
	//document.getElementById("position_t").style.display = 'block';
	//document.getElementById("position_right").style.display = 'none';
}

function rollBack(){
	jQuery('#page_id').show();
	jQuery('#page_id2').hide();
	//if( !(document.getElementById("page_id")) == null)  {
//		//document.getElementById("page_id").style.display = 'block';
//		jQuery('#page_id').show();
//	} else {
//		//alert('sss');
//	}
//	if( !(document.getElementById("page_id2")) == null)  {
//		//document.getElementById("page_id2").style.display = 'none';
//		jQuery('#page_id2').hide();
//	} else {
//		//alert('sss');
//	}
	
	//document.getElementById("page_id").style.display = 'block';
	//document.getElementById("page_id2").style.display = 'none';	
	//document.getElementById("position_t").style.display = 'none';

	//document.getElementById("position_right").style.display = 'none';
}

function checkPosition(str, areas) {

	var temp=document.getElementById('display');
	
	var id = getUrlVars()["id"];
	
	areas = temp.options[temp.options.selectedIndex].value;
	
	if (areas == 1) {
		//var value = document.getElementById('page_id');
		//str=value.options[value.options.selectedIndex].value;
		
	} else {
		//var value = document.getElementById('page_ids');
		//str=value.options[value.options.selectedIndex].value;	
	}
	
	if (str=="") {
	  document.getElementById("dropDown").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("dropDown").innerHTML=xmlhttp.responseText;
			
			if (document.getElementById('dropDown').innerHTML == 'wrong') {
					jQuery('#position_t').hide();
					jQuery('#rgalert').removeAttr('onclick');
					jQuery('#rgalert').removeAttr('onclick');
					jQuery('#rgalert').removeClass('btn-red').addClass("btn-black");
					showMess('this position page is not available');
					$('#rgalert').unbind('click');
			
			} else {
				
					$('#rgalert').click(function() {
						bannerSubmit();	
					})
					jQuery('#rgalert').removeClass('btn-black').addClass("btn-red");		
					var drop = document.getElementById("dropDowns");		
					var dropValue = drop.options[drop.options.selectedIndex].value;		
					jQuery('#dropDown span').html(dropValue);
					jQuery('#position_t').show();
			
				//jQuery('#rgalert').attr('onClick', "banner.submit('#frmCreate');");
						
			}
		}
	  }
	 
	xmlhttp.open("POST","modules/banner/banner.position.php?action=edit-advertising&q="+str+"&areas="+areas+"&id="+id,true);
	xmlhttp.send();
	
			//url = 'modules/banner/banner.position.php?action=edit-advertising';
//            var param = new Object();
//            param.q = str;
//            param.areas = areas;
//            param.id = id;       
//            $.get(url, param, this.onSubmit, 'html');
	
}


function changeValue(){
	var drop = document.getElementById("dropDowns");		
	var dropValue = drop.options[drop.options.selectedIndex].value;	
	jQuery('#dropDown span').html(dropValue);				
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$(document).ready(function() {
       
	  var temp =  jQuery('#display');
	  var page1 = jQuery('#page_id');
	  var page2 = jQuery('#page_ids');
	
		
});


function onReloadDisplay(form) {
	
	var val= form.display.options[form.display.options.selectedIndex].value;
	
	if (val != 1) {	
		Change();
		//if( !(document.getElementById("page_ids")) == null)  {
			var value = form.page_ids.options[form.page_ids.options.selectedIndex].value;
			//checkPosition(value, val);
			
			EnabledOptionWithCenter();
			disabledOptionWithCenter();
			document.getElementById("page_ids").className = "input-select validate-choose-select";
		//}
		
	} else if (val == 1) {	
		rollBack();
		//if( !(document.getElementById("page_id")) == null)  {
			var value = form.page_id.options[form.page_id.options.selectedIndex].value;		
			//checkPosition(value, val);
			
			EnabledOption();
			disabledOption();	
			document.getElementById("page_ids").className = "input-select";
		//} 
		
	}
	
}