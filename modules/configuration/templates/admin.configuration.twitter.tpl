<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
             <select name="fields[twitter_enable]" id="twitter_enable" class="input-select">
                {html_options options=$options_yes_no selected =$form_data.twitter_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%">
        	<strong>Consumer key</strong>
        </td>
        <td>
			<input type="text" name = "fields[twitter_consumer_key]" id = "twitter_consumer_key" value="{$form_data.twitter_consumer_key}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Consumer Secret</strong>
        </td>
        <td>
			<input type="text" name = "fields[twitter_consumer_secret]" id = "twitter_consumer_secret" value="{$form_data.twitter_consumer_secret}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>


	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>

</table>