<script type="text/javascript" src="{$ROOTURL}/modules/agent/templates/js/file.js"></script>
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

        .fileWrap{ position:relative;}
        .fileWrap input[type=file]{cursor: pointer}
        .file-box{
            /*border: 1px solid #4d7cd6;
            background-color: #5a9bd5;*/
            height: 30px;
            padding: 0;
            margin-top: 5px;
        }
        .file-box .file-button{
            border: none;
            background-color: #3B95CC;
            padding: 7px 20px;
            margin-right: 10px;
            color: #fff;
            font-weight: bold;
            float: left;
            cursor: pointer;
            margin-bottom: 5px;
        }
        .file-box .file-button:hover{
            background-color: #2a678d;
        }
        .file-box .file-action{
            height: 30px;
            float: left;
            line-height: 30px;
            margin-right: 0;
            border: 1px solid #cbcbcb;
            border-left: 0 none;
            padding: 0 10px;
            width: 70px;
            box-sizing: border-box;
        }
        .file-box .file-action:hover{
            cursor: pointer;
            background-color: #cbcbcb;
        }
        .file-box .file-name{
            height: 30px;
            line-height: 30px;
            /*color: #ffffff;*/
            margin-left: 0;
            border: 1px solid #cbcbcb;
            padding: 0 5px;
            float: left;
            width: 225px;
            box-sizing: border-box;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .form-register .file-box .file-name{
            width: 200px;
        }
        .file-box .file-text{
            text-align: center;
            line-height: 32px;
            color: #ffffff;
            font-size: 20px;
        }
        .file-box.btn-control{
            cursor: pointer;
            text-align: center;
        }
        .file-box.btn-control:hover{
            background-color: #4d7cd6 ;
        }
        .file-box .file-adds{
            height: 30px;
            line-height: 30px;
            cursor: pointer;
            padding-left: 10px;
            font-size: 16px;
        }
        .file-box .file-adds:hover{
            background-color: #4d7cd6 ;
        }
    </style>
{/literal}
<script type="text/javascript">
    var isBlock = {$isBlock};
{literal}
    function validPrice() {
        var sec = jQuery('#selection_day').val() + jQuery('#selection_hour').val() +jQuery('#selection_minute').val() + jQuery('#selection_second').val();
        if(jQuery('#start_time').val().length == 0 && jQuery('#end_time').val().length == 0 && parseInt(sec) <= 0 ){
            return true;
        }
        var start_price = isNaN(parseInt(jQuery('#auction_start_price').val())) ? 0 : parseInt(jQuery('#auction_start_price').val());
        var reserve_price = isNaN(parseInt(jQuery('#reserve').val())) ? 0 : parseInt(jQuery('#reserve').val());
        var increment_price = isNaN(parseInt(jQuery('#initial_auction_increments').val())) ? 0 : parseInt(jQuery('#initial_auction_increments').val());
        if(start_price == 0){
            Common.warningObject('#auction_start_price');
            showMess('Please enter start price');
            return false;
        }
        if(reserve_price == 0){
            Common.warningObject('#reserve');
            showMess('Please enter reserve price');
            return false;
        }
        if (start_price > reserve_price) {
            Common.warningObject('#auction_start_price');
            Common.warningObject('#reserve');
            showMess('"Auction start price" must be less than "Reserve price"');
            return false;
        }
        if (reserve_price <= increment_price) {
            Common.warningObject('#initial_auction_increments');
            Common.warningObject('#reserve');
            showMess('"Initial auction increments" must be less than "Reserve price"');
            return false;
        }
        return true;
    }
    function validDate() {
        var sec = jQuery('#selection_day').val() + jQuery('#selection_hour').val() +jQuery('#selection_minute').val() + jQuery('#selection_second').val();
        if(parseInt(sec) > 0){return true;}
        if (jQuery('#start_time').val() > jQuery('#end_time').val()) {
            Common.warningObject('#start_time');
            Common.warningObject('#end_time');
            return false;
        }
        return true;
    }
    function validTheBlock() {
        var date_reg = jQuery('#date_to_reg_bid').val();
        if (date_reg != '') {
            if ($('#start_time').val() < date_reg) {
                Common.warningObject('#start_time');
                Common.warningObject('#date_to_reg_bid');
                return false;
            }
        }
        return true;
    }
    pro.flushCallback();
    //if (!isBlock && !(isAgent && isAuction)) {
    if (!isBlock) {
        pro.callback_func.push(function () {
            return validDate();
        });
    } else {
        pro.callback_func.push(function () {
            return validTheBlock();
        });
    }
    jQuery(document).ready(function () {
        if ($('#reserve').length > 0) {
            pro.callback_func.push(function () {
                return validPrice();
            });
        }
    });
</script>
{/literal}
<div id="admin_term">
<table  width="100%" cellspacing="5">
	<tr>
    	<td>
        	<ul class="term" style="width:100%;">
                <li class="control">
                    <label>
                        <strong style="float:left;width:320px;" id="notify_release_time">{localize translate="Release Time"}</strong>
                    </label>
                    <strong style="float:left;width:200px;">
                        <div class="input-box">
                            <input type ="text" name="release_time" id="release_time" class="validate-require-none" value="{$form_data.release_time}" style="width:97.5% !important;"/>
                        </div>
                    </strong>
                </li>
                <li class="control" id="control-first">
                    <label>
                        <strong style="float:left;width:320px;" id="notify_start_time">{localize translate="Auction Start Time"}</strong>
                    </label>
                    <strong style="float:left;width:200px;">
                        <div class="input-box">
                            <input type ="text" name="start_time" id="start_time" class="validate-require-none" value="{$form_data.start_time}" style="width:97.5% !important;" {$readonly.start_time} />
                        </div>
                    </strong>
                </li>
                {*<br clear="all"/>*}
                {if !$isBlock}
                    <li class="control">
                        <label>
                            <strong style="float:left;width:320px;" id="notify_end_time">{localize translate="Auction End Time"}
                                - <span style="font-size: 10px;">{localize translate="the bidding finished time"}</span>
                            </strong>
                        </label>
                        <strong style="float:left;width:200px">
                            <input type ="text" name="end_time" id="end_time" class="validate-require-none" value="{$form_data.end_time}" style="width:97.5% !important;" {$readonly.end_time}/>
                        </strong>
                    </li>
                    <li class="control auctions_run_in_hours_control">
                        <label>
                            <strong style="float:left;width:320px;" id="notify_end_time">{localize translate="Auction Run In Hours"}
                                - <span style="font-size: 10px;">{localize translate="add to selection of 1-30 days, 1-23 hours."}</span>
                                <br><span style="font-size: 10px;">The end time field will be updated automatically when Auction Run In Hours is selected.</span>
                            </strong>
                        </label>
                        <strong style="float:left;width:200px">
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
                    {*<br clear="all"/>*}
                {elseif $isBlock}
                    <li class="control">
                        <label>
                            <strong style="float:left;width:320px;" id="notify_date_to_reg_bid">{localize translate="Date to lock the property"}</strong>
                        </label>
                        <strong style="float:left;width:200px;">
                            <div class="input-box">
                                <input type="text" name="date_to_reg_bid" id="date_to_reg_bid" class="" value="{$form_data.date_to_reg_bid}" style="width:97.5% !important;" {$readonly.start_time} />
                            </div>
                        </strong>
                         <span><a id="tooltip_2" href="javascript:void(0)" title="Date to hide this pro">
                                 <img style="margin-left: 45px;" src="/modules/general/templates/images/img_question.png"  />
                             </a></span>
                    </li>
                    {* <br clear="all"/>*}
                {/if}
                {if is_array($auction_terms) and count($auction_terms)>0}
                    <li>
                        <div id="pro_step6" style="clear: both">
                            <ul style="list-style: none;">
                                {foreach from = $auction_terms key = k item = v}
                                    <li class="control">
                                        {assign var = star value = ''}
                                        {assign var = require_id value = ''}
                                        {assign var = require_cls value = ''}
                                        {if $is_auction == true}
                                            {*{if in_array($v.code,array('auction_start_price','reserve','auction_date'))}
                                                {assign var = star value = '<span class="require">*</span>'}
                                                {assign var = require_cls value = 'validate-require'}
                                            {/if}*}
                                            {if in_array($v.code,array('reserve'))}
                                                {assign var = disabled value = $readonly.reserve_price}
                                                {assign var = title_ value = "Auction reserve price" }
                                            {else}
                                                {assign var = disabled value = $readonly.start_price }
                                                {assign var = title_ value= $v.title }
                                            {/if}
                                        {/if}
                                        {assign var = require_id value = "notify_`$v.code`"}
                                        {assign var = part1 value = 'width:320px'}
                                        {assign var = part2 value = 'width:200px'}
                                        {if $v.code == 'deposit_required'}
                                            {assign var = tooltip_title value=  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please define the % deposit you desire, from the buyer, upon the sale of your property. Do you want A 5, 10 or 15% deposit from the purchaser. Please refer to your Contract of Sale and solicitors  advice.</div>"}
                                        {/if}
                                        {if $v.code == 'settlement_period'}
                                            {assign var = tooltip_title value =  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please enter the timeframe you desire for settlement of the transaction, please list your settlement timeframe, 30, 60 or 90 days etc. Please refer to your Contract of Sale and solicitors  advice.</div>"}
                                        {/if}
                                        {if $v.code == 'contract_and_deposit_timeframe'}
                                            {assign var = tooltip_title value=  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please enter the timeframe you desire for the buyer to sign the contract and send to you and forward their deposit funds, 1,2 or 3 days etc. Please refer to your Contract of Sale and solicitors  advice.</div>"}
                                        {/if}
                                        {if $v.code == 'auction_start_price'}
                                            {assign var = tooltip_title value=  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please enter the price you would like your auction open at, prior to bids commencing.  Please be aware of the 10% +/- requirements, and your advertised/reserve price.</div>"}
                                        {/if}
                                        {if $v.code == 'reserve'}
                                            {assign var = tooltip_title value=  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please enter your reserve price, remember this is the price you are willing to sell at.  Please be aware that some states require a maximum of a 10% range +/- from advertised prices.  You can change your reserve price up to 3 days prior to the auction depending on feedback.</div>"}
                                        {/if}
                                        {if $v.code == 'initial_auction_increments'}
                                            {assign var = tooltip_title value=  "<div style='text-align: justify;padding:0px 10px;0px;10px'> Please set the minimum bid increment you would like your auction to start at.  This will allow bidders to bid at this level or higher, but not lower.  If you set too high bidders may not bid, if you set too low you may have a long auction which may not attain your reserve.  You can change this as you progress to and through the auction.</div>"}
                                        {/if}
                                        {if $v.code == 'schedule'}
                                            {assign var = tooltip_title value ="<div style='text-align: justify;padding:0px 10px;0px;10px'>please confirm with your lawyer which schedule applies to your auction. The schedules can be found at $ROOTURL/policies-rules/ibb-auction-rules.html for your review</div>"}
                                        {/if}
                                        {*{assign var = tooltip_title value=  "`$v.title`"}
                                        {if $v.type == 'text' }
                                            {assign var = tooltip_title value=  "`$form_data.tooltip_des_date_lock`"}
                                        {/if}*}
                                        {assign var = tooltip value=  "<span><a id=\"tooltip_`$k`\" href=\"javascript:void(0)\" title=\"`$tooltip_title`\"><img style=\"margin-left: 45px;\" src=\"/modules/general/templates/images/img_question.png\" /></a></span>"}
                                        {assign var = before value = "<strong style='float:left;`$part1`' id='$require_id'>`$title_` $star </strong>"}
                                        {assign var = after value = ""}
                                        <label>
                                            {$before}
                                        </label>
                                        <strong class="strong-number-gtzero" style="float:left;{$part2}">
                                            {if $v.type == 'text'}
                                            {if $v.code == 'auction_date'}
                                                <script type="text/javascript">
                                                </script>
                                            {/if}
                                                <input type ="text" name="" id="" class="{$require_cls}" value="{$price[$v.code]}" style="width:97.5% !important;" onkeyup="this.value=format_price(this.value,'#{$v.code}','#pro_step6')" {$disabled}/>
                                                <input type ="hidden" name="fields[term][{$k}]" id="{$v.code}" class="{$require_cls}" value="{$property_terms[$k]}" style="width:90%;"/>
                                            {elseif $v.type == 'select'}
                                                {assign var=tmp_options value=$v.options|@reset}
                                                {assign var=first value = $v.options|@key}
                                                <input id="add_new_{$v.code}" style="display: none;" type="text" name="new_fields[{$v.code}]" placeholder="Example: {$v.options.$first}"/>
                                            {if in_array($v.code,array('schedule'))}
                                                <div id="file-box-schedule" class="file-box" style="{if !($property_terms[$k]|strstr:"/store/uploads/files_schedule/")} display: none;{/if}">
                                                    <span class="file"><input type="file" name="schedule"/></span>
                                                    <span class="file-name">
                                                        {if $property_terms[$k]|strstr:"/store/uploads/files_schedule/"}
                                                        {$property_terms[$k]|replace:'/store/uploads/files_schedule/':''}
                                                        {/if}
                                                    </span>
                                                <span class="file-action" style="background-color: #cbcbcb">
                                                    {if ($property_terms[$k]|strstr:"/store/uploads/files_schedule/")}<span class="sp-delete">Delete</span>{else}No file{/if}</span>
                                                    <input class="file-delete" type="hidden" value="0" name="files_deleted[schedule]"/>
                                                </div>
                                            {/if}
                                            {if !$property_terms[$k]|strstr:"/store/uploads/files_schedule/"}
                                                <select onchange="newFields(this,'#add_new_{$v.code}')" name="fields[term][{$k}]" id="{$v.code}" class="input-select {$v.is_valid_zero}"
                                                        style="width:100%;{if $property_terms[$k]|strstr:"/store/uploads/files_schedule/"} display: none ;{/if}">
                                                    {html_options options = `$v.options` selected = $property_terms[$k]}
                                                    {if in_array($v.code,array('deposit_required','settlement_period','contract_and_deposit_timeframe'))}
                                                        <option value="new" label="Add New">Add New</option>
                                                    {/if}
                                                    {if in_array($v.code,array('schedule'))}
                                                        <option value="new-schedule" label="Upload New Schedule">Upload New Schedule</option>
                                                    {/if}

                                                </select>
                                            {/if}
                                            {elseif $v.type == 'checkbox'}
                                                {assign var = chked value = ''}
                                                {if isset($property_terms[$k]) and $property_terms[$k]>0}
                                                    {assign var = chked value ='checked'}
                                                {/if}
                                                <input type="checkbox" name="fields[term][{$k}]" id="term_{$k}" {$chked} class="{$require_cls}"/>
                                            {/if}
                                        </strong>
                                        {$after}
                                        {*{$tooltip}*}
                                        {*</label>*}
                                    </li>
                                    {*<br class="all"/>*}
                                {/foreach}
                            </ul>
                        </div>
                    </li>
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
  Calendar.setup({
    inputField : 'release_time',
    trigger    : 'release_time',
    onSelect   : function() { this.hide() },
    showTime   : true,
    dateFormat : "%Y-%m-%d %H:%M:%S"
  });
  Calendar.setup({
      inputField: 'end_time',
      trigger: 'end_time',
      onSelect: function () {
          this.hide()
      },
      showTime: true,
      dateFormat: "%Y-%m-%d %H:%M:%S"
  });
</script>
{/literal}
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
        /*newFields*/
        function newFields(obj,target){
            if(jQuery(obj).val() == 'new'){
                jQuery(obj).hide();
                jQuery(target).show();
            }
            if(jQuery(obj).val() == 'new-schedule'){
                jQuery(obj).hide();
                jQuery('#file-box-schedule').show();
            }
        }
    </script>
{/literal}


