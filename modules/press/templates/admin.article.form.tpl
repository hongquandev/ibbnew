<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css" />
<table class="edit-table" cellspacing="10" width="100%">
    <colgroup>
        <col width="19%"/>
        <col width="30%"/>
        <col width="19%"/>
        <col width="30%"/>
    </colgroup>
        <tr>
            <td><strong id="notify_question">Title<span class="require">*</span></strong></td>
                <td colspan="3">
                <input id="question" name="fields[title]" style="width:100%" value="{$form_data.title}" class="input-text validate-require"/>
            </td>
        </tr>
        <tr>
            <td>
               <strong id="notify_cat_id">Category<span class="require">*</span></strong>
            </td>
            <td>
               <select id="cat_id" name="fields[cat_id]" class="input-select validate-number-gtzero" style="width:100%">
                   {html_options options=$options_category selected=$form_data.cat_id}
               </select>
            </td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td>
               <strong id="notify_show_date">Date to show<span class="require">*</span></strong>
            </td>
            <td>
               <input id="show_date" name="fields[show_date]" style="width:100%" value="{$form_data.show_date}" class="input-text"/>
            </td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td><strong id="notify_answer">Content<span class="require">*</span></strong></td>
            <td colspan="3">
                <textarea id="content" name="fields[content]" rows="15" cols="80" style="width:100%" class="">{$form_data.content}</textarea>
            </td>
        </tr>

        <tr>
            <td><strong id="notify_tag">Tag<span class="require">*</span></strong>
            </td>
                <td colspan="3">
                <input id="tag" name="fields[tag]" style="width:100%" value="{$form_data.tag}" class="input-text"/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td colspan="3">
                <div style="float:left;width:30%;">
                    <label for="active">

                        <input id="active" name="fields[active]" type="checkbox" {if $form_data.active == 1}checked{/if}/>
                        <strong>Active</strong>

                    </label>
                    
                </div>
                <div style="float:left;width:30%;">
                    <label>
                            <input id="publish_facebook" name="fields[publish_facebook]" type="checkbox" {if $form_data.publish_facebook == 1}checked{/if}/>
                            <strong>Publish Facebook</strong>
                    </label>
                    <br />
                    <label>
                            <input id="publish_twitter" name="fields[publish_twitter]" type="checkbox" {if $form_data.publish_twitter == 1}checked{/if}/>
                            <strong>Publish Twitter</strong>
                    </label>

                </div>

            </td>
        </tr>

        <tr>
            <td colspan="4" align="right">
            <hr/>
                <input type="hidden" id="track" name="track" value="0"/>
                <input type="button"  class="button" value="Save" onclick="press.submit();"/>
                <input type="button" class="button" value="Save & New" onclick="press.submit(true);"/>
            </td>
        </tr>

</table>
{literal}
<script type="text/javascript">
    function validEditor() {
        if (typeof tinyMCE.get('content') != 'undefined') {
            var editorContent = tinyMCE.get('content').getContent();
        } else {
            var editorContent = jQuery('#content').val();
        }
        if (editorContent == '') {
            Ext.Msg.show({
                title:'Warning?', msg:'Please fill Property description', icon:Ext.Msg.WARNING, buttons:Ext.Msg.OK
            });
            return false;
        } else {
            return true;
        }
    }
    press.flushCallback();
    press.callback_func.push(function () {
        return validEditor()
    });
    Calendar.setup({
        inputField:'show_date',
        trigger:'show_date',
        onSelect:function () {
            this.hide()
        },
        showTime:true,
        dateFormat:"%Y-%m-%d %H:%M:%S"
    });
</script>
{/literal}