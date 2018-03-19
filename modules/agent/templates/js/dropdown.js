function hiddenFields() {
	document.getElementById("notify_firstname").innerHTML = 'Company Name';
	document.getElementById("notify_lastname").style.display = "none";
	document.getElementById("lastname").style.display = "none";
	document.getElementById("notify_street").innerHTML = 'Company Address';
    document.getElementById("add_new_cw").style.display = "table-row";

	/*document.getElementById("notify_telephone").style.display = "none";
    document.getElementById("telephone").style.display = "none";
	document.getElementById("notify_mobilephone").innerHTML = 'Contact Phone Number';
	document.getElementById("mobilephone").style.display = "block";
    */
    //document.getElementById('mobilephone_block').style.display = "block";
    /*document.getElementById("notify_mobilephone").innerHTML = 'Contact Phone Number';
    document.getElementById('telephone_block').style.display = "none";*/

    document.getElementById('notify_telephone').innerHTML = 'Contact Phone Number';
    document.getElementById('mobilephone_block').style.display = "none";

	document.getElementById("notify_email_address").innerHTML = 'Contact Email Address';
	document.getElementById("notify_license_number").style.display = "none";
	document.getElementById("license_number").style.display = "none";
	document.getElementById("partner_hidden").style.display = "none";
	document.getElementById("notify_preferred_contact_method").style.display = "none";
	document.getElementById("preferred_contact_method").style.display = "none";

	//document.getElementById("Personal detail").innerHTML = "Company detail";
	//document.getElementById("Lawyer information").innerHTML = "Company information";

	//document.getElementById("Contact information").style.display = "none";
	// Title
	document.getElementById("titlx").innerHTML = "Company detail";
}

function showFields() {

	document.getElementById("notify_firstname").innerHTML = "First Name";
	document.getElementById("notify_lastname").style.display = "block";
	document.getElementById("lastname").style.display = "block";
	document.getElementById("notify_street").innerHTML = "Address";
	document.getElementById("notify_telephone").innerHTML = 'Telephone';
	document.getElementById("notify_mobilephone").style.display = "block";
	document.getElementById("mobilephone").style.display = "block";
	document.getElementById("notify_email_address").innerHTML = 'Email';
	document.getElementById("notify_license_number").style.display = "block";
	document.getElementById("license_number").style.display = "block";
	document.getElementById("partner_hidden").style.display = "block";
	document.getElementById("notify_preferred_contact_method").style.display = "block";
	document.getElementById("preferred_contact_method").style.display = "block";
	document.getElementById("add_new_cw").style.display = "none";

	//document.getElementById("Personal detail").innerHTML = "Personal detail";
	//document.getElementById("Lawyer information").innerHTML = "Lawyer information";
	//document.getElementById("Contact information").style.display = "block";
	// Title


	document.getElementById("titlx").innerHTML = "Personal detail";

}

/// Dynamic Get Checjcountry_admin_personal

function OnKeyRoll() {
	//document.getElementById("lock_id").id = 'search_overlay';
    jQuery('#lock_id').attr('id','search_overlay');
}

function rollStateCountry(){
	// Hide
		document.getElementById("inactive_state").style.display = '';
	// SHow
		document.getElementById("active_state").style.display = 'none';
}
function returnClass() {

	document.getElementById("state").className = "input-select validate-number-gtzero";
	document.getElementById("other_state").className = "input-text";
}

function rollWithCountryOther() {
	document.getElementById("other_state").className = "input-text";
}

function rollClassvalidatePhone() {

	document.getElementById("telephone").className = "input-text validate-require validate-telephone";
	document.getElementById("mobilephone").className = "input-text validate-require validate-telephone";
}



/// End
function onReloadMemberPartner(form) {

	var val= form.type_id.options[form.type_id.options.selectedIndex].value;
	var toption = form.country.options[form.country.options.selectedIndex].value;

	if (val == 1  && toption == 1 || val == 2  && toption == 1 || val == 4 && toption == 1) {
		//alert('AAAAAAA');
		//alert('111111111111111');
		showFields();

		rollStateCountry();

		returnClass();
		rollWithCountryOther();
		// apply validate Phone
		rollClassvalidatePhone();

		//
		/*	document.getElementById("suburbs").id = 'suburb';
			document.getElementById("notify_suburbs").id = 'notify_suburb';

			document.getElementById("postcodes").id = 'postcode';
			document.getElementById("notify_postcodes").id = 'notify_postcode';
		*/
		document.getElementById("lastname").className = "input-text validate-require";
		document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		document.getElementById("license_number").className = "input-text validate-require validate-license";
         document.getElementById("add_new_cw").style.display = "none";
		// Change Title
		document.getElementById("Personal detail").innerHTML = "Personal detail";
		document.getElementById("Lawyer information").innerHTML = "Lawyer information";
		document.getElementById("Contact information").style.display = "block";

		OnKeyRoll();

	}

	if (val == 1 || val == 2 || val == 4) {
		//alert('2222222222222222');
		showFields();
		document.getElementById("lastname").className = "input-text validate-require";
		document.getElementById("mobilephone").className = "input-text validate-number";
		document.getElementById("license_number").className = "input-text validate-number";

		// Change Title
		document.getElementById("Personal detail").innerHTML = "Personal detail";
		document.getElementById("Lawyer information").innerHTML = "Lawyer information";
		document.getElementById("Contact information").style.display = "block";
         document.getElementById("add_new_cw").style.display = "none";

	}

	else if (val == 3){
		//alert('3333333333');
		//var toption = form.country.options[form.country.options.selectedIndex].value;
		hiddenFields();

		document.getElementById("lastname").className = "input-select";
		document.getElementById("mobilephone").className = "input-select";
		document.getElementById("license_number").className = "input-text";
		document.getElementById("preferred_contact_method").className = "input-select";

		/*	document.getElementById("suburb").id = 'suburbs';
			document.getElementById("notify_suburb").id = 'notify_suburbs';

			document.getElementById("postcode").id = 'postcodes';
			document.getElementById("notify_postcode").id = 'notify_postcodes';
		*/

		// CHange Title
		document.getElementById("Personal detail").innerHTML = "Company detail";
		document.getElementById("Lawyer information").innerHTML = "Company information";
		document.getElementById("Contact information").style.display = "none";
		
	} 


	

}






