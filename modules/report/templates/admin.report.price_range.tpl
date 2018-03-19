<script type="text/javascript" src="../modules/report/templates/js/price_range.paging.js"></script>
<script type="text/javascript" src="js/adapter-extjs.js"></script>
<script type="text/javascript" src="js/Ext.ux.HighChart.js"></script>
{*<script type="text/javascript" src="js/highcharts.js"></script>*}
<script type="text/javascript" src="../modules/general/templates/js/highcharts.js"></script>
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
            <td><div id="msgID" class="message-box" style="display:none;"></div> </td>
        </tr>
        <tr>
            <td><div id="topic-grid"></div></td>
            <td><div id="container"></div></td>
            
        </tr>
    </table>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table> 
{/if}

<script type="text/javascript">
    var session = new Object();
    session.action_link = '../modules/report/action.admin.php?action=[1]&token={$token}';
	var select_country = '<select>'+'{$option_country_str}'+'</select>';
    var select_state = '<select>'+'{$option_state_str}'+'</select>';
</script>