<script type="text/javascript" src="../modules/report/templates/js/property.paging.js"></script>
{*<link href="/admin/resources/css/xtheme-gray.css" type="text/css" rel="stylesheet">*}
<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css"/>
{if $Admin.Level == 1}
    <div style="margin: 0 auto; width: 1140px" id="dash">
          {*LEFT*}
          {include file="admin.report.property.right.tpl"}
          {*RIGHT*}
          <div style="float:left;height: 500px;margin-left: 5px;width: 893px;">
             <div id="topic-grid2" style="float:left;padding-right:0px;"></div>
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
    var list_link1 = '../modules/report/action.admin.php?action=list-property&token={$token}';
	var list_link2 = '../modules/report/action.admin.php?action=list-property_time&token={$token}';
	var select_box = '<select>'+'{$option_country_str}'+'</select>';
    var select_box_state = '<select>'+'{$option_state_str}'+'</select>';
	
</script>