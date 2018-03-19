<div id="note_form" class="popup_container" style="width:450px;display:none;">
  <div id="contact-wrapper">
    <div class="title">
        <h2> Notes History <span onclick="closeNote()">x</span></h2>
    </div>
    <div class="content" style="width:94%">
		<form name="frmNote" id="frmNote">
		    <input type="hidden" name="property_id" id="property_id" value=""/>
		    <div class="input-box">
				<label for="subject"><strong>Note <span id="notify_message">*</span></strong></label>
                <br/>
			    <textarea rows="5" cols="30" name="content" id="content" class="input-text validate-require" style="width:100%;"></textarea>
            </div>
        </form>
    </div>

        <div>
             <button class="btn-red" name="submit" onClick="note.send('#frmNote','/modules/note/action.php?action=add-note',note_data)"><span><span>Submit</span></span></button>
             <div id="loading1" style="display:inline;position:absolute">
                 <img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;"/>
             </div>
        </div>

        <div id="grid" class="note-grid"></div>
  </div>
</div>