

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

<!-- Step 2 -->

function withCountryOtherLawyer() {
	
	document.getElementById("other_country2").className = "input-text validate-require";
	document.getElementById("other_state2").className = "input-text validate-require";
}

function rollWithCountryOtherLawyer() {

	document.getElementById("other_country2").className = "input-text";
	document.getElementById("other_state2").className = "input-select";
}
<!-- End Step 2 -->

<!-- Step 3 -->

function withCountryOtherContact() {
	
	document.getElementById("other_country3").className = "input-text validate-require";
	document.getElementById("other_state3").className = "input-text validate-require";
}

function rollWithCountryOtherContact() {

	document.getElementById("other_country3").className = "input-text";
	document.getElementById("other_state3").className = "input-text";
}

<!-- End Step 3 -->

// Apply With Country is not Australia

<!-- Step 1 -->
function ChangeClassvalidatePhone() {
	
	document.getElementById("telephones").className = "input-text validate-require validate-number";
	document.getElementById("mobilephone").className = "input-text validate-require validate-number";
}

function rollClassvalidatePhone() {

	document.getElementById("telephones").className = "input-text validate-require validate-telephone";
	document.getElementById("mobilephone").className = "input-text validate-require validate-telephone";
}
<!-- End Step 1 -->

<!-- Step 2 -->
function ChangeClassvalidatePhone2() {
		
	document.getElementById("lawyer_telephones").className = "input-text validate-number";
	document.getElementById("lawyer_mobilephones").className = "input-text validate-number";
}

function rollClassvalidatePhoneLawyer() {
	
	document.getElementById("lawyer_telephones").className = "input-text validate-require validate-telephone";
	document.getElementById("lawyer_mobilephones").className = "input-text validate-require validate-telephone";
	document.getElementById("lawyer_state").className = "input-select validate-number-gtzero";
}
<!-- End Step 2 -->


<!-- Step 3 -->
function ChangeClassvalidatePhone3() {
	
	document.getElementById("contact_telephones").className = "input-text validate-require validate-number";
	document.getElementById("contact_mobilephones").className = "input-text validate-require validate-number";
}

function rollClassvalidatePhoneContact() {
	
	document.getElementById("contact_telephones").className = "input-text validate-require validate-telephone";
	document.getElementById("contact_mobilephones").className = "input-text validate-require validate-telephone";
	document.getElementById("contact_state").className = "input-select validate-number-gtzero";
}
<!-- End Step 3 -->

<!-- End Function Using All -->

function changeStateCountry() {
	// Hide Default
		document.getElementById("inactive_state").style.display = 'none';
	// Show 
		document.getElementById("active_state").style.display = 'block';
		
		//document.getElementById("active_country").style.display = 'none';
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
	document.getElementById("personal_state").className = "input-select";
}

function rollClassState() {

	document.getElementById("personal_state").className = "input-select validate-number-gtzero";
}

function returnClass() {
		
	document.getElementById("other_state").className = "input-select";
}


function RefrershCountry() {
	
	/* var ddl = document.getElementById("country");

     for (var i = 0; i < ddl.options.length; i++) {
             if (ddl.selectedIndex == i) {
                 ddl.selectedIndex = 1;
				// ddl.selected = true;
				// dd1.options[i].label = 'AAAAAAAAAAAAAA';
				 ddl.onchange(); 
				 ddl.selected = true;
				 break;
             }       
     } 
	 */
//document.location = '?module=agent&action=register-buyer';
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
		
		RefrershCountry();
}


// function Change ANd Rollback Sugestion
<!-- Personal -->
function OnKeyChangePersonal() {
	document.getElementById("search_personal").id = 'lock_id_per';
}

function OnKeyRollPersonal() {
	document.getElementById("lock_id_per").id = 'search_personal'; 
}

<!-- Lawyer -->
function OnKeyChange() {
	document.getElementById("search_overlay").id = 'lock_id';
}

function OnKeyRoll() {
	document.getElementById("lock_id").id = 'search_overlay'; 
}

<!-- Contact -->
function OnKeyChangeContact() {
	document.getElementById("search_contact").id = 'lock_id_contact';
}

function OnKeyRollContact() {
	document.getElementById("lock_id_contact").id = 'search_contact'; 
}

// End Change ANd Rollback Sugestion


