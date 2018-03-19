<!-- Call JavaScrip Editor Tiny_MCE -->
{literal}
<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css"/>
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/cms/templates/js/upload.js"></script>
{/literal}

<!-- Call Tiny -->

{literal}
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "editor",
        height : "200",
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

<!-- Loop -->
{section name=infographic loop=$infographic_data }
    <tr class="tr-theme tr-theme-infographic">
        <td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend>Step {$infographic_data[infographic].step}</legend>
            </fieldset>
        </td>
    </tr>
    <tr class="tr-theme tr-theme-infographic">
        <td  valign="top">
        Step Icon (On)
        </td>
        <td colspan="3">
            <li class="wide" id="upload-logo-{$infographic_data[infographic].step}">
                <div id="icon_container_on_{$infographic_data[infographic].step}" {if $infographic_data[infographic].icon_on == ''}style="display:none"{/if}>
                    <img src="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_on}" width="120px"/> 
                    <input class="icon_file" type="hidden" name="infographic_icon_on[{$infographic_data[infographic].step}]" id="icon_on_file_{$infographic_data[infographic].step}" value="{$infographic_data[infographic].icon_on}"/>   
                </div>
                <div class="input-box">
                    <div class="input-box file-upload">
                        <div id="btn_photo_{$infographic_data[infographic].step}" style="float:left"></div>
                        <ul id="lst_photo_{$infographic_data[infographic].step}" style="float:left;margin-left:10px" class="qq-upload-list">
                            No file chosen
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo = new Media();
                            photo.uploader('btn_photo_{$infographic_data[infographic].step}', 'icon', '/modules/cms/action.php?action=upload&target=icon_container_on_{$infographic_data[infographic].step}');
                        </script>
                    </div>
                    <i>   
                    You must upload  with one of the following extensions: jpg, jpeg, gif, png<br/>
                    </i>
                </div>
            </li>    
        </td>
    </tr>
    <tr class="tr-theme tr-theme-infographic">
        <td  valign="top">
        Step Icon (Off)
        </td>
        <td colspan="3">
            <li class="wide" id="upload-logo-{$infographic_data[infographic].step}-off">
                <div id="icon_container_off_{$infographic_data[infographic].step}" {if $infographic_data[infographic].icon_off == ''}style="display:none"{/if}>
                    <img src="{$MEDIAURL}/store/uploads/infographic/images/{$infographic_data[infographic].icon_off}"  width="120px" /> 
                    <input class="icon_file" type="hidden" name="infographic_icon_off[{$infographic_data[infographic].step}]" id="icon_off_file_{$infographic_data[infographic].step}" value="{$infographic_data[infographic].icon_off}"/>   
                </div>
                <div class="input-box">
                    <div class="input-box file-upload">
                        <div id="btn_photo_{$infographic_data[infographic].step}_off" style="float:left"></div>
                        <ul id="lst_photo_{$infographic_data[infographic].step}_off" style="float:left;margin-left:10px" class="qq-upload-list">
                            No file chosen
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo = new Media();
                            photo.uploader('btn_photo_{$infographic_data[infographic].step}_off', 'icon', '/modules/cms/action.php?action=upload&target=icon_container_off_{$infographic_data[infographic].step}');
                        </script>
                    </div>
                    <i>   
                    You must upload  with one of the following extensions: jpg, jpeg, gif, png<br/>
                    </i>
                </div>
            </li>    
        </td>
    </tr>
    <tr class="tr-theme tr-theme-infographic">
        <td width="19%">
            <strong id="notify_sort_order">Title<span class="require"></span></strong>
        </td>
        <td width="100%">
            <input id="title_step_{$infographic_data[infographic].step}" name="infographic_title[{$infographic_data[infographic].step}]" type="text" size="5"
                   class="input-text "
                   style="width: 100%"
                   value="{$infographic_data[infographic].title}"/>
        </td>
    </tr>
    <tr class="tr-theme tr-theme-infographic">
        <td width="19%"><strong id="notify_content">Content</strong></td>
        <td>
            <textarea name = "infographic_content[{$infographic_data[infographic].step}]" id = "content_step_{$infographic_data[infographic].step}" class="input-text editor" style="width:100%;height:100px">{$infographic_data[infographic].content}</textarea>
        </td>
    </tr>
  
{/section}
