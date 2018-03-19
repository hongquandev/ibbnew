<table class="edit-table" cellspacing="10" width="100%">
    <colgroup>
        <col width="19%"/>
        <col width="30%"/>
        <col width="19%"/>
        <col width="30%"/>
    </colgroup>
        <tr>
            <td><strong id="notify_question">Question<span class="require">*</span></strong></td>
                <td colspan="3">
                <input id="question" name="fields[question]" style="width:100%" value="{$form_data.question}" class="input-text validate-require"/>
            </td>
        </tr>
        <tr>
            <td>
               <strong id="notify_catID">Category<span class="require">*</span></strong>
            </td>
            <td>
               <select id="catID" name="fields[catID]" class="input-select validate-number-gtzero" style="width:100%">
                   {html_options options=$options_category selected=$form_data.catID}
               </select>
            </td>

        </tr>
        <tr>
            <td>
               <strong id="notify_title">Position<span class="require"></span></strong>
            </td>
            <td>
               <input id="position" name="fields[position]" style="width:100%" value="{$form_data.position}" class="input-text validate-digits"/>
            </td>
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
            <td><strong id="notify_answer">Answer<span class="require">*</span></strong></td>
            <td colspan="3">
                <textarea id="answer" name="fields[answer]" rows="15" cols="80" style="width:100%" class="">{$form_data.answer}</textarea>
            </td>
        </tr>

        <tr>
            <td colspan="4" align="right">
            <hr/>
                <input type="button"  class="button" value="{if $action == 'add-center'}Create Question{else}Update Question{/if}" onclick="help.submit();"/>
                <input type="button" class="button" value="Back" onclick="window.location='{$list}'"/>
            </td>
        </tr>

</table>
