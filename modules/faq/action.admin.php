<?php  
	require '../../configs/config.inc.php';
	require ROOTPATH.'/includes/functions.php';
	include ROOTPATH.'/includes/model.class.php';
	include_once ROOTPATH.'/modules/faq/inc/faq.php';	   
	
	$rows = $faq_cls->getRows('SELECT * FROM '.$faq_cls->getTable().'', true);
							
	$totalCount = $faq_cls->getFoundRows();
								
	$retArray = array();	  
	
	if (is_array($rows) and count($rows) > 0) {
	
		foreach ($rows as $row) {
							
					$row['active'] = $row['active'] ==0?"<div style='cursor:pointer; color:#FF0000' onclick =\" deleteItem('../modules/faq/admin.delete.php?action=active&id={$row['faq_id']}'); document.getElementById('ext-gen54').click();   \" >Disable </a>":"<div style='cursor:pointer; color:#009900' onclick =\" deleteItem('../modules/faq/admin.delete.php?action=inactive&id={$row['faq_id']}'); document.getElementById('ext-gen54').click();   \" >Enabled</a>";		
					
					$row['Edit'] = "<a href=\"?module=faq&action=edit&id={$row['faq_id']}\" style=\"color:#0000FF; text-decoration:none\" onClick=\"\">Edit</a>"; 
				
					$row['Delete'] = '<a style="cursor:pointer; text-decoration:none; color:#FF0000" onclick ="deleteItemF5(\'../modules/faq/admin.delete.php?action=delete&id='.$row['faq_id'].'\');"> Delete </a>';		
					
				$retArray[] = $row;
		  } 
	} 
	
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);

	echo json_encode($arrJS);
	
	

?> 
