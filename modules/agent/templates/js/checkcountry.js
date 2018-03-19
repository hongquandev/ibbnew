<!-- Function Using All Function -->
// Apply With Country is not Australia
try{
function withCountryOther() {
	//document.getElementById("other_country").className = "input-text validate-require";
	document.getElementById("other_state").className = "input-text validate-require";
}

function rollWithCountryOther() {
	document.getElementById("other_state").className = "input-text";
}


function withCountryOtherContact() {

//	document.getElementById("other_countrys").className = "input-text validate-require";
	document.getElementById("other_state2").className = "input-text validate-require";
}

function rollWithCountryOtherContact() {
	document.getElementById("other_state2").className = "input-text";
}

function withCountryOtherLawyer() {

//	document.getElementById("other_country").className = "input-text validate-require";
	document.getElementById("other_state").className = "input-text validate-require";
}

function rollWithCountryOtherLawyer() {
	document.getElementById("other_state").className = "input-text";
}

<!-- Step 1 -->
function ChangeClassvalidatePhone(name) {
    if (name != 'lawyer'){
		
        document.getElementById("telephones").className = "input-text validate-number";
		document.getElementById("mobilephone").className = "input-text validate-number";
	  
    }else{
        document.getElementById("telephones").className = "input-text validate-number";
	    document.getElementById("mobilephone").className = "input-text validate-number";
    }

}

function rollClassvalidatePhone(name) {
    if (name != 'lawyer'){
        document.getElementById("telephones").className = "input-text validate-telephone";
	    document.getElementById("mobilephone").className = "input-text validate-telephone";
    }else{
		
        document.getElementById("telephones").className = "input-text  validate-telephone";
	  	document.getElementById("mobilephone").className = "input-text  validate-telephone";
    }

}
<!-- End Step 1 -->

<!-- Step 2 -->
function ChangeClassvalidatePhone2() {
	
	document.getElementById("lawyer_telephones").className = "input-text  validate-number";
	document.getElementById("lawyer_mobilephones").className = "input-text  validate-number";
}

function rollClassvalidatePhoneLawyer() {
	
	document.getElementById("lawyer_telephones").className = "input-text validate-require validate-telephone";
	document.getElementById("lawyer_mobilephones").className = "input-text validate-require validate-telephone";
	document.getElementById("lawyer_state").className = "input-select validate-number-gtzero";
	
}
<!-- End Step 2 -->


<!-- Step 3 -->
function ChangeClassvalidatePhone3() {
		
	document.getElementById("contact_telephones").className = "input-text validate-number";
	document.getElementById("contact_mobilephones").className = "input-text validate-number";
}

function rollClassvalidatePhoneContact() {

	document.getElementById("contact_telephones").className = "input-text validate-telephone";
	document.getElementById("contact_mobilephones").className = "input-text validate-telephone";
	document.getElementById("contact_state").className = "input-select validate-number-gtzero";
}
<!-- End Step 3 -->

<!-- End Function Using All -->

function changeStateCountry() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = 'block';
		
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
	
		document.getElementById("country").className = "input-select";
}

function changeClass() {

		document.getElementById("state").className = "input-select";
}

function rollClassState() {

	document.getElementById("state").className = "input-select validate-number-gtzero";
}

