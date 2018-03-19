<?php

	//include(ROOTPATH.'/includes/adodb/adodb.inc.php'); 

	//$smarty = new Smarty;  
	//$smarty->compile_dir = '../../templates_c/'; 

 if($_POST) $request = $_POST;
	else if($_GET) $request = $_GET;
	else
	{
		echo '<error>no query</error>';
		return;
	}
	$ID = $_GET['ID'];
	
	if ($_POST['submit']) {
		$firstName = $_POST['firstname'];
		$lastName  = $_POST['lastname'];
		$email     = $_POST['email'];
		$telephone = $_POST['telephone']; 
		$country   = $_POST['country'];
		$state	   = $_POST['state'];	
		
		$today = getdate();
		$currentDate = $today["year"] . "-" . $today["mon"] ."-" . $today["mday"] . "-" . $today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];
		 
		$query = mysql_query("INSERT INTO agent(firstname, lastname, email_address, telephone, country, suburb,	creation_time)
										 VALUES('$firstName', '$lastName', '$email', '$telephone', '$country', '$state', '$currentDate')")
			    or die(mysql_error());		
		
		echo $query->sql;
	}
	
?>
