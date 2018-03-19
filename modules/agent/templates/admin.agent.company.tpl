
{literal}
<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "content",
        theme:"advanced",
        height:"300",
        width:"640",
        plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,link,unlink,sub,sup,|,hr,removeformat,,charmap",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing_min_width: 640,
        /*theme_advanced_source_editor_width:500,*/
        theme_advanced_resizing : true,

        content_css : "css/content.css",

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
        }
    });
</script>
{/literal}

<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
{literal}
<script type="text/javascript">

    var search_overlay = new Search();
        search_overlay._frm = '#frmAgent';
        search_overlay._text_search = '#company_suburb';
        search_overlay._text_obj_1 = '#company_state';
        search_overlay._text_obj_2 = '#company_postcode';
        search_overlay._overlay_container = '#search_overlay';
        search_overlay._url_suff = '&'+'type=suburb';

        search_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_overlay._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_overlay.setValue(this)' id="+id+">"+info[i]+"</li>";
                    search_overlay._item.push(id);
             }
			 jQuery(search_overlay._text_search).removeClass('search_loading');
        }

        search_overlay._getValue = function(data){
             var info = jQuery.parseJSON(data);
             //alert(info[0]);
             jQuery(search_overlay._text_obj_1).val(info[0]);
             $('#uniform-personal_state span').html($(search_overlay._text_obj_1+" option:selected").text());
        }

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
}

document.onclick = function() {search_overlay.closeOverlay()};

</script>
{/literal}
<table width="100%" cellspacing="10" class="edit-table">
    <tr>
        <td width="19%">
            <strong id="notify_company_name">Company name</strong><span class="require"> * </span>
        </td>
        <td width="30%">
            <input type="text" name="company_name" id="company_name" value="{$form_data.company_name}"
                   class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
        <td width="19%" style="text-align: right">
            <strong id="notify_company_name">Client ID</strong>
        </td>
        <td width="30%">
            <input type="text" name="clientID" id="clientID" value="{$form_data.clientID}"
                   class="input-text" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    <tr>
        <td width="19%">
            <strong id="notify_abn">ABN / ACN</strong><span class="require"> * </span>
        </td>
        <td>
            <input type="text" name="abn" id="nab" value="{$form_data.abn}"
                   class="input-text validate-require validate-digit" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr>
        <td width="19%">
            <strong id="notify_telephone">Telephone</strong><span class="require">*</span>
        </td>
        <td>
            <input type="text" name="telephone" id="company_telephone" value="{$form_data.telephone}"
                   class="input-text validate-require {*validate-telephone*}" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    <tr>
        <td width="19%">
            <strong id="notify_address">Address</strong><span class="require"> * </span>
        </td>
        <td>
            <input type="text" name="address" id="company_address" value="{$form_data.address}"
                   class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    <tr>
        <td width = "19%">
        	<strong id="notify_suburb" style="float: left">Suburb <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="suburb" id="company_suburb" value="{$form_data.suburb}" class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off" style="width:100%"/>
	        <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>
        <td style="text-align:right;"><strong id="notify_postcode">Postcode <span class="require">*</span></strong></td>
        <td>
            <input type="text" name="postcode" id="company_postcode" style="width:100%" value="{$form_data.postcode}" class="input-text validate-require validate-postcode"
             autocomplete="off" onkeyup="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#company_suburb','#company_state','#company_postcode','#frmAgent')"/>
        </td>
    </tr>

	<tr>
        <td width = "19%"><strong id="notify_state">State <span class="require">*</span></strong></td>
        <td>
            <div id="inactive_company_state">
                <select name="state" id="company_state" class="input-select validate-number-gtzero" style="width:100%" onchange="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#company_suburb','#company_state','#company_postcode','#frmAgent')">
                      {html_options options=$subState selected =$form_data.state}
                </select>
            </div>
            <input type="text" id="company_other_state" name="other_state" class="input-text not-require" style="width:100%"
                           value="{$form_data.other_state}"/>
        </td>
        <!-- Country -->
		<td style="text-align:right;">
        	<strong id="notify_country" style="float:right"> Country <span class="require">*</span></strong>
        </td>
        <td >
             <select name="country" id="company_country" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options=$options_country selected =$form_data.country}
            </select>
        </td>
    </tr>

    <tr>
        <td><strong id="notify_email_address">Company Email</strong></td>
        <td>
        	<input type="text" class="input-text validate-email" name="email_address" id="email_address" value="{$form_data.email_address}" style="width:100%" autocomplete="off"/>
        </td>
        <td style="text-align:right"><strong id="notify_website">Website</strong></td>
        <td>
        	<input type="text" class="input-text validate-url" name="website" id="website" value="{$form_data.website}" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    
    <tr>
        <td><strong id="notify_logo">Logo </strong></td>
        <td style="vertical-align: top;" colspan="3">
            <div class="input-box">
                <div class="input-box file-upload">
                    <div id="btn_partner_photo" style="float:left"></div>
                    <ul id="lst_partner_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                        No file chosen
                    </ul>
                    <br clear="all"/>
                    <script type="text/javascript">
                        var photo = new Media();
                        photo.uploader('btn_partner_photo', 'logo', '/modules/agent/action.admin.php?action=upload-banner-agent&id={$form_data.agent_id}&token={$token}');
                    </script>
                    {if $form_data.logo}
                        <div id="partner_logo">
                            <img src="{$MEDIAURL}/{$form_data.logo}" alt="" title=""/>
                        </div>
                    {/if}
                </div>
                <i>You must upload with one of the following extensions: jpg, jpeg, gif, png. </i> <br
                    style="margin-bottom:5px;" />
                <i> Max size: 2Mb.</i>
            </div>
        </td>
    </tr>
    <tr>
    	<td width="19%" valign="top">
			<strong id="notify_description">Description<span class="require">*</span></strong>
        </td>
        <td colspan="3">
            <textarea rows="6" cols="" name="description" id="description" class="content input-text">{$form_data.description}</textarea>
        </td>
    </tr>
    <tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="cc_id" id="cc_id" value=""/>
			<input type="button" class="button" value="Save" onclick="agent.submit(false)" />
            <input type="button" class="button" value="Save & Next" onclick="agent.submit(true)"/>
        </td>
    </tr>
</table>
<script type="text/javascript">
    onLoad('company');
    {literal}
    jQuery(document).ready(function(){
        $('#company_country').bind('change',function(){
            onLoad('company');
        });
    });

    function validEditor(){
        if(typeof tinyMCE.get('description') != 'undefined'){
            var editorContent = tinyMCE.get('description').getContent();
        }else{
            var editorContent = jQuery('#description').val();
        }
        if(editorContent == ''){
            Ext.Msg.show({
                title:'Warning?'
                ,msg: 'Please fill Property description'
                ,icon:Ext.Msg.WARNING
                ,buttons:Ext.Msg.OK
            });
            return false;
        }else{
            jQuery('#message_content').hide();
            return true;
        }
    }
    agent.flushCallback();
    agent.callback_func.push(function(){return validEditor();});
    /*agent.addCallbackFnc('valid',validEditor());*/
    {/literal}
</script>

