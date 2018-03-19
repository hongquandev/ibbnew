<?php
			header('Location: http://'.$_SERVER['HTTP_HOST']."/admin/index.php");		
			require '../../configs/config.inc.php';
			require '../../includes/smarty/Smarty.class.php';
				//get value to form
				$emailname = $_POST['txtEmail'];
				// create xml document
				$xmldoc = new DOMDocument();
				$xmldoc->formatOutput = true;		
				// create root nodes
				$root = $xmldoc->createElement("ContactUs");
				$xmldoc->appendChild( $root );		
				// create element nodes
				$eleme = $xmldoc->createElement("Contact");	
				$fname = $xmldoc->createElement("EmailName");
				$fname->appendChild($xmldoc->createTextNode($emailname));
				$eleme->appendChild($fname);   
				//create end root nodes
				$root->appendChild($eleme);
				//save file
				$xmldoc->save('contact.xml'); 	
				//file_put_contents(ROOTPATH.'/tam.txt', $handle);	
				
				// Write System Logs
				mysql_query("INSERT INTO `systemlogs` SET  `Updated`='".date("Y-m-d H:i:s")."', `Action`='UPDATE', `Detail`=' CONTACT SET EMAIL : $emailname', `UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '".$_SERVER['REMOTE_ADDR']."'");		
		
				
?>