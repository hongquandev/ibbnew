<?php
/***************************************************************************
*
*   Filename           : users.class.php
*   Began              : 2008/01/24
*   Modified           : 2008/12/18 	
*   Copyright          : (c) 2008
*   Commercial Support : ngchphuong@yahoo.com
*   Version            : 1.0.0 Eros
*   Written by         : Nguyen Chon Phuong
*
*   You are encouraged to redistribute and / or modify this program under the terms of
*   the GNU General Public License as published by the Free Software Foundation
*   (www.fsf.org); any version as from version 2 of the License.
*
***************************************************************************/


class Users { 
	 	 

	 function checkUser($field,$value,$Level){

	 	$result = mysql_query("SELECT `$field` FROM `users` WHERE `$field` = '$value' AND Level = '$Level'");
 			if(mysql_num_rows($result)>0){
 				return true;
 			}else{
 				return false;
 			}
	 } 

	 function adminLogin($Username, $Password){
		global $_SESSION;

     	$sql = "SELECT ID, EmailAddress, Password, Level FROM `users` WHERE `EmailAddress` = '$Username' AND `Password` = '".md5($Password)."' AND `Status` = 1";
	 	$result = mysql_query($sql);
		
		if (!$result) { die(mysql_error()); };

		if (mysql_num_rows($result) > 0) {
			list($ID, $EmailAddress, $Password, $Level)=mysql_fetch_row($result);
			$_SESSION['Admin'] = array ("Logged"=>TRUE, "ID"=>$ID, "Level"=>$Level,  "EmailAddress" => $EmailAddress, "Password" => $Password);
			mysql_free_result ($result);
			return true;
		}else{
			return false;
		}

	 }


}

?>