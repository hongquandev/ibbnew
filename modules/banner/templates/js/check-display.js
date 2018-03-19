

function duc1234() {
	alert('1112');
}
	
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
	document.getElementById("page_id").style.display = 'none';
	document.getElementById("page_id2").style.display = 'block';
	
	//document.getElementById("position_t").style.display = 'block';
	//document.getElementById("position_right").style.display = 'none';
}

function rollBack(){
	
	document.getElementById("page_id").style.display = 'block';
	document.getElementById("page_id2").style.display = 'none';	
	//document.getElementById("position_t").style.display = 'none';

	//document.getElementById("position_right").style.display = 'none';
}

function test() {		
}
function checkPosition(str, areas) {

	var temp=document.getElementById('display');
	
	areas=temp.options[temp.options.selectedIndex].value;
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

					jQuery('#rgalert').removeAttr('onclick');
					jQuery('#rgalert').removeAttr('onclick');
					jQuery('#rgalert').removeClass('btn-red').addClass("btn-black");
					jQuery('#fields_position').hide();
					//$('#rgalert').css({"cursor" : "none"});
					showMess('this position page is not available');
					$('#rgalert').unbind('click');
			} else {
				
				//document.getElementById("rgalert").setAttribute('onClick', 'banner.submit("#frmCreate)');
				//jQuery('#rgalert').attr("onClick", "banner.submit('#frmCreate')");
				
				 
				
				//jQuery('#rgalert').attr('onclick', 'banner.submit("#frmCreate")');
				//var c = document.getElementById("rgalert");
				//c.setAttribute("onclick", "test()");

				$('#rgalert').click(function() {
					bannerSubmit();
					
				})

				//$('#rgalert').attr("onclick", "banner.submit(true)");
				//jQuery("#rgalert").click(function () {jQuery('#rgalert').attr('onClick', 'banner.submit("#frmCreate")'); })


				jQuery('#rgalert').removeClass('btn-black').addClass("btn-red");
				
				var drop = document.getElementById("dropDowns");		
				var dropValue = drop.options[drop.options.selectedIndex].value;		
				jQuery('#dropDown span').html(dropValue);
				jQuery('#fields_position').show();

			
				
					
				//$('#rgalert').css({"cursor" : "pointer"});	
			}
		}
	  }
	xmlhttp.open("POST","modules/banner/banner.position.php?action=add-advertising&q="+str+"&areas="+areas,true);
	xmlhttp.send();
}


function changeValue(){
	var drop = document.getElementById("dropDowns");		
	var dropValue = drop.options[drop.options.selectedIndex].value;	
	jQuery('#dropDown span').html(dropValue);				
}

function onReloadDisplay(form) {
	
	var val= form.display.options[form.display.options.selectedIndex].value;
	
	if (val != 1) {	
		Change();
		var value = form.page_ids.options[form.page_ids.options.selectedIndex].value;
		//checkPosition(value, val);
		EnabledOptionWithCenter();
		disabledOptionWithCenter();
		document.getElementById("page_ids").className = "input-select validate-choose-select";
		
	} else if (val == 1) {	
		rollBack();
		var value = form.page_id.options[form.page_id.options.selectedIndex].value;
		
		//checkPosition(value, val);
		
		EnabledOption();
		disabledOption();	
		document.getElementById("page_ids").className = "input-select";
	}
	
}