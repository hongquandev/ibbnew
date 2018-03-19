
<script type="text/javascript" src="/modules/general/templates/js/helper.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/jquery.scrollTo-1.4.2.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/jquery.localscroll-min.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/validate.js"></script>
{*<script type="text/javascript" src="modules/general/templates/js/jquery.tipsy.js"></script>*}
<script type="text/javascript" src="/modules/general/templates/js/term.popup.js"></script>
<script src="/modules/general/templates/js/confirm.js" type="text/javascript"></script>
<script type="text/javascript" src="/modules/property/templates/js/property.js"></script>
<script type="text/javascript" language="javascript" src="/modules/agent/templates/js/loginpopup.js" ></script>
<link href="/modules/{$module}/templates/style/styles.css" type="text/css" rel="stylesheet"/>
<link href="/modules/calendar/templates/style/calendar.css" type="text/css" rel="stylesheet"/>
{*<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>*}

{*<script type="text/javascript" src="modules/general/templates/js/partner_popup.js"></script> *}
{if in_array($action,array('register'))}
	{include file="`$module`.`$action`.tpl"}
{elseif $action == 'bid-history-full'}
    {include file="`$module`.view.tpl"}
{elseif eregi('^view',$action) or in_array($action, array('search', 'search-auction', 'search-sale', 'search-ebiddar','search-agent-auction','search-partner','search-agent'))}
	{include file="`$module`.view.tpl"}
{else}
    {include file="`$module`.`$action`.tpl"}
	{*Can not find the template with this request.*}
{/if}
