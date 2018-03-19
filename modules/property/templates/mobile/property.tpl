<script type="text/javascript" src="/modules/general/templates/js/helper.js"></script>
<script type="text/javascript" src="/modules/general/templates/mobile/js/jquery.fileDownload.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/jquery.scrollTo-1.4.2.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/jquery.localscroll-min.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/validate.js"></script>
<script type="text/javascript" language="javascript" src="/modules/agent/templates/js/loginpopup.js" ></script>

{*<script type="text/javascript" src="modules/general/templates/js/jquery.tipsy.js"></script>*}
<script type="text/javascript" src="/modules/general/templates/mobile/js/term.popup.js"></script>
<script src="/modules/general/templates/mobile/js/confirm.js" type="text/javascript"></script>
<script type="text/javascript" src="/modules/property/templates/mobile/js/property.js"></script>
<link href="/modules/{$module}/templates/mobile/style/styles.css" type="text/css" rel="stylesheet"/>
<link href="/modules/{$module}/templates/mobile/style/style1.css" type="text/css" rel="stylesheet"/>
<link href="/modules/calendar/templates/style/calendar.css" type="text/css" rel="stylesheet"/>
<link href="/modules/general/templates/shadowbox/shadowbox.css" type="text/css" rel="stylesheet"/>
{*<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>*}
 
{*<script type="text/javascript" src="modules/general/templates/js/partner_popup.js"></script> *}
{assign var="path" value="`$ROOTPATH`/modules/`$module`/templates/"}
{if in_array($action,array('register'))}
    {include file="`$module`.`$action`.tpl"}
{elseif $action == 'bid-history-full'}
    {include file="`$module`.view.tpl"}
{elseif eregi('^view',$action) or in_array($action, array('search', 'search-auction', 'search-sale', 'search-ebiddar','search-agent-auction','search-partner','search-agent'))}
	{if file_exists("`$path`mobile/`$module`.view.tpl")}
        {include file="`$module`.view.tpl"}
    {else}
        {include file= "`$path``$module`.view.tpl"}
    {/if}
{else}
	Can not find the template with this request.
{/if}
