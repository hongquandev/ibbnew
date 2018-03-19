<?php
    if($_POST) $request = $_POST;
	else if($_GET) $request = $_GET;
	else
	{
		echo '<error>no query</error>';
		return;
	}
	$ID = $_GET['ID'];
	$module = 'users';
	
	if ($_POST['submit']){
		$firstName = $_POST['firstname'];
		$lastName  = $_POST['lastname'];
		$email     = $_POST['email'];
		$telephone = $_POST['telephone']; 
		$country   = $_POST['country'];
		$state	   = $_POST['state'];	
		$today = getdate();
		$currentDate = $today["year"] . "-" . $today["mon"] ."-" . $today["mday"] . "-" . $today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];
		
		if (empty($firstName) || empty($lastName) || empty($email)){
			 $msg ="Please enter all value.";
		}
		elseif (!eregi('^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9_\-.]+\.([a-zA-Z]{2,4})$',$email)){
			
			 $msg ="Your email address is not correct.";
			}
		else
		    {
			  $query= mysql_query("UPDATE agent  SET firstname = '{$firstName}', lastname = '$lastName', email_address = '$email', telephone = '$telephone', country ='{$country}', suburb ='{$state}', update_time = '{$currentDate}'
			    			   WHERE agent_id ='$ID' ") or die(mysql_error());
			 // $msg = "Updated successfully.";
			 redirect('?module='.$module.'&action=list');
			}	
		//$smarty->assign('message', $msg);  

	
	}
?>
