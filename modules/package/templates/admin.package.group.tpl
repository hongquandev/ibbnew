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
                            Package Group Information
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
                                                 {if isset($bar_data) and is_array($bar_data) and count($bar_data) > 0}
    	                                                {foreach from = $bar_data key = i item = v}
                                                            <div id="group_info_tabs_{$i}" class="tabs">
                                                                {include file="admin.package.`$i`.tpl"}
                                                            </div>
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
                        {*<input type="button" class="button" value="Reset" onclick="package.resetAllElement('?module=package&action=save-{$action_ar[1]}&token={$token}')"/>*}
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
    <input type="hidden" name="group_id" id="group_id" value="{$package_id}" />
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
</script>
{/literal}