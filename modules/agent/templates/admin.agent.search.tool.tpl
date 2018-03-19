<form name="frmSearch" id="frmSearch" onSubmit="agent.search();return false;">
<table class="table-search" cellspacing="4" width="30%">
	<tr>
        <td valign="top">
        	<input type="text" name="search_text" id="search_text" class="input-text" value=""/>
        </td>
        <td valign="top">
        	<input type="button" value="Search" class="button" onClick="agent.search()"/>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<label class="note"><u>Search by:</u> id, firstname, lastname, telephone, mobilephone, address, postcode, suburb, state, country</label>
        </td>
    </tr>
</table>
</form>