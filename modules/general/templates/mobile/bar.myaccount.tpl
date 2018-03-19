<div class="block account first">
    <h1 class="f-left">Hi {$authentic.full_name}</h1>
    <a href="{$logout_url}" class="log-out f-right"></a>
    <div class="clearthis"></div>
</div>
<div class="block">
    <div class="title">Account Information</div>
    <ul class="sub-nav">
        <li>
            <a href="javascript:void(0)" onclick="window.location = '/index.php?module=agent&action=view-dashboard'">My Control Centre</a>
        </li>
        {if $authentic.type == 'partner'}
            {*<li><a href="/?module=agent&action=edit-personal">My Company Details</a></li>
            <li><a href="/?module=agent&action=edit-company">My Extra Company Details</a></li>*}
        {elseif in_array($authentic.type,array('vendor','buyer'))}
            <li><a href="/?module=agent&action=edit-personal">My Personal Information</a></li>
            <li><a href="/?module=agent&action=edit-lawyer">My Lawyer Information</a></li>
            <li><a href="/?module=agent&action=edit-contact">My Contact Details</a></li>
        {else}
            <li><a href="/?module=agent&action=edit-personal">My Account Information</a></li>
        {/if}
        {*
        {if $authentic.parent_id == 0}
            <li><a href="/?module=agent&action=edit-company">My Company Information</a></li>
        {/if}
        {if $authentic.type == 'agent'}
            <li><a href="/?module=agent&action=view-payment">My Package Information</a></li>
        {/if}*}
        <li><a href="/?module=agent&action=view-my_offers">My Offers</a></li>
        <li><a href="/?module=agent&action=view-property_offers">Property Offers</a></li>
        <li style="position:relative"><a href="/?module=agent&action=view-message">My Messages</a>
            <span class="number">{$rights.num_unread}</span>
        </li>
        <li><a href="/?module=agent&action=view-property">My Property Lists</a></li>
        <li><a href="/?module=agent&action=view-watchlist">My Watchlist</a></li>
        <li><a href="/?module=agent&action=view-registered_bidders">My Registered Bidders</a></li>
        <li><a href="/?module=agent&action=view-property_bids">My Property Bids - <br>Registered to Bid</a></li>
    </ul>
</div>
{*<div class="block">
    <div class="title">{if $authentic.type == 'partner'}Manage Banners{else}Manage Properties{/if}</div>
    <ul class="sub-nav">
        {if $authentic.type == 'partner'}
            <li><a href="javascript:void(0)" onclick="check.regPro('/?module=banner&action=edit-advertising')">Register New
                Banner</a></li>
            <li><a href="/?module=banner&action=my-banner">My Banner Details</a></li>
            {else}
            <li><a href="javascript:void(0)" onclick="check.regPro('/?module=property&action=register')">Register New
                Property</a></li>
            <li><a href="/?module=agent&action=view-property">My Property Details</a></li>
        {/if}
            <li><a href="/?module=agent&action=view-report">My Reports</a></li>
    </ul>
</div>*}
{*<div class="block">
    *}{*<div class="title">My Lists</div>*}{*
    <ul class="sub-nav">
        <li><a href="/?module=agent&action=view-property">My Property Lists</a></li>
        <li><a href="/?module=agent&action=view-watchlist">My Watchlist</a></li>
        <li><a href="/?module=agent&action=view-property_bids">My Property Bids - <br>Registered to Bid</a></li>
    *}{*{if $authentic.type != 'partner'}
        <li><a href="/?module=emailalert&action=ali-email">My Email Alert</a></li>
        <li><a href="/?module=agent&action=edit-notification">My Notifications</a></li>
    {/if}*}{*
    </ul>    
</div>*}

{*{if in_array($authentic.type, array('theblock','agent')) && $authentic.parent_id == 0}
<div class="block">
    <div class="title">Manage Users</div>
    <ul class="sub-nav">
        <li><a href="/?module=agent&action=ali-user">New User</a></li>
        <li><a href="/?module=agent&action=view-user">My {$agent_type} Users</a></li>
    </ul>
</div>
{/if}*}