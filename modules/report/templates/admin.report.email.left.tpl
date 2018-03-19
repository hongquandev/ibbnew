 <div style="float: left; width: 327px; height:500px;" class="leftdash">
   <div class="report-search">
       <div style="display: inline-block;"><span>From</span><input type="text" id="from" name="from" class="input-text"/></div>
       <div style="display: inline-block;"><span>To</span><input type="text" id="to" name="to" class="input-text"/></div>
       <input id="search" type="button" value="Search" class="button" style="width:52px;padding: 3px 1px 1px 3px; font-size:12px"/>
   </div>
   <div class="clearthis"></div>
   <div class="report" style="text-align:center">
       <img src="../../modules/general/templates/images/loading.gif" width="40" height="40">
   </div>
</div>
<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css"/>
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
        jQuery(document).ready(function(){
            search();
        });
        $('#search').click(function(){
            search();
        });
        function search(){
            jQuery('div.report').html('<img src="../../modules/general/templates/images/loading.gif" width="40" height="40">');
            var date_from = $('#from').val();
            var date_to = $('#to').val();
            var url = '../modules/report/action.admin.php?action=search-email&token='+token;
            $.post(url,{date_from:date_from,date_to:date_to},function(data){
                            $('div.report').html(data);
                        },'html');
        }
    {/literal}
</script>