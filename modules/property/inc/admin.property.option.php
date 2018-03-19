<?php
$form_data = array();
$options = getOptions();

if (is_array($options) and count($options)>0) {
	foreach ($options as $key => $row) {
		$form_data[$key] = '';
	}
}

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']['option']) and count($_POST['fields']['option']) > 0) {
	
		foreach ($_POST['fields']['option'] as $key => $val) {
			if (isset($form_data[$key])) {
			
				$form_data[$key] = $property_option_cls->escape($val);
				$row = $property_option_cls->getRow('property_id='.$property_id.' AND option_id='.$key);
				
				if (!$property_option_cls->hasError()) {
					if (is_array($row) and count($row) > 0) {//update
						$data = array('value' => $form_data[$key]);
						$property_option_cls->update($data,'property_id='.$property_id.' AND option_id='.$key);
		
						// Write Logs					
						$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
								 'Action' => 'UPDATE',
								 'Detail' => "UPDATE PROPERTY OPTION ID :". $property_id, 
								 'UserID' => $_SESSION['Admin']['EmailAddress'],
								 'IPAddress' =>$_SERVER['REMOTE_ADDR']
								  ));	
						
					} else {//insert
						$data = array('property_id' => $property_id,
									  'option_id' => $key,
									  'value' => $form_data[$key]);
									  
						$property_option_cls->insert($data);
						
						// Write Logs					
						$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
								 'Action' => 'INSERT',
								 'Detail' => "ADD NEW PROPERTY OPTION ID :". $property_id, 
								 'UserID' => $_SESSION['Admin']['EmailAddress'],
								 'IPAddress' =>$_SERVER['REMOTE_ADDR']
								  ));	

					}
				}
				
				if ($property_option_cls->hasError()) {
					$message = 'Error during processing.';
					break;
				} else {
									
				}
			}//end if
		}//end foreach
		
		if (strlen($message) == 0) {
			$message = 'Added / Edited successful.';
			if ($_POST['next'] == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=list&token='.$token);		
			} 
		}
	}
}

$rows = $property_option_cls->getRows('property_id='.$property_id);
if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $row) {
		$form_data[$row['option_id']] = $row['value'];
	}
}

$smarty->assign('options_',PO_getOptions());

$smarty->assign('options',$options);
$smarty->assign('form_data',formUnescapes($form_data));
?>