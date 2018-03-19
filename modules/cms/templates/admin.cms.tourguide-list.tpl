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
        session.action_link = '{$ROOTURLS}/modules/cms/action.admin.php?[1]&token={$token}';
		session.add_link = '?module=cms&action=tourguide-add&token={$token}';
        session.url_link = '?[1]&token={$token}';
		session.action_type = 'tourguide';
		session.token = '{$token}';
		session.grid_title = 'Tour Guide List';
</script>
<script type="text/javascript" src="/admin/js/ext-base.js"></script>
<script type="text/javascript" src="/admin/js/ext-all.js"></script>
<script type="text/javascript" src="/modules/cms/templates/js/paging-tourguide.en.js"></script>
<script type="text/javascript" src="/admin/js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="/admin/js/Ext.ux.grid.Search.js"></script>
