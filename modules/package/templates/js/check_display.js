function onReloadDisplay(form) {
	var val= form.area.options[form.area.options.selectedIndex].value;
	
	if (val != 1) {
		document.getElementById("postion_display").style.display = '';
	} else if (val == 1) {	
		document.getElementById("postion_display").style.display = 'none';
	}
}