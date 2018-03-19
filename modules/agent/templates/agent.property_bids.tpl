{*
{if $mode_fix !='grid'}
{include file = 'agent.property_bids.list.tpl'}
{else}
{include file = 'agent.property_bids.grid.tpl'}
{/if}*}
{include file = "`$ROOTPATH`/modules/property/templates/property.view.`$mode`.tpl"}
