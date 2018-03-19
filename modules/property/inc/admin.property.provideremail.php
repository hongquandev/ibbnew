<?php
$form_data = array();

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']['provider_email']) and count($_POST['fields']['provider_email']) > 0) {
	
        $form_data['provider_email'] = $property_provider_email_cls->escape($_POST['fields']['provider_email']);
            $email = $_POST['fields']['provider_email'];
				$row = $property_provider_email_cls->getRow('property_id='.$property_id);
				
				if (!$property_provider_email_cls->hasError()) {
					if (is_array($row) and count($row) > 0) {//update
						$data = array('email' => $form_data['provider_email']);
						$property_provider_email_cls->update($data,'property_id='.$property_id);
		
						// Write Logs					
						$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
								 'Action' => 'UPDATE',
								 'Detail' => "UPDATE PROPERTY SERVICE PROVIDER EMAIL :". $property_id, 
								 'UserID' => $_SESSION['Admin']['EmailAddress'],
								 'IPAddress' =>$_SERVER['REMOTE_ADDR']
								  ));	
						
					} else {//insert
						$data = array('property_id' => $property_id,
									  'email' => $form_data['provider_email']);
									  
						$property_provider_email_cls->insert($data);
						
						// Write Logs					
						$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
								 'Action' => 'INSERT',
								 'Detail' => "ADD NEW PROPERTY SERVICE PROVIDER EMAIL :". $property_id, 
								 'UserID' => $_SESSION['Admin']['EmailAddress'],
								 'IPAddress' =>$_SERVER['REMOTE_ADDR']
								  ));	

					}
				}
				
				if ($property_provider_email_cls->hasError()) {
					$message = 'Error during processing.';
					break;
				} else {
									
				}
		//die($_POST['fields']['provider_email']);		
		if (strlen($message) == 0) {
			$message = 'Added / Edited successful.';
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=list&token='.$token);		
			} 
		}
	}
}

$rows = $property_provider_email_cls->getRows('property_id='.$property_id);
if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $row) {
		$form_data['provider_email'] = $row['email'];
	}
}
$smarty->assign('form_data',formUnescapes($form_data));
?>