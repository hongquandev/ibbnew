<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Download file when register bid</strong>
        </td>
        <td>
            <select name="fields[termdoc_method_download]" id="termdoc_method_download" class="input-select" style="width:50%">
                    {html_options options=$options_yes_no selected = $form_data.termdoc_method_download}
             </select>
        </td>
    </tr>
    <tr>
    	<td width = "19%">
        	<strong>File Name</strong>
        </td>
        <td>
            <input type="text" name="fields[termdoc_filename]" id="termdoc_filename" value="{$form_data.termdoc_filename}" class="input-text" style="width:50%"/> 
        </td>
    </tr>
    <tr>
    	<td width = "19%">
        	<strong>Upload form Title</strong>
        </td>
        <td>
            <input type="text" name="fields[termdoc_title]" id="termdoc_title" value="{$form_data.termdoc_title}" class="input-text" style="width:50%"/>
        </td>
    </tr>
    <tr>
    	<td width = "19%">
        	<strong>Upload form Message</strong>
        </td>
        <td>
            <textarea name="fields[termdoc_msg]" id="termdoc_msg" rows="5">{$form_data.termdoc_msg}</textarea>
        </td>
    </tr>
    <tr>
    	<td width = "19%">
        	<strong>Download File Message</strong>
        </td>
        <td>
            <textarea name="fields[termdoc_download_msg]" id="termdoc_download_msg" rows="5">{$form_data.termdoc_download_msg}</textarea>
        </td>
    </tr>

    <tr>
    	<td width = "19%">
        	<strong>Upload File Message</strong>
        </td>
        <td>
            <textarea name="fields[termdoc_upload_msg]" id="termdoc_upload_msg" rows="5">{$form_data.termdoc_upload_msg}</textarea>
        </td>
    </tr>
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
</table>
