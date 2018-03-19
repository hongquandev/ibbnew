<?php
/***************************************************************************
*
*   Filename           : news.class.php
*   Began              : 2008/12/19
*   Modified           : 
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


class News { 

	 function insertItem(){
	 global $_POST;

	 
	 	$sql = "INSERT INTO `news` SET `CatID`='".addslashes($_POST['CatID'])."', `Title`='".addslashes($_POST['Title'])."', `vnTitle`='".addslashes($_POST['vnTitle'])."', `Intro`='".addslashes($_POST['Intro'])."', `vnIntro`='".addslashes($_POST['vnIntro'])."', `Content`='".addslashes($_POST['Content'])."', `vnContent`='".addslashes($_POST['vnContent'])."',  `Updated`='".time()."'"; 
	 	if (!mysql_query($sql)) { die(mysql_error()); };

	 }

	 function updateItem($ID){
	 global $_POST;

        $sql = "UPDATE `news` SET `CatID`='".addslashes($_POST['CatID'])."', `Title`='".addslashes($_POST['Title'])."', `vnTitle`='".addslashes($_POST['vnTitle'])."', `Intro`='".addslashes($_POST['Intro'])."', `vnIntro`='".addslashes($_POST['vnIntro'])."', `Content`='".addslashes($_POST['Content'])."', `vnContent`='".addslashes($_POST['vnContent'])."' WHERE NewsID='$ID'";

	 	if (!mysql_query($sql)) { die(mysql_error()); };

	 }

	 function deleteItem($ID){
		$result=mysql_query("SELECT Photo FROM `news` WHERE NewsID='$ID'");
		list($Photo)=mysql_fetch_row($result);
		@unlink("../store/files/$Photo");
	 	if (!mysql_query("DELETE FROM `news`  WHERE NewsID='$ID'")){ die(mysql_error());}

	 }

	 function getSingleRow($ID){

	 	$result = mysql_query("SELECT * FROM `news` WHERE NewsID='$ID'");
	 	$row = mysql_fetch_assoc($result);
	 	mysql_free_result ($result);
	 	$row['Title'] = stripslashes($row['Title']);
		$row['vnTitle'] = stripslashes($row['vnTitle']);
		$row['Content'] = stripslashes($row['Content']);
		$row['vnContent'] = stripslashes($row['vnContent']);
		if (is_file("../store/files_thumb/{$row['Photo']}")) {
			$fileName = "../store/files_thumb/{$row['Photo']}";
        }else{
			$fileName = "../resize.php?filename={$row['Photo']}&h=150&w=150";
        }
		$row['Photo'] = $fileName;
		
		return $row;

	 } 
	  

}

?>