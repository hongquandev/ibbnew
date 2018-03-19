<?php  
	header('Content-type:text/javascript;charset=UTF-8');
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    include_once  '../../includes/functions.php';
	$smarty = new Smarty;  
	if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../../m.templates_c/';
        }else{
            $smarty->compile_dir = '../../templates_c/';
        }

	if ($_SESSION['language'] == 'vn') {
		include 'lang/systemlog.vn.lang.php';
	}else{
		include 'lang/systemlog.en.lang.php';
	}
 
  $start = $_REQUEST['start'] == 0?0:$_REQUEST['start'] ;
  $limit = $_REQUEST['limit'] == 0?25:$_REQUEST['limit'] ;
  $sortby = $_REQUEST['sort'] == ''?'a.ID':$_REQUEST['sort'] ;
  $dir = $_REQUEST['dir'] == ''?'ASC':$_REQUEST['dir'] ;
  
   
 
  $sql = "SELECT * FROM `systemlogs` ";
  $handle = mysql_query($sql);

  if (!$handle) { echo mysql_error();}

  $totalCount = mysql_num_rows($handle);	
  
  $handle = mysql_query($sql." ORDER BY $sortby $dir LIMIT $start, $limit");		
  if (!$handle) { echo mysql_error();}
  $retArray = array();
  
  while ($row = mysql_fetch_assoc($handle)) {
    
		$row['Delete'] = '<a style="cursor:pointer; text-decoration:none; color:#FF0000" onclick ="deleteItemF5(\'../modules/systemlog/deletelogs.php?action=delete&ID='.$row['ID'].'\');"> Delete </a>';	
	
	$retArray[] = $row;
  } 
 
  // $data = json_encode($retArray);
 
   $arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
   
   echo json_encode($arrJS);

?> 