<div id="pack_property">
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
        	<strong id="notify_price">Price <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text"  id="price_dl" value="{$form_data.show_price}" class="input-text validate-require disable-auto-complete" onblur="this.value=format_price(this.value,'#price','#pack_property','cent')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "price" id = "price" value="{$form_data.price}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_description">Description <span class="require">*</span></strong>
        </td>
        <td>
            <textarea name="description" id="description" class="input-text validate-require" style="width:100%;height:100px">{$form_data.description}</textarea>        
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_photo_num">Number of photo<span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "photo_num" id = "photo_num" value="{$form_data.photo_num}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/><i>input a value >=0 or "all"</i>       
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_video_num">Number of video <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "video_num" id = "video_num" value="{$form_data.video_num}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/><i>input a value >=0 or "all"</i>       
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_video_capacity">Capacity of Video <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "video_capacity" id = "video_capacity" value="{$form_data.video_capacity}" class="input-text validate-require disable-auto-complete" style="width:50%"/> mb
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_title">Document </strong>
        </td>
        <td>
            <select name="document_ids[]" id="document_ids" class="input-select" style="width:50%;height:150px" multiple>
                {html_options options=$options_doc selected = $form_data.document_ids}
            </select>
        </td>

    </tr>
    <tr>
        <td>

        </td>
        <td>
            <input type="button" onclick="nodoc()" value="No download document" class="button" style="margin-left: 148px; height: 18px; font-size: 10px;" />
        </td>
    </tr>
	<!--
	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Can comment ? <span class="require">*</span></strong>
        </td>
        <td>
            <select name="can_comment" id="can_comment" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = $form_data.can_comment}
            </select>
        </td>
    </tr>
	-->
	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Can blog/comment ? <span class="require">*</span></strong>
        </td>
        <td>
            <select name="can_blog" id="can_blog" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = $form_data.can_blog}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Type of property <span class="require">*</span></strong>
        </td>
        <td>
            <select name="property_type" id="property_type" class="input-select" style="width:50%">
                {html_options options=$options_property_type selected = $form_data.property_type}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order<span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name = "order" id = "order" value="{$form_data.order}" class="input-text validate-digits disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%">
        </td>
        <td>
            <div class="input">
                {assign var = 'chked' value = ''}
                {if $form_data.active == 1}
                    {assign var = 'chked' value = 'checked'}
                {/if}
                <label for="active" >
                <input type="checkbox" name="active" id="active" value="1" {$chked}/>
                Active
                </label>
            </div>

            <div class="input">
                {assign var = 'chked' value = ''}
                {if $form_data.can_show == 1}
                    {assign var = 'chked' value = 'checked'}
                {/if}
                <label for="can_show" >
                <input type="checkbox" name="can_show" id="can_show" value="1" {$chked}/>
                Show
                </label>
            </div>    
        </td>
    </tr>
    

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="package.reset('?module=package&action=save-{$action_ar[1]}&token={$token}')"/>
			<input type="button" class="button" value="Save" onclick="package.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="package.submit(true)"/>
        </td>
    </tr>
</table>
</div>
{literal}
    <script type="text/javascript" >
        function nodoc()
        {
            jQuery('#document_ids').val('0');
        }
    </script>
{/literal}