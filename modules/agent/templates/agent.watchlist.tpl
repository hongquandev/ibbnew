{*{if $mode_fix != 'grid'}
{include file = 'agent.watchlist.list.tpl'}
{else}
{include file = 'agent.watchlist.grid.tpl'}
{/if}*}
{include file = "`$ROOTPATH`/modules/property/templates/property.view.`$mode`.tpl"}