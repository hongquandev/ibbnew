<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script src="/modules/banner/templates/js/check-exposition.js"></script>     
<script src="/modules/general/templates/calendar/js/jscal2.js"></script>
<script src="/modules/general/templates/calendar/js/lang/en.js"></script>
<script src="/modules/banner/templates/js/common.js"></script>
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/steel/steel.css" />

<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css"/>
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>

{literal}
<script type="text/javascript">
function howMany(page_id){
	var page_select = document.getElementById(page_id);
	if (form_select.hasManySelect(page_id)) {
		if (page_select.options[0].selected == true) {
			form_select.unSelectAll(page_id);
			page_select.options[0].selected = true;
			alert("You can't choose the two cases");
		}
	}
}
var banner = new BANNER('#frmCreate');
var search_overlay = new Search();
	search_overlay._frm = '#frmAgent';
	search_overlay._text_search = '#suburb';
	search_overlay._text_obj_1 = '#state';
	search_overlay._text_obj_2 = '#postcode';
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
		 //alert(info[0]);
		 jQuery(search_overlay._text_obj_1).val(info[0]);
		 $('#uniform-state span').html($(search_overlay._text_obj_1+" option:selected").text());
	}

	if (content_str.length > 0) {
		jQuery(search_overlay._overlay_container).html(content_str);
		jQuery(search_overlay._overlay_container).show();
		jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
	} else {
		jQuery(search_overlay._overlay_container).hide();
	}
}

var sug_agent = new Search();
sug_agent._frm = '#frmCreate';
sug_agent._text_search = '#agent_name';
sug_agent._text_obj_1 = '#agent_id';
sug_agent._overlay_container = '#sug_agent';
sug_agent._url_suff = '&type=partner';
sug_agent._name_id = 'item_';
sug_agent._location = '?module=banner&action=edit&agent_id=[1]&token=';

sug_agent._success = function(data) {
	var info = jQuery.parseJSON(data);
	var content_str = "";
	var id = 0;
	if (info.length > 0) {
		sug_agent._total = info.length;
		for (var i = 0; i < info.length; i++) {
			var id = 'item_' + i;
			if (info[i]['status'] == 1){
				content_str +="<li onclick='sug_agent.set2SearchText_agent(this,"+info[i]['agent_id']+","+info[i]['status']+")' id="+id+" class="+info[i]['agent_id']+">"+info[i]['full_name']+"<span>"+info[i]['email_address']+"</span></li>";
			}else{
				content_str +="<li id="+id+" class='li-inactive "+info[i]['agent_id']+"' onclick='sug_agent.set2SearchText_agent(this,"+info[i]['agent_id']+","+info[i]['status']+")'>"+info[i]['full_name']+"<span>"+info[i]['email_address']+"</span></li>";
			}
			sug_agent._item.push(id);
		}
	}

	if (content_str.length > 0) {
		jQuery(sug_agent._overlay_container).html(content_str);
		jQuery(sug_agent._overlay_container).show();
		jQuery(sug_agent._overlay_container).width(jQuery(sug_agent._text_search).width());
	} else {
		jQuery(sug_agent._overlay_container).hide();
	}
}

document.onclick = function() {
	search_overlay.closeOverlay();
	sug_agent.closeOverlay();
};

function showUser(str, areas) {
	var temp=document.getElementById('display');
	var areas = temp.options[temp.options.selectedIndex].value;
	
	var page=document.getElementById('page_id');
	var pages = page.options[page.options.selectedIndex].value;
	
	//alert(areas);
	if (str=="") {
		document.getElementById("txtHint").innerHTML="";
		return;
	}
	
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","/modules/banner/admin.exsposition.php?action=checkposis&position="+str+"&areas="+areas+"&page="+pages,true);
	//xmlhttp.open("POST","/modules/banner/admin.exsposition.php?action=checkposis",true);
	xmlhttp.send();
}

var banner = new BANNER('#frmCreate');
</script>
{/literal}
<script language="javascript" src="/modules/banner/templates/js/check_state.js"> </script>

