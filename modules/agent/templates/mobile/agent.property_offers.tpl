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
                                <table style="width: 100%" class="tbl-messages tbl-messages2 tbl-my-registered-bidders" cellpadding="0" cellspacing="0">
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
                                                        <br>
                                                        <br>
                                                        --- Details ---<br>
                                                        {$row.property_details}
                                                        <br>
                                                        <br>
                                                        <a href="{$row.link_detail}" style="text-decoration: underline; color: #980000">View property</a>
                                                    </td>
                                                    {*<td>{$row.offer_price}</td>*}
                                                    <td style="text-align:center;">{$row.time}</td>
                                                    <td style="text-align:center;">{$row.status}</td>
                                                    <td style="text-align:center;font-size: 16px;">
                                                        <button onclick="onMakeAnOfferAccept('{$row.message_id}','{$row.property_id}')" style="float: left;width: 100px" type="button" title="Accept" class="btn-pv btn-po">
                                                            <span><span>Accept</span></span>
                                                        </button>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <button onclick="onMakeAnOfferRefuse('{$row.message_id}','{$row.property_id}')" style="float: left;width: 100px" type="button" title="Accept" class="btn-pv btn-por">
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
                                                <span style="float: right; margin-top: 2px; margin-right:4px; ">{localize translate="Page"}: </span>
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
    function onMakeAnOfferAccept(mess_id,property_id){
        showLoadingPopup();
        var url = '/modules/property/action.php?action=make_an_offer-accept';
        jQuery.post(url,{'message_id':mess_id,'property_id':property_id,'accept':'link'},function(result){
            closeLoadingPopup();
            var data = jQuery.parseJSON(result);
            if(data.onMakeAnOfferAccept){
                showMess__('Accept make an offer successful. Wait 3s to reload page');
                setTimeout(function(){
                    location.reload(true);
                },3000)
            }else{
                showMess__(data.error);
            }
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
</script>
{/literal}