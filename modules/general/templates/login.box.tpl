

<form name="frmLogin" id="frmLogin" method="post" action="/index.php?module=agent&action=login" onsubmit="login('frmLogin');return false;">
    {if isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0}
         <div class="showusername-field">
            Hi {$authentic.firstname} &nbsp;| &nbsp;
            <a style="color:#980000" href="/index.php?module=agent&action=view-dashboard">Control Centre</a>  &nbsp;| &nbsp;
            <a id="logout" style="color:#666666" href="{$logout_url}">Logout</a>
            <!--index.php?module=agent&action=logout-->
        </div>
    {else}
        <div class="username-field">
            <select name="fields[instance]" id="instance">
                {html_options options=$account_instances selected=""}
            </select>
            <input class="txt-username input-text" type="text" value="email" name="fields[username]" id="username"
                   onfocus="onFocusBlur(this,'focus')" onblur="onFocusBlur(this,'blur')"/>
            <div class="password-field">
                <input class="txt-password input-text disable-auto-complete" type="password" value="password"
                       name="fields[password]" id="password" onfocus="onFocusBlur(this,'focus')"
                       onblur="onFocusBlur(this,'blur')"/>
            </div>
            <div class="button-field">
                <input class="btn-login" type="submit" value=""/><input class="btn-register" type="button" value=""
                                                                        onclick="document.location='index.php?module=agent& action=landing'"/>
            </div>
        </div>

    {/if}
</form>