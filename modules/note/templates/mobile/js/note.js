 //BEGIN CONTATCT POPUP
	var note = new Note();
	var note_popup = new Popup();
        note_popup.init({id:'note_popup',className:'popup_overlay'});
	
	//BEGIN CONTACT						
	
	var note_data = ['property_id','content'];
    var note_count=0;
    var note_id=0;
	note.prepare = function() {
		jQuery('#loading1').show();
	};
	
	note.finish = function(data) {
		var info = jQuery.parseJSON(data);
		if (info.notes) {
			showGrid(info.notes);
            note_count=info.notes.length;
		} else {
			emptyGrid();
		}

		jQuery('#loading1').hide();
		note.clear('#frmNote',['content']);//clear data from Contact form
	}
	
	function openNote(property_id) {
        note_id=property_id;
		jQuery('#loading1').hide();
        //note_popup.updateContainer('<div class="popup_container" style="width:450px">'+jQuery('#note_form').html()+'</div>');
        note_popup.updateContainer('<div class="popup_container note-container" style="width:300px"><div id="contact-wrapper">\
			 <div class="title title-note">\
                         <h2 id="txtt">Notes History<span onclick="closeNote()" class="span-title-note-b" id="fridx">x</span></h2> \
             </div>\
			 <div class="content" style="width:94%">\
				<form name="frmNote" id="frmNote">\
				    <input type="hidden" name="property_id" id="property_id" value=""/>\
				    <div class="input-box">\
					    <label for="subject"><strong>Note <span id="notify_message">*</span></strong></label><br/>\
					    <textarea rows="5" cols="30" name="content" id="content" class="input-text validate-require" style="width:100%;"></textarea>\
                    </div>\
                </form>\
              </div>\
             <div>\
                    <button style="float:left;" class="btn-red btn-red-note" name="submit" onClick="note.send(\'#frmNote\',\'/modules/note/action.php?action=add-note\',note_data)"><span><span>Submit</span></span></button>\
                    <div id="loading1" style="float:left;"><img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;"/></div>\
             </div>\
            <div class="clearthis"></div>\
             <div style="margin-top:10px;" id="grid" class="note-grid"></div>\
             </div></div>');
        note_popup.show().toCenter();
		jQuery('#frmNote [name=property_id]').val(property_id);
		//note.clear('#frmNote',['content']);

		//note_popup.show();
		emptyGrid();
		//GET NOTE TO SHOW ON GRID
		note.list('#frmNote','/modules/note/action.php?action=add-note',['property_id']);
	}


	function closeNote() {
		jQuery('#loading1').hide();
		note.clear('#frmNote',['content']);
		jQuery(note_popup.container).fadeOut('slow',function(){note_popup.hide()});
        jQuery('#note_'+note_id).html(note_count);
	}
    /*confirm_sold: function(property_id,target) {
		url = '/modules/property/action.php?action=sold-property';
		$.post(url,{property_id:property_id,target:target},this.on_sold,'html');
	},

	on_sold: function(data) {
		var json = jQuery.parseJSON(data);
		if (json.target.length > 0) {
			jQuery('#'+json.target).html(json.msg);
		}
	}*/
	
	function deleteNote(note_id){
		note.del('#frmNote','/modules/note/action.php?action=delete-note&note_id='+note_id,['property_id']);
	}
	
	function showGrid(notes) {
		var str = '';
		if (notes.length > 0) {
			for (i = 0; i < notes.length; i++) {
				str += "<div class='item'><p class='title'><label>"+notes[i]['time']+"</label> <span class='note-button' onclick='deleteNote("+notes[i]['note_id']+")'><img src='/modules/general/templates/images/delete.gif' title='Delete'/></span></p> <p class='content'>"+notes[i]['content']+"</p></div>";
				
			}
			/*
			for (i in notes) {
				str += "<div class='item'><p class='title'><label>"+notes[i]['time']+"</label> <span class='note-button' onclick='deleteNote("+notes[i]['note_id']+")'><img src='/modules/general/templates/images/delete.gif' title='Delete'/></span></p> <p class='content'>"+notes[i]['content']+"</p></div>";
			}
			*/
		}
		
		jQuery('#grid').html(str);
	}
	
	function emptyGrid() {
		jQuery('#grid').html('');
	}
	//END
	
	
	/*note_popup.init({id:'note_popup',className:'note_time_popup_overlay'});
	note_popup.updateContainer('<div class="popup_container" style="width:450px"><div id="contact-wrapper">\
			 <div class="title"><h2> Notes History <span onclick="closeNote()">x</span></h2> </div>\
			 <div class="content" style="width:94%">\
				<form name="frmNote" id="frmNote">\
				<input type="hidden" name="property_id" id="property_id" value=""/>\
				<div class="input-box">\
					<label for="subject"><strong>Note <span id="notify_message">*</span></strong></label><br/>\
					<textarea rows="5" cols="30" name="content" id="content" class="input-text validate-require" style="width:100%;"></textarea></div></form><div><button class="btn-red" name="submit" onClick="note.send(\'#frmNote\',\'/modules/note/action.php?action=add-note\',note_data)"><span><span>Submit</span></span></button><div id="loading1" style="display:inline;position:absolute"><img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;"/></div></div></div><div id="grid" class="note-grid"></div></div></div>');*/







