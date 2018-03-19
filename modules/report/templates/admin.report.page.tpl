<script type="text/javascript" src="../modules/report/templates/js/page.paging.js"></script>
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
            <td colspan="2"><div id="msgID" class="message-box" style="display:none;"></div> </td>
        </tr>
        <tr>
            <td><div id="topic-grid1"></div> </td>
            <td><div id="topic-grid2"></div> </td>
        </tr>
        <tr>
            <td><div id="topic-grid3"></div> </td>
            <td><div id="topic-grid4"></div> </td>
        </tr>
        
    </table> 
	<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table> 
{/if}

<script type="text/javascript">
	var session = new Object();
	session.list_link1 = '../modules/report/action.admin.php?action=list-page&type=daily&token={$token}';
	session.list_link2 = '../modules/report/action.admin.php?action=list-page&type=weekly&token={$token}';
	session.list_link3 = '../modules/report/action.admin.php?action=list-page&type=monthly&token={$token}';
	session.list_link4 = '../modules/report/action.admin.php?action=list-page&type=yearly&token={$token}';
	
	session.option_month = '../modules/report/action.admin.php?action=list-page_month&token={$token}';
	session.option_year = '../modules/report/action.admin.php?action=list-page_year&token={$token}';
	
	session.title1 = '{$daily}';
	session.title2 = '{$weekly}';
	session.title3 = '{$monthly}';	
	session.title4 = '{$yearly}';
	
	//var select_box_time_3 = '<select onchange="report.pageSelect3(this)">'+'{$select_box_time_3}'+'</select>';
	//var select_box_time_4 = '<select onchange="report.pageSelect4(this)">'+'{$select_box_time_4}'+'</select>';
	
</script>