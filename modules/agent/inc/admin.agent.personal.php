<?php
include_once 'partner.php';
include_once 'company.php';
$form_data = $agent_cls->getFields();
$form_data['logo'] = '';
$form_data[$agent_cls->id] = $agent_id;
$password = $form_data['password'];
$arr = AgentType_getOptions();

$row = $agent_cls->getRow('SELECT a.*, l.logo
	                           FROM ' . $agent_cls->getTable() . ' AS a
	                           LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS l
	                           ON a.agent_id = l.agent_id
	                           WHERE a.agent_id = ' . (int)$agent_id, true);
if (is_array($row) && count($row)) {
    foreach ($form_data as $key => $val) {
        if (isset($row[$key])) {
            $form_data[$key] = $row[$key];
        }
    }
}
$type = $arr[$form_data['type_id']];
if ($type == 'partner') {
    $partner = $partner_cls->getRow('agent_id = ' . $agent_id);
    if (is_array($partner) and count($partner) > 0) {
        foreach ($partner as $key => $val) {
            $form_data[$key] = $val;
        }
    }
}
if (in_array($type,array('agent','theblock'))){
    $agent = $company_cls->getCRow(array('address','state','other_state','country','suburb','postcode'),'agent_id = '.$agent_id);
    if (is_array($agent) and count($agent) > 0){
        foreach ($agent as $key =>$val){
            if ($key == 'address'){
                $form_data['street'] = $agent[$key];
            }else{
                $form_data[$key] = $agent[$key];
            }
        }
    }
}
//LOGO FOR AGENT:BLOCK

if ($type == 'theblock' && file_exists(ROOTPATH . $form_data['logo'])) {
    list($width, $height) = getimagesize(ROOTPATH . $form_data['logo']);
    $smarty->assign('height', $height);
    if (!isset($_SESSION['block'][$form_data[$agent_cls->id]])) {
        $_SESSION['block'][$form_data[$agent_cls->id]] = array();
    }
}
//END

if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $val) {
		if (isset($_POST[$key])) {
			$form_data[$key] = $data[$key] = $agent_cls->escape($_POST[$key]);
		}
	}

	$type = $agent_id > 0?AgentType_getTypeAgent($agent_id):$arr[$data['type_id']];


	if (strlen(getPost('allow_vendor_contact')) > 0) {
		$data['allow_vendor_contact'] = 1;
	}
	
	if (strlen(getPost('is_active')) > 0) {
		$data['is_active'] = 1;	
	}
	
	if (strlen(getPost('notify_email')) > 0) {
		$data['notify_email'] = 1;
	}
	
	if (strlen(getPost('notify_sms')) > 0) {
		$data['notify_sms'] = 1;
	}
	
	if (strlen(getPost('subscribe')) > 0) {
		$data['subscribe'] = 1;	
	}
	
	if (strlen(getPost('notify_turnon_sms')) > 0) {
		$data['notify_turnon_sms'] = 1;
	}


	$agent_cls->addValid(array('field' => 'firstname', 'label' => 'First name', 'fnc' => array('isRequire' => null)));
    $agent_cls->addValid(array('field' => 'email_address', 'label' => 'Email', 'fnc' => array('isEmail' => null)));

	if ($type != 'partner'){
        $agent_cls->addValid(array('field' => 'lastname', 'label' => 'Last name', 'fnc' => array('isRequire' => null)));
    }
    if ($type != 'agent' && $type != 'theblock'){
        $agent_cls->addValid(array('field' => 'street', 'label' => 'Street', 'fnc' => array('isRequire' => null)));
        $agent_cls->addValid(array('field' => 'suburb', 'label' => 'Suburb', 'fnc' => array('isRequire' => null)));
        $agent_cls->addValid(array('field' => 'state', 'label' => 'State', 'fnc' => array('isRequire' => null)));
        $agent_cls->addValid(array('field' => 'postcode', 'label' => 'Post code', 'fnc' => array('isRequire' => null)));
        $agent_cls->addValid(array('field' => 'country', 'label' => 'Country', 'fnc' => array('isRequire' => null)));
        /*$agent_cls->addValid(array('field' => 'telephone', 'label' => 'Telephone', 'fnc' => array('isRequire' => null)));*/
        /*$agent_cls->addValid(array('field' => 'mobilephone', 'label' => 'Mobilephone', 'fnc' => array('isRequire' => null)));*/
    }
    if (!in_array($type,array('agent','partner'))){
        /*$agent_cls->addValid(array('field' => 'license_number', 'label' => 'Drivers License number', 'fnc' => array('isRequire' => null)));*/
	    $agent_cls->addValid(array('field' => 'preferred_contact_method', 'label' => 'Preferred contact method', 'fnc' => array('isRequire' => null)));
    }

	$agent_cls->addValid(array('field' => 'security_question', 'label' => 'Security question', 'fnc' => array('isRequire' => null)));
	$agent_cls->addValid(array('field' => 'security_answer', 'label' => 'Security answer', 'fnc' => array('isRequire' => null)));

	try {
		/*if ($type != 'agent' && $type != 'theblock'){
            if (!$agent_cls->isValid($data)) {
                throw new Exception(implode("<br/>",$agent_cls->getErrorsValid()));
            }
        }

		if ($data['country'] == 1 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($data['suburb'], $data['state'], $data['postcode']))))) {
			throw new Exception('Wrong suburb/postcode or state!');
		}*/

        $row = $agent_cls->getRow("email_address = '".$data['email_address']."' AND agent_id != ".$agent_id);
	    if (is_array($row) and count($row) > 0){
             throw new Exception('Email existed!');
		}
		
		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$data['creation_time'] = date('Y-m-d H:i:s');
        //no edit password
        if (strlen($data['password']) == 0){
            unset($data['password']);
            //$data['password'] = $row['password'];
        } else {
			if ($config_cls->getKey('general_customer_password_length') > 0 && strlen(trim($data['password'])) < $config_cls->getKey('general_customer_password_length')) {
				throw new Exception('Password\' length must be larger than '.$config_cls->getKey('general_customer_password_length').' characters.');
			}		
            $data['password'] = encrypt($data['password']);
        }



        if ($type == 'partner'){
            $partner = array();
            foreach ($_POST['partner'] as $key=>$val){
                $form_data[$key] = $partner[$key] = $agent_cls->escape($val);
            }
            if ($partner['postal_country'] == 1){
                $partner['postal_other_state'] = '';
            }else{
                $partner['postal_state'] = '';
            }
            if ($partner['postal_country'] == 1 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($partner['postal_suburb'], $partner['postal_state'], $partner['postal_postcode']))))) {
			    throw new Exception('Wrong postal suburb/postcode or state!');
		    }
        }

		if ($form_data[$agent_cls->id] > 0) { //update
            if ($data['country'] != 1){
                $data['state'] = 0;
            }
			if ($data['type_id'] == 3) { // If Agent Name Is Partner
				$data['lastname'] = '';
			}

			$agent_cls->update($data, $agent_cls->id.'='.$form_data[$agent_cls->id]);
		} else { //new

			$agent_cls->insert($data);
			$agent_id = $agent_cls->insertId();
            if (isset($_SESSION['partner'][0])){
                $_SESSION['partner'][$agent_id] = $_SESSION['partner'][0];
            }
		}

        if (in_array($type,array('agent','theblock')) and $data['parent_id'] > 0){
            $row = $company_cls->getRow('agent_id = '.$agent_id);
            $data['address'] = $data['street'];
            if (is_array($row) and count($row) > 0){
                $company_cls->update($data,'agent_id = '.$agent_id);
            }else{
                $company_cls->insert($data);
            }
        }

        if (isset($partner) and count($partner) > 0){
            //LOGO FOR PARTNER
            if (isset($_SESSION['partner']) && strlen($_SESSION['partner'][$agent_id]['logo']) > 0) {
                $form_data['partner_logo'] = $partner['partner_logo'] = $_SESSION['partner'][$agent_id]['logo'];
                unset($_SESSION['partner'][$agent_id]);
            }
            $partner['agent_id'] = $agent_id;
            $row = $partner_cls->getRow('agent_id = '.$agent_id);
            if (is_array($row) and count($row) > 0){
                $partner_cls->update($partner,'agent_id = '.$agent_id);
            }else{
                $partner_cls->insert($partner);
            }
            //END
        }

        if ($agent_cls->hasError()) {
			throw new Exception('Error when updating / inserting data.');
		}

		//LOGO FOR AGENT:BLOCK
        if (isset($_SESSION['block']) && strlen($_SESSION['block'][$form_data['agent_id']]['logo']) > 0) {
            $row = $agent_logo_cls->getRow('agent_id = ' . $form_data['agent_id']);
            if (is_array($row) and count($row) > 0) {
                @unlink(ROOTPATH.$row['logo']);
                $agent_logo_cls->update(array('logo' => $_SESSION['block'][$form_data['agent_id']]['logo']), 'agent_id = ' . $form_data['agent_id']);
            } else {
                $agent_logo_cls->insert(array('agent_id' => $form_data['agent_id'],
                                             'logo' => $_SESSION['block'][$form_data['agent_id']]['logo']));
            }
            unset($_SESSION['block'][$form_datas['agent_id']]);
        }
        //END

		$path = ROOTPATH.'/store/uploads/'.$agent_id;
		createFolder($path,1);
		if (!is_dir($path)) {
			throw new Exception('It can not create folder');
		}
		
		$form_action = '?module=agent&action='.$action.'&agent_id='.$agent_id.'&token='.$token;
		$message = $form_data[$agent_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';

		if (getPost('next', 0) == 1) {
			if (in_array($type,array('agent','theblock'))){
                    redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-company&agent_id='.$agent_id.'&token='.$token);
            }
            redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-lawyer&agent_id='.$agent_id.'&token='.$token);
		} else {
			$session_cls->setMessage('Add/Update successful');
            redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-personal&agent_id='.$agent_id.'&token='.$token);
		}
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
    $form_data['agent_id'] = $agent_id;
}
$form_data['password'] = '';
//end

if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}
if ((int)$form_data['postal_country'] == 0) {
    $form_data['postal_country'] = $config_cls->getKey('general_country_default');
}
$options_parent = A_getParentOption($form_data['type_id'],array(0=>'None'));
$smarty->assign(array('options_type' => AgentType_getOptions_(false),
					  'options_state' => R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')),
					  'options_country' => R_getOptions(0,array('0'=>'Select...')),
					  'options_method' => AO_getOptions('contact_method'),
					  'options_question' => AO_getOptions('security_question'),
					  'subState' => subRegion(),
					  'form_data' => formUnescapes($form_data),
                      'agent_arr'=>AgentType_getArr(),
                      'default_country'=>$config_cls->getKey('general_country_default'),
                      'options_parent'=>$options_parent));
?>