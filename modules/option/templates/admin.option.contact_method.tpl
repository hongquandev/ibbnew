<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Title <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "title" id = "title" value="{$form_data.title}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order<span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name = "order" id = "order" value="{$form_data.order}" class="input-text validate-digits disable-auto-complete" style="width:100%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%">
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.active == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="active" >
			<input type="checkbox" name="active" id="active" value="1" {$chked}/>
            Active
            </label>
        </td>
    </tr>
    

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="opt.reset('?module=option&action=save-{$action_ar[1]}&token={$token}')"/>
			<input type="button" class="button" value="Save" onclick="opt.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="opt.submit(true)"/>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
            {if isset($data) and is_array($data) and count($data) > 0}
                <div class="edit-table" style="max-height:400px">
                    <table width="100%" class="grid-table" cellspacing="1">
                        <tr class="title">
                            <td width="30px" align="center" style="font-weight:bold;color:#fff;">#</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Title</td>
                            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Order</td>
                            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Status</td>
                            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Action</td>
                        </tr>
                        {assign var = i value = 0}
                        {foreach from = $data key = k item = row}
                        {assign var = i value = $i+1}
                        <tr class="item{if $i%2==0}1{else}2{/if}">
                            <td align="center">{$i}</td>
                            <td><span style="margin-left:4px;">{$row.title}</span></td>
                            <td><span style="margin-left:4px;"><center>{$row.order}</center></span></td>
                            <td><span style="margin-left:4px;"><center>{$row.link_status}</center></span></td>
                            <td width="70px" align="center">
                              <a href="{$row.link_edit}" style="color:#0000FF">edit</a> | 
                              <a href="javascript:void(0)" onclick ="deleteItem2('{$row.link_del}')" style="color:#0000FF">delete</a>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
            {/if}
        </td>
    </tr>
    
</table>

