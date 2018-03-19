<script type="text/javascript" src="/modules/banner/templates/js/admin.js"> </script>
{if $action == 'edit'}
	{include file = 'admin.banner.edit.tpl'}
{else}
    <div style="width:100%">
        <table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
            {if $message}<tr><td><div id="msgID" class="message-box">{$message}</div></td></tr>{/if}
            <tr><td><div id="topic-grid"></div></td></tr>
        </table>
    </div>
    <script type="text/javascript" src="js/ext-base.js"></script>
    <script type="text/javascript" src="js/ext-all.js"></script>
    <script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
    <script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
    <script type="text/javascript" src="/modules/banner/templates/js/pagings.en.js"></script>
    <script type="text/javascript">
        var session = Object();
        session.action_link = '../modules/banner/action.admin.php?[1]&token={$token}';
        session.url_link = '?[1]&token={$token}';
        session.add_link = '?module=banner&action=edit&token={$token}';
        session.action_type = 'banner';
        session.token = '{$token}';
        session.grid_title = 'Banner List';
    </script>
{/if}
