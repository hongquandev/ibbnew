<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main myaccount">
                    {if strlen($action_ar[1])>0}                   
                    	    {include file = "agent.list.`$action_ar[1]`.tpl"}
                    {/if}
                </div>
                <div class="col-right">
                    {if $action_ar[1] == 'partner'}
                    {else}
                        {include file = "`$ROOTPATH`/modules/general/templates/quicksearch.tpl"}
                    {/if}
                    {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>