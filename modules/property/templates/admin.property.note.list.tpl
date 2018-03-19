<script type="text/javascript" src="../modules/property/templates/js/paging.en.note.js"></script>
<script type="text/javascript" src="../modules/property/templates/js/admin.js"></script>
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
    	<tr>
        	<td align="right">
            	{include file= admin.property.search.tool.tpl}
            </td>
        </tr>
        <tr>
            <td><div id="msgID" class="message-box" style="display:none"></div> </td>
        </tr>
        
        <tr>
            <td><div id="topic-grid"></div></td>
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