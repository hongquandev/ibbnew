<div style="width:100%">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"></td>
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">                            
                            Content Banner Setting Information                       
                        </td>
                    </tr>
                </table>
            </td>    
        </tr>  
        <tr>
        <td colspan="2" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1" bgcolor="#CCCCCC"></td>
                    <td align="left" valign="top" class="padding1">
                        <table width="100%" cellspacing="15">
                            <tr>
                                <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                <!--bar-->
                                	{include file = 'admin.banner_setting.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>Content Banner setting</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                            {if isset($action)}
                                                    <form method="post" action="{$form_action}" class="cmxform" name="frmCreate" id="frmCreate" enctype="multipart/form-data" >
                                                  	<table class="edit-table" cellspacing="10" width="100%">
                                                       <tr>
                                                            <td width="19%">
                                                                 <strong id="notify_title">Title <span class="require">*</span></strong>
                                                            </td>
                                                            <td width="30%">
                                                              	<input type="text" id="title" name="fields[title]" class="input-text validate-require" style="width:100%" value="{$row.title}" />
                                                            </td>
                                                            <td width="19%"></td>
                                                            <td width="30%"></td>
                                                        </tr>

                                                        <tr>
                                                           <td><strong>Setting Value </strong></td>
                                                           <td width="30%">
                                                              	<input type="text" id="setting_value" name="fields[setting_value]" class="input-text validate-require" style="width:100%" value="{$row.setting_value}" />
                                                           </td>
                                                         
                                                        </tr>
                                                        <tr>
                                                        	<td> </td>
                                                            <td width="30%">
                                                              <i> Ex : You can input divided to 3 </i>
                                                            </td>
                                                        </tr>
                                                     	<tr>
                                                            <td colspan="4" align="right">
                                                                <hr/>
                                                                <input type="hidden" name="next" id="next" value="0"/>
                                                                <input type="button"  class="button" value="{if $action == 'add'}Create New Menu{else}Update Setting {/if}" onclick="bannerSetting.submit('#frmCreate');"/>
                                                                <input type="button" class="button" value="Back" onClick="window.location='{$url.list_menu}'"/>
                                                            </td>
                                                    	</tr>                                                      
                                                </table>
                                                </form>
                                                {else}
                                                    Can not find the template with this request.
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
            </table>
        </td>
        </tr>       
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="{$imagepart}left_bot.jpg" width="16" height="16" /></td>
                        <td background="{$imagepart}bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$imagepart}right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    var bannerSetting = new BannerSetting();
</script>



