function showNoteTimePopup(id) {
	jQuery('#'+id).show();
}

function hideNoteTimePopup(id) {
	jQuery('#'+id).hide();
}

function exportNoteTime(calendar_id) {
	var url = '/modules/calendar/action.php?action=export-calendar';
	var obj = {calendar_id:calendar_id};
	
	$.post(url,obj,function(){},'html');
}