<?php
$form_data = $comment_cls->getFields();
$form_data[$comment_cls->id] = $comment_id;

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['delete'] == 1) {
		$comment_cls->delete('comment_id = '.$comment_id);
		$message = 'Deleted successful.';
		redirect(ROOTURL.'/admin/?module=comment&action=list&token='.$token);
	} else {
		$active = 0;
		$message = 'Inactived successful.';
		if (isset($_POST['active'])) {
			$active = 1;
			$message = 'Actived successful.';
		}	
		$comment_cls->update(array('active' => $active),'comment_id = '.$comment_id);
		
		
		// Write Logs					
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
				 'Action' => 'UPDATE',
				 'Detail' => "UPDATE COMMENT ID :". $property_id ." SET ACTIVE  = YES" , 
				 'UserID' => $_SESSION['Admin']['EmailAddress'],
				 'IPAddress' =>$_SERVER['REMOTE_ADDR']
				  ));
								
								
	}
} 
	
$row = $comment_cls->getRow('comment_id='.(int)$comment_id);
if ($comment_cls->hasError()) {
	$message = $comment_cls->getError();
} else if (is_array($row) and count($row)) {
	//set form data 
	foreach ($form_data as $key => $val) {
		if (isset($row[$key])) {
			$form_data[$key] = $row[$key];
		}
	}
}
//end

$smarty->assign('form_data',formUnescapes($form_data));
?>