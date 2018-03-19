<!-- Function Using All Function -->

<!-- Step 1 -->

function withCountryOther() {
	
	document.getElementById("other_country").className = "input-text validate-require";
	document.getElementById("other_state").className = "input-text validate-require";
}

function rollWithCountryOther() {

	document.getElementById("other_country").className = "input-text";
	document.getElementById("other_state").className = "input-text";
}
<!-- End Step 1 -->

// Apply With Country is not Australia
<!-- Step 1 -->
function ChangeClassvalidatePhone() {
	//document.getElementById("personal_telephone").setAttribute((document.all ? 'className' : 'class'),"input-text validate-number");
	document.getElementById("personal_telephone").className = "input-text validate-number";
}
function rollClassvalidatePhone() {
	//document.getElementById("personal_telephone").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require validate-telephone");
	document.getElementById("personal_telephone").className = "input-text validate-require validate-telephone";
}
<!-- End Step 1 -->

<!-- End Function Using All -->

function changeStateCountry() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = 'block';
		
	//	document.getElementById("active_country").style.display = 'none';
}

function rollStateCountry(){
	// Hide
		document.getElementById("inactive_state").style.display = 'block';
	// SHow
		document.getElementById("active_state").style.display = 'none';
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
	//document.getElementById("personal_state").setAttribute("class", "input-select");
	//document.getElementById("personal_state").setAttribute((document.all ? 'className' : 'class'),"input-select");	
	document.getElementById("personal_state").className = "input-select";
}

function rollClassState() {
	//document.getElementById("personal_state").setAttribute("class", "input-select validate-number-gtzero");	
	//document.getElementById("personal_state").setAttribute((document.all ? 'className' : 'class'),"input-select validate-number-gtzero");	
	document.getElementById("personal_state").className = "input-select validate-number-gtzero";
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

function removeOnchage() 
{
	document.getElementById('state').onchange = undefined;
	document.getElementById('postcode').onkeyup = undefined;
	document.getElementById('suburb').onkeyup = undefined;  
}
function rollback() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'block';
		document.getElementById("inactive_country").style.display = 'block';
	// Show 
		document.getElementById("active_state").style.display = 'none';
		document.getElementById("active_country").style.display = 'none';
		
}

function OnKeyChangePartner() {
	document.getElementById("search_personal").id = 'lock_id';
}

function OnKeyRollPartner() {
	document.getElementById("lock_id").id = 'search_personal'; 
}

function onReloadPartner(form) {
	
	var val= form.personal_country.options[form.personal_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry();
		rollWithCountryOther();
		changeClass();	
		//removeOnchage();	
		// apply validate Phone
		ChangeClassvalidatePhone();
	//	document.getElementById("other_state").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require");		
	//	document.getElementById("personal_postcode").setAttribute((document.all ? 'className' : 'class'),"input-text validate-number");
		
		document.getElementById("other_state").className = "input-text validate-require";
		document.getElementById("personal_postcode").className = "input-text validate-number";
		
		OnKeyChangePartner();
	}
	
	if (val == 1) {
		//document.getElementById("active_country").style.display = 'none';
		rollStateCountry();
		//RefrershCountry();
	//	document.getElementById("active_country").style.display = 'none';
		returnClass();
		// return validate default state
		rollClassState();
		
		rollWithCountryOther();
		// rollback validate Phone 
		rollClassvalidatePhone();
		
	//	document.getElementById("personal_postcode").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require validate-postcode");
		document.getElementById("personal_postcode").className = "input-text validate-require validate-postcode";
		
		OnKeyRollPartner();
	}
	
	if (val == 0) {
		
	}
}



