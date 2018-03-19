{include file = "`$ROOTPATH`/modules/property/templates/mobile/property.view.list.tpl"}
<script src="modules/agent/templates/js/delete.js" type="text/javascript"> </script>
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
var reg = "{$register}";
{literal}
/*$(document).ready(function(){
	if ($('#reg').val().length > 0){
		showMess('You want to register '+ reg +'. Please logout !');
	}
});*/
</script>
<style type="text/css" >
.tbl-info .col1rx li {
    background-color: none;
    margin: 1px 0;
    padding: 4px 10px;
}
.search-results .search-list .item .info .title span {
    color: #666666;
}
.sr-new-info p {
    color:#FD4D4E !important;
}
</style>

{/literal}
{literal}
    <script type="text/javascript">
        function changeNotification(obj,loading,id_div) {
            jQuery(loading).show();
            var value = jQuery(obj).attr('checked') ? 1: 0;
            if (id_div != ''){
                if (value == 1){
                    $(id_div).toggle();
                }
            }
            var dataString = '?'+jQuery(obj).attr('name')+'='+value;
            jQuery.ajax({
                type: "GET",
                url: '{/literal}{$ROOTURL}{literal}/modules/agent/json/agent.notification.json.php' + dataString,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    var obj = jQuery.parseJSON(msg);
                    jQuery(loading).hide();
                }
            });
        }
    </script>
{/literal}
<div class="bar-title">
    <h2>CONTROL CENTRE</h2>
</div>
<div class="ma-hello mb-20px">
	{if strlen($message) > 0}
    	<div class="message-box message-box-dashbord">{$message}</div>
    {/if}
    <h3>HELLO {$db_account_data.firstname|upper} {$db_account_data.lastname|upper}</h3>
    <p>
        From your Control Centre you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.
    </p>
