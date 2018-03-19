<?php  
	header('Content-type:text/javascript;charset=UTF-8');
	require '../../configs/config.inc.php';
    require '../../includes/smarty/Smarty.class.php';
    include_once '../../includes/functions.php';
	$smarty = new Smarty;  
        if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../../m.templates_c/';
        }else{
            $smarty->compile_dir = '../../templates_c/';
        } 
			if ($_SESSION['language'] == 'vn') {
				include 'lang/emailenquired.vn.lang.php';
			}else{
				include 'lang/emailenquired.en.lang.php';
			}
		 
		  $start = $_REQUEST['start'] == 0?0:$_REQUEST['start'] ;
		  $limit = $_REQUEST['limit'] == 0?25:$_REQUEST['limit'] ;
		  $sortby = $_REQUEST['sort'] == ''?'ID':$_REQUEST['sort'] ;
		  $dir = $_REQUEST['dir'] == ''?'ASC':$_REQUEST['dir'] ;	  
	
		  $sql = "SELECT agent_id as agent_id
					,(SELECT count(notify_email) from agent where notify_email = 1 ) AS email
					,(SELECT count(notify_sms) from agent where notify_sms = 1 ) AS sms
					,(SELECT count(notify_turnon_sms) from agent where notify_turnon_sms = 1 ) AS turnon
				  		FROM agent GROUP BY email, sms, turnon ";
						
		  $handle = mysql_query($sql);	
	
		  if (!$handle) { echo mysql_error();}
		  
		  $totalCount = mysql_num_rows($handle);	
		  	
		  $handle = mysql_query($sql."ORDER BY $sortby $dir LIMIT $start, $limit");		
		  
		  if (!$handle) { echo mysql_error();}
		  
		  $retArray = array();		  
		  
		  while ($row = mysql_fetch_assoc($handle)) {
		  
			$retArray[] = $row;		
			
		  } 	 
		  // $data = json_encode($retArray); 
		   $arrJS = array("totalCount" => $totalCount, "topics" => $retArray);	   
		   echo json_encode($arrJS);

?> 
