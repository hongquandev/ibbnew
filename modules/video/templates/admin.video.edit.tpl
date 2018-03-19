{literal}
	<script>
    var video = new Video();
	
	function toggleEmbed() {
		if (jQuery('#is_embed').is(':checked')) {
			jQuery('#embed0').hide();
			jQuery('#embed1').show();
		} else {
			jQuery('#embed0').show();
			jQuery('#embed1').hide();
		}
	}
	</script>
{/literal}

<div style="width:100%">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="2" align="center"></td></tr> 
        <tr> 
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">Video Information</td></tr>
                </table>
            </td>    
        </tr>
        
        <tr>
            <td colspan="2">
                <form method="post" action="{$form_action}" name="frmCreate" id="frmCreate" enctype="multipart/form-data" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                            <table width="100%" cellspacing="15">
                                <tr>
                                    <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                    <!--bar-->
                                        {include file = 'admin.video.bar.tpl'}
                                    </td>
                                    <td valign="top">
                                        {if isset($message) and strlen($message) > 0}
                                            <div class="message-box">{$message}</div>
                                        {/if}
                                        <table width="100%" cellspacing="0" class="box">
                                            <tr><td class="box-title"><label>Video detail</label></td></tr>
                                            <tr>
                                                <td class="box-content">
                                                    {if isset($action)}
                                                    <table class="edit-table" cellspacing="10" width="100%">
                                                        <tr>
                                                            <td width="19%"><strong id="notify_title">Video Name<span class="require">*</span></strong></td>
                                                            <td>
                                                                <input type="text" id="video_name" name="video_name" class="input-text validate-require" style="width:100%;" value="{$row.video_name}"/>
                                                            </td>
                                                        </tr>
                                                    
                                                        <tr>
                                                            <td width="19%"><strong id="notify_file">Embeded File</strong></td>
                                                            <td>
                                                            	<div id="embed1">
                                                                <textarea name="video_file" id="video_file" rows="5" cols="80" style="width:100%"  class="content">{$row.video_file}</textarea>
                                                                </div>
                                                                <!--
                                                                <div id="embed0">	
                                                                    <input type="file" name="file_video_name" id="file_video_name"/>
                                                                    {if strlen($row.video_file) > 0 && $row.is_embed == 0}
                                                                        <br/>
                                                                        {$row.video_file}
                                                                    {/if}
                                                                    <br/>Extentions allowed (mpeg, wmv, wmv, mov), Max size: 10M.
                                                                </div>
                                                                -->
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td width="19%"><strong id="notify_content">Content</strong></td>
                                                            <td>
                                                                <textarea name="video_content" id="video_content" rows="15" cols="80" style="width:100%"  class="content">{$row.video_content}</textarea>
                                                            </td>
                                                        </tr>                                                        
                                                        <!--
                                                        <tr>
                                                            <td width="19%">
                                                                <strong id="notify_sort_order">Is Embed<span class="require">*</span></strong>
                                                            </td>
                                                            <td>
                                                            	<input type="checkbox" name="is_embed" id="is_embed" value="1" {if $row.is_embed == 1}checked="checked"{/if} onclick="toggleEmbed()"/>
                                                            </td>
                                                        </tr>
                                                    	-->
                                                        <tr>
                                                            <td align="right" colspan="4">
                                                                <hr />
                                                                <input type="button" class="button" id="btncrt" value="{if $page_id > 0}Update{else}Create{/if} Page" onClick="video.submit('#frmCreate');"/>
                                                                <input type="button" class="button" value="Back" onClick="window.location='?module=video&token={$token}'" />
                                                                <input type="hidden" name="video_id" id="video_id" value="{$video_id}"/>
                                                                <input type="hidden" name="is_embed" id="is_embed" value="1"/>
                                                            </td>
                                                        </tr>
                                                    </table>
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
            </form>
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
{literal}
	<script>
	//toggleEmbed();
	</script>	
{/literal}
