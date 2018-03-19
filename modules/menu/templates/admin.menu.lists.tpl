<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td colspan="2">
	        Filter by area: 
            <select name="area_id" id="area_id" class="input-select" style="width:30%;" onchange="menu.areaSelect(this)">
                {html_options options = $options_area selected = $area_id}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td colspan="2">
            <table width="100%" class="grid-table" cellspacing="1">
            	<tr class="title">
                	<td style="width:30px; text-align:center;font-weight:bold;color:#ffffff;">No.</td>
                    <td style="text-align:center;font-weight:bold;color:#ffffff;">Title</td>
                    <td style="text-align:center;font-weight:bold;color:#ffffff;">Url</td>
                    <td style="width:70px;text-align:center;font-weight:bold;color:#ffffff;">Order</td>
                    <td style="width:70px;text-align:center;font-weight:bold;color:#ffffff;">Status</td>
                    <td style="width:70px;text-align:center;font-weight:bold;color:#ffffff;">Active</td>
                </tr>
                {assign var = i value = 0}
                {foreach from = $list_menu key = tab_id item = row}
                    {assign var = i value = $i+1}
                    <tr class="item{if $i%2==0}1{else}2{/if}">
                        <td width="20px" align="center" valign="top">{$i}</td>
                        
                        <td valign="top">
                        	<div style="margin:0px 5px">
                                <b>{$row.title}</b>
                                <br/>
                                <div style="margin:5px 20px">
                                    Area : 
                                    {php}
                                    echo Menu_convert(Menu_areaAr(), $this->_tpl_vars['row']['area_ids']);
                                    {/php}

                                    <br/>
                                    Banner Area : 
                                    {php}
                                    echo Menu_convert(CMS_getArea(), $this->_tpl_vars['row']['banner_area_ids']);
                                    {/php}
                                    
                                    <br/>
                                    Access : 
                                    {php}
                                    echo Menu_convert(AgentType_getOptions(1, 'name'), $this->_tpl_vars['row']['access']);
                                    {/php}
                                </div>
                            </div>
                        </td>
                        <td valign="top">{$row.url}</td>
                        <td valign="top" align="center">{$row.order}</td>
                        <td valign="top" style="text-align:center">
                        	<a href="?module=menu&action=active&menu_id={$row.menu_id}&token={$token}">{if $row.active == 1}Active{else}InActive{/if}</a>
                        </td>
                        <td align="center" valign="top">
                        	<a href="?module=menu&action=edit&menu_id={$row.menu_id}&token={$token}">Edit</a> - 
                        	<a href="?module=menu&action=delete&menu_id={$row.menu_id}&token={$token}">Delete</a>
                        </td>
                    </tr>
                {/foreach}
            </table>
        </td>
    </tr>

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="button" class="button" value="Save" onclick="menu.submit()"/>
        </td>
    </tr>
</table>

