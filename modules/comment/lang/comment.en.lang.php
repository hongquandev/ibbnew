<?php 

$commentLang = array (
"PleaseEnter" => "Please enter all fields",
"Close" => "Close",
"OK" => "OK",

"FirstName" => "FirstName",
"LastName" => "LastName",
"Telephone" => "Telephone",
"Duplicate" => "This Username is already exist.",
"Login" => "Administrator Login",
"Register" => "Register",
"Username" => "Username",
"Password" => "Password",
"oldPassword" => "Old Password",
"confirmPassword" => "Confirm Password",
"Change" => "Change",
"loginMsg" => "Please enter Username and Password",
"loginError" => "Could not login, Please try again.", 
"Updated" => "Updated successfully", 
"Active" => "Active", 
"InActive" => "In Active", 
"Edit" => "Edit",
"Approve" => "Approve",
"View" => "View",
"Delete" => "Delete",
"RUS" => "Are you sure you want to delete?",
"oldPasswordWrong" => "The old password is wrong",
"PasswordDoesNotMath" => "Password does not match",
"PasswordHasBeenChanged" => "Password has been changed",
);

if (isset($smarty)) {
	$smarty->assign('commentLang', $commentLang);  
}
?>