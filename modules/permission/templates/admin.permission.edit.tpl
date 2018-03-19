<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td colspan="2">
        
             <script type="text/javascript">
			var permission = new Permission('#frmPermission');
			</script>
       	
            <table width="100%" class="grid-table" cellspacing="1">
            	<tr class="title">
                	<td width="30px"></td>
                    <td>
                    	<select style="width:50%" name="role_id" id="role_id1" onchange="permission.roleSelect(this)">
                        	{html_options options = $options_role selected = $role_id}
                        </select>
                    </td>
                    <td width="50px" align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'add')">Add</a></td>
                    <td width="50px" align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'view')">View</a></td>
                    <td width="50px" align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'edit')">Edit</a></td>
                    <td width="50px" align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'delete')">Delete</a></td>
                </tr>
                {assign var = i value = 0}
                {foreach from = $options_permission key = tab_id item = row}
                {assign var = i value = $i+1}
                <tr class="item{if $i%2==0}1{else}2{/if}">
                    <td width="20px" align="center">{$i}</td>
                    
                    <td>{$row.title}</td>
                    <td align="center"><input type="checkbox" name="add[{$tab_id}]" id="add_{$tab_id}" value="1" {if $row.permission.add} checked {/if}/></td>
                    <td align="center"><input type="checkbox" name="view[{$tab_id}]" id="view_{$tab_id}" value="1" {if $row.permission.view} checked {/if}/></td>
                    <td align="center"><input type="checkbox" name="edit[{$tab_id}]" id="edit_{$tab_id}" value="1" {if $row.permission.edit} checked {/if}/></td>
                    <td align="center"><input type="checkbox" name="delete[{$tab_id}]" id="delete_{$tab_id}" value="1" {if $row.permission.delete} checked {/if}/></td>
                </tr>
                {/foreach}
            	<tr class="title">
                	<td></td>
                    <td>
                    	<select style="width:50%" name="role_id" id="role_id2" onchange="permission.roleSelect(this)">
                        	{html_options options = $options_role selected = $role_id}
                        </select>
                    </td>
                    <td align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'add')">Add</a></td>
                    <td align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'view')">View</a></td>
                    <td align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'edit')">Edit</a></td>
                    <td align="center"><a href="javascript:void(0)" onclick="permission.checkAll(this,'delete')">Delete</a></td>
                </tr>
                
            </table>
        </td>
    </tr>

    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="button" class="button" value="Save" onclick="permission.submit()"/>
        </td>
    </tr>
    
</table>

