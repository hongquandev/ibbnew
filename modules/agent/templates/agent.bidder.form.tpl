<script src="/modules/agent/templates/js/admin.js" type="text/javascript"></script>
<script src="/modules/property/templates/js/admin.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
	var agent = new Agent('#frmAgent');
    var pro = new Property('#frmAgent');
    {literal}
    var sug_agent = new Search();
        sug_agent._frm = '#frmProperty';
        sug_agent._text_search = '#agent_name';
        sug_agent._text_obj_1 = '#agent_id';
        sug_agent._overlay_container = '#sug_agent';
        sug_agent._url_suff = '&type=_agent';
        sug_agent._name_id = 'item_';
        sug_agent._location = '?module=agent&action=add-bidder&agent_id=[1]&token=';

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
		jQuery(sug_agent._text_search).removeClass('search_loading');
    }

    document.onclick = function() {
        sug_agent.closeOverlay();
    };
    {/literal}
</script>

<form  method="post" name="frmAgent" id="frmAgent" action="{$form_action}" enctype="multipart/form-data">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr >
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>
        </tr>
        <tr>
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">
                            <span class="adm-left">{$prev}</span>
                            Bid Information
                            <span class="adm-right">{$next}</span>
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
                                	{*{include file = 'admin.agent.bar.tpl'}*}
                                    <ul style="margin-top:21px;">
                                        <li><a href="/admin/?module=agent&action=manage-bidder&token={$token}">Bid & Register Bid List</a></li>
                                    </ul>
                                </td>
                                <td valign="top" style="position:relative">
                                    <div class="loading" style="display:none;position:absolute;top:300px;right:450px"><img src="/modules/general/templates/images/loading.gif"></div>
                                    <table width="100%" cellspacing="10" id="table">
                                        <tr>
                                            <td colspan="4">
                                                {if isset($message) and strlen($message) > 0}
                                                    <div class="message-box">{$message}</div>
                                                {/if}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="19%">
                                                <strong id="notify_agent_id">Agent <span class="require">*</span></strong>
                                            </td>
                                            <td width="30%">
                                                <input type="text" name="fields[agent_name]" id="agent_name"
                                                       value="{$form_data.agent_name}" onclick="sug_agent.getData(this)"
                                                       onkeyup="sug_agent.moveByKey(event)"
                                                       class="input-text"
                                                       style="width:100%"/>
                                                <input type="hidden" name="fields[agent_id]" id="agent_id"
                                                       value="{$form_data.agent_id}"/>
                                                <ul>
                                                    <div id="sug_agent" class="search_overlay"
                                                         style="display:none; position: absolute;"></div>
                                                </ul>
                                            </td>
                                            <td width="19%"></td>
                                            <td width="30%"></td>
                                        </tr>

                                        <tr id="search">
                                            <td><strong id="notify_property_id">Search property</strong></td>
                                            <td><input type="text" name="property_id" id="property_id" class="input-text" style="width:100%"/></td>
                                            <td><a style="color:#980000" href="javascript:void(0)"><small>Show all properties in live and forthcoming</small></a></td>
                                        </tr>

                                       {* <tr>
                                            <td></td>
                                            <td colspan="3" id="list_search"></td>
                                        </tr>
*}
                                        <tr>
                                            <td><strong>Registed bid List</strong></td>
                                            <td colspan="3">
                                                {include file="agent.bidder.table.tpl"}
                                            </td>
                                        </tr>
                                        {*<tr>
                                            <td><strong>Live Auction Properties <span class="require"></span></strong></td>
                                            <td>
                                                {foreach from=$options_live item=live}
                                                    <input class="bidder-check" type="checkbox" value="{$live.property_id}" name="auction[]"
                                                        {if isset($form_data.auction) && $form_data.auction != null && in_array($live.property_id,$form_data.auction)}checked="checked"{/if}
                                                        {if isset($form_data.has_bid) && $form_data.has_bid != null &&  in_array($live.property_id,$form_data.has_bid)}disabled="disabled"{/if}
                                                        > #{$live.property_id}{if $live.pro_type == 'theblock'} - The Block's pro{/if}<br />
                                                {/foreach}
                                            </td>
                                            <td><strong>Forthcoming Auction Properties <span class="require"></span></strong></td>
                                            <td>
                                                {foreach from=$options_forth item=forth}
                                                    <input class="bidder-check" type="checkbox" value="{$forth.property_id}" name="auction[]"
                                                    {if isset($form_data.auction) && $form_data.auction != null && in_array($forth.property_id,$form_data.auction)}checked="checked"{/if}
                                                    {if isset($form_data.has_bid) && $form_data.has_bid != null && in_array($forth.property_id,$form_data.has_bid)}disabled="disabled"{/if}
                                                    > #{$forth.property_id}{if $forth.pro_type == 'theblock'} - The Block's pro{/if}<br />
                                                {/foreach}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right">
                                                <hr/>
                                                <input type="button" class="button" value="Save" onclick="pro.validAgent('#frmAgent')"/>
                                                <input type="button" class="button" value="Back to List" onclick="document.location='/admin/?module=agent&action=manager-bidder&token={$token}'"/>
                                            </td>
                                        </tr>*}
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
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
<script type="text/javascript">
    var root = '{$ROOTURL}';
    {literal}
    $(document).ready(function(){
        $('a.add-property').bind('click', function() { $(this).attr("disabled", "disabled"); });
        $("a[disabled]").attr("onclick",'');
    });
        $('#property_id').bind('keypress',function(e){
           if (e.keyCode == 13){
                showProperty('');
           }
        });
        $('tr#search td').last().find('a').click(function(){
                $('#property_id').val('');
                showProperty('');
        });
        function showProperty(url){
            $('.loading').show();
            var url = '/modules/agent/action.admin.php?action=search-property&token='+$('#token').val()+url;
            $.post(url,{property_id:$('#property_id').val(),agent_id:$('#agent_id').val()},function(data){
                if ($('#result').length > 0){
                    $('tr#result').remove();
                }
                $('tr#search').after(data);
                $('.loading').hide();
            })
        }
        function showList(url){
            var url = '/modules/agent/action.admin.php?action=view-bidder&token='+$('#token').val()+url;
            $.post(url,{agent_id:$('#agent_id').val()},function(data){
                $('.edit-table').html(data);
            })
        }

        function addProperty(property_id,agent_id){
            $('.loading').show();
            if (agent_id == 0){
                alert('Please choosen a vendor/buyer !');
                return;
            }
            var url = '/modules/agent/action.admin.php?action=add-property&token='+$('#token').val();
            //$('#grid-table').
            $.post(url,{property_id:property_id,agent_id:agent_id},function(data){
                   if (data != 'error'){
                       $('.edit-table').html(data);
                   }                        
                   showProperty('');
            },'html')
        }


    {/literal}
</script>