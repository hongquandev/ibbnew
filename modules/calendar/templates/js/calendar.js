//BEGIN NOTE
var NoteTime = function(o) {
	this.form = '';//id of form (#frm)
	if (o != undefined) {
		if (typeof o.form == 'string' && o.form.length > 0) {
			this.form = o.form;
		}
	}
	
	this.require = [];//required field list
	this.prepare = null;
	this.finish = null;
	this.content_type = 'html';
    this.callback_func = [];
}

NoteTime.prototype = {
	clear: function(form, require) {
		
		if (typeof form == 'string' && form.length > 0) {
			this.form = form;
		}
		
		if (require != undefined) {
			this.require = require;
		}
		
		for (i = 0; i < this.require.length; i++ ) {
			jQuery(this.form+' [name='+this.require[i]+']').val('');
		}
	},
	
	send: function(form, url, require) {
		if (typeof form == 'string' && form.length > 0) {
			var validation = new Validation(form);
			this.form = form;
		} else if (this.form.length > 0) {
			var validation = new Validation(this.form);
		}

        var ok = true;
		if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]() == false) {
					ok = false;
					//break;
				}
			}
		}
        //alert(ok);


		if(ok && validation.isValid()){
			this.require = require;
			
			if (this.prepare != null) {
				this.prepare();
			}
			var obj = {};
			
			for (i = 0; i < this.require.length; i++ ) {
				
				obj[this.require[i]] = jQuery(this.form+' [name='+this.require[i]+']').val();
			}
			
			if (this.finish != null) {
				$.post(url,obj,this.finish,this.content_type);
			} else {
				$.post(url,obj,this.onSend,this.content_type);
			}
		}
	},
	
	onSend: function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
			alert('success');
		} else {
			alert('failure');
		}
	},
	
	list: function(form, url, require) {
		if (typeof form == 'string' && form.length > 0) {
			this.form = form;
		}
		this.require = require;
		
		if (this.prepare != null) {
			this.prepare();
		}
		var obj = {};
		
		for (i = 0; i < this.require.length; i++ ) {
			obj[this.require[i]] = jQuery(this.form+' [name='+this.require[i]+']').val();
		}
		
		if (this.finish != null) {
			$.post(url,obj,this.finish,this.content_type);
		} else {
			$.post(url,obj,this.onList,this.content_type);
		}		
	},
	
	onList: function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
			alert('success');
		} else {
			alert('failure');
		}
	},
	
	del: function(form, url, require) {
		if (typeof form == 'string' && form.length > 0) {
			this.form = form;
		}
		
		this.require = require;
		
		if (this.prepare != null) {
			this.prepare();
		}
		var obj = {};
		
		for (i = 0; i < this.require.length; i++ ) {
			obj[this.require[i]] = jQuery(this.form+' [name='+this.require[i]+']').val();
		}
		
		if (this.finish != null) {
			$.post(url,obj,this.finish,this.content_type);
		} else {
			$.post(url,obj,this.onDel,this.content_type);
		}			
	},
	
	onDel: function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
			alert('success');
		} else {
			alert('failure');
		}
	},
	
	edit: function(form, url, require, finish) {
		if (typeof form == 'string' && form.length > 0) {
			this.form = form;
		}
		
		this.require = require;
		
		if (this.prepare != null) {
			this.prepare();
		}
		var obj = {};
		
		for (i = 0; i < this.require.length; i++ ) {
			obj[this.require[i]] = jQuery(this.form+' [name='+this.require[i]+']').val();
		}
		
		if (finish != null) {
			$.post(url,obj,finish,this.content_type);
		} else {
			$.post(url,obj,this.onEdit,this.content_type);
		}			
		
	},
	
	onEdit: function(data) {
		var info = jQuery.parseJSON(data);
		if (info.success) {
			alert('success');
		} else {
			alert('failure');
		}
	},
    flushCallback: function() {
		this.callback_func = [];
	},
    addCallbackFnc: function(fnc) {
		this.callback_func.push(fnc);
	},
    load:function(property_id){
        var url = '/modules/calendar/action.php?action=load-calendar';
        $.post(url,{property_id:property_id},function(data){
                   //var info = jQuery.parseJSON(data);

                   jQuery('#popup_calendar').html(data);
                   jQuery('#loading1').hide();
                   note_time.list('#frmNoteTime','/modules/calendar/action.php?action=list-calendar&property_id='+property_id,['property_id']);
               },'html');
    }
}


//BEGIN CONTATCT POPUP
var note_time = new NoteTime();
var note_time_popup = new Popup(/*{id:'note_time'}*/);
var document_width = jQuery(document).width();
var width = jQuery.browser.mobile?(document_width - 30+'px'):'300px';
note_time_popup.init({id:'note_time_popup',className:'note_time_popup_overlay'});
note_time_popup.updateContainer('<div class="popup_container" style="width:'+width+'"><div id="popup_calendar"></div></div>');


//BEGIN CONTACT						

var note_time_data = ['property_id','begin','end','calendar_id']; 
note_time.prepare = function() {
	jQuery('#loading1').show();
};

note_time.finish = function(data) {
	if (data.length > 0) {
		showNoteTimeGrid(data);
	} else {
		emptyNoteTimeGrid();
	}
	
	jQuery('#loading1').hide();
	note_time.clear('#frmNoteTime',['begin','end','calendar_id']);//clear data from Contact form
}

function openNoteTimeForm(property_id) {
    //note_time_popup.updateContainer('<div class="popup_container" style="width:300px">'+jQuery('#note_time_container_form').html()+'</div>');

    note_time.load(property_id);

	note_time_popup.show().toCenter();
	//jQuery('#frmNoteTime [name=property_id]').val(property_id);
    Common.warningObject('#begin',true);
    Common.warningObject('#end',true);
    //showNoteTimeGrid(data);
	//emptyNoteTimeGrid();
	//GET NOTE TO SHOW ON GRID
	//note_time.list('#frmNoteTime','/modules/calendar/action.php?action=list-calendar',['property_id']);
}

function closeNoteTimeForm() {
	jQuery('#loading1').hide();
	note_time.clear('#frmNoteTime',['begin','end']);
    calend.hide();
    calbegin.hide();
	jQuery(note_time_popup.container).fadeOut('slow',function(){note_time_popup.hide()});
}

function deleteNoteTime(calendar_id){
	note_time.del('#frmNoteTime','/modules/calendar/action.php?action=delete-calendar&calendar_id='+calendar_id,['property_id']);
}

function editNoteTime(calendar_id) {
	note_time.edit('#frmNoteTime','/modules/calendar/action.php?action=edit-calendar&calendar_id='+calendar_id,['property_id'],
		function(data){
			var info = jQuery.parseJSON(data);
			
			if (info.data) {
				jQuery('#property_id','#frmNoteTime').val(info.data.property_id);
				jQuery('#begin','#frmNoteTime').val(info.data.begin);
				jQuery('#end','#frmNoteTime').val(info.data.end);
				jQuery('#calendar_id','#frmNoteTime').val(info.data.calendar_id);
			} 
			
			jQuery('#loading1').hide();
		});
}

function showNoteTimeGrid(data) {
	var str = '';
	if (data.length > 0) {
		str = data;
	}
	jQuery('#grid_note_time').html(str);
}

function emptyNoteTimeGrid() {
	jQuery('#grid_note_time').html('');
}
//END