</div>
<div class="ma-info mb-20px ma-info-dashboard">
    <div class="mb-20px">
            <h4>ACCOUNT INFORMATION</h4>
            {if isset($db_account_data) and is_array($db_account_data) and count($db_account_data)>0}
            <div>
                <p>
                    <a class="highlight-a" href="mailto:{$db_account_data.email_address}">{$db_account_data.email_address}</a>
                </p>
            </div>
            <div class="actions-set"style="margin-top: 15px;" >
                <a class="mail-icons" href="/?module={$module}&action=edit-account"><span class="edit-icon"></span><span>Change Password</span></a>
            </div>
            {/if}
    </div>
    <div class="mb-20px">
            <h4>MESSAGES</h4>
                <p style="margin-bottom: 5px">
                    <a class="mail-icons" href="/?module={$module}&action=view-message-inbox"><span class="inbox-icon"></span><span>Inbox</span></a>
                    <span>({if isset($db_message_data.num_inbox)}{$db_message_data.num_inbox}{else}0{/if})</span>
                    <span class="new-messages">({if isset($db_message_data.num_unread)}{$db_message_data.num_unread}{else}0 {/if} New messages)</span>
                </p>
                <p style="margin-bottom: 5px">
                    <a class="mail-icons" href="/?module={$module}&action=view-message-outbox"><span class="outbox-icon"></span><span>Outbox</span></a>
                    <span>({if isset($db_message_data.num_outbox)}{$db_message_data.num_outbox}{else}0{/if})</span>
                </p>
                <p>
                    <a class="mail-icons" href="/?module={$module}&action=view-message-draft"><span class="draft-icon"></span><span>Drafts</span></a>
                </p>
    </div>

    <div class="mb-20px">
        	{if $authentic.type != 'partner'}
                <h4>PERSONAL DETAILS</h4>
                	{if isset($db_personal_data) and is_array($db_personal_data) and count($db_personal_data)>0}
                        <div>
                            <p><strong>{$db_personal_data.firstname} {$db_personal_data.lastname}</strong></p>
                            <p>
                            	<i>
                                	{if $authentic.type == 'agent'}{$db_personal_data.c_email}{else}{$db_personal_data.email_address}{/if}
                                </i>
                            </p>
                            <br/>
                            <p>
                            	<strong>Address</strong><br/>
                                {if $authentic.type != 'agent'}
                                    {$db_personal_data.street}, {$db_personal_data.full_address}
                                {else}
                                    {$db_personal_data.address}, {$db_personal_data.company_full_address}
                                {/if}
                            </p>
                            {if in_array($authentic.type,array('agent','theblock'))}
                                <div class="format-desc">
                                    {$db_personal_data.description}
                                </div>
                            {/if}
                        </div>
                        <div class="actions-set" style="margin-top: 15px;">
                            <a class="mail-icons" href="/?module={$module}&action=edit-personal"><span class="edit-icon"></span><span>Edit</span></a>
                        </div>
                	{/if}
            {else}
                <h4>COMPANY DETAILS</h4>
                {if isset($db_personal_data) and is_array($db_personal_data) and count($db_personal_data)>0}
                    <div>
                        <p><strong>{$db_personal_data.firstname}</strong></p>
                        <p><i>{$db_personal_data.general_contact_partner}</i></p>
                        <br/>
                        <table>
                            <tr>
                                <td><strong>Address</strong></td>
                                <td>{$db_personal_data.street}</td>
                            </tr>
                                <tr>
                                <td></td>
                                <td>{$db_personal_data.full_address}</td>
                            </tr>
                            <tr>
                                <td><strong>Postal Address</strong></td>
                                <td>{$db_partner_data.postal_address}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{$db_partner_data.full_postal_address}</td>
                            </tr>
                        </table>
                        <div>
                            <img src="{$MEDIAURL}/store/uploads/banner/images/partner/{$db_partner_data.partner_logo}" alt="{$db_personal_data.firstname}" style="max-width:185px; max-height:154px;" />
                            <div class="clearthis"></div>
                        </div>
                        <div class="format-desc word-justify">
                            {$db_partner_data.description}
                        </div>
                    </div>
                {/if}
            {/if}
        </div>

        
    <div class="mb-20px">
			{if in_array($authentic.type,array('vendor','buyer'))}
                <h4>CONTACT DETAILS </h4>
                {if isset($db_contact_data) and is_array($db_contact_data) and count($db_contact_data)>0}
                    <div>
                        <p>{$db_contact_data.name}</p>
                        <p>{$db_contact_data.email}</p>
                        <p>{$db_contact_data.address} {$db_contact_data.suburb} {$db_contact_data.state_name} {$db_contact_data.postcode} {$db_contact_data.country_name}</p>
                    </div>
                    <div class="actions-set" style="margin-top: 15px;">
                        <a class="mail-icons" href="/?module={$module}&action=edit-contact"><span class="edit-icon"></span><span>Edit</span></a>
                    </div>
                {else}
                    <div class="actions-set" style="margin-top: 15px;">
                        <a class="mail-icons" href="/?module={$module}&action=edit-contact"><span class="edit-icon"></span><span>Add contact information</span></a>
                    </div>
                {/if}
         	{elseif in_array($authentic.type,array('agent','theblock'))}
                <h4>COMPANY DETAILS</h4>
                {if isset($company_data) and is_array($company_data) and count($company_data)>0}
                    <div>
                        <p><strong>{$company_data.company_name}</strong></p>
                        <p><i>{$company_data.email_address}</i></p>
                        <br/>
                        <p>
                            <strong>Address</strong><br/>
                            {$company_data.address}, {$company_data.full_address}
                        </p>
                        {if $company_data.logo != ''}
                            <div>
                                <img src="{$MEDIAURL}/{$company_data.logo}" alt="{$company_data.company_name}" width="277" style="padding:10px 0"/>
                                <div class="clearthis"></div>
                            </div>
                        {/if}
                        <div class="format-desc word-justify">
                            {$company_data.description}
                        </div>
                    </div>
                {/if}
            {elseif $authentic.type == 'partner'}
                 <h4>NOTIFICATIONS</h4>
                 <div style="margin-bottom: 20px">
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_email) and $db_notification_data.notify_email==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="emailNotification" name="notify_email" value="1" {$ch}/>
                            Notification email address
                        </label>
                    </p>

                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_sms) and $db_notification_data.notify_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_sms" value="Notification SMS number" {$ch}/>
                            Notification SMS number
                        </label>
                    </p>

                    <p class="mb-5px" style="display:none">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_turnon_sms) and $db_notification_data.notify_turnon_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}

                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_turnon_sms" value="Turn on SMS Notification $$$ per xxx" {$ch}/>
                            Turn on SMS Notification $$$ per xxx
                        </label>
                    </p>
                    {*subscribe Nhung*}
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.subscribe) and $db_notification_data.subscribe==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="subscribe" name="subscribe" value="1" {$ch}/>
                            Subscribe to newsletter
                        </label>
                    </p>
                    <div class="loading" id="loading" ></div>
                 </div>

                <h4>MY SOCIAL MEDIA</h4>
                <div>
                {*facebook and twitter*}
                {if $tw.enable == 1}
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.allow_twitter) and $db_notification_data.allow_twitter==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading_1','#twitter_detail');" id="allow_twitter" name="allow_twitter" value="1" {$ch}/>
                            <a href="javascript:void(0)" onclick="$('#twitter_detail').toggle();">Twitter</a>
                        </label>
                    </p>
                    <div id="twitter_detail" style="display:none">
						{include file='agent.dashboard.twitter.tpl'}
                    </div>
                {/if}

                {if $fb.enable == 1}
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.allow_facebook) and $db_notification_data.allow_facebook==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading_1','#facebook_detail');" id="allow_facebook" name="allow_facebook" value="1" {$ch}/>
                            <a href="javascript:void(0)" onclick="$('#facebook_detail').toggle();">Facebook</a>
                        </label>
                    </p>
                    <div id="facebook_detail" style="display:none">
                        {include file='agent.dashboard.facebook.tpl'}
                    </div>
                {/if}
                <div class="loading" id="loading_1" ></div>
            </div>
         	{/if}
    </div>
    <div class="mb-20px">
         	{if in_array($authentic.type,array('vendor','buyer'))}
                <h4>LAWYERS DETAILS</h4>
                {if isset($db_lawyer_data) and is_array($db_lawyer_data) and count($db_lawyer_data)>0}
                    <div>
                        <p>{$db_lawyer_data.name}</p>
                        <p>{$db_lawyer_data.email}</p>
                        <p>{$db_lawyer_data.address} {$db_lawyer_data.suburb} {$db_lawyer_data.state_name} {$db_lawyer_data.postcode} {$db_lawyer_data.country_name}</p>
                        <p class="mb-5px" style="margin-top: 5px;">
                            <label>
                                {assign var='ch' value=''}
                                {if isset($db_notification_data.allow_lawyer) and $db_notification_data.allow_lawyer == 1}
                                    {assign var='ch' value='checked'}
                                {/if}
                                <input type="checkbox" onclick="changeNotification(this,'#loading_lawyer','');" id="lawyerNotification" name="allow_lawyer" value="1" {$ch}/>
                                Allow send mail to Lawyer
                            </label>
                        </p>
                        <div class="loading" id="loading_lawyer" ></div>
                    </div>
                    <div class="actions-set" style="margin-top: 15px;">
                        <a class="mail-icons" href="/?module={$module}&action=edit-lawyer"><span class="edit-icon"></span><span>Edit</span></a>
                    </div>
                {else}
                    <div class="actions-set" style="margin-top: 15px;">
                        <a class="mail-icons" href="/?module={$module}&action=edit-lawyer"><span class="edit-icon"></span><span> Add Lawyer information</span></a>
                    </div>
                {/if}
         	{elseif in_array($authentic.type,array('agent'))}
                <h4>{if $authentic.parent_id > 0}PACKAGE DETAILS{else}PACKAGE AND BILLING{/if}</h4>
                {if isset($package_data) and is_array($package_data) and count($package_data)>0}
                    <div>
                        <p>
                        	<strong>Current Package</strong><br/>
                            {$package_data.title}
                        </p>
                        <br/>
                        <p>
                            <strong>Expire</strong><br/>
                            {$package_data.expire}
                        </p>
                    </div>
                {/if}
         	{/if}
        </div>

    <div class="mb-20px">
            {*move script*}
            {if $authentic.type != 'partner'}
                <h4>NOTIFICATIONS</h4>
                <div>
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_email) and $db_notification_data.notify_email==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="emailNotification" name="notify_email" value="1" {$ch}/>
                            Notification email address
                        </label>
                    </p>

                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_sms) and $db_notification_data.notify_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_sms" value="Notification SMS number" {$ch}/>
                            Notification SMS number
                        </label>
                    </p>

                    <p class="mb-5px" style="display:none">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_turnon_sms) and $db_notification_data.notify_turnon_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}

                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_turnon_sms" value="Turn on SMS Notification $$$ per xxx" {$ch}/>
                            Turn on SMS Notification $$$ per xxx
                        </label>
                    </p>
                    {*subscribe Nhung*}
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.subscribe) and $db_notification_data.subscribe==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="subscribe" name="subscribe" value="1" {$ch}/>
                            Subscribe to newsletter
                        </label>
                    </p>
                    <div class="loading" id="loading" ></div>
                </div>
            {else}
                <h4 style="display: none;">NOTIFICATIONS</h4>
                <div  style="display: none;">
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_email) and $db_notification_data.notify_email==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="emailNotification" name="notify_email" value="1" {$ch}/>
                            Notification email address
                        </label>
                    </p>

                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_sms) and $db_notification_data.notify_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_sms" value="Notification SMS number" {$ch}/>
                            Notification SMS number
                        </label>
                    </p>

                    <p class="mb-5px" style="display:none">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.notify_turnon_sms) and $db_notification_data.notify_turnon_sms==1}
                                {assign var='ch' value='checked'}
                            {/if}

                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" name="notify_turnon_sms" value="Turn on SMS Notification $$$ per xxx" {$ch}/>
                            Turn on SMS Notification $$$ per xxx
                        </label>
                    </p>
                    {*subscribe Nhung*}
                    <p class="mb-5px">
                        <label>
                            {assign var='ch' value=''}
                            {if isset($db_notification_data.subscribe) and $db_notification_data.subscribe==1}
                                {assign var='ch' value='checked'}
                            {/if}
                            <input type="checkbox" onclick="changeNotification(this,'#loading','');" id="subscribe" name="subscribe" value="1" {$ch}/>
                            Subscribe to newsletter
                        </label>
                    </p>
                    <div class="loading" id="loading" ></div>
                </div>
            {/if}
        </div>
    <div class="mb-20px">
            {if $authentic.type != 'partner'}
                <h4>MY SOCIAL MEDIA</h4>
                <div>
                    {*facebook and twitter*}
                    {if $tw.enable == 1}
                        <p class="mb-5px">
                            <label>
                                {assign var='ch' value=''}
                                {if isset($db_notification_data.allow_twitter) and $db_notification_data.allow_twitter==1}
                                    {assign var='ch' value='checked'}
                                {/if}
                                <input type="checkbox" onclick="changeNotification(this,'#loading_1','#twitter_detail');" id="allow_twitter" name="allow_twitter" value="1" {$ch}/>
                                <a href="javascript:void(0)" onclick="$('#twitter_detail').toggle();">Twitter</a>
                            </label>
                        </p>
                        <div id="twitter_detail" style="display:none">
                            {include file='agent.dashboard.twitter.tpl'}
                        </div>
                    {/if}

                    {if $fb.enable == 1}
                        <p class="mb-5px">
                            <label>
                                {assign var='ch' value=''}
                                {if isset($db_notification_data.allow_facebook) and $db_notification_data.allow_facebook==1}
                                    {assign var='ch' value='checked'}
                                {/if}
                                <input type="checkbox" onclick="changeNotification(this,'#loading_1','#facebook_detail');" id="allow_facebook" name="allow_facebook" value="1" {$ch}/>
                                <a href="javascript:void(0)" onclick="$('#facebook_detail').toggle();">Facebook</a>
                            </label>
                        </p>
                        <div id="facebook_detail" style="display:none">
                            {include file='agent.dashboard.facebook.tpl'}
                        </div>
                    {/if}
                    <div class="loading" id="loading_1" ></div>
                </div>
            {else}
                 <h4 style="display: none;">MY SOCIAL MEDIA</h4>
                 <div style="display: none;">
                    {*facebook and twitter*}
                    {if $tw.enable == 1}
                        <p class="mb-5px">
                            <label>
                                {assign var='ch' value=''}
                                {if isset($db_notification_data.allow_twitter) and $db_notification_data.allow_twitter==1}
                                    {assign var='ch' value='checked'}
                                {/if}
                                <input type="checkbox" onclick="changeNotification(this,'#loading_1','#twitter_detail');" id="allow_twitter" name="allow_twitter" value="1" {$ch}/>
                                <a href="javascript:void(0)" onclick="$('#twitter_detail').toggle();">Twitter</a>
                            </label>
                        </p>
                        <div id="twitter_detail" style="display:none">
                            {include file='agent.dashboard.twitter.tpl'}
                        </div>
                    {/if}

                    {if $fb.enable == 1}
                        <p class="mb-5px">
                            <label>
                                {assign var='ch' value=''}
                                {if isset($db_notification_data.allow_facebook) and $db_notification_data.allow_facebook==1}
                                    {assign var='ch' value='checked'}
                                {/if}
                                <input type="checkbox" onclick="changeNotification(this,'#loading_1','#facebook_detail');" id="allow_facebook" name="allow_facebook" value="1" {$ch}/>
                                <a href="javascript:void(0)" onclick="$('#facebook_detail').toggle();">Facebook</a>
                            </label>
                        </p>
                        <div id="facebook_detail" style="display:none">
                            {include file='agent.dashboard.facebook.tpl'}
                        </div>
                    {/if}
                    <div class="loading" id="loading_1" ></div>
                </div>
            {/if}
    </div>
    <div class="mb-20px">
        <h4>MY REGISTERED BIDDERS</h4>
        <div class="actions-set" style="margin-top: 15px;">
            <a class="mail-icons" href="/?module={$module}&action=view-registered_bidders"><span class="edit-icon"></span><span>{localize translate="View registered bidders for approved"}</span></a>
        </div>
    </div>
</div>