function onReloadPersonal(form) {
	
	var val= form.personal_country.options[form.personal_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry();
		rollWithCountryOther();
		changeClass();
		OnKeyChangePersonal();
		//removeOnchage();	
		// apply validate Phone
		ChangeClassvalidatePhone();

		document.getElementById("other_state").className = "input-text validate-require";
		document.getElementById("personal_postcode").className = "input-text validate-require validate-number";
		document.getElementById("personal_license_number").className = "input-text validate-number";
		
	}
	
	if (val == 1) {
	
		rollStateCountry();
		//RefrershCountry();
		OnKeyRollPersonal();
		returnClass();
		// return validate default state
		rollClassState();
		
		rollWithCountryOther();
		// rollback validate Phone 
		rollClassvalidatePhone();
		
		document.getElementById("personal_postcode").className = "input-text validate-require validate-postcode";
		document.getElementById("personal_license_number").className = "input-text validate-license";
		
		
	}
	
	if (val == 0) {
		
	}
}

<!-- Using With Agent Step 2 -->

function changeStateCountry2() {
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'none';
	// Show 
		document.getElementById("active_state2").style.display = 'block';
		
		//document.getElementById("active_country2").style.display = 'none';
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
			
}

function changeClass2() {
	//document.getElementById("contact_state").setAttribute("class", "input-select");
	//document.getElementById("contact_state").setAttribute((document.all ? 'className' : 'class'),"input-select");	
	document.getElementById("contact_state").className = "input-select";
}

function returnClass2() {
	//document.getElementById("other_state2").setAttribute("class", "input-select");
	//document.getElementById("other_state2").setAttribute((document.all ? 'className' : 'class'),"input-select");
	document.getElementById("other_state2").className = "input-select";
}

function rollClassState2() {
	//document.getElementById("state").setAttribute("class", "input-select validate-number-gtzero");	
//	document.getElementById("state").setAttribute((document.all ? 'className' : 'class'),"input-select validate-number-gtzero");
	document.getElementById("state").className = "input-select validate-number-gtzero";
}


function changeOtherCountry2()
{
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'none';
		//document.getElementById("inactive_country").style.display = 'none';
	// Show 
		document.getElementById("active_state2").style.display = 'block';
		//document.getElementById("active_country2").style.display = 'block';

}

function rollback2() {
	// Hide Default
		document.getElementById("inactive_state2").style.display = 'block';
		document.getElementById("inactive_country2").style.display = 'block';
	// Show 
		document.getElementById("active_state2").style.display = 'none';
		document.getElementById("active_country2").style.display = 'none';
		
		RefrershCountry();
}


