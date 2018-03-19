<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>

<script src="/modules/package/templates/js/admin.js" type="text/javascript"></script>

<script type="text/javascript">
var package = new Package('#frmPackage');
</script>

<div style="width:100%">

<form method="post" name="frmPackage" id="frmPackage" action="{$form_action}">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr >
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>
        </tr>
        <tr>
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">
                            Package Pricing Information
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1" bgcolor="#CCCCCC"></td>
                    <td align="left" valign="top" class="padding1">
                        <table width="100%" cellspacing="15">
                            <tr>
                                <td width="22%" valign="top" class="bar" id="myaccount-nav">
                                <!--bar-->
                                	{include file = 'admin.package.group.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if $message}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>{$title}</label>
                                            </td>
                                        </tr>

                                        <tr>
                                        	<td class="box-content">
                                                <div id="package_info_tabs_general" class="tabs">
                                                    {include file="admin.package.tab.general.tpl"}
                                                </div>
                                                 {if isset($bar_data) and is_array($bar_data) and count($bar_data) > 0}
    	                                                {foreach from = $bar_data key = i item = v}
                                                            {if isset($v.options)}
                                                                <div id="package_info_tabs_{$i}" class="tabs">
                                                                    {include file="admin.package.tab.tpl" tab=$i options=$v.options}
                                                                </div>
                                                            {/if}
                                                        {/foreach}
                                                 {/if}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="1" bgcolor="#CCCCCC"></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <hr/>
                        <input type="hidden" name="next" id="next" value="0"/>
                        <input type="button" class="button" value="Reset"
                               onclick="package.reset('?module=package&action=save-{$action_ar[1]}&token={$token}')"/>
                        <input type="button" class="button" value="Save" onclick="package.submit()"/>
                        <input type="button" class="button" value="Save & Next" onclick="package.submit(true)"/>
                    </td>
                </tr>
            </table>
        </td>
        </tr>

        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <input type="hidden" name="package_id" id="package_id" value="{$package_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
</div>
{literal}
<script type="text/javascript">
    var Tab = function(container, bar){
        this.container = container;
        this.bar = bar;
    };
    Tab.prototype = {
        load:function() {
            //get first tab and set default
            if (typeof(this.container) == 'string'){
                this.container = jQuery(this.container);
            }
            if (typeof(this.bar) == 'string'){
                this.bar = jQuery(this.bar);
            }
            this.container.find('.tabs').hide();
            var firstTab = this.container.children().first();
            var self = this;
            jQuery(this.bar.find('li')).each(function( index ) {
                jQuery(this).bind('click',function(){
                    self.show(jQuery(this).attr('ref'));
                })
            });
            this.show('#'+firstTab.attr('id'));
        },

        show:function(id) {
            this.container.find('.tabs').hide();
            this.bar.find('li').removeClass('select');
            this.container.find(id).show();
            var self = this;
            jQuery(this.bar.find('li')).each(function( index ) {
                if (jQuery(this).attr('ref') == id){
                    jQuery(this).addClass('select');
                    jQuery('.box-title label').text(jQuery(this).text());
                }
            });
        }
    };
    jQuery(document).ready(function(){
        var tab = new Tab(jQuery('.box-content'),jQuery('.tabs-bar'));
        tab.load();
    });

    //validate price
    function validPrice(){
        {/literal}
        {foreach from = $bar_data key = i item = v}
            {if is_numeric($i)}
        {literal}
        if (jQuery('#group_{/literal}{$i}{literal}_special_price').length > 0 && jQuery('#group_{/literal}{$i}{literal}_special_price').val().length > 0){
            var special_price = jQuery('#group_{/literal}{$i}{literal}_special_price').val();
            var price = jQuery('#group_{/literal}{$i}{literal}_price').val();
            var label_special_price = jQuery('#notify_group_{/literal}{$i}{literal}_special_price').text();
            var label_price = jQuery('#notify_group_{/literal}{$i}{literal}_price').text();
            if (parseFloat(special_price) > parseFloat(price)){
                Ext.Msg.show({
                    title:'Warning?'
                    ,msg: label_special_price+' must be less than '+label_price
                    ,icon:Ext.Msg.WARNING
                    ,buttons:Ext.Msg.OK
                });
                Common.warningObject('#group_{/literal}{$i}{literal}_special_price_show');
                Common.warningObject('#group_{/literal}{$i}{literal}_price_show');
                return false;
            }
        }
        {/literal}
            {/if}
        {/foreach}
        {literal}
        return true;
    }

    function validDate(){
         {/literal}
         {foreach from = $bar_data key = i item = v}
            {if is_numeric($i)}
         {literal}
         if (jQuery('#group_{/literal}{$i}{literal}_special_price_from').val() > jQuery('#group_{/literal}{$i}{literal}_special_price_to').val()){
              Common.warningObject('#group_{/literal}{$i}{literal}_special_price_from');
              Common.warningObject('#group_{/literal}{$i}{literal}_special_price_to');
              return false;
         }
         {/literal}
            {/if}
         {/foreach}
         {literal}
         return true;
    }

    package.flushCallback();
    package.callback_func.push(function() {
        return validPrice();
    });
    package.callback_func.push(function() {
        return validDate();
    });
</script>
{/literal}