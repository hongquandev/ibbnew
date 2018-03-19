<br />
<table width="778" align="center" border="0" cellspacing="0" cellpadding="0">
		
      <tr>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="9" align="left" valign="top"><img src="{$templatesPath}/images/left_search.jpg" width="9" height="25" alt="" /></td>
                        <td align="center" valign="middle" bgcolor="#0159BA" class="bold12white">
							{$newsLanguage.News}
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
                        
<form method="post" action="" enctype="multipart/form-data">
<input name="NewsID" value="{$row.NewsID}" type="hidden" />
<table border="0" cellpadding="1" cellspacing="1"> 
 <tbody> 
 <tbody><tr><td></td><td align="center">{$message}</td></tr>
 
 <tr><td id="txtTitle">{$newsLanguage.Title}</td>
 <td>
  <input name="Title" style="width: 400px;" value="{$row.Title}" type="text" />
 </td></tr>
 <tr><td>{$newsLanguage.Title} ({$newsLanguage.Vietnamese})</td>
 <td>

  <input name="vnTitle" style="width: 400px;" value="{$row.vnTitle}" type="text" />
 </td></tr>
     <tr>
    <td>{$newsLanguage.Photo}</td>
    <td>
	<input name="Photo" type="file" />	</td> 
  </tr>
   <tr>
    <td> </td>
    <td>
    
    {if $row.Photo != ''}
    <img src="{$row.Photo}" alt="" /><br />
    <input type = 'checkbox' name = 'delImg' value = '1' /> {$newsLanguage.DelImg}
    {/if} 
  </td> 
  </tr>
    <tr>

    <td id="txtIntro">{$newsLanguage.Intro}</td>
    <td>
	<textarea name="Intro" mce_editable="false" cols="60" rows="7">{$row.Intro}</textarea> </td> 
  </tr>

    <tr>
    <td>{$newsLanguage.Intro} ({$newsLanguage.Vietnamese})</td>
    <td>
	<textarea name="vnIntro" mce_editable="false" cols="60" rows="7">{$row.vnIntro}</textarea> </td> 
  </tr>

    <tr>
    <td id="txtContent">{$newsLanguage.Content}</td>
    <td>
	<textarea name="Content" cols="60" rows="20">{$row.Content}</textarea> </td> 
  </tr>

    <tr>
    <td>{$newsLanguage.Content} ({$newsLanguage.Vietnamese})</td>
    <td>
	<textarea name="vnContent" cols="60" rows="20">{$row.vnContent}</textarea> </td> 
  </tr>

    <tr><td></td><td><input name="submit" value="{$newsLanguage.AddNew}" type="submit" /> <input name="submit" value="&laquo; {$newsLanguage.Back}" onClick="window.location = 'index.php?module=news'" type="button" /></td></tr>
</tbody></table>
</form> 
                     
                        </td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="12" align="left" valign="top"><img src="{$templatesPath}/images/left_bot.jpg" width="16" height="16" alt="" /></td>
                        <td style="background: url({$templatesPath}/images/bgd_bot.jpg)">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$templatesPath}/images/right_bot.jpg" width="16" height="16" alt="" /></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>

