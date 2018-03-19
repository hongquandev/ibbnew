{literal}
    <script type="text/javascript" src="js/ext-base.js"></script>
    <script type="text/javascript" src="js/ext-all.js"></script>
    <script type="text/javascript" src="../modules/homepage_slides/js/grid.js"></script>
    <script src="/modules/general/templates/js/admin.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
    <script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
{/literal}

<table align="center" border="0" cellspacing="1" cellpadding="3">
    <tr>
        <td>
            <div id="topic-grid"></div>
        </td>
    </tr>
</table>

<div style="width:100%">
    <script type="text/javascript">
        var session = Object();
        session.action_link = '../modules/homepage_slides/action.admin.php?[1]&token={$token}';
        session.url_link = '?[1]&token={$token}';
        session.add_link = '?module=homepage_slides&action=add&token={$token}';
        session.action_type = 'homepage_slides';
        session.token = '{$token}';
        session.grid_title = 'Slides Management';
    </script>
</div>


