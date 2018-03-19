{if $action_ar[1] != 'soldpassedin' }
    <script type="text/javascript" src="js/ext-base.js"></script>
    <script type="text/javascript" src="js/ext-all.js"></script>
    <script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
{/if}
<script src="/modules/general/templates/js/date_picker/jquery.ui.core.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/date_picker/jquery.ui.datepicker.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/date_picker/jquery.ui.widget.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="/modules/general/templates/js/date_picker/css/jquery.ui.all.css" />  


<script type="text/javascript" src="../modules/report/templates/js/admin.js"></script>
<script type="text/javascript">
var report = new Report('');
    var ROOTURL = '{$ROOTURL}';
</script>
{if $action_ar[1]}
	{include file="admin.report.`$action_ar[1]`.tpl"}
{elseif ($message|count_characters > 0 )}    
	<div id="msgID" class="message-box" style="width:1130px;margin:auto">{$message}</div>
{/if} 

