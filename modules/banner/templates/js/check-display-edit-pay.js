

function disabledOption() {
	var ddl = document.getElementById("page_ids");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true;
		// ddl.onchange(); 
	}
}

function disabledOptionWithCenter() {
	var ddl = document.getElementById("page_id");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true;
		// ddl.onchange(); 
	}
}

function EnabledOptionWithCenter() {
	var ddl = document.getElementById("page_ids");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = false;
		// ddl.onchange(); 
	}
}

function EnabledOption() {
	var ddl = document.getElementById("page_id");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = false;
		// ddl.onchange(); 
	}
}

// Position
function disabledOptionPosition() {
	var d1 = document.getElementById("position");	
	for (var i = 0; i < d1.options.length; i++) {
		 d1.disabled = true;		
	}
}


function disabledOptionPositionWithCenter() {
	//var d1 = document.getElementById("position_rights");	
//	for (var i = 0; i < d1.options.length; i++) {
//		 d1.disabled = true;		
//	}
}



function EnabledOptionPosition() {
	var ddl = document.getElementById("position");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = false;
		// ddl.onchange(); 
	} 
}

function EnabledOptionPositionWithRight() {
	//var ddl = document.getElementById("position_rights");	
//	for (var i = 0; i < ddl.options.length; i++) {
//		 ddl.disabled = false;
//		// ddl.onchange(); 
//	} 
}

function removeOptionWithMorePage() {
	var dnu = document.getElementById("more_page");	
	if (dnu != null) {
		for (var i = 0; i < dnu.options.length; i++) {
			 if (dnu.options[i].selected !=true){
				dnu.options[i].disabled = true;
				//dnu.options[i].style.color = 'red';
			 }
		} 
	}
}

function DhiddenPageRight() {	
	var dnu = document.getElementById("page_id");	
	if (dnu != null) {
		for (var i = 0; i < dnu.options.length; i++) {
			 if (dnu.options[i].selected !=true){
				dnu.options[i].disabled = true;
				//dnu.options[i].style.color = 'red';
			 }
		} 
	}
}


function DhiddenPageCenter() {
	var dnu = document.getElementById("page_ids");	
	if (dnu != null) {
		for (var i = 0; i < dnu.options.length; i++) {
			 if (dnu.options[i].selected !=true){
				dnu.options[i].disabled = true;
				//dnu.options[i].style.color = 'red';
			 }
		} 
	}
}


// End Position

function Change() {
	if( !(document.getElementById("page_id")) == null)  {
		//document.getElementById("page_id").style.display = 'block';
		jQuery('#page_id').hide();
	} 
	if( !(document.getElementById("page_id2")) == null)  {
		//document.getElementById("page_id2").style.display = 'none';
		jQuery('#page_id2').show();
	}
	
	//document.getElementById("page_id").style.display = 'none';
	//document.getElementById("page_id2").style.display = 'block';
	
	//document.getElementById("position_t").style.display = 'block';
	//document.getElementById("position_right").style.display = 'none';
}

function rollBack(){
	if( !(document.getElementById("page_id")) == null)  {
		//document.getElementById("page_id").style.display = 'block';
		jQuery('#page_id').show();
	} else {
		//alert('sss');
	}
	if( !(document.getElementById("page_id2")) == null)  {
		//document.getElementById("page_id2").style.display = 'none';
		jQuery('#page_id2').hide();
	} else {
		//alert('sss');
	}
	
	//document.getElementById("position_t").style.display = 'none';
	//document.getElementById("position_right").style.display = 'none';
}

function onReloadDisplay(form) {
	
	var val= form.display.options[form.display.options.selectedIndex].value;
	
	if (val != 1) {
		Change();
		//EnabledOptionPosition();
		disabledOptionPositionWithCenter();
		DhiddenPageCenter();
		
	} else if (val == 1) {	
		
		rollBack();
		removeOptionWithMorePage();
		disabledOptionPosition();
		EnabledOptionPositionWithRight();
		//DhiddenPageRight();
	}
	
}