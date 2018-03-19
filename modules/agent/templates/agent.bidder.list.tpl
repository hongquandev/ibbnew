<script type="text/javascript">
    var TOKEN = "{$token}";
    //var link_csv = '<a target="_blank" href="?module=agent&action=exportCSV-bidder&file_name=RegisterTobid&token={$token}">Export CSV</a>';
    var link_csv = '<div><a href="javascript:void(0)" onclick="customerCSV(\'{$token}\')">Export CSV</a></div>';
    {literal}
        function customerCSV(token)
        {
            var query = jQuery('#ext-comp-1030').val();
            document.location = '?module=agent&action=exportCSV-bidder&file_name=RegisterTobid&token='+token+'&query='+ query;
        }
    {/literal}
</script>
<script type="text/javascript" src="../modules/agent/templates/js/bidder.en.js"></script>

{if $Admin.Level == 1}
<table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td><div id="topic-grid"></div></td>
      </tr>
    </table>

    <script type="text/javascript">
    var session = Object();
		session.action_link = '../modules/agent/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=agent&action=add-bidder&token={$token}';
        session.export_csv_link = '?module=agent&action=exportCSV-bidder&file_name=RegisterTobid&token={$token}';
		session.action_type = 'bidder';
		session.token = '{$token}';
		session.grid_title = 'Bid and Register Bid List';
    </script>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table>
{/if}

