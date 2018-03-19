{literal}
<script type="text/javascript" src="/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "specific_textareas",
	editor_selector : "content",
	theme:"advanced",
	height:"380",
	width:"367",
	plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,charmap,emotions,print",
	theme_advanced_buttons2 : "save,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent",
	theme_advanced_buttons3 : "undo,redo,|,link,unlink,anchor,cleanup,help",

	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	/*theme_advanced_resizing_max_width: 365,*/
	theme_advanced_resizing_min_width: 365,
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
{literal}
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<script type="text/javascript" src="modules/agent/templates/js/checkimage.js"></script>
<script type="text/javascript">

jQuery(document).ready(function(){
    onLoad('company');
    $('#company_country').bind('change',function(){
        onLoad('company');
    })
});
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
	}

	search_overlay._getValue = function(data){
		var info = jQuery.parseJSON(data);
		jQuery(search_overlay._text_obj_1).val(info[0]);
		$('#uniform-company_state span').html($(search_overlay._text_obj_1+" option:selected").text());
	};

	if (content_str.length > 0) {
		jQuery(search_overlay._overlay_container).html(content_str);
		jQuery(search_overlay._overlay_container).show();
		jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
	} else {
		jQuery(search_overlay._overlay_container).hide();
	}
	jQuery(search_overlay._text_search).removeClass('search_loading');
};
</script>
{/literal}
<div>
    <ul class="form-list form-register">
        <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}" enctype="multipart/form-data">
        {if isset($message) and strlen($message)>0}
         <div id="message" class="message-box message-box-v-ie">{$message}</div>
        {/if}
        <div id="message_reg" class="message-box message-box-v-ie" style="display: none;"></div>
        <h2>Company Information </h2>
        <hr/>
        <li class="wide">
            <label>
                <strong id="notify_company_name">Company Name<span>*</span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="company_name" id="company_name" value="{$form_data.company_name}" class="input-text validate-require"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_contact_name">ABN / ACN <span>*</span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="abn" id="abn" value="{$form_data.abn}" class="input-text validate-require validate-digits"/>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_address">Address <span>*</span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="address" id="company_address" value="{$form_data.address}" class="input-text validate-require"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_mobilephone">{localize translate="Phone Number"}</strong>
            </label>
            <div class="input-box">
                <input type="text" name="telephone" id="notify_mobilephone" value="{$form_datas.mobilephone}"
                       class="input-text" autocomplete="off"/>
            </div>
        </li>
        <li class="fields">
            <div class="field">
                <label>
                    <strong id="notify_company_suburb">Suburb <span>*</span></strong>
                </label>
                <div class="input-box">
                    <input type="text" name="suburb" id="company_suburb" value="{$form_data.suburb}"
                           onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"
                           class="input-text validate-require validate-letter" autocomplete="off"/>
                    <ul>
                        <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                    </ul>
                </div>
            </div>
            <div class="field" style="float:right">
                <label>
                    <strong id="notify_company_postcode">Postcode <span>*</span></strong>
                </label>
                <div class="input-box">
                    <input type="text" name="postcode" id="company_postcode" value="{$form_data.postcode}" class="input-text validate-require validate-postcode" autocomplete="off"/>
                </div>
            </div>
            <div class="clearthis"></div>
        </li>
        <li class="fields">
            <div class="field">
                <label>
                    <strong id="notify_company_state">State</strong>
                </label>
                <div class="input-box input-select">
                    <div id="inactive_company_state">
                        <select id="company_state" name="state" class="input-select">
                            {html_options options=$options_state selected=$form_data.state}
                        </select>
                    </div>
                    <input type="text" id="company_other_state" class="input-text" name="other_state" value="{$form_data.other_state}"/>
                </div>
            </div>
            <div class="field" style="float:right">
                <label>
                    <strong id="notify_country">Country <span>*</span></strong>
                </label>
                <div class="input-box">
                    <select name="country" id="company_country" class="input-select validate-number-gtzero">
                        {html_options options = $options_country selected = $form_data.country}
                    </select>
                </div>
            </div>
            <div class="clearthis"></div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_email">Company Email</strong>
            </label>
            <div class="input-box">
                <input type="text" name="email_address" id="email_address" value="{$form_data.email_address}" class="input-text validate-email" autocomplete="off"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_website">Website <span></span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="website" id="website" value="{$form_data.website}" class="input-text validate-url" autocomplete="off"/>
            </div>
        </li>
        
        {if $form_data.logo != ''}
        <li class="wide">
            <label>
                <strong id="notify_logo">Logo</strong>
            </label>
            <div class="input-box" style="margin-left:0px;">
                <img src="{$MEDIAURL}/store/uploads/banner/images/partner/{$form_data.partner_logo}" alt="{$form_data.partner_logo}" style="max-width:185px; max-height:154px;"/>
                <div class="clearthis"></div>
            </div>
        </li>
        {/if}

        <li class="wide">
            <label>
                <strong id="notify_contact_address">Description <span></span></strong>
            </label>
            <div class="input-box">
                <textarea rows="6" cols="43" name="description" id="description" class="content">{$form_data.description}</textarea>
            </div>
        </li>
        </form>
    </ul>
    <div class="buttons-set">
        <button class="btn-blue" onclick="agentAuctionSubmit();">
            <span><span>Next</span></span>
        </button>
    </div>
</div>
{literal}
<script type="text/javascript">
function agentAuctionSubmit() {
    if(typeof tinyMCE.get('description') != 'undefined'){
        var editorContent = tinyMCE.get('description').getContent();
    }else{
        var editorContent = jQuery('#description').val();
    }
	if(editorContent == '') {
		jQuery('#message_reg').show();
		jQuery('#message_reg').html('Please input Company description');
	} else {
		jQuery('#message_reg').hide();
		agent.step('#frmAgent');
	}
}
</script>
{/literal}