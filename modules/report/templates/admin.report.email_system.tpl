<script type="text/javascript" src="../modules/report/templates/js/email_system.paging.js"></script>
<script src="js/Ext.ux.plugin.PagingToolbarResizer.js" type="text/javascript"></script>
<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css"/>
{if $Admin.Level == 1}
    <div style="margin: 0 auto; width: 1140px" id="dash">
        <div style="float: left; width: 280px; height:500px;" class="leftdash">
            <div class="report-search">
                <div style="display: inline-block;"><span>From</span><input type="text" id="from" name="from" class="input-text"/></div>
                <div style="display: inline-block;"><span>To</span><input type="text" id="to" name="to" class="input-text"/></div>
                <input id="search" type="button" value="Search" class="button" style="width:52px;padding: 3px 1px 1px 3px; font-size:12px"/>
            </div>
            <div class="clearthis"></div>
            <div class="report" style="text-align:center;display: none;">
                <img src="../../modules/general/templates/images/loading.gif" width="40" height="40">
            </div>
        </div>
        <div style="float:left;height: 500px;margin-left: 5px;width: 850px;">
            <div id="topic-grid" style="float:right;width: 100%"></div>
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
    session.email_log_system_link = '../modules/report/action.admin.php?action=list-email_system&token={$token}';
</script>
<script type="text/javascript">
    var token = '{$token}';
    {literal}
    Calendar.setup({
        inputField : 'from',
        trigger    : 'from',
        onSelect   : function() { this.hide() },
        showTime   : true,
        dateFormat : "%Y-%m-%d"
    });

    Calendar.setup({
        inputField : 'to',
        trigger    : 'to',
        onSelect   : function() { this.hide() },
        showTime   : true,
        dateFormat : "%Y-%m-%d"
    });
    $('#search').click(function(){
        search();
    });
    function search(){
        jQuery('div.report').html('<img src="../../modules/general/templates/images/loading.gif" width="40" height="40">');
        var date_from = $('#from').val();
        var date_to = $('#to').val();
        store.reload({params:{start:0, limit:20,date_from: date_from, date_to: date_to}});
    }
    {/literal}
</script>