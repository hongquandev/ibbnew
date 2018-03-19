<div id="container">
    <div id="topnav" class="topnav"> Hi {$authentic.full_name}
        <span>|</span>
        <a href="{$logout_url}" class="logout">Log out</a>
        <a href="javascript:void(0)" class="signin" id="signin-top"><span>My account</span></a>

    </div>
    <fieldset id="signin_menu">
        <div class="subnav-top">
            <ul>
                <li>
                    <dl>
                        <dt>Account Information</dt>
                        <dd><a href="javascript:void(0)" onclick="window.location = '/index.php?module=agent&action=view-dashboard'">Control Centre</a></dd>
                        {if $authentic.type == 'partner'}
                            <dd><a href="/?module=agent&action=edit-personal">My Company Details</a></dd>
                            <dd><a href="/?module=agent&action=edit-company">My Extra Company Details</a></dd>
                        {elseif in_array($authentic.type,array('vendor','buyer'))}
                            <dd><a href="/?module=agent&action=edit-personal">My Personal Information</a></dd>
                            <dd><a href="/?module=agent&action=edit-lawyer">My Lawyer Information</a></dd>
                            <dd><a href="/?module=agent&action=edit-contact">My Contact Details</a></dd>
                        {else}
                            <dd><a href="/?module=agent&action=edit-personal">My Account Information</a></dd>
                            {if $authentic.parent_id == 0}
                            <dd><a href="/?module=agent&action=edit-company">My Company Information</a></dd>
                            {/if}
                            {if $authentic.type == 'agent'}
                                <dd><a href="/?module=agent&action=view-payment">My Package Information</a></dd>
                            {/if}
                        {/if}
                        <dd style="position:relative"><a href="/?module=agent&action=view-message">My Messages</a>
                            <span class="number">{$rights.num_unread}</span></dd>
                    </dl>

                    <dl>
                        <dt>{if $authentic.type == 'partner'}Manage Banners{else}Manage Properties{/if}</dt>
                        {if $authentic.type == 'partner'}
                            <dd><a href="javascript:void(0)" onclick="check.regPro('/?module=banner&action=edit-advertising')">Register New Banner</a></dd>
                            <dd><a href="/?module=banner&action=my-banner">My Banner Details</a></dd>
                        {else}
                            <dd><a href="javascript:void(0)" onclick="check.regPro('/?module=property&action=register')">Register New Property</a></dd>
                            <dd><a href="/?module=agent&action=view-property">My Property Details</a></dd>
                        {/if}
                        <dd><a href="/?module=agent&action=view-report">My Reports</a></dd>
                    </dl>

                    
                    <dl>
                        <dt>My Lists</dt>
                        <dd><a href="/?module=agent&action=view-watchlist">My Watchlist</a></dd>
                        <dd><a href="/?module=agent&action=view-property_bids">My Property Bids - <br>Registered to Bid</a></dd>
                        {if $authentic.type != 'partner'}
                            <dd><a href="/?module=emailalert&action=add-email">My Email Alert</a></dd>
                            <dd><a href="/?module=agent&action=edit-notification">My Notifications</a></dd>
                        {/if}
                    </dl>


                    <div class="clearthis"></div>
                </li>
                <li>

                    {if in_array($authentic.type, array('theblock','agent')) && $authentic.parent_id == 0}
                    <dl>
                        <dt>Manage Users</dt>
                        <dd><a href="/?module=agent&action=add-user">Add New User</a></dd>
                        <dd><a href="/?module=agent&action=view-user">My {$agent_type} Users</a></dd>
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