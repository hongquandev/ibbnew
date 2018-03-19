<script type="text/javascript" src="{$ROOTURL}/modules/general/templates/js/image-lightbox/imagelightbox.js"></script>
<div class="container-l">
    <div class="container-r">
    	<img id="banner-header" src="" style="width:950px;display:none"/>
        <div class="container col2-right-layout">{$mode2}
            <div class="main">
            	{if $action == "view-tv-show"}
                	 {include file = "`$module`.view.tv.show.tpl"}
				{elseif in_array($action, array('view-search-advance','view-search-advance-auction','view-search-advance-sale','view-search-advance-ebiddar','view-search-advance-bid2stay','view-search-advance-agent-auction'))}
                     {include file = "`$module`.view.search.advance.tpl"}  
                {elseif $action == 'view-search-advance-agent'}
                    {include file = "property.search.agent.tpl"}
                {else}
                    <div class="col-main">
                    	{if in_array($action,array('view-auction-list','view-passedin-list','view-sale-list','view-forthcoming-list','view-live_agent-list','view-forthcoming_agent-list','search', 'search-auction', 'search-sale','search-agent-auction','search-ebiddar', 'search-bid2stay'))}
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
                        {elseif $action == 'bid-history-full'}
                            {include file = "`$module`.bid-history-full.tpl"}
                        
                        {elseif in_array($action, array('view-auction-detail','view-sale-detail','view-forthcoming-detail','view-passedin-detail', 'view-detail'))}
                            {include file = "`$module`.view.detail.tpl"}
                        {elseif in_array($action, array('view-auction-agent_detail','view-sale-agent_detail','view-forthcoming-agent_detail'))}
                            {include file = "`$module`.view.agent_detail.tpl"}
                        {/if}
                    </div>
                
                    <div class="col-right">
                        {if in_array($action, array('view-auction-list','view-sale-list','search', 'view-passedin-list','search-auction','search-sale','search-ebiddar','search-agent-auction','view-forthcoming-list','bid-history-full','view-forthcoming_agent-list','view-live_agent-list'))}
                            {*{include file = "`$ROOTPATH`/modules/general/templates/quicksearch.tpl"}*}
                        {/if}
                        <!-- SHOW TEMPLATES SEARCH RIGHT -->
                        {if $action == 'search-partner'}
                            {*{include file = "`$ROOTPATH`/modules/general/templates/partner.quicksearch.tpl"}*}
                        {/if}

                        {if $action == 'search-agent'}
                           {* {include file = "`$ROOTPATH`/modules/general/templates/agent.quicksearch.tpl"}*}
                        {/if}

                        {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                    </div>
                {/if}
                <div class="clearthis"></div>
            </div>
        </div>
		<img id="banner-footer" src="" style="width:950px;display:none"/>        
    </div>
</div>

<script>
    var url = '/modules/theblock/action.php?action=load-banner';
	var id = {php}echo getParam('id', 0);{/php};
	var link_page = '{php}echo $_SERVER['REDIRECT_URL'];{/php}';
{literal}	
    $.post(url, {id:id, link_page:link_page}, function(data) {
        var result = jQuery.parseJSON(data);
        if (!result.error) {
			if (result.content.link_header.length > 0) {
				$('#banner-header').show();
				$('#banner-header').attr('src', result.content.link_header);
			}
			
			if (result.content.link_footer.length > 0) {
				$('#banner-footer').show();
				$('#banner-footer').attr('src', result.content.link_footer);
			}
        }
    }, 'html');
{/literal}	
</script>
