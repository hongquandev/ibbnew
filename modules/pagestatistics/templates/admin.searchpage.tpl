<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search View Page</title>
<link rel="stylesheet" type="text/css" href="../general/templates/style/css.css" />
<script language="javascript" type="text/javascript" src="../../admin/ajax/js/Ajax.js"></script>
<script language="javascript" type="text/javascript" src="../../admin/ajax/js/PostPopup.js"></script>
 


 {literal}
 
<script src="jslang/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="jslang/jquery.ui.core.js" type="text/javascript"></script>
<script src="jslang/jquery.ui.datepicker.js" type="text/javascript"></script>
<script src="jslang/jquery.ui.widget.js" type="text/javascript"></script>

 <script type="text/javascript">
	function validate_form()
	{
		valid = true;
	
		if (document.searchFrm.date.value == "")
		{
			alert ("Please choose date in the box.");
			valid = false;
		}
		return valid;
	}

</script>


<link rel="stylesheet" type="text/css"
 media="screen" href="../pagestatistics/templates/base/jquery.ui.all.css" />  
	 <script type="text/javascript">
		$(function() {
			$('#datepicker').datepicker();
		});
	</script>

 {/literal}

<body>
<form method="post"  onsubmit="return validate_form();" action="popup.php?ID={$row.page_id}" name="searchFrm" id="searchFrm" enctype="multipart/form-data">

<table border='0' cellpadding='3' cellspacing='1' width='100%' align="center">
<h3 align="center"> Search Number Page On Date </h3>
<tr><td width="19%" id='txtDID'>Page Title</td>
<td width="81%">
	<input type="text" disabled="disabled" value="{$row.title}" />
</td></tr> 
<tr><td id='txtDID'>Choose Date </td><td>
	<input type="text" id="datepicker" name="date"  />
</td></tr> 
<tr><td id='txtDID'></td><td>
{if (isset($viewsearch)) }
<tr><td id='txtDID'>Views Number </td><td>
	<input type="text" name="values" disabled="disabled" id="values" value="{$viewsearch.views}" />
</td></tr> 

{/if}
</td></tr> 
<tr><td></td><td><input type='submit' name='submit' value='Submit' /> 
				<input type="button" value="Close" onclick='window.close();' /></td></tr>
</table>

</form>

</body>
</html>

