<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css" />
{literal}
<script type="text/javascript">
    function format_price_new(num, id, form_id, cent) {
        if(typeof num == 'undefined'){
            return 0;
        }
        num.toString();
        var price = num;
        if(typeof num == 'string')
        {
            price = num;
            i = price.indexOf("$");
            price = price.substr(i + 1, price.length - i + 1);
            //format price
            var j = 0;
            for (j; j <= price.length; j++) {
                price = price.replace(",", "");
            }
        }
        //if (formatCurrency(num) == '$0') price = 0;
        console.log(price);
        if (form_id == null) {
            jQuery(id).val(price);
        }else {
            jQuery(id, form_id).val(price);
        }
        if (cent != null) {
            if (num.length){
                return formatCurrency(num, cent);
            }
            return num;
        }else {
            if (num.length){
                return formatCurrency(num);
            }
            return num;
        }
    }
</script>
{/literal}
<div class="pack_option">
<table width="100%" cellspacing="10" class="edit-table">
	{foreach from = $options key = k item = option}
        <tr>
            {assign var = group value = "group_`$tab`"}
            {assign var = code value = $option.code}
            <td width = "22%">
                <strong id="notify_group_{$tab}_{$code}">{$option.name} {if $option.is_required}<span class="require">*</span>{/if}</strong>
            </td>
            <td>
                {if $option.type == 'text'}
                       <input type="text" name="group_{$tab}[{$code}]" id="group_{$tab}_{$code}" value="{$form_data.$group.$code}" class="input-text disable-auto-complete {if $option.is_required}validate-require{/if}" style="width:50%"/>
                       {if $option.has_unit}
                       ({$option.unit})
                       {/if}
                {elseif $option.type == 'select'}
                        <select name="group_{$tab}[{$code}]" id="group_{$tab}_{$code}" class="input-select {if $option.is_required}validate-require{/if}" style="width:50%">
                            {html_options options=$option.list selected = $form_data.$group.$code}
                        </select>
                        {if $option.has_unit}
                        ({$option.unit})
                        {/if}
                {elseif $option.type == 'multiselect'}
                        <select name="group_{$tab}[{$code}][]" id="group_{$tab}_{$code}" class="input-select {if $option.is_required}validate-require{/if}" style="width:50%" multiple>
                            {html_options options=$option.list selected = $form_data.$group.$code}
                        </select>
                {elseif $option.type == 'textarea'}
                        <textarea name="group_{$tab}_{$code}]" id="group_{$tab}_{$options.code}" class="input-text" style="width:100%;height:100px">{$form_data.$group.$code}</textarea>
                {elseif $option.type == 'price'}
                        {assign var = price_field value = "`$code`_show"}
                        <input type="text" id="group_{$tab}_{$code}_show" value="{$form_data.$group.$price_field}" class="input-text disable-auto-complete {if $option.is_required}validate-require{/if}" onblur="this.value=format_price_new(this.value,'#group_{$tab}_{$code}','','cent')" style="width:50%"/>
                        ($AU)
                        <input type="hidden" name="group_{$tab}[{$code}]" id="group_{$tab}_{$code}" value="{$form_data.$group.$code}" class="input-text {if $option.is_required}validate-money{/if} disable-auto-complete" style="width:50%"/>
                {elseif $option.type == 'boolean'}
                        <select name="group_{$tab}[{$code}]" id="group_{$tab}_{$code}" class="input-select" style="width:50%">
                            {html_options options=$options_yes_no selected = $form_data.$group.$code}
                        </select>
                {elseif $option.type == 'date'}
                        <input type="text" name="group_{$tab}[{$code}]" id="group_{$tab}_{$code}" value="{$form_data.$group.$code}" class="input-text disable-auto-complete {if $option.is_required}validate-require{/if}" style="width:50%"/>
                        {literal}
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField : '{/literal}group_{$tab}_{$code}{literal}',
                                trigger    : '{/literal}group_{$tab}_{$code}{literal}',
                                onSelect   : function() { this.hide() },
                                showTime   : false,
                                dateFormat : "%Y-%m-%d"
                            });
                        </script>
                        {/literal}
                {/if}
            </td>
        </tr>
    {/foreach}
</table>
</div>
