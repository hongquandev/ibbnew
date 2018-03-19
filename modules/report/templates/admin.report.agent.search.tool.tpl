<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css" />

<form name="frmSearch" id="frmSearch">
<table class="table-search" cellspacing="4">
	<tr>
        <td valign="top">
        	<span class="tbl-search-rep-admin">From</span> <input type="text" name="date_begin" id="date_begin" class="input-text" style="width:100px" value=""/>
            <span class="tbl-search-rep-admin">To</span> <input type="text" name="date_end" id="date_end" class="input-text" style="width:100px" value=""/>
        </td>
        <td valign="top">
        	<input type="hidden" name="is_submit" id="is_submit" value="0"/>
        	<input type="button" value="Search" class="button" onclick="report.search()"/>
        </td>
    </tr>
</table>
</form>
{literal}
<script type="text/javascript">
      Calendar.setup({
        inputField : "date_begin",
        trigger    : "date_begin",
        onSelect   : function() { this.hide() },
		dateFormat : "%m/%d/%Y",
		min: 20110604,
        //dateFormat : "%Y-%m-%d %I:%M %p"
      });
      
      Calendar.setup({
        inputField : "date_end",
        trigger    : "date_end",
        onSelect   : function() { this.hide() },
        dateFormat : "%m/%d/%Y"
      });

</script>
{/literal}
