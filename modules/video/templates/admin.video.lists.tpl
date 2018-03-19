<table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
    {if $message}
	    <tr><td><div id="msgID" class="message-box">{$message}</div></td></tr>
    {/if}
    <tr><td><div id="topic-grid"></div></td></tr>
</table> 

<div id="blankDiv" style="position:absolute;left:0pt;top:0pt;visibility:hidden;"></div>
<script type="text/javascript">
    var session = new Object();
    var token = "{$token}";
    var show = "{$show}";
        session.action_link = '/modules/video/action.admin.php?[1]&token={$token}';
        {literal}
        if (show == 'full') {
            session.action_link = '/modules/video/action.admin.php?[1]&show=full&token='+ token;
        }
        {/literal}
		session.add_link = '?module=video&action=edit&token={$token}';
        session.url_link = '?[1]&token={$token}';
		session.action_type = 'page';
		session.token = '{$token}';
		session.grid_title = 'Video List';
</script>
<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="/modules/video/templates/js/paging.en.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
