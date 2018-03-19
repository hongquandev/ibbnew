{literal}
<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "content",
        theme:"advanced",
        height:"300",
        width:"650",
        plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,link,unlink,sub,sup,|,hr,removeformat,,charmap",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
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

<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>

{literal}
<script type="text/javascript">
    var search_overlay = new Search();
        search_overlay._frm = '#frmAgent';
        search_overlay._text_search = '#personal_suburb';
        search_overlay._text_obj_1 = '#personal_state';
        search_overlay._text_obj_2 = '#personal_postcode';
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
    var partner_overlay = new Search();
        partner_overlay._frm = '#frmAgent';
        partner_overlay._text_search = '#postal_suburb';
        partner_overlay._text_obj_1 = '#postal_state';
        partner_overlay._text_obj_2 = '#postal_postcode';
        partner_overlay._overlay_container = '#search_partner';
        partner_overlay._url_suff = '&'+'type=suburb';

        partner_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_overlay._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='partner_overlay.setValue(this)' id="+id+">"+info[i]+"</li>";
                    partner_overlay._item.push(id);
             }
			 jQuery(partner_overlay._text_search).removeClass('search_loading');
        }

        partner_overlay._getValue = function(data){
             var info = jQuery.parseJSON(data);
             jQuery(partner_overlay._text_obj_1).val(info[0]);
        }

    if (content_str.length > 0) {
        jQuery(partner_overlay._overlay_container).html(content_str);
        jQuery(partner_overlay._overlay_container).show();
        jQuery(partner_overlay._overlay_container).width(jQuery(partner_overlay._text_search).width());
    } else {
        jQuery(partner_overlay._overlay_container).hide();
    }
}

document.onclick = function() {search_overlay.closeOverlay();partner_overlay.closeOverlay()};

</script>
{/literal}

