<table width="100%" cellspacing="10" class="edit-table">

    <tr>
        <td colspan="8" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend><small>Property Time Settings</small></legend>
            </fieldset>
        </td>

    </tr>
    
    <tr>
        <td colspan="4" align="left">
            <strong>The Date allow to vendor can edit on their property before becoming live</strong>
            </br>
            <small>Description: </small>
        </td>
        <td width="20%">
            <label style="padding-right: 3px"> > </label><input id="date_to_lock_before_live" name="fields[date_to_lock_before_live]" type="text" class="input-text validate-require disable-auto-complete" value="{$form_data.date_to_lock_before_live}" />
        </td>
        <td>
            <strong>Day(s)</strong>
        </td>
    </tr>

    <tr>
        <td colspan="4" align="left">
            <strong>The Date allow to vendor can edit on their property before become bidding stop</strong>
            <br>
            <small>Description: </small>
        </td>
        <td width="20%">
            <label style="padding-right: 3px"> > </label> <input id="date_to_lock_before_ending" name="fields[date_to_lock_before_ending]" type="text" class="input-text validate-require disable-auto-complete" value="{$form_data.date_to_lock_before_ending}" />
        </td>
        <td>
            <strong>Day(s)</strong>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <strong>
                Show this description on frontend By tooltip
            </strong>
        </td>
        <td colspan="4">
            <textarea rows="10px" name="fields[date_to_lock_before_live_des]">
                {$form_data.date_to_lock_before_live_des}
            </textarea>
        </td>
    </tr>


    <tr>
        <td colspan="8" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend><small>Auto Update End Time Settings</small></legend>
            </fieldset>
        </td>
    </tr>

	<tr>
    	<td width = "19%" >
        	<strong>Auto Update End time</strong>
        </td>
        <td width= "20%";>
             <select name="fields_time[endtime-enable]" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = $end_time}
            </select>
        </td>
        <td colspan="8" align="left">
            <strong> Description: If You choose "YES" option, System will update end time automatically. When The iBB Site is scheduled maintenance for a long time.</strong>
        </td>
    </tr>

    <tr>
        <td colspan="8" >
            <strong>Add time into end time for Live,Forth, and The Block Auction Property. Before The Site is scheduled maintenance. </strong>
        </td>
    </tr>

	<tr>
    	<td width = "10%" valign="top">
            <input type="text" name = "fields_time[days]" class="input-text validate-number disable-auto-complete" value="0" style="width:100%;text-align: right;"/>
        </td>
        <td>
            <strong>Days</strong>
        </td>

        <td width = "10%" valign="top">
            <input type="text" name = "fields_time[hrs]"  class="input-text validate-number disable-auto-complete" value="0" style="width:100%;text-align: right;"/>
        </td>
        <td>
            <strong>Hours</strong>
        </td>

        <td width = "10%" valign="top">
            <input type="text" name = "fields_time[min]"  class="input-text validate-number disable-auto-complete" value="0" style="width:100%;text-align: right;"/>
        </td>
        <td>
            <strong>Minutes</strong>
        </td>

        <td width = "10%" valign="top">
            <input type="text" name = "fields_time[sec]"  class="input-text validate-number disable-auto-complete" value="0" style="width:100%;text-align: right;"/>
        </td>
        <td>
            <strong>Seconds</strong>
        </td>

    </tr>
    
	<tr>
    	<td colspan="8" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
