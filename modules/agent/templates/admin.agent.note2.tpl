<script src="/modules/note/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
 var note = new Note('#frmAgent','note-list',{$agent_id});
 var id = {$agent_id};
 {literal}
 $(document).ready(function(){
        note.update_note('/modules/note/action.admin.php?action=update-note&agent_id='+id);
    });
 {/literal}
</script type="text/javascript">
<table width="100%" cellspacing="10">
    <tr>
    	<td colspan="2">
        {*{if isset($notes) and is_array($notes) and count($notes) > 0}*}
        	<div class="note-list" id="note-list" style="">
        	{*{assign var = i value = 0}
        	{foreach from = $notes key = k item = note}
            {assign var = i value = $i+1}
            <div class="note-item{if $i%2==0}1{else}2{/if}">
            	<p>{$note.time} <span> by {$note.firstname} {$note.lastname}</span>
                	<span class="link">
                    	  <a href="javascript:void(0)" onclick="note.edit('{$note.note_id}')">edit</a> |
                          <a href="javascript:void(0)" onclick ="deleteItem2('{$note.delete_link}')">delete</a>
                    </span></p>
                <div>
                {$note.content}
                </div>
            </div>
            {/foreach}*}
            </div>
       {* {/if}*}
        </td>
    </tr>

    <tr>
    	<td>
        	<strong id="notify_note">Note <span class="require">*</span></strong>
        </td>
        <td>
        	<textarea name="fields[content]" id="content" class="input-select validate-require" style="width:100%;height:100px">{$form_data.content}</textarea>
            
           {* <div style="margin-top:5px">
            	<div style="float:left;width:30%;">
                    <label for="active">
                        {assign var = 'chked' value = ''}
                        {if $form_data.active == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        {*
                        <input type="checkbox" name="fields[active]" id="active" value="1" {$chked}/>
                        <strong>Active</strong>

                    </label>
                </div>    
            </div>*}
        </td>
    </tr>



	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <script type="text/javascript">

			</script>
            <input type="hidden" name="note_id" id="note_id" value="{$note_id}"/>
            <input type="hidden" name="action" id="action" value=""/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="submit_" id="submit_" value="0"/>
            <input type="button" class="button" value="Reset" onclick="note.reset('?module=agent&action=edit-note2&agent_id={$agent_id}')"/>
			{*<input type="button" class="button" value="Save" onclick="note.submit()"/>*}
			<input type="button" class="button" value="Save" onclick="note.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="note.submit(true)"/>
        </td>
    </tr>

   {* <tr>
    	<td colspan="2">
        
        {if isset($notes) and is_array($notes) and count($notes) > 0}
        	<div class="note-list" style="max-height:400px">
        	{assign var = i value = 0}
        	{foreach from = $notes key = k item = note}
            {assign var = i value = $i+1}
            <div class="note-item{if $i%2==0}1{else}2{/if}">
            	<p>{$note.time} <span> by {$note.firstname} {$note.lastname}</span>
                	<span class="link">
                    	  <a href="{$note.edit_link}">edit</a> | 
                          <a href="javascript:void(0)" onclick ="deleteItem2('{$note.delete_link}')">delete</a>
                    </span></p>
                <div>
                {$note.content}
                </div>
            </div>
            {/foreach}
            </div>
        {/if}
        </td>
    </tr>*}
</table>

