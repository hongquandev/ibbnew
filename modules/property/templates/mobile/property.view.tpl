<div class="container-l">
    
    <div class="container-r">
    	<img id="banner-header" src="" style="width:100%;display:none"/>
        <div class="container">{$mode2}
            {if $action == "view-tv-show"}
            {include file = "`$module`.view.tv.show.tpl"}
                {else}
                <div class="col-main">
                    {if in_array($action,array('view-auction-list','view-passedin-list','view-sale-list','view-forthcoming-list','view-live_agent-list','view-forthcoming_agent-list','search', 'search-auction', 'search-sale','search-agent-auction','search-ebiddar'))}
                    {include file = "`$module`.view.`$mode`.tpl"}
                        <!-- DUC CODING SHOW SEARCH PARTNER TEMPLATES -->
                        {elseif $action == 'view-search-partner'}
                    {include file = "`$module`.search.partner.tpl"}
                        {elseif $action == 'search-partner' and isset($mode) and $mode == 'grid'}
                    {include file="property.search.partner.tpl"}
                        {elseif $action == 'search-partner' and $mode != 'grid'}
                    {include file="property.search.partner.tpl"}
                        <!-- END DUC CODING -->
                        {elseif $action == 'search-agent'}
                    {include file = "search.agent.viewmode.list.tpl"}
                        {elseif $action == 'view-search-advance-agent'}
                    {include file = "property.search.agent.tpl"}
                        {elseif $action == 'bid-history-full'}
                    {include file = "`$module`.bid-history-full.tpl"}
                        {elseif in_array($action, array('view-search-advance','view-search-advance-auction','view-search-advance-sale','view-search-advance-ebiddar','view-search-advance-agent-auction'))}
                    {include file = "`$module`.view.search.advance.tpl"}
                        {elseif in_array($action, array('view-auction-detail','view-sale-detail','view-forthcoming-detail','view-passedin-detail', 'view-detail'))}
                    {include file = "`$module`.view.detail.tpl"}
                        {elseif in_array($action, array('view-auction-agent_detail','view-sale-agent_detail','view-forthcoming-agent_detail'))}
                    {include file = "`$module`.view.agent_detail.tpl"}
                    {/if}
                </div>
            {/if}
            <div class="clearthis"></div>
        </div>
	<img id="banner-footer" src="" style="width:100%;display:none"/>        
    </div> 
</div>
