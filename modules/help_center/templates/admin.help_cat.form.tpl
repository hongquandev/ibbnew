<table class="edit-table" cellspacing="10" width="100%">
    <colgroup>
        <col width="19%"/>
        <col width="30%"/>
        <col width="19%"/>
        <col width="30%"/>
    </colgroup>
    <tr>
        <td><strong id="notify_title">Category name<span class="require">*</span></strong></td>
        <td colspan="3">
            <input id="title" name="fields[title]" style="width:100%" value="{$form_data.title}" class="input-text validate-require"/>
        </td>
    </tr>
    <tr>
        <td width="19%">
           <strong id="notify_position">Position<span class="require"></span></strong>
        </td>
        <td width="30%">
           <input id="position" name="fields[position]" style="width:100%" value="{$form_data.position}" class="input-text validate-digits"/>
        </td>
           <td width="19%"></td>
           <td width="30%"></td>
    </tr>
    <tr>
        <td>
           <strong id="notify_allow">Allow</strong>
        </td>
        <td colspan="3">
           {foreach from = $options_role key = k item = role}
               {assign var = chked value = ''}
               {if isset($form_data.allow[$role]) and $form_data.allow[$role] == 1}
                    {assign var = chked value = 'checked="checked"'}
               {/if}
               <span style="margin-right:20px;"><input style="vertical-align:top;*vertical-align:middle;*margin-left:-4px;" type="checkbox" name="fields[{$role}]" {$chked}/>  {$role}</span>
           {/foreach}
        </td>
    </tr>

    <tr>
        <td><strong id="notify_description">Description</strong></td>
            <td colspan="3">
            <textarea rows="55" cols="80" style="width:100%" id="description" name="fields[description]" style="width:100%"/>{$form_data.description}</textarea>
        </td>
    </tr>

    <tr>
        <td colspan="4" align="right">
        <hr/>
            <input type="button"  class="button" value="{if $action == 'add-cat'}Create Category{else}Update Category{/if}" onclick="help.submit();"/>
            <input type="button" class="button" value="Back" onclick="window.location='{$list}'"/>
        </td>
    </tr>
</table>