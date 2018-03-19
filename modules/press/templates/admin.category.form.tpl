<table class="edit-table" cellspacing="10" width="100%">
    <colgroup>
        <col width="19%"/>
        <col width="30%"/>
        <col width="19%"/>
        <col width="30%"/>
    </colgroup>
    <tr>
        <td><strong id="notify_title">Category name<span class="require">*</span></strong></td>
        <td>
            <input id="title" name="fields[title]" style="width:100%" value="{$form_data.title}" class="input-text validate-require"/>
        </td>
    </tr>
    <tr>
        <td width="19%">
           <strong id="notify_position">Position<span class="require"></span></strong>
        </td>
        <td width="30%">
           <input id="position" name="fields[position]" style="width:100%" value="{$form_data.position}" class="input-text validate-number"/>
        </td>
           <td width="19%"></td>
           <td width="30%"></td>
    </tr>
    <tr>       
        <td></td>
        <td>
           <input id="active" name="fields[active]" type="checkbox" {if $form_data.active == 1}checked{/if}/> Active
        </td>

    </tr>
   
    <tr>
        <td colspan="4" align="right">
        <hr/>
            <input type="hidden" value="0" name="track" id="track"/>
            <input type="button"  class="button" value="Save" onclick="press.submit(false);"/>
            <input type="button" class="button" value="Save & New" onclick="press.submit(true);"/>
        </td>
    </tr>
</table>