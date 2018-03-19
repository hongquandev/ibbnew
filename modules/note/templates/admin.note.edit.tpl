<table width="100%" cellspacing="10" class="edit-table">

    <tr>
    	<td valign="top">
        	<strong id="notify_note">Note <span class="require">*</span></strong>
        </td>
        <td>
        	<textarea name="fields[content]" id="content" class="input-select validate-require" style="width:100%;height:100px">{$form_data.content}</textarea>
            
            <div style="margin-top:5px">
            	<div style="float:left;width:30%;">
                    <label for="active">
                        {assign var = 'chked' value = ''}
                        {if $form_data.active == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                    	<!--
                        <input type="checkbox" name="fields[active]" id="active" value="1" {$chked}/>
                        <strong>Active</strong>
                        -->
                    </label>
                </div>    
            </div>
        </td>
    </tr>



	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <!--<input type="button" class="button" value="Reset" onclick="note.reset('#frmNote')"/>-->
			<input type="button" class="button" value="Save" onclick="note.submit()"/>
            <!--<input type="button" class="button" value="Save & Next" onclick="note.submit('#frmNote',true)"/>-->
        </td>
    </tr>
    
    
</table>

