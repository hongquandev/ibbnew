{*
<script src="/modules/general/templates/js/date_picker/jquery.ui.core.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/date_picker/jquery.ui.datepicker.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/date_picker/jquery.ui.widget.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/modules/general/templates/js/date_picker/css/jquery.ui.all.css" />  
*}
<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css" />
{literal}
    <style type="text/css">
        .auctions_run_in_hours_control select {
            width: 128px; float: left; margin-right: 10px;
            margin-bottom: 3px;
        }
        .auctions_run_in_hours_control #selection_hour,
        .auctions_run_in_hours_control #selection_second{
            margin-right: 0;
        }
    </style>
{/literal}
<script type="text/javascript">
    var isBlock = {$isBlock};
    {literal}
    function validDateTime_end(entity) {
        var hour = jQuery('#hour').val();
        var minute = jQuery('#minute').val();
        var second = jQuery('#second').val();
        //alert(hour);
        var day = jQuery('#day').val();
        var month = jQuery('#month').val();
        var year = jQuery('#year').val();
        if ((hour.length * minute.length * second.length * day.length * month.length * year.length) == 0) {
            jQuery(entity).css({"color": "#ff0000"});
            return false;
        }
        jQuery(entity).css({"color": ""});
        return true;
    }
    function validPrice() {
        var start_price = isNaN(parseInt(jQuery('#term_6').val())) ? 0 : parseInt(jQuery('#term_6').val(), 10);
        var reserve_price = isNaN(parseInt(jQuery('#term_7').val())) ? 0 : parseInt(jQuery('#term_7').val(), 10);
        var increment_price = isNaN(parseInt(jQuery('#term_8').val())) ? 0 : parseInt(jQuery('#term_8').val(), 10);
        //BEGIN reset value
        jQuery('#term_6').val(start_price);
        jQuery('#term_7').val(reserve_price);
        //END
        Common.warningObject('#term_6', true);
        Common.warningObject('#term_7', true);
        Common.warningObject('#term_8', true);
        if (start_price > reserve_price) {
            Common.warningObject('#term_6');
            Common.warningObject('#term_7');
            return false;
        }
        if (reserve_price <= increment_price) {
            Common.warningObject('#term_8');
            Common.warningObject('#term_7');
            return false;
        }
        return true;
    }
    function validDate() {
        if (jQuery('#start_time').val() > jQuery('#end_time').val()) {
            Common.warningObject('#start_time');
            Common.warningObject('#end_time');
            return false;
        }
        return true;
    }
    /*function validEndTime(){
     var currentTime = new Date();
     alert(currentTime);
     if (jQuery('#end_time').val() < currentTime){
     Common.warningObject('#end_time');
     return false;
     }
     return true;
     }*/
    pro.flushCallback();
    //pro.callback_func.push(function(){return validDateTime() });
    /*if (!(isBlock || ({/literal}{$ofAgent}{literal})){
     pro.callback_func.push(function(){return validDate();});
     }*/
    {/literal}
    {if (!($isBlock || ($ofAgent && $isAuction)))}
    {literal}
    pro.callback_func.push(function () {
        return validDate();
    });
    {/literal}
    {/if}
    {literal}
    jQuery(document).ready(function () {
        if ($('#term_7').length > 0) {
            pro.callback_func.push(function () {
                return validPrice();
            });
        }
    });
    /*pro.callback_func.push(function(){return validEndTime();});*/
    {/literal}
