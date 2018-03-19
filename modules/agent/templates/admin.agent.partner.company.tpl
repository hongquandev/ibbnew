
    <tr>
        <td></td>
        <td colspan="3">
            <ul class="tabs">
                    <li><a href="javascript:void(0)" rel="regions" class="defaulttab">Regions</a></li>
                    <li><a href="javascript:void(0)" rel="partners">Partner References</a></li>
            </ul>
        </td>
    </tr>
    {*--------------------------------REGIONS-----------------------------*}
   {* <form id="frmRegion" onsubmit="return false;" name="frmRegion">*}
    <tr class="regions tab-content">
        <td width = "19%">
        	<strong id="notify_suburb" style="float: left">Suburb</strong>
        </td>
        <td >
        	<input type="text" name="suburb" id="suburb" class="input-text" onclick="partner_overlay.getData(this)" onkeyup="partner_overlay.moveByKey(event)" autocomplete="off" style="width:100%"/>
	        <ul>
                <div id="partner_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>

        <td width="19%" style="text-align:right"><strong id="notify_state">State</strong></td>
        <td style="text-align:right">
            <div id="inactive_state">
                <select name="state" id="state" class="input-select" style="width:100%" >
                      {html_options options=$subState}
                </select>
            </div>
            <input type="text" id="other_state" name="other_state" class="input-text" style="width:100%"/>
        </td>
    </tr>
    <tr class="regions tab-content">
        <td><strong id="notify_postcode">Postcode</strong></td>
        <td>
            <input type="text" name="postcode" id="postcode" style="width:100%" class="input-text validate-digit"
             autocomplete="off"/>
        </td>
        <td width="19%" style="text-align:right">
        	<strong id="notify_country">Country</strong>
        </td>
        <td >
             <select name="country" id="country" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options=$options_country selected = $form_data.country}
            </select>
            <input type="hidden" name="ID"/>
        </td>
    </tr>
    {*</form>*}
    <tr class="tab-content regions">
        <td colspan="4">
            <input type="button" class="button f-right" value="Add" onclick="agent.addRegion('#frmAgent','add-region')" />
        </td>
    </tr>

    <tr class="regions tab-content">
        <td></td>
        <td colspan="3">
            <div id="region">
            {*<table width="100%" class="grid-table" cellspacing="1" id="grid-table">
                <tr class="title">
                    <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Region</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Edit</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Delete</td>
                </tr>
                {if isset($regions) and is_array($regions) and count($regions) > 0}
                {assign var = i value = 0}
                {foreach from = $regions key = k item = region}
                {assign var = i value = $i+1}
                <tr class="item{if $i%2==0}1{else}2{/if}" id="row_{$region.ID}">
                    <td align="center">{$i}</td>
                    <td>
                        {$region.region}
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="agent.editRegion({$region.ID},'row')">Edit</a>
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="agent.deleteRegion({$region.ID},'row')">Delete</a>
                    </td>
                </tr>
                {/foreach}
                {/if}
            </table>*}
            </div>
        </td>
    </tr>

    {if $row.contact_references == 1}
    {*<form name="frmPartner" id="frmPartner">*}
    <tr class="partners tab-content">
        <td width = "19%">
        	<strong id="notify_company_name" style="float: left">Company</strong>
        </td>
        <td >
        	<input type="text" name="company_name" id="company" class="input-text" style="width:100%"/>
        </td>

        <td width="19%" style="text-align:right"><strong id="notify_address">Address</strong></td>
        <td style="text-align:right">
            <input type="text" id="address" name="address" class="input-text" style="width:100%"/>
        </td>
    </tr>
    <tr class="partners tab-content">
        <td><strong id="notify_telephone">Telephone</strong></td>
        <td>
            <input type="text" name="telephone" id="telephone" style="width:100%" value="{$form_data.postcode}" class="input-text validate-require validate-digit"
             autocomplete="off"/>
        </td>
        <td width="19%" style="text-align:right">
        	<strong id="notify_email">Email</strong>
        </td>
        <td >
            <input type="text" name="email_address" id="email" class="input-text validate-email" style="width:100%"
             autocomplete="off"/>
            <input type="hidden" name="ref_id"/>
        </td>
    </tr>
    {*</form>*}
    <tr class="tab-content partners">
        <td colspan="4">
            <input type="button" class="button f-right" value="Add" onclick="agent.addRegion('#frmAgent','add-partner')" />
        </td>
    </tr>
    <tr class="tab-content partners">
        <td></td>
        <td colspan="3">
            <div id="reference">
            {*<table width="100%" class="grid-table" cellspacing="1">
                <tr class="title">
                    <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Company</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Address</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Telephone</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Edit</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:60px;">Delete</td>
                </tr>
                {if isset($partners) and is_array($partners) and count($partners) > 0}
                {assign var = i value = 0}
                {foreach from = $partners key = k item = partner}
                {assign var = i value = $i+1}
                <tr class="item{if $i%2==0}1{else}2{/if}">
                    <td align="center">{$i}</td>
                    <td>
                        <b>{$partner.company_name}</b>
                        <br />
                        <i><a href="mailto:{$partner.email_address}">{$partner.email_address}</a></i>
                    </td>
                    <td>{$partner.address}</td>
                    <td>{$partner.telephone}</td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="">Edit</a>
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="">Delete</a>
                    </td>
                </tr>
                {/foreach}
                {/if}
            </table>*}
            </div>
         </td>
    </tr>
    {else}
        <tr class="tab-content partners">
            <td></td>
            <td colspan="3" class="hide">This partner don't want to share their partner references with you.</td>
        </tr>
    {/if}
<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<script type="text/javascript">
     var country_default = '{$form_data.country}';
     var token = '{$token}';
     {literal}
     onLoadSearch();
     $(document).ready(function() {
                $('.tabs a').click(function(){
                       switch_tabs($(this));
                });
                switch_tabs($('.defaulttab'));

                agent.prepareList('prepare-region','#region','');
                agent.prepareList('prepare-partner','#reference','');

                $('#country').bind('change',function(){
                        onLoadSearch();
                })
     });

     function switch_tabs(obj) {
         var id = obj.attr("rel");
         $('.tab-content').hide();
         $('.tabs a').removeClass("selected");
         $('.' + id).show();
         obj.addClass("selected");
         $('.message-box').hide();
     }

     var partner_overlay = new Search();
        partner_overlay._frm = '#frmRegion';
        partner_overlay._text_search = '#suburb';
        partner_overlay._text_obj_1 = '#state';
        partner_overlay._text_obj_2 = '#postcode';
        partner_overlay._overlay_container = '#partner_overlay';
        partner_overlay._url_suff = '&'+'type=suburb';

        partner_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                partner_overlay._total = info.length;
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

document.onclick = function() {partner_overlay.closeOverlay()};
     {/literal}
</script>