
function changeStateCountry() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = '';
		
		//document.getElementById("active_country").style.display = 'none';
}

<!-- Apply validate Phone Number -->

function ChangeClassvalidatePhone() {
	document.getElementById("telephone").className = "input-text validate-require validate-number";
	document.getElementById("mobilephone").className = "input-text validate-require validate-number";	
}

function rollClassvalidatePhone() {
	
	document.getElementById("telephone").className = "input-text validate-require validate-telephone";
	document.getElementById("mobilephone").className = "input-text validate-require validate-telephone";	
}

<!-- End Apply Validate Phone -->

function rollStateCountry(){
	// Hide
		document.getElementById("inactive_state").style.display = '';
	// SHow
		document.getElementById("active_state").style.display = 'none';
}

function changeCountryWithOther() {
	// Hide 
		document.getElementById("active_country").style.display = 'none';
		document.getElementById("active_state").style.display = 'none';
	// Show	
		document.getElementById("Inactive_country").style.display = '';
		document.getElementById("Inactive_state").style.display = '';
		document.getElementById("link_return").style.display = '';
		
		//document.getElementById("country").setAttribute("class", "input-select");
		
		document.getElementById("country").className = "input-select";
}

function changeClass() {
	
	document.getElementById("state").className = "input-select";
}


function withCountryOther() {


	document.getElementById("other_state").className = "input-text validate-require";
}

function rollWithCountryOther() {

	
	document.getElementById("other_state").className = "input-text";
}

function returnClass() {
		
	document.getElementById("state").className = "input-select validate-number-gtzero";
	document.getElementById("other_state").className = "input-text";
}



function changeOtherCountry()
{
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
		//document.getElementById("inactive_country").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = '';
		document.getElementById("active_country").style.display = '';

}

function rollback() {
	// Hide Default
		document.getElementById("inactive_state").style.display = '';
		document.getElementById("inactive_country").style.display = '';
	// Show 
		document.getElementById("active_state").style.display = 'none';
		document.getElementById("active_country").style.display = 'none';
		
		RefrershCountry();
}

function OnKeyChange() {
	document.getElementById("search_overlay").id = 'lock_id';
}

function OnKeyRoll() {
	document.getElementById("lock_id").id = 'search_overlay'; 
}

function onReloadCountry(form) {
	
	var val= form.country.options[form.country.options.selectedIndex].value;
	var toption = form.type_id.options[form.type_id.options.selectedIndex].value;
	
	if (val != 1 && toption != 3) {
	
		changeStateCountry();
		OnKeyChange();
		changeClass();
		ChangeClassvalidatePhone();
		withCountryOther();
		//removeOnchage();	
		// apply validate Phone
		
		
		document.getElementById("postcode").className = "input-text validate-require validate-number";
		document.getElementById("license_number").className = "input-text validate-number";
		
		/*document.getElementById("suburb").id = 'suburbs';
		document.getElementById("notify_suburb").id = 'notify_suburbs';	
		
		document.getElementById("postcode").id = 'postcodes';	
		document.getElementById("notify_postcode").id = 'notify_postcodes';	
		*/	
	}
	
	if (val != 1 && toption == 3) {
		
		changeStateCountry();
		OnKeyChange();
		changeClass();
		//ChangeClassvalidatePhone();
		withCountryOther();
		//removeOnchage();	
		// apply validate Phone
		document.getElementById("telephone").className = "input-text validate-require validate-number";
		document.getElementById("mobilephone").className = "input-text";
		document.getElementById("postcode").className = "input-text validate-require validate-number";
		document.getElementById("license_number").className = "input-text validate-number";
			
	}
	
	if (val == 1 && toption != 3) {
		
		rollStateCountry();
		OnKeyRoll();
		//RefrershCountry();
		//document.getElementById("active_country").style.display = 'none';
		returnClass();
		rollWithCountryOther();
		// apply validate Phone
		rollClassvalidatePhone();
		
		document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		document.getElementById("license_number").className = "input-text validate-require validate-license";
		
		// 
		
		/*	document.getElementById("suburb").id = 'suburbs';
			document.getElementById("notify_suburb").id = 'notify_suburbs';	
			
			document.getElementById("postcode").id = 'postcodes';	
			document.getElementById("notify_postcode").id = 'notify_postcodes';	
		*/
	
		
	}	
	if (val == 1 && toption == 3 || toption == 3 && val == 1) {
		//document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		document.getElementById("telephone").className = "input-text validate-require validate-telephone";
		document.getElementById("mobilephone").className = "input-text";
		
		/*	document.getElementById("suburbs").id = 'suburb';
			document.getElementById("notify_suburbs").id = 'notify_suburb';	
			
			document.getElementById("postcodes").id = 'postcode';	
			document.getElementById("notify_postcodes").id = 'notify_postcode';	
		*/
	}
	if (val == 1) {
		
		rollStateCountry();
		OnKeyRoll();
		//RefrershCountry();
		//document.getElementById("active_country").style.display = 'none';
		returnClass();
		rollWithCountryOther();
		// apply validate Phone
		//rollClassvalidatePhone();
		
		document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		document.getElementById("license_number").className = "input-text validate-require validate-license";
		
		//
		
		/* document.getElementById("suburbs").id = 'suburb';
			document.getElementById("notify_suburbs").id = 'notify_suburb';	
		
			document.getElementById("postcodes").id = 'postcode';	
			document.getElementById("notify_postcodes").id = 'notify_postcode';	
		*/
		
	}
	

	
}







