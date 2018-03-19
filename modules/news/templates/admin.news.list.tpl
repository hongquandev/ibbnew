<br />
<table width="778" align="center" border="0" cellspacing="0" cellpadding="0">
		
      <tr>
        <td   align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="9" align="left" valign="top"><img src="{$templatesPath}/images/left_search.jpg" width="9" height="25" alt="" /></td>
                        <td align="center" valign="middle" bgcolor="#0159BA" class="bold12white">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="bold12white">{$newsLanguage.News}</td>
    <td align="right" ><a href="index.php?module=news&amp;action=add" style="color:#ffffff">{$newsLanguage.AddNew}</a></td>
  </tr>
</table>

                             
						</td>
                        <td width="9" align="right" valign="top"><img src="{$templatesPath}/images/right_search.jpg" width="9" height="25" alt="" /></td>
                      </tr>
                  </table></td>
                </tr>
				
                <tr>
                  <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                        
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="3">
  <tr style="font-weight:bold">
    <td>#</td>
    <td>{$newsLanguage.Title}</td>
    <td>{$newsLanguage.Updated}</td> 
    <td colspan="2" align="center">{$newsLanguage.Tools}</td>
  </tr>
{foreach item=item key=key from = $news}  
  <tr>
    <td>{$item.No}</td>
    <td>{$item.Title}</td>
    <td>{$item.Updated}</td>
    <td align="center"><a href="index.php?module=news&amp;action=add&amp;NewsID={$item.NewsID}">{$newsLanguage.Edit}</a></td>
    <td align="center"><a href="index.php?module=news&amp;Delete={$newsLanguage.NewsID}" onclick="return confirm('{$newsLanguage.RUS}');">{$newsLanguage.Delete}</a></td>
  </tr>
  
{/foreach} 
<tr>
    <td colspan="5" align="center">{$newsLanguage.Page}: {$divPages}</td>
  </tr> 
</table>                       
                        </td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="12" align="left" valign="top"><img src="{$templatesPath}/images/left_bot.jpg" width="16" height="16" alt="" /></td>
                        <td style="background:url({$templatesPath}/images/bgd_bot.jpg)">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$templatesPath}/images/right_bot.jpg" width="16" height="16" alt="" /></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>

