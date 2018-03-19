
function EnbStateSearchPartner() {
	$('#paxxother_state').hide();
	$('#paxx_state').show();
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = false; 
	}
	
}

function DisStateSearchPartner() {	
	$('#paxxother_state').show();
	$('#paxx_state').hide();
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true; 
	}
}
function DisabDStateCountryAny() {
	$('#paxxother_state').show();
	$('#paxx_state').hide();
	$("#other_state").val("");
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true; 
	}
}
function DdNewCountryAny() {
	$('#paxxother_state').show();
	$('#paxx_state').hide();
	var ddl = document.getElementById("state");	
	for (var i = 0; i < ddl.options.length; i++) {
		 ddl.disabled = true; 
	}
}
function onReloadSearchPartners(form) {
	if ($('#country').length > 0){
        var val= form.country.options[form.country.options.selectedIndex].value;
        if (val == 0) {
            DdNewCountryAny();
        } else if (val == 1) {
            EnbStateSearchPartner();
            $("#other_state").val(""); 
        } else if(val > 1 && val != 0) {
            DisStateSearchPartner();
        }
    }

}