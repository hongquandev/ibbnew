<?php 
	
	 
	if ($_POST['submit']) {
		$firstname = $_POST['oldFirstName'];
		$lastname = $_POST['oldLastName'];
		$telephone = $_POST['oldTelephone'];
		
		if($firstname == $_POST['oldFirstName'] && $lastname == $_POST['oldLastName'] && $telephone == $_POST['oldTelephone'] && $_POST['oldPassword'] =='' && $_POST['Password']=='' && $_POST['ConfirmPassword'] =='')
		{
			$sql = mysql_query("UPDATE users SET FirstName='{$firstname}', LastName='{$lastname}', 				            Telephone='{$telephone}' WHERE ID='{$_SESSION['Admin']['ID']}'") or die (mysql_error());
	       
		   	$msg = $usersLang['Updated'];
		}
		
		 else if ($_POST['Password']=='') 
		 {
		    	//$msg = $usersLang['oldPasswordWrong'];
		    	$msg ='Password is empty';
		 }
		 else if ($_POST['Password'] != $_POST['ConfirmPassword']) 
		 {
			    //$msg = $usersLang['PasswordDoesNotMath'];	
				$msg ='Password is not match old password';	
		 }
		 else if ( md5($_POST['oldPassword']) != $_SESSION['Admin']['Password'])
		 {
		       //$msg ='Password is not match old password';
			   $msg = $usersLang['oldPasswordWrong'];
		 }
		 else
		 {
			$sql = mysql_query("UPDATE users SET Password='".md5($_POST['Password'])."',          	     FirstName='{$firstname}', LastName='{$lastname}', Telephone='{$telephone}' WHERE    ID='{$_SESSION['Admin']['ID']}'") or die (mysql_error());
			if ($sql)
			 {
				$msg = $usersLang['PasswordHasBeenChanged'];
			 }
			 else {
					$msg = 'Error!';
				  }
		 }
		
	
		$smarty->assign('message', $msg);  
		
	}
	if ($_GET['action']=='changepassword')
	  {
	   //print_r($_SESSION['Admin']['EmailAddress']);
	   $result =mysql_query("SELECT * from users WHERE ID='{$_SESSION['Admin']['ID']}'");
	     while ($row = mysql_fetch_array($result))
		 
		 {
		      $email     =$row['EmailAddress'];
		      $firstname =$row['FirstName'];
			  $lastname  =$row['LastName'];
			  $telephone =$row['Telephone'];
		 }
	  	   $profile = array('email'=>$email,'firstname'=>$firstname,'lastname'=>$lastname,'telephone'=>$telephone);
	   $smarty->assign('profile', $profile);  
	  }
	
	 
?>