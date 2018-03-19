 <!-- LIBS -->
<script type="text/javascript" src="js/ext-base.js"></script>
<!-- ENDLIBS -->
<script type="text/javascript" src="js/ext-all.js"></script> 

<script type="text/javascript" src="../modules/users/js/paging.js"></script>

<form method="post"  action="" enctype="" name="frm">
<table width="90%" align="center" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td  ><div id="msgID" align="center" style="color:#FF0000" class="textbox"></div> </td>
  </tr>

  <tr>
    <td ><div id="topic-grid"></div> </td>
  </tr>
</table> 

</form> 
<div onClick="event.cancelBubble = true;" class="popup" id="nameFieldPopup"> 
<form method="post" action="../modules/users/post.php" name="frmEdit" onsubmit="Post.Send(this); return false;" enctype="multipart/form-data">
<input type="hidden" name="ID" value="">
<table width="100%" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td>{$usersLang.FirstName}</td>
    <td><input type="text" name="FirstName" id="FirstName" style="width:180px" /></td>
  </tr>
   <tr>
    <td>{$usersLang.LastName}</td>
    <td><input type="text" name="LastName" id="LastName" style="width:180px" /></td>
  </tr>
  <tr>
    <td>{$usersLang.Telephone}</td>
    <td><input type="text" name="Telephone" id="Telephone" style="width:180px" /></td>
  </tr>
  <tr>
    <td>{$usersLang.Username}</td>
    <td><input type="text" name="EmailAddress" id="EmailAddress" style="width:180px" /></td>
  </tr>
  <tr>
    <td>{$usersLang.Password}</td>
    <td><input type="password" name="Password" id="Password" style="width:180px" /></td>
  </tr>
  <tr>
    <td>{$usersLang.confirmPassword}</td>
    <td><input type="password" name="CPassword" id="CPassword" style="width:180px" /></td>
  </tr>
  <tr>
    <td>{$usersLang.Level}</td>
    <td>
    <select name="userLevel">
    <option value="0">User</option>
    <option value="1">Admin</option>
    </select> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="{$usersLang.OK}" onclick="{literal}javascript: if (document.frmEdit.EmailAddress.value =='' || document.frmEdit.Password.value != document.frmEdit.CPassword.value) { alert('{/literal}{$usersLang.PleaseEnter}{literal}'); return false; }{/literal}" />
      <input type="button" value="{$usersLang.Close}" onclick='hideCurrentPopup(); return false;' /></td>
  </tr>
</table>
 
</form>
</div> 
<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
