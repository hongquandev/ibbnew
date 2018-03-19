{if $action == 'list-property'}
	<script type="text/javascript" src="/modules/sale/templates/js/property.paging.en.js"></script>
{else}
	<script type="text/javascript" src="/modules/sale/templates/js/banner.paging.en.js"></script>
{/if}

{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
    	{if $message}<tr><td><div id="msgID" class="message-box">{$message}</div></td></tr>{/if}
        <tr><td><div id="topic-grid"></div></td></tr>
    </table> 
	<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr><td><div class="message-box">You do not have permission to view this module.</div></td></tr>
    </table> 
{/if}

<script type="text/javascript">

</script>
