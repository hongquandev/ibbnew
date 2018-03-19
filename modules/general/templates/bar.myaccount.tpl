<div id="container">
    <div id="topnav" class="topnav">{localize translate="Hi"}  {$authentic.full_name}
        <span>|</span>
        <a href="{$logout_url}" class="logout">{localize translate="Log out"}</a>
        <a href="javascript:void(0)" style="background-color: #980000" class="signin" id="signin-top"><span>{localize translate="Control Centre"}</span></a>
    </div>
    <fieldset id="signin_menu">
        <div class="subnav-top">
            <ul>
                <li>
                    <dl>
                        <dt>{localize translate="Account Information"}</dt>
                        <dd><a href="javascript:void(0)" onclick="window.location = '/index.php?module=agent&action=view-dashboard'">{localize translate="My Control Centre"}</a></dd>
                        {if $authentic.type == 'partner'}
                            <dd><a href="/?module=agent&action=edit-personal">{localize translate="My Company Details"}</a></dd>
                            <dd><a href="/?module=agent&action=edit-company">{localize translate="My Extra Company Details"}</a></dd>
                        {elseif in_array($authentic.type,array('vendor','buyer'))}
                            <dd><a href="/?module=agent&action=edit-personal">{localize translate="My Personal Information"}</a></dd>
                            <dd><a href="/?module=agent&action=edit-lawyer">{localize translate="My Lawyer Information"}</a></dd>
                            <dd><a href="/?module=agent&action=edit-contact">{localize translate="My Contact Details"}</a></dd>
                        {else}
                            <dd><a href="/?module=agent&action=edit-personal">{localize translate="My Account Information"}</a></dd>
                            {if $authentic.parent_id == 0}
                            <dd><a href="/?module=agent&action=edit-company">{localize translate="My Company Information"}</a></dd>
                            {/if}
                            {if $authentic.type == 'agent'}
                                <dd><a href="/?module=agent&action=view-payment">{localize translate="My Package Information"}</a></dd>
                            {/if}
                        {/if}
                        <dd style="position:relative"><a href="/?module=agent&action=view-message">{localize translate="My Messages"}
                                {if $rights.num_unread > 0}<span style="color: #980000;font-size: 14px">({$rights.num_unread})</span>{/if}</a>
                            {*<span class="number">{$rights.num_unread}</span>*}
                        </dd>
                        <dd>
                            <a href="/?module=agent&action=view-my_offers">{localize translate="My Offers"}</a>
                        </dd>
                    </dl>

                    <dl>
                        <dt>{if $authentic.type == 'partner'}{localize translate="Manage Banners"}{else}{localize translate="Manage Properties"}{/if}</dt>
                        {if $authentic.type == 'partner'}
                            <dd><a href="javascript:void(0)" onclick="check.regPro('/?module=banner&action=edit-advertising')">{localize translate="Register New Banner"}</a></dd>
                            <dd><a href="/?module=banner&action=my-banner">{localize translate="My Banner Details"}</a></dd>
                        {else}
                            <dd><a href="javascript:void(0)" onclick="check.regPro('/?module=package')">{localize translate="Register New Property"}</a></dd>
                            <dd><a href="/?module=agent&action=view-property">{localize translate="My Property Details"}</a></dd>
                        {/if}
                        <dd><a href="/?module=agent&action=view-report">{localize translate="My Reports"}</a></dd>
                        <dd>
                            <a href="/?module=agent&action=view-property_offers">{localize translate="Property Offers"}</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>{localize translate="My Lists"}</dt>
                        <dd><a href="/?module=agent&action=view-watchlist">{localize translate="My Watchlist"}</a></dd>
                        <dd><a href="/?module=agent&action=view-registered_bidders">{localize translate="My Registered Bidders"}</a></dd>
                        <dd><a href="/?module=agent&action=view-property_bids">{localize translate="My Property Bids"} - <br>{localize translate="Registered to Bid"}</a></dd>
                        {if $authentic.type != 'partner'}
                            <dd><a href="/?module=emailalert&action=add-email">{localize translate="My Email Alert"}</a></dd>
                            <dd><a href="/?module=agent&action=edit-notification">{localize translate="My Notifications"}</a></dd>
                        {/if}
                    </dl>


                    <div class="clearthis"></div>
                </li>
                <li>

                    {if in_array($authentic.type, array('theblock','agent')) && $authentic.parent_id == 0}
                    <dl>
                        <dt>{localize translate="Manage Users"}</dt>
                        <dd><a href="/?module=agent&action=add-user">{localize translate="Add New User"}</a></dd>
                        <dd><a href="/?module=agent&action=view-user">{localize translate="My"} {$agent_type} {localize translate="Users"}</a></dd>
                    </dl>
                    {/if}
                    <div class="clearthis"></div>
                </li>
            </ul>
        </div>
    </fieldset>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        $(".signin").click(function(e) {
            e.preventDefault();
            $("fieldset#signin_menu").toggle();
            $(".signin").toggleClass("menu-open");
            if ($('fieldset#signin_menu').css('display') == 'block'){
                $('#container').css('background-color','white');
            }else{
                $('#container').css('background-color','#EEE');
            }

        });

        $("fieldset#signin_menu").mouseup(function() {
            return false
        });
        $(document).mouseup(function(e) {
            if ($(e.target).parent("a.signin").length == 0) {
                $(".signin").removeClass("menu-open");
                $("fieldset#signin_menu").hide();
                $('#container').css('background-color','#EEE');
            }
        });

    });
</script>
{/literal}