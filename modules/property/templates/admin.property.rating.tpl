<table  width="100%" cellspacing="5">
	<tr>
    	{*<td width="45%" valign="top">
			<ul class="form-list">
                <li class="wide">
                    <h3>iBB Livability Rating</h3>
                </li>
                {if is_array($livability_ratings) and count($livability_ratings)>0}
                    {foreach from = $livability_ratings key = k item = v}
                        <li class="wide">
                            {assign var = var1 value = ""}
                            {assign var = var2 value = ""}
                            {if $v.require == 1}
                                <!--{assign var = var1 value = "<span id='notify_rating_`$v.rating_id`'>*</span>"}-->
                                {assign var = id value = "id='notify_rating_`$v.rating_id`'"}
                                {assign var = var1 value = "<span class='require'>*</span>"}
                                {assign var = var2 value = "validate-number-gtzero"}
                            {/if}
                        
                            <label>
                                <strong {$id}>{$v.title} {$var1}</strong>
                            </label>
                            <div class="input-box">
                                <select name="fields[{$v.rating_id}]" id="rating_{$v.rating_id}" class="input-select {$var2}" style="width:100%">
                                    {html_options options = $options[$v.rating_id] selected = $form_data[$v.rating_id]}
                                </select>
                            </div>
                        </li>
                    {/foreach}
                {/if}
               
            </ul>        	
        </td>*}
        
        <td width="100%" valign="top">
			<ul class="form-list">
                <li class="wide" style="padding-bottom: 10px;clear: both;">
                    <h3>iBB Sustainability</h3>
                </li>
                {if is_array($green_ratings) and count($green_ratings)>0}
                    {foreach from = $green_ratings key = k item = v}
                        <li class="wide" style="padding-bottom: 23px;clear: both;*padding-bottom: 10px;">
                            {assign var = var1 value = ""}
                            {assign var = var2 value = ""}
                            {if $v.require == 1}
                                {assign var = var1 value = "<span id='notify_rating_`$v.rating_id`'>*</span>"}
                                {assign var = var2 value = "validate-number-gtzero"}
                            {/if}
                        
                            <label style="float: left;width: 20%;padding-bottom: 0px;">
                                <strong>{$v.title} {$var1}</strong>
                            </label>
                            <div class="input-box" style="float: right;clear: none;width: 80%;">
                                <select name="fields[{$v.rating_id}]" id="rating_{$v.rating_id}" class="input-select {$var2}" style="width:70%">
                                    {html_options options = $options[$v.rating_id] selected = $form_data[$v.rating_id]}
                                </select>
                            </div>
                        </li>
                    {/foreach}
                {/if}
            </ul>        
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
        	<input type="button" class="button" value="Save" onclick="pro.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.submit(true)"/>
        </td>
    </tr>
</table>
