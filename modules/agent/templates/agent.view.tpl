{if $action != 'view-partner-list'}
    <script type="text/javascript">
        var agent = new Agent();
    </script>
    <div class="container-l">
        <div class="container-r">
            <div class="container col2-right-layout">
                <div class="main">
                    <div class="col-main myaccount">
                        {if $action == 'add-info'}
                            {include file = "agent.information.tpl"}
                        {elseif $action == 'add-info-partner'}
                            {include file = "agent.information.partner.tpl"}
                        {elseif $action == 'add-user'}
                            {include file = "agent.user.form.tpl"}
                        {elseif strlen($action_ar[1])>0}
                            {if $action_ar[1] == 'auction'}
                                {include file = "agent.property.tpl"}
                            {else}
                                {include file = "agent.`$action_ar[1]`.tpl"}
                            {/if}
                        {/if}
                    </div>
                    <div class="col-right">
                        {if $action_ar[1] == 'detail'}
                            {include file = 'agent.detail.right.tpl'}
                        {else}
                            {include file = 'agent.side.right.tpl' }
                        {/if}
                        <br clear="all"/>
                        {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                    </div>
                    <div class="clearthis">
                    </div>
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="container-l">
        <div class="container-r">
            <div class="container col2-right-layout">
                <div class="main">
                    <div class="col-main">
                        {if isset($mode) and $mode == 'grid'}
                            {include file="partner.view.grid.tpl"}
                        {else}
                            {include file="partner.view.list.tpl"}
                        {/if}
                    </div>
                    <div class="col-right">
                        <!-- SHOW TEMPLATES SEARCH RIGHT -->
                        {include file = "`$ROOTPATH`/modules/general/templates/partner.quicksearch.tpl"}
                        {if $action == 'search-partner'}
                        {else}
                            {*{include file = "`$ROOTPATH`/modules/general/templates/quicksearch.tpl"}*}
                        {/if}
                        {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                    </div>
                    <div class="clearthis"></div>
                </div>
            </div>
        </div>
    </div>
{/if}

