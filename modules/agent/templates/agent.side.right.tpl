<script type="text/javascript">
{*  var isBasic = {$check_agent};*}
  {literal}
//         function regBanner(){
//             if (isBasic){
//                var url = '?module=agent&action=add-info-partner';
//                showMess('Please complete your information before register a banner !',url);
//                return;
//             }
//             document.location='?module=banner&action=add-advertising';
//         }
  {/literal}
</script>


{* If Agent is Partners *}
  {if $authentic.type == 'partner'}
  <div class="refine-search-box">
    <div class="title">
        <h3>{localize translate="MY ACCOUNT"}</h3>
    </div>
    <div class="form">
        <ul class="myaccount-nav">
            <li>
                <a href="/?module=agent&action=view-dashboard">{localize translate="My Control Centre"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=edit-account">{localize translate="Change My Password"}</a>
            </li>
            <li>
            	<a href="/?module=agent&action=edit-personal">{localize translate="My Company Details"} </a>
            </li>
            <li>
            	<a href="/?module=agent&action=edit-company">{localize translate="My Extra Company Details"}</a>
            </li>
            <!--
            <li>

                <a href="?module=agent&action=edit-lawyer">My Lawyers Information</a>

            </li>
            <li>
                <a href="?module=agent&action=edit-contact">My Property Contact Details</a>
            </li> -->
           <!-- <li>
                <a href="javascript:void(0)" onclick="check.regPro('?module=banner&action=add-advertising','banner')">Register Banner Advertising </a>
            </li> -->
            <li>
                <a href="/?module=banner&action=my-banner"> {localize translate="My Banner Details"} </a>
            </li>
           {* <li>
                <a href="/?module=agent&action=view-creditcard">My Credit Card Details</a>
            </li>*}
            <li>
                <a href="/?module=agent&action=view-message">{localize translate="My Messages"} <span class="new-messages">({if isset($rights.num_unread)}{$rights.num_unread}{else}0 {/if} {localize translate="My Messages"})</span></a>
            </li>
            <li>
                <a href="/?module=agent&action=view-my_offers">{localize translate="My Offers"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-property_offers">{localize translate="Property Offers"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-property_bids">{localize translate="My Property Bids/Registered to Bid"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-watchlist">{localize translate="My Watchlist"} </a>
            </li>
           
            {*if $authentic.type == 'vendor'*}
            <li>
                <a href="/?module=agent&action=view-report">{localize translate="My Reports"} </a>
            </li>
            {*/if*}
            <li>
                <a href="/?module=agent&action=files-management">{localize translate="Files Management"}</a>
            </li>
        </ul>
    </div>
    <div class="bg-bottom">
    </div>
</div>
  {else}
        <div class="refine-search-box">
    <div class="title">
        <h3>{localize translate="MY ACCOUNT"}</h3>
    </div>
    <div class="form">
        <ul class="myaccount-nav">
            <li>
                <a href="/?module=agent&action=view-dashboard">{localize translate="My Control Centre"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=edit-account">{localize translate="Change My Password"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=edit-personal">{if in_array($authentic.type,array('agent','theblock'))}{localize translate=""}My Account Information{else}{localize translate="My Personal Information"}{/if}</a>
            </li>
            {if in_array($authentic.type,array('agent','theblock'))}
                {if $authentic.parent_id == 0}
                    <li>
                        <a href="/?module=agent&action=edit-company">{localize translate="My Company Information"}</a>
                    </li>
                {/if}
                {if $authentic.type == 'agent'}
                    <li>
                        <a href="/?module=agent&action=view-payment">{localize translate="My Package Information"}</a>
                    </li>
                {/if}
            {/if}
            {if !in_array($authentic.type,array('agent','theblock'))}
                <li>
                    <a href="/?module=agent&action=edit-lawyer">{localize translate="My Lawyers Information"}</a>
                </li>
                <li>
                    <a href="/?module=agent&action=edit-contact">{localize translate="My Contact Details"}</a>
                </li>
            {/if}
            {*<li>
                <a href="/?module=agent&action=view-creditcard">My Credit Card Details</a>
            </li>*}
            <li>
                <a href="/?module=agent&action=view-message">{localize translate="My Messages"} <span class="new-messages">({if isset($rights.num_unread)}{$rights.num_unread}{else}0 {/if} {localize translate="New messages"})</span></a>
            </li>
            {*if $authentic.type == 'vendor'*}
            <li>
                <a href="/?module=agent&action=view-property">{localize translate="My Property Details"}</a>
            </li>
            {*/if*}
            <li>
                <a href="/?module=agent&action=view-my_offers">{localize translate="My Offers"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-property_offers">{localize translate="Property Offers"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-registered_bidders">{localize translate="My Registered Bidders"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-property_bids">{localize translate="My Property Bids/Registered to Bid"}</a>
            </li>
            <li>
                <a href="/?module=agent&action=view-watchlist">{localize translate="My Watchlist"} </a>
            </li>
            <li>
                <a href="/?module=agent&action=edit-notification">{localize translate="My Communications & Notifications"}</a>
            </li>
            
             <li>
                <a href="/?module=emailalert&action=add-email">{localize translate="My Email Alerts"} </a>
            </li>
            {*if $authentic.type == 'vendor'*}
            <li>
                <a href="/?module=agent&action=view-report">{localize translate="My Reports"} </a>
            </li>
            {*/if*}
            {if $authentic.type == 'theblock' || $authentic.type == 'agent'}
                {if $authentic.parent_id == 0}
                <li>
                    <a href="/?module=agent&action=view-user">My {$agent_type} Users </a>
                </li>
                {/if}
            {/if}
            <li>
                <a href="/?module=agent&action=files-management">{localize translate="My Files Management"}</a>
            </li>
        </ul>
    </div>
    <div class="bg-bottom">
    </div>
</div>
  {/if}
<script type="text/javascript">
    var a_href_active = '/?module={$module}&action={php} echo $_GET['action']{/php}';
    {literal}
    $('ul.myaccount-nav li a').each(function(){
        var href = $(this).attr(('href'));
        if(href == a_href_active ){
            $(this).addClass('active');
        }
    });
    {/literal}
</script>




