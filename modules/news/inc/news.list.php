<?php 

	include "news.class.php";
	$news = new News;


 	$max = 10;
	$p = $_GET['p'] == ''?0:$_GET['p'];
	$from=$p*$max; 
		
  if ($_GET['Delete'] > 0) { 
	$news -> deleteItem($_GET['Delete']);
  }
  
  $sql="SELECT NewsID, Title, Intro, Photo, Updated FROM `news` WHERE 1 $sqlAdd ORDER BY `NewsID` DESC LIMIT $from,$max";
  	
  $rs = $db->Execute($sql); 
  
  $i = $from + 1;	
  while ($NewsList = $rs->FetchRow()) { 
  	$NewsList['Title'] = stripslashes($NewsList['Title']);
	$NewsList['Updated'] = date("H:i d/m/Y",$NewsList['Updated']);
	$NewsList['No'] = $i;
	$newsarr[] = $NewsList;
	$i++;
  }

	 
  $smarty->assign('news',$newsarr); 
  
	//---------------
	$sql = "SELECT NewsID FROM `news` WHERE 1 $sqlAdd";
				  
    $uri = "index.php?page=news";
	
	$smarty->assign('divPages', phantrang($sql,$max,$p,$uri));	 
  
  	
?>