<div style="width:100%">
   <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
       <tr >
        	<td colspan=2 align="center"></td>
       </tr>
       <tr>
           <td colspan=2>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">
                        	{if $next != ''}<span class="adm-left"><a href="{$next}">&lt;&lt; Previews</a></span>{/if}
                                Banner Information
                            {if $prev != ''}<span class="adm-right"><a href="{$prev}">Next &gt;&gt;</a></span>{/if}
                        </td>
                    </tr>
                </table>
            </td>    
       </tr>

       <tr>
            <td colspan="2" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                            <td align="left" valign="top" class="padding1">
                                <table width="100%" cellspacing="15">
                                    <tr>
                                        <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                        <!--bar-->
                                            {include file = 'admin.banner.bar.tpl'}
                                        </td>
                                        <td valign="top">
                                            {if isset($message) and strlen($message) > 0}
                                                <div class="message-box">{$message}</div>
                                            {/if}
                                            <table width="100%" cellspacing="0" class="box">
                                                <tr>
                                                    <td class="box-title">
                                                        <label>Banner detail</label>
                                                    </td>
                                                </tr>
                                        
                                                <tr>
                                        	        <td class="box-content">
                                                        
                                                            <form method="post" action="{$form_action}" class="cmxform" name="frmCreate" id="frmCreate" enctype="multipart/form-data" onsubmit="return checkUrlB();">
                                                  	        <table class="edit-table" width="100%" cellspacing="10">
                                                                <tr>
                                                                    <td width="19%"><strong id="notify_agent_id">Partner <span class="require">*</span></strong></td>
                                                                    <td width="30%">
                                                                        <input type="text" name="fields[agent_name]" id="agent_name" value="{$form_data.agent_name}" onclick="sug_agent.getData(this)" onkeyup="sug_agent.moveByKey(event)" class="input-text validate-require disable-auto-complete" style="width:100%"/>
                                                                        <input type="hidden" name="fields[agent_id]" id="agent_id" value="{$form_data.agent_id}"/>
                                                                        <ul>
                                                                            <div id="sug_agent" class="search_overlay" style="display:none; position: absolute;"></div>
                                                                        </ul>
                                                                    </td>
                                                                    <td width="19%"></td>
                                                                    <td width="30%"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <strong id="notify_banner_name">Banner Name<span class="require">*</span></strong>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="banner_name" name="fields[banner_name]" style="width:100%" class="input-text validate-require" value="{$form_data.banner_name}"/>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong id="notify_url">Url<span class="require">*</span></strong></td>
                                                                    <td>
                                                                        <input id="url" name="fields[url]" type="text" style="width:100%" class="input-text validate-require"value="{$form_data.url}"/>				
                                                                        <i>Ex : http://www.google.com</i>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr id="banner_container" {if $form_data.banner_file == ''}style="display:none"{/if}>
                                                                    <td><strong id="notify_title">Image</strong></td>
                                                                    <td colspan="3">
                                                                        <img src="{$MEDIAURL}/store/uploads/banner/images/{$form_data.banner_file}" style="max-width:600px"/> 
                                                                        <input type="hidden" name="fields[banner_file]" id="banner_file" value="{$form_data.banner_file}"/>   
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td  valign="top">
                                                                    	Upload Banner
                                                                    </td>
                                                                    <td colspan="3">
                                                                        <li class="wide" id="upload-logo">
                                                                            <div class="input-box">
                                                                                <div class="input-box file-upload">
                                                                                    <div id="btn_photo" style="float:left"></div>
                                                                                    <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                                                                                        No file chosen
                                                                                    </ul>
                                                                                    <br clear="all"/>
                                                                                    <script type="text/javascript">
                                                                                        var photo = new Media();
                                                                                        photo.uploader('btn_photo', 'logo', '/modules/banner/action.php?action=upload');
                                                                                    </script>
                                                                                </div>
                                                                                <i>   
                                                                                    You must upload  with one of the following extensions: jpg, jpeg, gif, png<br/>
                                                                                    The best dimension for right banner is: 280 x 280 pixel and for center banner is: 616 x 110 pixel. !<br/> 
                                                                                    But in case you don't have the banner fits the size, we limit it up to 280 pixel in width and 500pixel in height<br/>
                                                                                    for right banner. And 616 pixel in width and 200 pixel in height for center banner.<br/> 
                                                                                 </i>
                                                                            </div>
                                                                        </li>    
                                                                    </td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                    <td>
                                                                        <strong id="notify_display">Display Area<span class="require">*</span></strong>
                                                                    </td>
                                                                    <td>
                                                                        <select class="input-select" name="fields[display]" id="display" style="width:100%" onchange="banner_area.change('/modules/menu/action.php?action=get-menu', this, '#page_id')" >
                                                                            {html_options options = $options_display selected = $form_data.display}
                                                                        </select>
                                                                    </td>

                                                                    <td align="right">
                                                                        <strong id="notify_position">Position</strong>
                                                                    </td>
                                                                    <td>
																		<input type="text" id="position" maxlength="3" name="fields[position]" style="width:100%" class="input-text" value="{$form_data.position == 1000 and $form_data.banner_id > 0 ? $form_data.position: ''}"/>   
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                    	<strong id="notify_page_id">Page<span class="require">*</span></strong>
                                                                    </td>
                                                                    <td>
                                                                         <select class="input-select " name="fields[page_id][]" id="page_id" multiple="multiple" style="width:100%;height:200px;font-size:10px;">
                                                                              {html_options options = $options_page selected = $form_data.page_id} 
                                                                         </select>
                                                                    </td>
                                                                	<td align="left"></td>
                                                                    <td valign="top"><div id="txtHint" style="color:#FF0000; font-weight:bold;"></div></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><strong id="notify_date_from">Date from<span class="require">*</span></strong></td>
                                                                    <td><input id="date_from" name="fields[date_from]" type="text" style="width:100%" class="input-text validate-require"value="{$form_data.date_from}"/></td>
                                                                    <td align="right"><strong id="notify_date_to">Date to<span class="require">*</span></strong></td>
                                                                    <td><input id="date_to" name="fields[date_to]" type="text" style="width:100%" class="input-text validate-require"value="{$form_data.date_to}"/></td>
                                                                </tr>

                                                                <tr>
                                                                  <td><strong id="notify_type">Property Type<span class="require">*</span></strong></td>
                                                                      <td>
                                                                          <select class="input-select" name="fields[type]" style="width:100%">
                                                                              {html_options options = $options_type selected = $form_data.type}
                                                                          </select>
                                                                      </td>
                                                                    <td align="right">	
                                                                        {assign var = 'chked' value = ''}
                                                                        {if $form_data.notification_email==1}
                                                                            {assign var = 'chked' value = 'checked'}
                                                                        {/if}
                                                                        <input type="checkbox" name="fields[notification_email]" id="notification_email" {$chked}/>
                                                                    </td>  
                                                                 	<td> <label style="margin-left:0px;">Notification Email</label></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><strong id="notify_suburb">Suburb</strong></td>
                                                                    <td>
                                                                        <input name="fields[suburb]" id="suburb" type="text" style="width:100%" class="input-text validate-require disable-auto-complete" onClick="search_overlay.getData(this)" onKeyUp="search_overlay.moveByKey(event)" value="{$form_data.suburb}"/>
                                                                        <ul>
                                                                            <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                                                                        </ul>
                                                                    </td>

                                                                    <td align="right"><strong id="notify_state">State<span class="require">*</span></strong></td>
                                                                    <td>
                                                                        <select style="width:100%" class="input-select" name="fields[state]" id="state" onChange="onReloadState(this.form)">
                                                                             {html_options options = $options_state selected = $form_data.state}
                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td><strong id="notify_postcode"> Postcode </strong></td>
                                                                    <td>
                                                             	        <input name="fields[postcode]" id="postcode" type="text" class="input-text validate-require" style="width:100%" value="{$form_data.postcode}"/>
                                                                    </td>

                                                                    <td align="right"><strong id="notify_country">Country<span class="require">*</span></strong></td>
                                                                    <td>
                                                                       <select name="fields[country]" id="country" class="input-select validate-number-gtzero" style="width:100%">
                                                                            {html_options options = $countries selected = $form_data.country}
                                                                       </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong id="notify_pay_status">Pay Status<span class="require">*</span></strong></td>
                                                                    <td>
                                                                       <select name="fields[pay_status]" id="pay_status" class="input-select" style="width:100%">
                                                                            {html_options options = $options_pay_status selected = $form_data.pay_status}
                                                                       </select>
                                                                    </td>
																	<td align="right"><strong id="notify_description">Notes</strong></td>
                                                                    <td>
                                                                     	<textarea name="fields[description]" id="description" rows="3" cols="3">{$form_data.description}</textarea>
                                                                    </td>
                                                                </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <hr/>
                                                                {if $id > 0}
                                                                    {assign var = button value= "Update banner"}
                                                                {else}
                                                                    {assign var = button value= "Add banner"}
                                                                {/if}
                                                                <input type="hidden" name="fields[id]" id="id" value="{$form_data.banner_id}"/>
                                                                <input type="button" class="button" value="{$button}" onClick="banner.validAgent();"/>
                                                                <input type="button" class="button" value="Back" onClick="window.location='?module=banner&token='+jQuery('#token').val()"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <input type="hidden" name="token" id="token" value="{$token}"/>
                                            	</form>
                                            </td>
                                        </tr> 
                                    </table>
                                  
                                </td>
                            </tr>             
                        </table>
                    </td>
                    <td width="1" bgcolor="#CCCCCC"></td>
                </tr>
            </table>
        </td>
   </tr>
        
   <tr>
       <td>
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                    <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                    <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                </tr>
           </table>
       </td>
   </tr>
