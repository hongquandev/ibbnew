<script type="text/javascript" src="../modules/report/templates/js/email_alert.paging.js"></script>
<script src="js/Ext.ux.plugin.PagingToolbarResizer.js" type="text/javascript"></script>
{if $Admin.Level == 1}
     <div style="margin: 0 auto; width: 1140px" id="dash">
          {*LEFT*}
          {include file="admin.report.email.left.tpl"}
          {*RIGHT*}
          <div style="float:left;height: 500px;margin-left: 5px;width: 806px;">
             <div id="topic-grid" style="float:right;"></div>
          </div>
    </div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table> 
{/if}

<script type="text/javascript">
    var session = new Object();
    session.alert_link = '../modules/report/action.admin.php?action=list-email_alert&token={$token}';
    session.send_link = '../modules/report/action.admin.php?action=list-email_send&token={$token}';
</script>