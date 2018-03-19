<!-- Function Using All Function -->
// Apply With Country is not Australia
function withCountryOther() {
	
	document.getElementById("other_country").className = "input-text validate-require";
	document.getElementById("other_state").className = "input-text validate-require";
}

function rollWithCountryOther() {
	//document.getElementById("other_country").setAttribute((document.all ? 'className' : 'class'),"input-text");
	//document.getElementById("other_state").setAttribute((document.all ? 'className' : 'class'),"input-text");
	
	document.getElementById("other_country").className = "input-text";
	document.getElementById("other_state").className = "input-text";
}


<!-- Step 1 -->
function ChangeClassvalidatePhone() {
	//document.getElementById("telephone_partner").setAttribute((document.all ? 'className' : 'class'),"input-text validate-number");
	document.getElementById("telephone_partner").className = "input-text validate-require validate-number";
}

function rollClassvalidatePhone() {
	//document.getElementById("telephone_partner").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require validate-telephone");
	document.getElementById("telephone_partner").className = "input-text validate-require validate-telephone";
}
<!-- End Step 1 -->


<!-- End Function Using All -->

function disabledSta() {
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true;
		// ddl.onchange(); 
	}
}

function EnabledSta() {
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = false;
		// ddl.onchange(); 
	}
}

function changeStateCountry() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = 'block';
		disabledSta();
	//	document.getElementById("active_country").style.display = 'none';
}

function rollStateCountry(){
	// Hide
		document.getElementById("inactive_state").style.display = 'block';
	// SHow
		document.getElementById("active_state").style.display = 'none';
		EnabledSta();
}

function changeCountryWithOther() {
	// Hide 
		document.getElementById("active_country").style.display = 'none';
		document.getElementById("active_state").style.display = 'none';
	// Show	
		document.getElementById("Inactive_country").style.display = 'block';
		document.getElementById("Inactive_state").style.display = 'block';
		document.getElementById("link_return").style.display = 'block';
		
		//document.getElementById("country").setAttribute("class", "input-select");
		//document.getElementById("country").setAttribute((document.all ? 'className' : 'class'),"input-select");	
		document.getElementById("country").className = "input-select";
}

function changeClass() {
	//document.getElementById("state").setAttribute("class", "input-select");	
		//document.getElementById("state").setAttribute((document.all ? 'className' : 'class'),"input-select");	
		document.getElementById("state").className = "input-select";
}

function rollClassState() {
	//document.getElementById("state").setAttribute("class", "input-select validate-number-gtzero");	
	//document.getElementById("state").setAttribute((document.all ? 'className' : 'class'),"input-select validate-number-gtzero");	
	document.getElementById("state").className = "input-select validate-number-gtzero";
}

function returnClass() {
	
	//document.getElementById("other_state").setAttribute((document.all ? 'className' : 'class'),"input-select");	
	
	document.getElementById("other_state").className = "input-select";
}


function changeOtherCountry()
{
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
		//document.getElementById("inactive_country").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = 'block';
		document.getElementById("active_country").style.display = 'block';

}

function rollback() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'block';
		document.getElementById("inactive_country").style.display = 'block';
	// Show 
		document.getElementById("active_state").style.display = 'none';
		document.getElementById("active_country").style.display = 'none';
		
}

function OnKeyChange() {
	document.getElementById("search_overlay").id = 'lock_id';
}

function OnKeyRoll() {
	jQuery("#lock_id").attr('id','search_overlay');
}

function onReloadPartner(form) {
	
	var val= form.country.options[form.country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry();
		
		changeClass();
		rollWithCountryOther();
		//removeOnchage();	
		// apply validate Phone
		ChangeClassvalidatePhone();
		//document.getElementById("other_state").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require");	
		document.getElementById("other_state").className = "input-text validate-require";
		document.getElementById("postcode").className = "input-text validate-require validate-number";
		
		OnKeyChange();
	}


	if (val == 1) {
		rollStateCountry();
		//RefrershCountry();
		//document.getElementById("active_country").style.display = 'none';
		returnClass();
		// return validate default state
		rollClassState();
		
		rollWithCountryOther();
		// rollback validate Phone 
		rollClassvalidatePhone();
		document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		OnKeyRoll();
	}
	
	
	if (val == 0) {
		
	}
}