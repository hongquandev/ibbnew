<div class="bar-title">
    <h2>{localize translate="PROPERTY OFFERS"}</h2>
</div>
<div class="ma-info mb-20px message-acc-inbox">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount" style="margin-top: 10px">
                {if isset($action_ar[0])}
                    {if isset($message) and strlen($message) > 0}
                        <div class="message-box message-box-dashbord">{$message}</div>
                    {/if}
                    {if in_array($action_ar[0], array('view','delete'))}
                        {if true}
                            <div class="ma-messages mb-20px">
                                <a style="margin: 10px 0; float: right" target="_blank" href="/?module=agent&action=export_csv_property_offers">
                                    <button class="btn-pv"><span>Export CSV</span></button>
                                </a>
                                <br/>
                                <table style="width: 100%; clear: both" class="tbl-messages tbl-messages2 tbl-my-registered-bidders" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col width="5%"/>
                                        <col width="7%"/>
                                        <col width="20%"/>
                                        <col width="10%"/>
                                        <col width="10%"/>
                                        <col width="5%"/>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <td>
                                                No
                                            </td>
                                            <td>
                                                Pro ID
                                            </td>
                                            <td>
                                                Offer Details
                                            </td>
                                            {*<td>
                                                Offer Price
                                            </td>*}
                                            <td>
                                                Date of offer
                                            </td>
                                            <td style="text-align: center">Status</td>
                                            <td style="text-align: center">Actions</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {if is_array($rows) and count($rows) > 0}
                                            {foreach from = $rows key = i item = row}
                                                <tr id="tr_register_{$i+1}">
                                                    <td style="text-align:center;padding: 8px;font-size: 13px">{math equation = "(p-1) * len + (i+1)"
                                                        p = $p
                                                        len = $len
                                                        i = $i
                                                        }
                                                    </td>
                                                    <td>
                                                        {$row.property_id}
                                                    </td>
                                                    <td>
                                                        --- From Buyer ---<br>
                                                        Agent ID#{$row.agent_from_id}
                                                        <br>
                                                        Name: {$row.agent_from_name}
                                                        <br>
                                                        Email Address: {$row.agent_from_email_address}
                                                        {*<span id="show_more" onclick="showmore('#tr_register_{$i+1}')">Show more</span>
                                                        <br>*}
                                                        <br/>
                                                        <a href="javascript:void(0)" style="font-weight: bold; font-style: italic;text-decoration: underline;" onclick="viewUserDetail(this)">View user detail</a>
                                                        <br/>
                                                        <br/>
                                                        <div class="rb-user-detail" style="display: none">
                                                            <span>Driver License:</span><span style="padding-left: 10px;font-style: italic; " >{if $row.agent_from_term}<a href="{$ROOTURL}{$row.agent_from_term.file_drivers_license_link}" target="_blank">click here</a>{else}Not yet upload{/if}</span><br/>
                                                            <span>Passport Birth:</span><span style="padding-left: 10px;font-style: italic;">{if $row.agent_from_term}<a href="{$ROOTURL}{$row.agent_from_term.file_passport_birth_link}" target="_blank">click here</a>{else}Not yet upload{/if}</span><br/>
                                                            <span>Fullname:</span><span style="padding-left: 10px;font-style: italic;">{$row.agent_from_name}</span><br/>
                                                            <span>Phone Number:</span><span style="padding-left: 10px;font-style: italic;">{if $row.agent_from_phone_number}{$row.agent_from_phone_number}{else}None{/if}</span><br/>
                                                        </div>
                                                        <div id="more_detail" style="display: block;">
                                                            {*<span id="show_less" onclick="showmore('#tr_register_{$i+1}')">Show less</span>*}
                                                            <br>
                                                            --- Details ---<br>
                                                            {$row.property_details}
                                                            <br>
                                                        </div>
                                                        <br>
                                                        <a href="{$row.link_detail}" style="text-decoration: underline; color: #980000">View property</a>
                                                        <a href="javascript:void(0)"
                                                           onclick="showContact('{$authentic.id}','{$authentic.full_name}','{$authentic.email_address}','{$authentic.telephone}','{$row.agent_from_id}','')"
                                                           style="text-decoration: underline; color: #980000; margin-left: 10px">Contact User</a>
                                                    </td>
                                                    {*<td>{$row.offer_price}</td>*}
                                                    <td style="text-align:center;">{$row.time}</td>
                                                    <td style="text-align:center;">{$row.status}</td>
                                                    <td style="text-align:center;font-size: 16px;">
                                                        <button onclick="onMakeAnOfferAccept('{$row.message_id}','{$row.property_id}')" style="float: left;width: 100px"
                                                                type="button" title="Accept" {$row.checkAccepted} class="btn-pv btn-po btn-status-{$row.checkAccepted}">
                                                            <span><span>Accept</span></span>
                                                        </button>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <button onclick="onMakeAnOfferRefuse('{$row.message_id}','{$row.property_id}')" style="float: left;width: 100px;"
                                                                type="button" title="Accept" {$row.checkAccepted} class="btn-pv btn-por btn-status-{$row.checkAccepted}">
                                                            <span><span>Refuse</span></span>
                                                        </button>
                                                    </td>
                                                    {literal}
                                                    <script type="text/javascript">
                                                    </script>
                                                    {/literal}
                                                </tr>
                                            {/foreach}
                                        {/if}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" style="padding: 5px 20px;">
                                            {if strlen($pag_str) > 0}
                                                {$pag_str}
                                                <span style="float: right; margin-top: 2px; margin-right:4px; ">{localize translate="Page"}: {$p} </span>
                                            {/if}
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        {/if}
                    {/if}
                {/if}
            </div>
        </div>
    <div class="clearthis">
    </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    function showmore(parent_id){
        var obj = jQuery('#more_detail',parent_id);
        console.log(obj);
        if(obj.css('display') == 'none'){
            obj.show();
            jQuery('#show_more',parent_id).hide();
        }else{
            obj.hide();
            jQuery('#show_more',parent_id).show();
        }
    }
    function onMakeAnOfferAccept(mess_id,property_id){
        showLoadingPopup();
        var url = '/modules/property/action.php?action=make_an_offer-accept';
        jQuery.post(url,{'message_id':mess_id,'property_id':property_id,'accept':'link'},function(result){
            closeLoadingPopup();
            var data = jQuery.parseJSON(result);
            if(data.onMakeAnOfferAccept){
                showMess__('Accept make an offer successful. Wait 3s to reload page');
            }else{
                showMess__(data.error);
            }
            setTimeout(function(){
                location.reload(true);
            },3000)
        },'html');
    }
    function onMakeAnOfferRefuse(mess_id,property_id){
        showLoadingPopup();
        var url = '/modules/property/action.php?action=make_an_offer-refuse';
        jQuery.post(url,{'message_id':mess_id,'property_id':property_id,'accept':'link'},function(result){
            closeLoadingPopup();
            var data = jQuery.parseJSON(result);
            if(data.onMakeAnOfferRefuse){
                showMess__('Refuse make an offer successful. Wait 3s to reload page');
                setTimeout(function(){
                    location.reload(true);
                },3000)
            }else{
                showMess__(data.error);
            }
        },'html');

    }
    function makeAnOfferAccept(){
        var action = getParameterByName('action');
        if(action == 'makeAnOfferAccept'){
            var mess_id = getParameterByName('mess_id');
            var property_id = getParameterByName('property_id');
            if(parseInt(mess_id) > 0 && parseInt(property_id) > 0){
                /*Check login*/
                if(parseInt(authentic_id) > 0){
                    onMakeAnOfferAccept(mess_id,property_id)
                }else{
                    login_cls.callback_fnc = function(){
                        onMakeAnOfferAccept(mess_id,property_id);
                    };
                    showLoginPopup();
                }
            }
            return true;
        }
        if(action == 'makeAnOfferRefuse'){
            var mess_id = getParameterByName('mess_id');
            var property_id = getParameterByName('property_id');
            if(parseInt(mess_id) > 0 && parseInt(property_id) > 0){
                /*Check login*/
                if(parseInt(authentic_id) > 0){
                    onMakeAnOfferRefuse(mess_id,property_id)
                }else{
                    login_cls.callback_fnc = function(){
                        onMakeAnOfferRefuse(mess_id,property_id);
                    };
                    showLoginPopup();
                }
            }
            return true;
        }
        return true;
    }
    function exportCSV() {
        window.location = "/modules/agent/index.php?action=export_csv_property_offers";
    }
</script>
{/literal}
{literal}
    <script type="text/javascript">
        function viewUserDetail(obj) {
            jQuery(obj).parent().find('.rb-user-detail').show();
        }
    </script>
{/literal}