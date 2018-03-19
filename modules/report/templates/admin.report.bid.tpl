<script type="text/javascript">
    var list_link1 = '../modules/report/action.admin.php?action=list-bid-property&token={$token}';
	var list_link2 = '../modules/report/action.admin.php?action=list-bid-property-agent&token={$token}';
</script>
<script type="text/javascript" src="../modules/report/templates/js/bid.paging.js"></script>
{if $Admin.Level == 1}
    <div style="margin: 0 auto; width: 1140px" id="dash">
         <div id="topic-grid1" style="float:left;padding-right:0px;"></div>
         <div id="topic-grid2" style="float:right;"></div>
    </div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table> 
{/if}

