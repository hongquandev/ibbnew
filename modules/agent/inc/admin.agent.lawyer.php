<?php
/*global $type;*/
$agent_lawyer_id = (int)restrictArgs(getParam('agent_lawyer_id', 0));
$form_data = $agent_lawyer_cls->getFields();
$form_data[$agent_lawyer_cls->id] = $agent_lawyer_id;
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $agent_lawyer_cls->escape($_POST[$key]);
		} 
	}
	
	$agent_row = $agent_cls->getRow('agent_id = '.$agent_id);
	try {
		if ($agent_row['type_id'] != 3) {
            /*$agent_lawyer_cls->addValid(array('field' => 'email', 'label' => 'Email', 'fnc' => array('isEmail' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'name', 'label' => 'Name', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'company', 'label' => 'Company', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'address', 'label' => 'Address', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'suburb', 'label' => 'Suburb', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'state', 'label' => 'State', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'postcode', 'label' => 'Postcode', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'country', 'label' => 'Country', 'fnc' => array('isRequire' => null)));*/
			/*$agent_lawyer_cls->addValid(array('field' => 'telephone', 'label' => 'Telephone', 'fnc' => array('isRequire' => null)));
			$agent_lawyer_cls->addValid(array('field' => 'mobilephone', 'label' => 'Mobilephone', 'fnc' => array('isRequire' => null)));*/
			
			if (!$agent_lawyer_cls->isValid($data)) {
				throw new Exception(implode('<br/>',$agent_lawyer_cls->getErrorsValid()));
			}

            if ($data['country'] == 1 &&
                strlen($data['suburb']) > 0 && strlen($data['postcode']) > 0 && strlen($data['state']) > 0 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($data['suburb'], $data['state'], $data['postcode']))))) {
				throw new Exception('Wrong suburb/postcode or state!');
			}
			
			if ($form_data[$agent_lawyer_cls->id] > 0) { // UPDATE
				$agent_lawyer_cls->update($data, $agent_lawyer_cls->id.'='.$form_data[$agent_lawyer_cls->id]);
				// Write Logs				
			} else { // INSERT
				
				if ($data['other_state'] != '') {
					$data['state'] = 0;
				} 
				$data['agent_id'] = $agent_id;
				$agent_lawyer_cls->insert($data);
				$agent_lawyer_id = $agent_lawyer_cls->insertId();
				// Write Logs					
			}
			
			if ($agent_lawyer_cls->hasError()) {
				throw new Exception('Error when inserting / updating data.');
			}
	
			if (getParam('next', 0) == 1) {
				redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-contact&agent_id='.$agent_id.'&token='.$token);
			}
			$message = $form_data[$agent_lawyer_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
		} 
		
		if ($agent_row['type_id'] == 3 && getParam('next', 0) != 1) {
			include_once 'admin.partner.php';
		} 
		if ($agent_row['type_id'] == 3 && getParam('next', 0) == 1) { // AGENT IS PARTNER 
			include_once 'admin.partner.php';
			//redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-ccdetail&agent_id='.$agent_id.'&token='.$token);
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-note2&agent_id='.$agent_id.'&token='.$token);
		}	
		
		/*if ($agent_row['type_id'] == 3 && getParam('next', 0) == 1) { // AGENT IS PARTNER 
			include 'admin.partner.php';
			//redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-ccdetail&agent_id='.$agent_id.'&token='.$token);
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-note2&agent_id='.$agent_id.'&token='.$token);
		}	
		*/
		
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
	
    $form_data = $data;
} else {
	$agent_row = $agent_cls->getRow('agent_id = '.$agent_id);
	if ($type != 'partner') { // If Not Partner
		$row = $agent_lawyer_cls->getRow('agent_id = '.$agent_id);
		if (is_array($row) && count($row)) {
			$agent_lawyer_id = $row['agent_lawyer_id'];
			foreach ($form_data as $key => $val) {
				if (isset($row[$key])) {
					$form_data[$key] = $row[$key];
				}
			}
		}
	} else { // Is Partner
		include_once 'partner.php';
        include_once ROOTPATH.'/modules/general/inc/regions.php';
		/*$row = $partner_cls->getRow('agent_id = '.$agent_id);
		if (count($row) > 0){ 
			$smarty->assign('row', $row);
			$smarty->assign('ckImageAdmin', 'ckImageAdmin');
		}*/
        $data = array();
        $row = $partner_cls->getRow('agent_id = '.$agent_id);
        $regions = $partner_region_cls->getRows('SELECT r.*,
                                                 (SELECT reg.code FROM '.$region_cls->getTable().' AS reg
                                                  WHERE reg.region_id = r.state) AS state_code,
                                                 (SELECT reg.name FROM '.$region_cls->getTable().' AS reg
                                                  WHERE reg.region_id = r.country) AS country_name
                                                 FROM '.$partner_region_cls->getTable().' AS r
                                                 WHERE r.agent_id ='.$agent_id,true);
        $partners = $partner_ref_cls->getRows('agent_id = '.$agent_id);
        if (is_array($regions) and count($regions)> 0){
            foreach ($regions as $region){
                $region['region'] = implode(' ',array($region['suburb'],$region['state_code'],$region['other_state'],$region['postcode'],$region['country_name']));
                $data[] = $region;
            }
        }
        $smarty->assign('row',$row);
        $smarty->assign('regions',$data);
        $smarty->assign('partners',$partners);
	}
	
}

if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign(array('agent_lawyer_id' => $agent_lawyer_id,
					  'options_state' => R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')),
					  'options_country' => R_getOptions(),
					  'subState' => subRegion(),
					  'form_data' =>  formUnescapes($form_data)));
?>