function returnClass() {
	
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

function OnKeyChange() {
	//document.getElementById("search_overlay").id = 'lock_id';
    jQuery('search_overlay').attr('id','lock_id');
}

function OnKeyRoll() {
	//document.getElementById("lock_id").id = 'search_overlay';
    jQuery('#lock_id').attr('id','search_overlay');
}

function OnKeyChangeContact() {
	document.getElementById("search_contact").id = 'lock_id';
}

function OnKeyRollContact() {
	document.getElementById("lock_id").id = 'search_contact'; 
}


// End

function onReloadCountry(form,name) {
	
	var val= form.country.options[form.country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry();
		
		changeClass();
		withCountryOther();
		//removeOnchage();	
		// apply validate Phone
	
		document.getElementById("other_state").className = "input-text validate-require";
		// Change class field text postCode, and license number
		document.getElementById("postcode").className = "input-text validate-require validate-number";
		OnKeyChange();		
        ChangeClassvalidatePhone(name);
		//document.getElementById("license_number").className = "input-text validate-require validate-number";
        jQuery('#license_number').removeClass();
        jQuery('#license_number').addClass('input-text validate-require validate-number');
		// End Change class 	
	}
	
	if (val == 1) {
		rollStateCountry();
		
		//RefrershCountry();
	//	document.getElementById("active_country").style.display = 'none';
		returnClass();
		// return validate default state
		rollClassState();
		
		rollWithCountryOther();
		document.getElementById("postcode").className = "input-text validate-require validate-postcode";
		OnKeyRoll();  
		rollClassvalidatePhone(name);
		  
		

            // return class field text postCode, and license number
        
            // rollback validate Phone

            document.getElementById("license_number").className = "input-text validate-require validate-license";
            // End return class

		
		
	}
	
}

<!-- Using With Agent Step 2 -->

function changeStateCountry2() {
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'none';
	// Show 
		document.getElementById("active_state2").style.display = 'block';
		
		document.getElementById("active_country2").style.display = 'none';
}

function rollStateCountry2(){
	// Hide
		document.getElementById("inactive_state2").style.display = 'block';
	// SHow
		document.getElementById("active_state2").style.display = 'none';
}

function changeCountryWithOther2() {
	// Hide 
		document.getElementById("active_country2").style.display = 'none';
		document.getElementById("active_state2").style.display = 'none';
	// Show	
		document.getElementById("Inactive_country2").style.display = 'block';
		document.getElementById("Inactive_state2").style.display = 'block';
		
		//document.getElementById("country2").setAttribute("class", "input-select");
		
		document.getElementById("country2").className = "input-select";
}

function changeClass2() {
	//document.getElementById("contact_state").setAttribute("class", "input-select");
	document.getElementById("contact_state").className = "input-select";
}

function returnClass2() {

	document.getElementById("other_state2").className = "input-select";
}

function rollClassState2() {
	//document.getElementById("state").setAttribute("class", "input-select validate-number-gtzero");	
	document.getElementById("state").className = "input-select validate-number-gtzero";
}


function changeOtherCountry2()
{
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'none';
		//document.getElementById("inactive_country").style.display = 'none';
	// Show 
		document.getElementById("active_state2").style.display = 'block';
		document.getElementById("active_country2").style.display = 'block';

}

function rollback2() {
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'block';
		document.getElementById("inactive_country2").style.display = 'block';
	// Show 
		document.getElementById("active_state2").style.display = 'none';
		document.getElementById("active_country2").style.display = 'none';
		
}


function onReloadCountryContact(form) {
	
	var val= form.contact_country.options[form.contact_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry2();
		
		changeClass2();
		withCountryOtherContact();
		//removeOnchage();	
		
		
		document.getElementById("other_state2").className = "input-text validate-require";
		document.getElementById("contact_postcodes").className = "input-text validate-require validate-number";
		OnKeyChangeContact();
		// apply validate phone
		ChangeClassvalidatePhone3();
	}

	if (val == 1) {
			document.getElementById("active_country2").style.display = 'none';
		
		
		rollStateCountry2();
		//RefrershCountry();
		//document.getElementById("active_country").style.display = 'none';
		returnClass2();
		rollWithCountryOtherContact();

		document.getElementById("contact_postcodes").className = "input-text validate-require validate-postcode";
		
		OnKeyRollContact();
		// return validate phone and state default
		rollClassvalidatePhoneContact();
	}
	
	if (val == 0) {
		
	}
}

<!-- Using With Agent Step 2 WITH Agent Lawyer -->

function changeStateCountry3() {
	// Hide Default
		document.getElementById("inactive_state3").style.display = 'none';
	// Show 
		document.getElementById("active_state3").style.display = 'block';
		
		document.getElementById("active_country3").style.display = 'none';
}

function rollStateCountry3(){
	// Hide
		document.getElementById("inactive_state3").style.display = 'block';
	// SHow
		document.getElementById("active_state3").style.display = 'none';
}

function changeCountryWithOther3() {
	// Hide 
		document.getElementById("active_country3").style.display = 'none';
		document.getElementById("active_state3").style.display = 'none';
	// Show	
		document.getElementById("Inactive_country3").style.display = 'block';
		document.getElementById("Inactive_state3").style.display = 'block';
		
		document.getElementById("country3").className = "input-select";	
}

function changeClass3() {
	//document.getElementById("lawyer_state").setAttribute("class", "input-select");
	document.getElementById("lawyer_state").className = "input-select";		
}

function returnClass3() {

	document.getElementById("other_state").className = "input-select";		
}


function rollClassState3() {
	
	document.getElementById("state").className = "input-select validate-number-gtzero";		
}

function changeOtherCountry3()
{
	// Hide Default
		document.getElementById("inactive_state3").style.display = 'none';
		//document.getElementById("inactive_country").style.display = 'none';
	// Show 
		document.getElementById("active_state3").style.display = 'block';
		document.getElementById("active_country3").style.display = 'block';

}

function rollback3() {
	// Hide Default
		document.getElementById("inactive_state3").style.display = 'block';
		document.getElementById("inactive_country3").style.display = 'block';
	// Show 
		document.getElementById("active_state3").style.display = 'none';
		document.getElementById("active_country3").style.display = 'none';

}

function onReloadCountryLawyer(form) {
	
	var val= form.lawyer_country.options[form.lawyer_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry3();
		changeClass3();
		withCountryOtherLawyer();
		//removeOnchage();	

        document.getElementById("lawyer_telephones").className = "input-text  validate-number";
	    document.getElementById("lawyer_mobilephones").className = "input-text validate-number";
		document.getElementById("other_state").className = "input-text validate-require";		
		document.getElementById("lawyer_postcode").className = "input-text validate-require validate-number";
		
		/*	document.getElementById("suburb").id = 'suburbs';	
			document.getElementById("notify_suburb").id = 'notify_suburbs';	
		
			document.getElementById("postcode").id = 'postcodes';	
			document.getElementById("notify_postcode").id = 'notify_postcodes';		
		*/
		OnKeyChange();

	}
	
	if (val == 1) {
		document.getElementById("active_country3").style.display = 'none';	
		// return validate phone and state default
		rollClassvalidatePhoneLawyer();
		
		rollStateCountry3();
		//RefrershCountry();
		returnClass3();
	
		rollWithCountryOtherLawyer();
		// Change class field text postCode
		document.getElementById("lawyer_postcode").className = "input-text validate-require validate-postcode";	
		
		OnKeyRoll();
		
		/*	document.getElementById("suburbs").id = 'suburb';	
			document.getElementById("notify_suburbs").id = 'notify_suburb';	
		
			document.getElementById("postcodes").id = 'postcode';	
			document.getElementById("notify_postcodes").id = 'notify_postcode';		
		*/
	}
	
	if (val == 0) {
		
	}
}
}
catch(er)
{

}