<table width="100%" cellspacing="10" class="edit-table edit-table-personal-detail">
	<tr>
    	<td width = "19%">
        	<strong>Member type</strong>
        </td>
        <td  width="30%">
           <select name="type_id" id="type_id" class="input-select" style="width:100%" {if $form_data.agent_id > 0}disabled="disabled"{/if}>
               {html_options options=$options_type selected =$form_data.type_id}
           </select>
        </td>
        <td width="19%"></td>
        <td width="30%"></td>
    </tr>

    <tr rel="{$agent_arr.theblock}-{$agent_arr.agent}">
    	<td width = "19%">
        	<strong>Main Account</strong>
        </td>
        <td  width="30%">
           <select name="parent_id" id="parent_id" class="input-select-disabled" style="width:100%" {if $form_data.agent_id > 0}disabled="disabled"{/if}>
               {html_options options=$options_parent selected =$form_data.parent_id}
           </select>
        </td>
        <td width="19%"></td>
        <td width="30%"></td>
    </tr>


	<tr>
    	<td width = "19%"><strong id="notify_firstname">First Name </strong><span class="require">*</span></td>
        <td>
        	<input type="text" name="firstname" id="firstname" value="{$form_data.firstname}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
        <td width="19%" rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.theblock}-{$agent_arr.agent}"><strong id="notify_lastname" style="float: right">Last Name <span class="require">*</span></strong></td>
        <td rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.theblock}-{$agent_arr.agent}">
           <input type="text" name="lastname" id="lastname" value="{$form_data.lastname}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.partner}">
    	<td width = "19%"><strong id="notify_register_number">ABN </strong><span class="require">*</span></td>
        <td>
        	<input type="text" name="partner[register_number]" id="register_number" value="{$form_data.register_number}" class="input-text validate-require validate-digit" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.partner}">
        <td><strong id="notify_general_contact_partner">Company Email</strong></td>
        <td>
        	<input type="text" class="input-text validate-email" name="general_contact_partner" id="general_contact_partner" value="{$form_data.general_contact_partner}" style="width:100%" autocomplete="off"/>
        </td>
        <td style="text-align:right"><strong id="notify_website_partner">Website</strong></td>
        <td>
        	<input type="text" class="input-text validate-url" name="website_partner" id="website_partner" value="{$form_data.website_partner}" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.partner}" class="child-field">
    	<td width = "19%">
        	<strong id="notify_street">Address</strong>
             <span class="require"> * </span>
        </td>
        <td >
        	<input type="text" name="street" id="street" value="{$form_data.street}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.partner}" class="child-field">
        <td width = "19%">
        	<strong id="notify_suburb" style="float: left">Suburb <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="suburb" id="personal_suburb" value="{$form_data.suburb}" class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off" style="width:100%"/>
	        <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>
        <td style="text-align:right;"><strong id="notify_postcdeo">Postcode <span class="require">*</span></strong></td>
        <td>
            <input type="text" name="postcode" id="personal_postcode" style="width:100%" value="{$form_data.postcode}" class="input-text validate-require validate-postcode"
             autocomplete="off" onkeyup="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')"/>
        </td>
    </tr>

	<tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.partner}" class="child-field">
        <td width = "19%"><strong id="notify_state">State <span class="require">*</span></strong></td>
        <td>
            <div id="inactive_personal_state">
                <select name="state" id="personal_state" class="input-select validate-number-gtzero" style="width:100%" onchange="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                      {html_options options=$subState selected =$form_data.state}
                </select>
            </div>
            <input type="text" id="personal_other_state" name="other_state" class="input-text not-require" style="width:100%"
                           value="{$form_data.other_state}"/>
        </td>
        <!-- Country -->
		<td style="text-align:right;">
        	<strong id="notify_country" style="float:right"> Country <span class="require">*</span></strong>
        </td>
        <td >
             <select name="country" id="personal_country" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options=$options_country selected =$form_data.country}
            </select>
        </td>
    </tr>

    <tr rel="{$agent_arr.partner}">
    	<td width = "19%">
        	<strong id="notify_postal_street">Postal Address</strong>
             <span class="require">*</span>
        </td>
        <td >
        	<input type="text" name="partner[postal_address]" id="postal_address" value="{$form_data.postal_address}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.partner}">
       <td width = "19%">
        	<strong id="notify_postal_suburb" style="float: left">Suburb <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="partner[postal_suburb]" id="postal_suburb" value="{$form_data.postal_suburb}" class="input-text validate-require validate-letter" onclick="partner_overlay.getData(this)" onkeyup="partner_overlay.moveByKey(event)" autocomplete="off" style="width:100%"/>
	        <ul>
                <div id="search_partner" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>
        <td style="text-align:right;"><strong id="notify_postal_postcode">Postcode <span class="require">*</span></strong></td>
        <td>
            <input type="text" name="partner[postal_postcode]" id="postal_postcode" style="width:100%" value="{$form_data.postal_postcode}" class="input-text validate-postcode validate-require"
             autocomplete="off" />
        </td>
    </tr>

	<tr rel="{$agent_arr.partner}">
        <td width = "19%"><strong id="notify_postal_state">State <span class="require">*</span></strong></td>
        <td>
            <div id="inactive_postal_state">
                <select name="partner[postal_state]" id="postal_state" class="input-select validate-number-gtzero " style="width:100%">
                      {html_options options=$subState selected =$form_data.postal_state}
                </select>
            </div>
            <input type="text" id="postal_other_state" name="partner[postal_other_state]" class="input-text not-require" style="width:100%"
                           value="{$form_data.postal_other_state}"/>
        </td>
         <!-- Country -->
		<td>
        	<strong id="notify_postal_country" style="float:right"> Country <span class="require">*</span></strong>
        </td>
        <td >
             <select name="partner[postal_country]" id="postal_country" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options=$options_country selected =$form_data.postal_country}
            </select>
        </td>
    </tr>

    <tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.partner}">
        <td width="19%">
            <strong id="notify_telephone">Telephone</strong>
        </td>
        <td>
            <input type="text" name="telephone" id="personal_telephone" value="{$form_data.telephone}"
                   class="input-text" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    <tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}-{$agent_arr.theblock}-{$agent_arr.partner}">
        <td width="19%"  rel="{$agent_arr.theblock}" rowspan="" style="text-align: left;vertical-align: top;line-height: 40px;"><strong id="notify_logo">Logo </strong></td>
        <td rel="{$agent_arr.theblock}" rowspan="" style="vertical-align: top;">
            <div class="input-box">
                <div class="input-box file-upload">
                    <div id="btn_photo" style="float:left"></div>
                    <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                        No file chosen
                    </ul>
                    <br clear="all"/>
                    <script type="text/javascript">
                        var photo = new Media();
                        photo.uploader('btn_photo', 'logo', '/modules/agent/action.admin.php?action=upload-logo-block&id={$form_data.agent_id}&token={$token}');
                    </script>
                    {if $form_data.logo}
                        <div id="logo">
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

    <tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}">
        <td>
            <strong id="notify_mobilephone" style="">Mobilephone</strong>
        </td>
        <td>
            <input type="text" name="mobilephone" id="personal_mobilephone" value="{$form_data.mobilephone}"
                   class="input-text" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}">
    	<td>
        	<strong id="notify_license_number">Drivers License Number/Medicare Card No.</strong>
        </td>
        <td>
        	<input type="text" name="license_number" id="personal_license_number" value="{$form_data.license_number}" class="input-text" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}">
        <td></td>
        <td>
            {assign var = 'allow' value = ''}
            {if $form_data.allow_vendor_contact>0}
                {assign var = 'allow' value = 'checked'}
            {/if}
                <label for="allow_vendor_contact">
                    <input type="checkbox" name="allow_vendor_contact" id="allow_vendor_contact" {$allow}/>
                    <strong>Can vendors contact you?</strong>
                </label>
        </td>
    </tr>
    
    
	<tr rel="{$agent_arr.vendor}-{$agent_arr.buyer}">
    	<td>
        	<strong id="notify_preferred_contact_method">Preferred contact method <span class="require">*</span></strong>
        </td>
        <td>
            <select name="preferred_contact_method" id="preferred_contact_method" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $options_method selected = $form_data.preferred_contact_method }
            </select>
        </td>
    </tr>

     <tr rel="{$agent_arr.partner}">
        <td><strong id="notify_logo">Logo </strong></td>
        <td style="vertical-align: top;">
            <div class="input-box">
                <div class="input-box file-upload">
                    <div id="btn_partner_photo" style="float:left"></div>
                    <ul id="lst_partner_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                        No file chosen
                    </ul>
                    <br clear="all"/>
                    <script type="text/javascript">
                        var photo = new Media();
                        photo.uploader('btn_partner_photo', 'logo', '/modules/agent/action.admin.php?action=upload-logo&id={$form_data.agent_id}&token={$token}');
                    </script>
                    {if $form_data.partner_logo}
                        <div id="partner_logo">
                            <img src="/store/uploads/banner/images/partner/{$form_data.partner_logo}" alt="" title=""/>
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
    	<td width = "19%">
        	<strong id="notify_email_address">Email </strong>
            <span class="require"> * </span>
        </td>
        <td >
        	<input type="text" name="email_address" id="email_address" value="{$form_data.email_address}" class="input-text validate-require validate-email" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr>
    	<td width="19%">
        	{assign var = cls_validate value = ''}
            {if $form_data.agent_id > 0}
                <strong >Password </strong>
            {else}
                <strong id="notify_password">Password <span class="require">*</span></strong>
                {assign var = cls_validate value = 'validate-require'}
            {/if}
        </td>
        <td >
        	<input type="password" name="password" id="password" value="{$form_data.password}" class="input-text {$cls_validate}" AUTOCOMPLETE = "off" style="width:100%"/>
            
        </td>
    </tr>

    <tr>
    	<td width="19%" valign="top">
			<strong id="notify_security_question">Security question <span class="require">*</span></strong>
        </td>
        <td>
            <select name="security_question" id="security_question" class="input-select validate-number-gtzero" style="100%">
                {html_options options = $options_question selected = $form_data.security_question}
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type="text" name="security_answer" id="security_answer" value="{$form_data.security_answer}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

    <tr rel="{$agent_arr.partner}">
    	<td width="19%" valign="top">
			<strong id="notify_description">Company Description<span class="">*</span></strong>
        </td>
        <td colspan="3">
            <textarea rows="6" cols="" name="partner[description]" id="description" class="content input-text">{$form_data.description}</textarea>
        </td>
    </tr>

    <tr>
        <td></td>
        <td colspan="{if $height > 200}2{else}4{/if}">
            <div style="float:left;">
                    {assign var = 'chk' value = ''}
                    {if $form_data.notify_email > 0}
                        {assign var = 'chk' value = 'checked'}
                    {/if}

                    <label for="notify_email">
                    	<input type="checkbox" name="notify_email" id="notify_email" value="1" {$chk}/> <span>Notification email address</span>
                    </label>

                    {assign var = 'chk' value = ''}
                    {if $form_data.notify_sms > 0}
                        {assign var = 'chk' value = 'checked'}
                    {/if}

                    <label for="notify_sms" style="margin-left: 20px;">
                    	<input type="checkbox" name="notify_sms" id="notify_sms" value="1" {$chk}/> <span>Notification SMS number</span>
                    </label>

                    {assign var = 'chk' value = ''}
                    {if $form_data.subscribe > 0}
                        {assign var = 'chk' value = 'checked'}
                    {/if}

                    <label for="subscribe" style="margin-left: 20px;">
                    	<input type="checkbox" name="subscribe" id="subscribe" value="1" {$chk}/> <span>Subscribe for newsletter</span>
                    </label>

                    {assign var = 'chk' value = ''}
                    {if $form_data.is_active > 0}
                        {assign var = 'chk' value = 'checked'}
                    {/if}

                    <label for="is_active" style="margin-left: 20px;">
                    	<input type="checkbox" name="is_active" id="is_active" value="1" {$chk}/> <span>Active</span>
                    </label>

                </div>
                <div class="clearthis"></div>
                {*<div style="clear:both;">
                    {assign var = 'chk' value = ''}
                    {if $form_data.notify_turnon_sms > 0}
                        {assign var = 'chk' value = 'checked'}
                    {/if}

                    <label for="notify_turnon_sms" style="float:left;">
                    	<input type="checkbox" name="notify_turnon_sms" id="notify_turnon_sms" value="1" {$chk}/> <span>Turn on SMS Notification $$$ per xxx</span>
                    </label>*}



                {*</div>*}
            </div>
        </td>
    </tr>

	<tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="cc_id" id="cc_id" value=""/>
            <input type="button" class="button" value="Reset" onclick="agent.reset('?module=agent&action=add')"/>
			<input type="button" class="button" value="Save" onclick="agent.submit(false, true)" />
		
			<!--<input type="button" class="button" value="Save" onclick="submit('#frmAgent')"/> -->
            <input type="button" class="button" value="Save & Next" onclick="agent.submit(true, true)"/>
        </td>
    </tr>
    
