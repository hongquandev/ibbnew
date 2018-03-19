<?php
	header('Location: http://'.$_SERVER['HTTP_HOST']."/admin/index.php?module=cms");
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    include_once '../../includes/functions.php';
	$smarty = new Smarty;  	
	if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../../m.templates_c/';
        }else{
            $smarty->compile_dir = '../../templates_c/';
        }
	$smarty->template_dir = '../../modules/Cms/templates/'; 
	$smarty->cache_dir = 'cache';
	$smarty->compile_check = true;
	$smarty->caching = true; //caching
	
	
	//$smarty -> assign("action", $_GET['action']);	
	
	if ($_SESSION['language'] == 'vn') {
		include 'lang/cms.vn.lang.php';
	}else{
		include 'lang/cms.en.lang.php';
	}
	
	// H:i:s
	function changeFormatDate($cdate) {	
		list($month,$day,$year)=explode("/",$cdate);
			return $year."-".$month."-".$day." 00:00:00";
} 


	
  // $page_id = $_POST['ID'];
//   $title   = $_POST['title'];
//   $content = $_POST['content'];
   $upTime  = $_POST['upTime'];
   
   // Goi Ham De Convert Date
   
 //	$insertdate2= changeFormatDate($upTime);
  
   $pos=$_POST['pos'];
  // $Cbselect = $_POST['Cbselect'];
//   if ($Cbselect == 'Enabled')
//   {
//   	  $sta = 1;
//   }
//   if ($Cbselect == 'Disabled')
//   {
//   	  $sta = 0;
//   }
//   
   if($_POST) $request = $_POST;
   
	//else if($_GET) $request = $_GET;
	else
	{
		echo '<error>no query</error>';
		return;
	}
	$today = getdate();
	
	 $updateDate = $today["year"] . "-" . $today["mon"] ."-" . $today["mday"] . "-" . $today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];
	 
	$sql = "UPDATE `cms_page` SET  `title`='{$request['title']}',  `content`='{$request['content']}', `update_time`='$updateDate' , `sort_order` = '{$request['pos']}'  WHERE `page_id` = '{$request['ID']}'";
	
	//file_put_contents(ROOTPATH.'/tam.txt',$sql);
   mysql_query($sql);
  
   
   //die($query);
 //  mysql_query($query) or
 //  die(mysql_error());
 
 



   
?>


