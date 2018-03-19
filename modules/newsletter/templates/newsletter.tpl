<script type="text/javascript" src="modules/general/templates/js/helper.js"></script>

<script type="text/javascript" src="modules/general/templates/js/jquery.scrollTo-1.4.2.js"></script>
<script type="text/javascript" src="modules/general/templates/js/jquery.localscroll-min.js"></script>
{literal}
<script type="text/javascript" language="javascript" src="modules/agent/templates/js/loginpopup.js" ></script>
{/literal}


{if in_array($action,array('unsubscribe'))}
	{include file="newsletter.unsubscribe.tpl"}
{else}
	Can not find the template with this request.
{/if}