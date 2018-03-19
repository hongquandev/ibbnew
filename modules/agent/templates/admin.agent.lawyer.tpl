<script src="../modules/agent/templates/js/checkcountry_admin.js" type="text/javascript"> </script>
{literal}
<script type="text/javascript">
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
document.onclick = function() {search_overlay.closeOverlay();};
</script>
{/literal}
<table width="100%" cellspacing="10" class="edit-table">
{if $type != 'partner'}
    <tr>
    	<td width = "22%">
        	<strong id="notify_name">Name </strong>
        </td>
        <td >
        	<input type="text" name="name" id="name" value="{$form_data.name}" class="input-text " style="width:100%" autocomplete="off"/>
        </td>
    </tr>
   
	<tr>
    	<td width = "22%">
        	<strong id="notify_company">Company </strong>
        </td>
        <td >
        	<input type="text" name="company" id="company" value="{$form_data.company}" class="input-text " style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_address">Address </strong>
        </td>
        <td >
        	<input type="text" name="address" id="address" value="{$form_data.address}" class="input-text " style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_suburb">Suburb </strong>
        </td>
        <td >
        	<input type="text" name="suburb" id="suburb" value="{$form_data.suburb}" class="input-text  validate-letter" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off" style="width:100%"/>
	        <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>
    </tr>

	<tr id="inactive_state">
    	<td width = "22%">
        	<strong id="notify_state">State </strong>
        </td>
        <td >
        {if $form_data.other_state != '' or $form_data.other_state == ''}
                <select name="state" id="state" class="input-select " style="width:50%" onchange="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')">
                    {html_options options=$subState selected =$form_data.state}
                </select>
            {else}
               <select name="state" id="state" class="input-select " style="width:50%" onchange="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')">
                    {html_options options=$options_state selected =$form_data.state}
                </select>
           {/if} 
        </td>
    </tr>

	<tr id="active_state" style="display:none">
        <!-- Change Text Suburb With Country is not Australia -->
           <td width="19%">
             <strong id="notify_state">State </strong>
            </td>
            
            <td>
                {if $form_data.other_state == ''}                           	
                     <input type="text" id="other_state" style="width:100%" name="other_state" class="input-text" value="" />
                {else}
                     <input type="text" id="other_state" style="width:100%" name="other_state" class="input-text" value="{$form_data.other_state}" />
                {/if}       
               
            </td>
           
    <!-- End Change Text Suburb With Country is not Australia -->
    </tr>
    
      <tr id="active_country" style="display:none">
    	  <!-- Change Country if Country is choose Other -->
                      
        <td width="19%">
       	 	<strong id="notify_country">Country Name </strong>
        </td>
        <td>
        	<input type="text" id="other_country" style="width:100%" name="other_country" value="{$form_data.other_country}" class="input-text" />                       
        </td>                   
                       
          <!-- End Change Country is choose Other -->      
    </tr>
    
	<tr>
    	<td width = "22%">
			<strong id="notify_postcode">Postcode </strong>
        </td>
        <td >
        	<input type="text" name="postcode" id="postcode" value="{$form_data.postcode}" class="input-text  validate-postcode" style="width:50%" autocomplete="off" onkeyup="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_country">Country </strong>
        </td>
        <td >
            <select name="country" id="country"  class="input-select " onchange="onReloadCountry(this.form,'lawyer')" style="width:50%">
                {html_options options = $options_country selected = $form_data.country}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_telephone">Telephone {**}</strong>
        </td>
        <td >
        	<input type="text" name="telephone" id="telephone" value="{$form_data.telephone}" class="input-text{* *} validate-telephone" style="width:50%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_mobiphone">Mobile Phone  {**}</strong>
        </td>
        <td >
        	<input type="text" name="mobilephone" id="mobilephone" value="{$form_data.mobilephone}" class="input-text {**} validate-telephone" style="width:50%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_email">Email </strong>
        </td>
        <td >
        	<input type="text" name="email" id="email" value="{$form_data.email}" class="input-text  validate-email" autocomplete="off" style="width:100%"/>
        </td>

    </tr>
{else} <!-- AGENT IS PARTNER -->
    	{include file = "admin.agent.partner.company.tpl"}
{/if}    
	<tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="agent_lawyer_id" id="agent_lawyer_id" value="{$agent_lawyer_id}"/>
			<input type="button" class="button" value="Save" onclick="agent.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="agent.submit(true)"/>
        </td>
    </tr>
</table>

