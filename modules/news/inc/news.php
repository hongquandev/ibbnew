<?php 

include "news.class.php";
$news = new News;

include "../includes/checkingform.class.php";
$check = new CheckingForm; 

$check -> arr = array('Title','Content','Intro');  
	 
	if ($_POST['submit']) {


        if (!$check -> checkForm()) {//checking missing fields

		$row = $_POST;
		$check -> showRed ();
		$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields."; 

		}else{
	
			if ($_POST['NewsID'] > 0) {
				$news -> updateItem($_POST['NewsID']);
				$newestID = $_POST['NewsID'];
				$message = "The news has been edited";
			}else{
				$news -> insertItem();
				$newestID = mysql_insert_id();
				$message = "The news has been added";
			}
			
			if($_FILES['Photo']['name']!=''){
				$ext = substr($_FILES['Photo']['name'],-3);
				$Photoname = time().".$ext ";
				if(!move_uploaded_file($_FILES['Photo']['tmp_name'],"../store/files/".$Photoname)){
				
				$msg = "Could not upload photo.";
				
				}else{		
							 
				$result=mysql_query("SELECT Photo FROM `news` WHERE NewsID='$newestID'");
				list($Photo)=mysql_fetch_row($result);
				@unlink("../store/files/$Photo");
		
				mysql_query("UPDATE `news` SET `Photo`='$Photoname' WHERE NewsID='$newestID'"); 
							 
				}
			}
			
			if ($_POST['delImg'] == 1) {
				$result=mysql_query("SELECT Photo FROM `news` WHERE NewsID='$newestID'");
				list($Photo)=mysql_fetch_row($result);
				@unlink("../store/files/$Photo");
				mysql_query("UPDATE `news` SET `Photo` = '' WHERE NewsID = '$newestID'");  
		
			}
	
	}
	
	$smarty -> assign("message",$message);	
	$smarty -> assign("msg",$msg);	
}



if ($_GET['NewsID'] > 0) {
	$smarty -> assign("row",$news->getSingleRow($_GET['NewsID']));	
}
?>