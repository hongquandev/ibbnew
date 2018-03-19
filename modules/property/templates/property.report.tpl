{if isset($actualBid_rows)}
    {include file="`$ROOTPATH`/modules/property/templates/tabs.bid_report.tpl"}
{/if}
{if isset($rows)}
    {include file="`$ROOTPATH`/modules/property/templates/tabs.register_bid.tpl"}
{/if}
{if isset($no_more_bids_data)}
    {include file="`$ROOTPATH`/modules/property/templates/tabs.no_more_bids.tpl"}
{/if}
{if isset($logged_data)}
    {include file="`$ROOTPATH`/modules/property/templates/tabs.logged_in_bid.tpl"}
{/if}
