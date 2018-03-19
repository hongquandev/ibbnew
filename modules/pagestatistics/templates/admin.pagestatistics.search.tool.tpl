<form name="frmSearch" id="frmSearch" onsubmit="searchPageReport(); return false;">
<table class="table-search" cellspacing="4">
	<tr>
        <td valign="top">
        	<input type="text" name="search_text" id="search_text" class="input-text" value="" onkeypress="return submitenter(this,event)" />
        </td>
        <td valign="top">
        	<input type="button" value="Search" class="button" onclick="searchPageReport() "/>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<label class="note"><u>Search by:</u> page id, page title</label>
        </td>
    </tr>
</table>
</form>
{literal}
<SCRIPT TYPE="text/javascript">
	<!--
	function submitenter(myfield,e)
	{
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		else return true;
		
		if (keycode == 13)
		   {
		   searchPageReport();
		   return false;
		   }
		else
		   return true;
	}
	//-->
</SCRIPT>

{/literal}