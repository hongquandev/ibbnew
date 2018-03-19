function DenyAgent() {
var ChkBox = document.getElementById("cbdeny");

	if (ChkBox.checked) {
		document.getElementById("cb_permit_vendor").style.display = "block";
		document.getElementById("cb_permit_buyer").style.display = "block";
		document.getElementById("cb_permit_partner").style.display = "block";
	} else {
		document.getElementById("cb_permit_vendor").style.display = "none";
		document.getElementById("cb_permit_buyer").style.display = "none";
		document.getElementById("cb_permit_partner").style.display = "none";
	}
}


/*function changeFields() {
	document.getElementById("action").style.display = "block";
	document.getElementById("notify_title_change").innerHTML = "Router ";
	document.getElementById("title").style.display = "none";
	document.getElementById("Content").innerHTML = "Description";
	document.getElementById("btncrt").value = "Update Action";
	// Permit 
	//document.getElementById("notify_permit").style.display = "block";
	//document.getElementById("type_agent").style.display = "block";
}

function returnFields() {
	document.getElementById("notify_title_change").innerHTML = "Page Title";
	document.getElementById("action").style.display = "none";
	document.getElementById("title").style.display = "block";
	document.getElementById("Content").innerHTML = "Content";
	document.getElementById("btncrt").value = "Update Page";
	// Permit 
	//document.getElementById("notify_permit").style.display = "none";
	//document.getElementById("type_agent").style.display = "none";
}

function changeClass() {
	document.getElementById("title").setAttribute("class", "input-select");
		document.getElementById("action").setAttribute("class", "input-select validate-require");
}

function returnClass() {
	document.getElementById("title").setAttribute("class", "input-select validate-require");
	document.getElementById("action").setAttribute("class", "input-select");
}*/


function changeClass(action,title){
    //document.getElementById("title").setAttribute("class", "input-select validate-require");
	//document.getElementById("action").setAttribute("class", "input-select");
}

function changeFields(action, title){
	var route = title == 'Page'?'Page Title':'Router';
	var content = title == 'Page'?'Content':'Description';
	$('#notify_title_').html(route+'<span class="require">*</span>');
    $('#Content').html(content);
    $('#btncrt').val(action+' '+title);
}
function onReloadForm(action) {
    var val = $('#type_id').val();
    var _ac = action == 'add'?'Create':'Update';
    var _title = val == 0?'Page':'Action';
    //$('#title').val('');
    changeFields(_ac,_title);
    //changeClass(_ac,_title);
}


