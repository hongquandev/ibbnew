<div class="edit-table" style="max-height:400px">
    <table width="100%" class="grid-table" cellspacing="1">
        <tr class="title">
            <td width="30px" align="center" style="font-weight:bold;color:#fff;">#</td>
            <td align="center" style="font-weight:bold;color:#fff;">Title</td>
            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Position</td>
            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Status</td>
            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Action</td>
        </tr>
        {if isset($data) and is_array($data) and count($data) > 0}
        {assign var = i value = 0}
        {foreach from = $data key = k item = row}
        {assign var = i value = $i+1}
        <tr class="item{if $i%2==0}1{else}2{/if}">
            <td align="center">{$i}</td>
            <td><span style="margin-left:4px;">{$row.title} ($ {$row.price}) </span></td>
            <td><span style="margin-left:4px;"><center>{$row.order}</center></span></td>
            <td>
            	<span style="margin-left:4px;">
            		<center>
                    	<a href="{$row.link_status}">
                        	{if $row.active == 1}
                            	Active
                            {else}
                            	Inactive
                            {/if}
                        </a>
                    </center>
                </span>
            </td>
            <td width="70px" align="center">
              <a href="{$row.link_edit}" style="color:#0000FF">edit</a> | 
              <a href="javascript:void(0)" onclick ="deleteItem2('{$row.link_delete}')" style="color:#0000FF">delete</a>
            </td>
        </tr>
        {/foreach}
        {/if}
    </table>
</div>
            