</table>
{if $action == 'add' or $action == 'edit-personal'}
    {literal}
    <script type="text/javascript">
        //onReloadMemberPartner(document.getElementById("frmAgent"));
        //onReloadCountry(document.getElementById("frmAgent"));
    </script>
    {/literal}
{/if}

<script type="text/javascript">
    var partner = '{$agent_arr.partner}';
    var agent_type = '{$agent_arr.agent}';
    var default_country = '{$default_country}';
    {literal}
    function changeType(obj){
        var type = $(obj).val();

        {/literal}{if $form_data.agent_id == 0}{literal}
        var url='../modules/agent/action.admin.php?action=get-parent&token={/literal}{$token}{literal}';
        $.post(url,{type:$(obj).val()},function(data){
                    $('#parent_id').find('option').remove();
                    var result = $.parseJSON(data);
                    $.each(result,function(key,value){
                        $('#parent_id').append('<option value="'+key+'">'+value+'</option>');
                    });
              },'html');
        {/literal}{/if}{literal}
        $.each($('td, li, tr'),function(){
            agent.flushCallback();
            var rel = $(this).attr('rel');
            if ( rel != '' && typeof rel != 'undefined'){
                var rel_ar = rel.split('-');
                if ($.inArray(type,rel_ar) > -1){
                    $(this).show();
                    if ($(this)[0].tagName == 'TR'){
                        $(this).find('input,textarea,select.input-select').removeAttr('disabled');
                        $.each($(this).find('td .require'),function(){
                            $(this).parents('td').next().find('input,textarea').addClass('validate-require');
                            $(this).parents('td').next().find('select').addClass('validate-number-gtzero');
                            var test = $(this).parents('td').next().find('div').attr('id');
                            if (typeof test != 'undefined' && test.indexOf('inactive') > -1){
                                var arr = test.split('_');
                                if ($('#'+arr[1]+'_country').val() == 1){
                                    $(this).parents('td').next().find('#'+arr[1]+'_other_state').removeClass('validate-require');
                                }else{
                                    $(this).parents('td').next().find('#'+arr[1]+'_state').removeClass('validate-number-gtzero');
                                }
                            }
                        });
                        if ($(this).find('#description')){
                            agent.callback_func.push(function (){ return validEditor()});
                        }
                    }
                    if ($(this)[0].tagName == 'TD'){
                        $(this).find('input[type=text],select.input-select,textarea').removeAttr('disabled');
                        if ($(this).children().children().hasClass('require')){
                            $(this).next().find('input,textarea').addClass('validate-require');
                            $(this).next().find('select').addClass('validate-number-gtzero');
                        }
                    }
                }
                else{
                    $(this).hide().find('input[type=text],textarea').removeClass('validate-require');
                    $(this).hide().find('select').removeClass('validate-number-gtzero');
                    $(this).hide().find('input[type=text],select.input-select').attr('disabled','disabled');

                }
            }
            if (type == partner){
                $('#notify_firstname').html('Company Name');
                $('#notify_street').html('Address Company');
                $('#notify_email_address').html('Login Email');
                if ($('#postal_country').val() == 0){
                    $('#postal_country').val(default_country);
                }
            }else{
                $('#notify_firstname').html('First Name');
                $('#notify_street').html('Address');
                $('#notify_email_address').html('Email');
            }

        });

    }
    $('#type_id').bind('change',function(){
        changeType(this);
    });
    onLoad('personal');onLoad('postal');
    changeType(('#type_id'));

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
            return true;
        }
    }

    $('#personal_country').bind('change',function(){
        onLoad('personal');
    });
    $('#postal_country').bind('change',function(){
        onLoad('postal');
    });

    $('#parent_id').change(function(){
          loadChildField(this);
    });
    loadChildField($('#parent_id'));
    function loadChildField(obj){
        if ($('#type_id').val() == '{/literal}{$agent_arr.agent}{literal}' || $('#type_id').val() == '{/literal}{$agent_arr.theblock}{literal}' ){
            if($(obj).val() > 0){
                  $('.child-field').show();
                  $.each($('.child-field'),function(){
                      $(this).find('input,textarea,select.input-select').removeAttr('disabled');
                      $.each($(this).find('td .require'), function() {
                          $(this).parents('td').next().find('input,textarea').addClass('validate-require');
                          $(this).parents('td').next().find('select').addClass('validate-number-gtzero');
                          var test = $(this).parents('td').next().find('div').attr('id');
                          if (typeof test != 'undefined' && test.indexOf('inactive') > -1) {
                              var arr = test.split('_');
                              if ($('#' + arr[1] + '_country').val() == 1) {
                                  $(this).parents('td').next().find('#' + arr[1] + '_other_state').removeClass('validate-require');
                              } else {
                                  $(this).parents('td').next().find('#' + arr[1] + '_state').removeClass('validate-number-gtzero');
                              }
                          }
                      });
                  })
            }else{
                  $('.child-field').hide();
                  $.each($('.child-field'),function(){
                      $(this).find('input,textarea,select.input-select').attr('disabled','disabled');
                      $(this).hide().find('input[type=text],textarea').removeClass('validate-require');
                      $(this).hide().find('select').removeClass('validate-number-gtzero');
                  })
            }
        }
    }
    {/literal}
</script>