</table>

</div>
{literal}
<script type="text/javascript">
    function activeAgent(agent_id){
        var url = '/modules/agent/action.admin.php?action=active-agent&token='+$('#token').val();
        $.post(url,{agent_id:agent_id},function(data){
             var result = jQuery.parseJSON(data);
             if (result.success){
               /*alert( jQuery('input[name='+agent_id+']').val());*/
               jQuery('#'+agent_id).removeAttr("disabled");
               jQuery('#'+agent_id).parent().removeClass('x-item-disabled');
               jQuery('a[name='+agent_id+']').remove();
             }
        });
    }
    function validDate(){
          if (jQuery('#date_from').val() > jQuery('#date_to').val()){
              Common.warningObject('#date_from');
              Common.warningObject('#date_to');
              return false;
          }
          return true;
    }
    banner.flushCallback();
    banner.callback_func.push(function(){return validDate();});
    Calendar.setup({
        inputField : 'date_from',
        trigger    : 'date_from',
        onSelect   : function() { this.hide() },
		showTime   : true,
		dateFormat : "%Y-%m-%d"
    });

    Calendar.setup({
        inputField : 'date_to',
        trigger    : 'date_to',
        onSelect   : function() { this.hide() },
		showTime   : true,
		dateFormat : "%Y-%m-%d"
    });
	
	onReloadState(document.getElementById("frmCreate"));

	function checkPageAll() {
		if ($("#check_all_page").is(':checked')) {
			jQuery('#page_id').hide();
			jQuery('#all_page_id').show();
			jQuery("#all_page_id").addClass("validate-choose-select");
			jQuery("#page_id").attr('disabled', 'disabled');	
			jQuery("#all_page_id").removeAttr('disabled');
		} else {
			jQuery('#all_page_id').hide();
			jQuery('#page_id').show();
			jQuery('#all_page_id').removeClass('validate-choose-select');
			jQuery("#page_id").removeAttr('disabled');
			jQuery("#all_page_id").attr('disabled', 'disabled');	
		}
	}
	checkPageAll();	
</script>
{/literal}