function ActionChange(action,mode){
	var model = (mode)?'&mode=grid':'';
	document.getElementById('frmSearch').action = '?module=property&action='+action+model;
	return document.getElementById('frmSearch').submit();
}

function OrderSearch(combo,action) {
	document.getElementById('order_by').value = combo.value;
	document.getElementById('frmSearch').action = '?module=property&action='+action;
	return document.getElementById('frmSearch').submit();
}

var pro = new Property();
var ids = [];

