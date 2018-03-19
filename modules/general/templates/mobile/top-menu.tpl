<div id="menu" class="overthrow" style="display: none;">
{if isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0}
    {include file="bar.myaccount.tpl"}
{/if}
<div class="block {if !(isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0)}first{/if}">
    <div class="title">Main Menu</div>
    <ul>
        <li>
            <a href="{$ROOTURL}">HOMEPAGE</a>
        </li>
        {if !(isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0)}
        <li>
            <a href="{$ROOTURL}?module=agent&action=login">SIGN IN/SIGN UP</a>
        </li>
        {/if}
        {$top_menufrontend}
    </ul>
</div>
</div>
<div class="menu-trigger" id="trigger"></div>
<div class="menu-search"></div>