function onReloadContact(form) {
	
	var val= form.contact_country.options[form.contact_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry2();
		changeClass2();
		rollWithCountryOtherContact();
		//removeOnchage();	
		// apply validate phone
		ChangeClassvalidatePhone3();
		
		document.getElementById("other_state3").className = "input-text validate-require";
		document.getElementById("contact_postcode").className = "input-text validate-require validate-number";
		
		OnKeyChangeContact();
	}
	
	
	if (val == 1) {
			//document.getElementById("active_country2").style.display = 'none';
		// return validate phone and state default
		rollClassvalidatePhoneContact();
		
		rollStateCountry2();
		//RefrershCountry();
		//document.getElementById("active_country").style.display = 'none';
		returnClass2();
	
		rollWithCountryOtherContact();
		
		//document.getElementById("contact_postcode").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require validate-postcode");
		document.getElementById("contact_postcode").className = "input-text validate-require validate-postcode";
		
		OnKeyRollContact();
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
		
		//document.getElementById("active_country3").style.display = 'none';
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
		
		//document.getElementById("country3").setAttribute("class", "input-select");
		//document.getElementById("country3").setAttribute((document.all ? 'className' : 'class'),"input-select");	
		document.getElementById("country3").className = "input-select";
}

function changeClass3() {
	//document.getElementById("lawyer_state").setAttribute("class", "input-select");
	//document.getElementById("lawyer_state").setAttribute((document.all ? 'className' : 'class'),"input-select");
	document.getElementById("lawyer_state").className = "input-select";
}

function returnClass3() {
	//document.getElementById("other_state").setAttribute("class", "input-select");
	//document.getElementById("other_state").setAttribute((document.all ? 'className' : 'class'),"input-select");
	document.getElementById("other_state").className = "input-select";
}

function rollClassState3() {
	//document.getElementById("state").setAttribute("class", "input-select validate-number-gtzero");
//	document.getElementById("state").setAttribute((document.all ? 'className' : 'class'),"input-select validate-number-gtzero");
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
		
		RefrershCountry();
}



function onReloadLawyer(form) {
	
	var val= form.lawyer_country.options[form.lawyer_country.options.selectedIndex].value;
	
	if (val != 1) {
		changeStateCountry3();
		changeClass3();
		rollWithCountryOtherLawyer();
		//removeOnchage();	
		// apply validate phone
		ChangeClassvalidatePhone2();

		document.getElementById("other_state2").className = "input-text validate-require";
		document.getElementById("lawyer_postcode").className = "input-text validate-number";
		
		OnKeyChange();
	}
	
	
	if (val == 1) {
		//document.getElementById("active_country3").style.display = 'none';
		// return validate phone and state default
		rollClassvalidatePhoneLawyer();
		rollStateCountry3();
		//RefrershCountry();
		returnClass3();
	
		rollWithCountryOtherLawyer();
		//document.getElementById("lawyer_postcode").setAttribute((document.all ? 'className' : 'class'),"input-text validate-require validate-postcode");
		document.getElementById("lawyer_postcode").className = "input-text validate-require validate-postcode";
	
		OnKeyRoll();
	}
	
	if (val == 0) {
		
	}
}

function onLoad(obj){
    var country = $('#'+obj+'_country').val();
	if(country.length < 1){ return true;}
    if (country == 1){//Aus
        //$('.'+obj+'_inactive').show();
        $('#'+obj+'_other_state').hide();
        $('#inactive_'+obj+'_state').show();
        //$('#'+obj+'_state').addClass('validate-number-gtzero');
        $('#'+obj+'_other_state').removeClass('validate-require');
        $('#'+obj+'_postcode').removeClass();
        $('#'+obj+'_postcode').addClass('input-text validate-postcode');
        /*if ($('#'+obj+'_telephone').length > 0 && !$('#'+obj+'_telephone').is(':disabled')){
            $('#'+obj+'_telephone').removeClass();
            $('#'+obj+'_telephone').addClass('input-text validate-telephone');
        }
        if ($('#'+obj+'_mobilephone').length > 0 && !$('#'+obj+'_mobilephone').is(':disabled')){
            $('#'+obj+'_mobilephone').removeClass();
            $('#'+obj+'_mobilephone').addClass('input-text validate-telephone');
        }
        if ($('#'+obj+'_license_number').length > 0 && !$('#'+obj+'_license_number').is(':disabled')){
            $('#'+obj+'_license_number').removeClass();
            $('#'+obj+'_license_number').addClass('input-text validate-license');
        }*/
    }else{
        $('#inactive_'+obj+'_state').hide();
        $('#'+obj+'_other_state').show();
        $('#'+obj+'_state').removeClass('validate-number-gtzero');
        //$('#'+obj+'_other_state').addClass('validate-require');
        $('#'+obj+'_postcode').removeClass();
        $('#'+obj+'_postcode').addClass('input-text validate-number');
        if ($('#'+obj+'_telephone').length > 0 && !$('#'+obj+'_telephone').is(':disabled')){
            $('#'+obj+'_telephone').removeClass();
            $('#'+obj+'_telephone').addClass('input-text validate-number');
        }
        if ($('#'+obj+'_mobilephone').length > 0 && !$('#'+obj+'_mobilephone').is(':disabled')){
            $('#'+obj+'_mobilephone').removeClass();
            $('#'+obj+'_mobilephone').addClass('input-text validate-number');
        }
        if ($('#'+obj+'_license_number').length > 0 && !$('#'+obj+'_license_number').is(':disabled')){
            $('#'+obj+'_license_number').removeClass();
            $('#'+obj+'_license_number').addClass('input-text validate-number');
        }
    }
}


function onLoadSearch(){
    var country = $('#country').val();
    if (country == 1){//Aus
        $('#other_state').hide();
        $('#inactive_state').show();
    }else{
        $('#inactive_state').hide();
        $('#other_state').show();
    }
}



