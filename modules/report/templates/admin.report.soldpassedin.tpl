{literal}
    <style type="text/css">
        #monthly-char {
            padding-left: 84px;
        }
    </style>
{/literal}
<script type="text/javascript">
    var session = new Object();
    session.monthly_link = '../modules/report/action.admin.php?action=report-soldpassedin&type=monthly&token={$token}';
    session.daily_link = '../modules/report/action.admin.php?action=report-soldpassedin&type=daily&token={$token}';
    session.weekly_link = '../modules/report/action.admin.php?action=report-soldpassedin&type=weekly&token={$token}';
    session.yearly_link = '../modules/report/action.admin.php?action=report-soldpassedin&type=yearly&token={$token}';

    session.chart = '{$ROOTURL}/modules/report/templates/js/extjs3/resources/charts.swf';
    session.list_link3 = '../modules/report/action.admin.php?action=list-page&type=monthly&token={$token}';

    session.option_month = '../modules/report/action.admin.php?action=list-page_month&token={$token}';
    session.option_year = '../modules/report/action.admin.php?action=view-option-year&token={$token}';

    session.title1 = '{$daily}';
    session.title2 = '{$weekly}';
    session.title3 = '{$monthly}';
    session.title4 = '{$yearly}';
</script>
<!-- GC -->
<!-- LIBS -->
<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/extjs3/adapter/ext/ext-base.js"></script>
<!-- ENDLIBS -->
<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/extjs3/ext-all.js"></script>
<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/extjs3/uxvismode.js"></script>
{*<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/extjs3/chart/reload-chart.js"></script>*}

<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/report/templates/js/extjs3/chart/chart.css" />
<!-- Common Styles for the examples -->
<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/report/templates/js/extjs3/shared/examples.css" />
<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/report/templates/js/extjs3/shared/examples.js" />

<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/jscharts.js"></script>

{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
            <td colspan="2"><div id="msgID" class="message-box" style="display:none;"></div> </td>
        </tr>
        <tr>
            <td>
                <div class="chart-content-main">
                    <div id="monthly-chart">
                    </div>
                </div>
            </td>
            <td>
                <div id="yearly-chart">
                </div>
            </td>
        </tr>
        <tr>
            <td><div id="daily-chart"></div> </td>
            <td><div id="weekly-chart"></div> </td>
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

<script type="text/javascript" src="{$ROOTURL}/modules/report/templates/js/soldpassedin.char.js"></script>

