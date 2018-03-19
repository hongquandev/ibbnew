{if $form_data.view == 'agent'}
    <div class="auctions-box agency-box">
        {include file = "`$ROOTPATH`/modules/property/templates/agent.search.view.top-bar.tpl"}
        <div class="clearthis"></div>
    </div>
    <div class="content-details">
            {include file="`$ROOTPATH`/modules/property/templates/agent.list.box.agent.tpl"}
    </div>
{elseif $form_data.view == 'property'}
    {include file = "`$ROOTPATH`/modules/property/templates/property.view.$mode.tpl"}
{/if}