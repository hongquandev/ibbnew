<!-- Call JavaScrip Editor Tiny_MCE -->
{literal}
<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
{/literal}

<!-- Call Tiny -->

{literal}
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "editor",
        height : "350",
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        theme_advanced_buttons1 : "mylistbox,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,bullist,numlist",
        theme_advanced_buttons2 : "outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,|,removeformat,unsubscribe,|,code,|,ROOTURL",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        /*content_css : "css/content.css",*/

        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        },
        setup : function(ed) {
            ed.addButton('unsubscribe', {
                title : 'Unsubscribe',
                image : location.protocol + '//' + location.host+'/editor/jscripts/tiny_mce/themes/advanced/img/unsub.gif',
                onclick : function() {
                    var text = ed.selection.getContent({format : 'text'});
                    ed.focus();
                    ed.selection.setContent('{unsubscribe}'+text+'{/unsubscribe}');
                }
            });

            ed.addButton('ROOTURL', {
                title : 'ROOTURL',
                image : location.protocol + '//' + location.host+'/modules/general/templates/images/url-editor.png',

                onclick : function() {
                    ed.focus();
                    ed.selection.setContent('[rooturl]');
                }
            });
        }

    });
</script>
<!-- /TinyMCE -->

{/literal}

<table width="100%" cellspacing="10" class="edit-table">

    <tr>
        <td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend>T&C Rules</legend>
            </fieldset>
        </td>
    </tr>

    <tr>
        <td width = "19%" valign="top">
        </td>
        <td>
            <textarea name = "fields[tandcrule]" id = "tandcrule" class="input-text editor" style="width:100%;height:100px">{$form_data.tandcrule}</textarea>
        </td>
    </tr>


    <tr>
        <td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend>iBB Rules</legend>
            </fieldset>
        </td>
    </tr>

    <tr>
        <td width = "19%" valign="top">
        </td>
        <td>
            <textarea name = "fields[ibbrule]" id = "ibbrule" class="input-text editor" style="width:100%;height:100px">{$form_data.ibbrule}</textarea>
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