</script>
<div id="admin_term">
<table  width="100%" cellspacing="5">
	<tr>
    	<td>
        	<ul class="term" style="width:100%;">
            {if is_array($auction_terms) and count($auction_terms)>0}
            		<li class="control" style="*padding-bottom: 15px;">
                    <label>
                        <strong style="float:left;width:320px" id="notify_start_time">Start time <span class="require"></span>
                        </strong>
                        <strong style="float:left;width:125px">
                        <input type ="text" name="start_time" id="start_time" class="{*validate-require*}" value="{$form_data.start_time}" style="width:100%" {$readonly}/>
                        </strong>
                    </label>
                    </li>
                    <br clear="all"/>
                    {if !($isBlock || ($ofAgent && $isAuction))}
                        <div class="clearthis" style="clear:both;height:8px;"></div>
                        <li class="control">
                        <label>
                            <strong style="font-weight: bold;float:left;width:320px" id="notify_end_time">End time <span class="require"></span>
                            - <span style="font-size: 10px;">the bidding finished time</span>
                            </strong>
                            <strong style="float:left;width:125px">
                            <input type ="text" name="end_time" id="end_time" class="{*validate-require*}" value="{$form_data.end_time}" style="width:100%"/>
                            </strong>
                        </label>
                        </li>
                        <li class="control auctions_run_in_hours_control">
                            <label>
                                <strong style="float:left;width:320px;" id="notify_end_time">Auction Run In Hours
                                    - <span style="font-size: 10px;">add to selection of 1-30 days, 1-23 hours.</span>
                                    <br><span style="font-size: 10px;">The end time field will be updated automatically when Auction Run In Hours is selected.</span>
                                </strong>
                            </label>
                            <strong style="float:left;width:285px">
                                {* Add to selection of 1-30 days, 1-23 hours so make selection 2 boxes maybe?, number, 1-30, second drop box, hours or days, and make default 3 days*}
                                <select id="selection_day" name="selection_day" class="input-select">
                                    {html_options options = `$day_options` selected = 0}
                                </select>
                                <select id="selection_hour" name="selection_hour" class="input-select">
                                    {html_options options = `$hour_options` selected = 0}
                                </select>
                                <select id="selection_minute" name="selection_minute" class="input-select">
                                    {html_options options = `$minute_options` selected = 0}
                                </select>
                                <select id="selection_second" name="selection_second" class="input-select">
                                    {html_options options = `$second_options` selected = 0}
                                </select>
                            </strong>
                        </li>
                        <br clear="all"/>
                    {/if}
                {foreach from = $auction_terms key = k item = v}
                    {assign var=ok value=1}
                    {if $v.code == 'reserve'}
                        {assign var=ok value=$property_terms[$k]}
                    {/if}
                    {if $ok > 0}
                    <li class="control" style="clear: both;*padding-bottom: 15px;">
                        <label>
                        	{assign var = star value = ''}
                            {assign var = require_id value = ''}
                            {assign var = require_cls value = ''}
                        	{if $is_auction == true}
                                {if in_array($v.code, array('auction_start_price','reserve','auction_date'))}
                                	{assign var = star value = '*'}
                                    {assign var = require_id value = "notify_term_$k"}
                                    {assign var = require_cls value = 'validate-require'}

                                {/if}
                                {if in_array($v.code,array('auction_start_price'))}
                                    {assign var = require_price value ='validate-price'}
                                {/if}
                                {if in_array($v.code,array('reserve'))}
                                    {assign var = disabled value = 'readonly="readonly"'}

                                {/if}
							{/if}                        
                        
                            {assign var = part1 value = 'width:320px'}
                            {assign var = part2 value = 'width:139px'}

                            {assign var = before value = "<strong style='float:left;`$part1`' id='`$require_id`'>`$v.title` $star</strong>"}
                            {assign var = after value = ""}
                            
                            {*
                            {if $v.code == 'auction_date'}
                                {assign var = part1 value = 'width:300px'}
                                {assign var = part2 value = 'width:20px'}
                                {assign var = before value = ""}
                                {assign var = after value = "<strong style='float:left;`$part1`' id='`$require_id`'>`$v.title` $star</strong>"}
                            {/if}
                            *}
                            {$before}
                            <strong style="float:left;{$part2}">
                                {if $v.type == 'text'}
                                	{if $v.code == 'auction_date'}
                                    	<script type="text/javascript">
											var picker = 'term_{$k}';
										</script>                                  	

										<input type ="text" name="fields[term][{$k}]" id="term_{$k}" class="{$require_cls} disable-auto-complete" value="{$property_terms[$k]}" style="width:90%" {$readonly}/>
                                    {else}
                                        <input type ="text" name="" id="" class="{$require_cls}" value="{$price[$k]}" style="width:90%;" onkeyup="this.value=format_price(this.value,'#term_{$k}','#admin_term')" />
										<input type ="hidden" name="fields[term][{$k}]" id="term_{$k}" class="{$require_cls} {$require_price} disable-auto-complete" value="{$property_terms[$k]}" style="width:90%" {$disabled} {$readonly}/>
                                    {/if}
                                    
                                {elseif $v.type == 'select'}
                                    <select name="fields[term][{$k}]" id="term_{$k}" class="input-select {$is_validate_zero}" style="width:90%">
                                        {html_options options = `$v.options` selected = $property_terms[$k]}
                                    </select>                                      
                                {elseif $v.type == 'checkbox'}
                                    {assign var = chked value = ''}
                                    {if isset($property_terms[$k]) and $property_terms[$k]>0}
                                        {assign var = chked value ='checked'}
                                    {/if}
                                
                                    <input type="checkbox" name="fields[term][{$k}]" id="term_{$k}" {$chked} class="{$require_cls}"/>
                                {/if}
                            </strong>
                            {$after}
                        </label>
                    </li>
                    {/if}
                    <br clear="all"/>
                {/foreach}
                    <br clear="all"/>
            {/if}
            </ul>
		</td>
     </tr>
     <tr>
     	<td align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
        	<input type="button" class="button" value="Save" onclick="pro.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.submit(true)"/>
        </td>
     </tr>
</table>
</div>    
{literal}
<script type="text/javascript">
      Calendar.setup({
        inputField : 'start_time',
        trigger    : 'start_time',
        onSelect   : function() { this.hide() },
		showTime   : true,
		dateFormat : "%Y-%m-%d %H:%M:%S"
      });
</script>
{/literal}


<script type="text/javascript">
    {if !($isBlock)}
    {literal}
    Calendar.setup({
        inputField: 'end_time',
        trigger: 'end_time',
        onSelect: function () {
            this.hide()
        },
        showTime: true,
        dateFormat: "%Y-%m-%d %H:%M:%S"
    });
    {/literal}
    {/if}
</script>
{literal}
    <script type="text/javascript">
        function validateRunInHour(){
            jQuery('#selection_day,#selection_hour,#selection_minute,#selection_second').change(function(){
                var sec = jQuery('#selection_day').val() + jQuery('#selection_hour').val() +jQuery('#selection_minute').val() + jQuery('#selection_second').val();
                if(parseInt(sec) > 0){
                    //jQuery('#end_time').val('5000-01-01 00:00:00');
                    jQuery('#end_time').parents('li').hide();
                }else{
                    jQuery('#end_time').val('');
                    jQuery('#end_time').parents('li').show();
                }
            })
        }
        validateRunInHour();
    </script>
{/literal}


