<?php
include_once ROOTPATH.'/modules/user/inc/user.php';
include_once ROOTPATH.'/modules/comment/inc/comment.php';

$comment_id = (int) (isset($_POST['comment_id']) ? $_POST['comment_id']: (isset($_GET['comment_id']) ? $_GET['comment_id']: 0)) ;

if ($comment_id > 0) {
	switch ($action) {
		case 'delete-comment':
			$message = 'Deleted successful.';
			$comment_cls->delete('comment_id = '.$comment_id);
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'DELETE',
					 'Detail' => "DELETE COMMENT ID :". $comment_id, 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));
	
		break;
		case 'active-comment':
			$message = 'Approved successful.';
			$comment_cls->update(array('active' => 1),'comment_id = '.$comment_id);
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE COMMENT ID :". $comment_id ."SET ACTIVE = YES", 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
				
		break;
		case 'inactive-comment':
			$message = 'Pending successful.';
			$comment_cls->update(array('active' => 0),'comment_id = '.$comment_id);		
			
			// Write Logs					
			$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
					 'Action' => 'UPDATE',
					 'Detail' => "UPDATE COMMENT ID :". $comment_id ."SET ACTIVE = NO", 
					 'UserID' => $_SESSION['Admin']['EmailAddress'],
					 'IPAddress' =>$_SERVER['REMOTE_ADDR']
					  ));	
				
		break;
	}
}

$rows = $comment_cls->getRows('SELECT *
					FROM '.$comment_cls->getTable().'
					WHERE property_id = '.$property_id.'
					ORDER BY comment_id DESC',true);

			
if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['created_date']);
		$rows[$key]['time'] = $dt->format('d M Y');
		$cmid = $row['comment_id'];
		$rows[$key]['delete_link'] = '?module=property&action=delete-comment&property_id='.$property_id.'&comment_id='.$row['comment_id'].'&token='.$token;
		// Write Logs					
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
				 'Action' => 'DELETE',
				 'Detail' => "DELETE COMMENT ID :". $cmid, 
				 'UserID' => $_SESSION['Admin']['EmailAddress'],
				 'IPAddress' =>$_SERVER['REMOTE_ADDR']
				  ));	

		
		$_param = '';
		$_label = '';
		if ($row['active'] == 1) {
			$_param = 'inactive';
			$_label = 'Approved';
		} else {
			$_param = 'active';
			$_label = 'Pending';
		
		}
		
		
		$rows[$key]['active_label'] = $_label;
		$rows[$key]['active_link'] = '?module=property&action='.$_param.'-comment&property_id='.$property_id.'&comment_id='.$row['comment_id'].'&token='.$token;
	}
	$smarty->assign('comments',$rows);
}

$smarty->assign('comment_id',$comment_id);
$smarty->assign('form_data',formUnescapes($form_data));
?>