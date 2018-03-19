
function changeClass() {
	
	//document.getElementById("search_overlay").id = 'lock_id';
	document.getElementById("suburb").className = "input-text ";
	document.getElementById("postcode").className = "input-text";
	
	//document.getElementById("sub_require").style.display = "none";
	//document.getElementById("post_require").style.display = "none";
}

function rollClassState() {
	//document.getElementById("suburb").className = "input-text validate-require";
	//document.getElementById("lock_id").id = 'search_overlay';
	//document.getElementById("postcode").className = "input-text validate-postcode";
	
	//document.getElementById("sub_require").style.display = "";
	//document.getElementById("post_require").style.display = "";
	
	document.getElementById("suburb").className = "input-text ";
	document.getElementById("postcode").className = "input-text";
}

function onReloadState(form) {
	
	var val= form.state.options[form.state.options.selectedIndex].value;
	
	var pos = document.frmCreate.postcode.value;

	if (val == 0) {
		
		changeClass();
		
		
	} else {
		rollClassState();
	}	
}