{literal}
<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script> 
<script type="text/javascript" src="../modules/faq/js/paging.en.js"></script>
{/literal}

<form method="post"  action="" enctype="" >
<table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
  <tr>
     <td align="right"><!-- {include file = admin.banner.search.tool.tpl} --> </td>
  </tr>
    

  <tr>
    <td ><div id="topic-grid"></div> </td>
  </tr>
</table> 

</form>
<div onClick="event.cancelBubble = true;" class="popup" id="nameFieldPopup"> 
 
<form method="post" action="" name="frmEdit" onSubmit="Post.Send(this); return false;" enctype="multipart/form-data" >
<input type="hidden" name="page_id" value="{$row.page_id}">
<table width="778" border="0" align="center" cellspacing="1" cellpadding="3"> 
<tr>
<td colspan="2" style="font-weight:bold; text-transform:uppercase">{$CmsLang.Title}</td>
</tr>
<tr>
    <td colspan="2"  ><div id="msgID" align="center" style="color:#FF0000" class="textbox"></div> </td>
  </tr>
    
    <tr><td>{$CmsLang.Content}</td><td >
    
    </td></tr> <tr>
    <tr><td>{$CmsLang.Creation_time}</td><td >
    <select name="JID" style="width:450px" onChange="changeDept('../modules/apportion/dept.xml.php?ID='+ this.value)">
    <option value="">-- --</option>
    {html_options options=$jobs selected=$row.JID}
    </select>
    </td></tr> <tr>
    <tr><td>{$CmsLang.Update_time}</td><td >
    <select name="page_id" style="width:450px">
    <option value="">-- --</option>
     
    </select>
    </td></tr> 
    <tr><td>{$CmsLang.Is_active}</td><td >
    <input type="text" name="Position" style="width:50px" value="{$row.title}">
    </td></tr> 
    <tr>
    <tr><td>{$CmsLang.Sort_order}</td><td >
    <textarea name="content" mce_editable = 'false' style="width:450px" cols="40" rows="10">{$row.content}</textarea>
    </td></tr> 
    
    
    <tr>
     
     <td> </td><td><input type="submit" name="submit" value="{$apportionLang.OK}" onClick="{literal}javascript: if (document.frmEdit.MID.value =='') { alert('{/literal}{$apportionLang.PleaseEnter}{literal}'); return false; }{/literal}"> <input type="button" value="{$generalLang.Back}" onClick="window.location='index.php?module=Cms'"></td>
  </tr> 
    
</table>
</form>
 
</div> 
<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>


