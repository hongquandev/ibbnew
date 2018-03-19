<form name="frmSearch" id="frmSearch" onSubmit="pro.search();return false;">
<table class="table-search" cellspacing="4">
	<tr>
        <td valign="top">
        	<input type="text" name="search_text" id="search_text" class="input-text" value=""/>
        </td>
        <td valign="top">
        	<input type="button" value="Search" class="button" onclick="pro.search()"/>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<label class="note"><u>Search by:</u> id, address, postcode, suburb, state, country</label>
        </td>
    </tr>
</table>
</form>