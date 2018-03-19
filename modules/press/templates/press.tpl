<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/press/templates/style/style.css"/>
<div class="container-l">
    <div class="container-r">
        <div class="container col3-layout">
            <div class="main">
                {if $action == 'view-detail'}
                    {include file ="press.col2.tpl"}
                {else}
                    {include file ="press.col3.tpl"}
                {/if}
            </div>
        </div>
    </div>
</div>


