<?php
include_once ROOTPATH.'/modules/agent/inc/company.php';
$form_data = array();
$agent_row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
$form_data['agent'] = $agent_row;
if (in_array($_SESSION['agent']['type'],array('agent','theblock'))){
    $agent_id = $_SESSION['agent']['id'];
    if ($_SESSION['property']['id'] > 0){
        $row = $property_cls->getCRow(array('agent_id','agent_manager'),'property_id = '.$_SESSION['property']['id']);
        if (is_array($row) and count($row) > 0){
            $agent_id = $row['agent_manager'] != ''?$row['agent_manager']:$row['agent_id'];
        }
    }
    $company_row = $company_cls->getRow('agent_id = '.$agent_id);
    $form_data['company'] = $company_row;

    if ((int)$agent_row['parent_id'] != 0){
        $parent_row = $company_cls->getRow('agent_id = '.$agent_row['parent_id']);
        $form_data['parent'] = $parent_row;
    }else{
        $form_data['parent'] = $company_row;
    }
}else{
    $agent_lawyer_row = $agent_lawyer_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
    $form_data['lawyer'] = $agent_lawyer_row;
}
$property_row = $property_cls->getCRow(array('package_id'),'property_id = '.$_SESSION['property']['id']);
if (is_array($property_row) and count($property_row) > 0) {
    $form_data['package_id'] = $property_row['package_id'];
}else{
    $package_id = getParam('pid','');
    $packageId = new_decrypt($package_id);
    $form_data['package_id'] = $packageId;
}
if (isSubmit()) {//FOR POST
	$data = getPost('fields');
    foreach($_POST['fields'] as $key => $val){
        if (strlen($val)){
            $form_data[$key] = $val;
        }
    }
	try {
        if ($_SESSION['agent']['type'] != 'agent'){
            $agent_cls->addValid(array('field' => 'fullname', 'label' => 'Name', 'fnc' => array('isRequire' => null)));
		    $agent_cls->addValid(array('field' => 'titlename', 'label' => 'Name on title', 'fnc' => array('isRequire' => null)));
        }

		//BEGIN AGENT
		if (!isset($data['agent']) || !is_array($data['agent']) || count($data['agent']) == 0) {
			throw new Exception('Agent\'s information is lack.');
		}
		
		if (!$agent_cls->isValid($data['agent'])) {
			throw new Exception(implode("<br/>",$agent_cls->getErrorsValid()));
		}

        /*if(is_array($data['lawyer']) && count($data['lawyer']) > 0){

            if (!isset($data['lawyer']) || !is_array($data['lawyer']) || count($data['lawyer']) == 0) {
                throw new Exception('Lawyer\'s information is lack, (you need to come back your dashboard to fill enough lawyer\'s information).');
            }

            if (!$agent_lawyer_cls->isExist($_SESSION['agent']['id'])) {
                throw new Exception('Your lawyer\'s information is not complete, (you need to come back to your dashboard to complete your lawyer\'s information).');
            }
        }*/
		
		foreach ($data['agent'] as $key => $val) {
			$form_data['agent'][$key] = $agent_cls->escape($val);
		}
		
		$agent_cls->update($data['agent'],'agent_id = '.$_SESSION['agent']['id']);
		
		if ($agent_cls->hasError()) {
			throw new Exception('You Can\'t update agent\'s information.');
		}
		//END

		//BEGIN AGENT_LAWYER
        if(is_array($data['lawyer']) && count($data['lawyer']) > 0) {

            foreach ($data['lawyer'] as $key => $val) {
                $form_data['lawyer'][$key] = $agent_lawyer_cls->escape($val);
            }

            if (!empty($agent_lawyer_row) && is_array($agent_lawyer_row) and count($agent_lawyer_row) > 0) {//update
                $agent_lawyer_cls->update($data['lawyer'], 'agent_id = ' . $_SESSION['agent']['id']);
            } else {//insert
                $data['agent_id'] = $_SESSION['agent']['id'];
                $agent_lawyer_cls->insert($data['lawyer']);
            }
        }

		if ($agent_lawyer_cls->hasError()) {
			throw new Exception('Can not update lawyer\'s information.');
		}
		
		//END

        //for package
        if ((int)$data['package_id'] == 0) {
            throw new Exception('Please select the package for this property.');
        }
        $row = $package_property_cls->getRow('package_id = '.$data['package_id']);
        if (!is_array($row) || count($row) == 0) {
            throw new Exception('Please select the package for this property.');
        }

    //}else{
       //$data['package_id'] = $package['package_id'];
    //}
		
		$_SESSION['property']['step'] = $step;
		$track = getParam('track',0);

        //save property
        $data['agent_id'] = $_SESSION['agent']['id'];
        if ($_SESSION['property']['id'] > 0){
            unset($data['package_id']);
            $property_cls->update($data,'property_id = '.$_SESSION['property']['id']);
        }else{
            $data['step'] = $step;
            $data['creation_date'] = date('Y-m-d H:i:s');
            $data['creation_datetime'] = date('Y-m-d H:i:s');
            $row_notify = $notification_cls->getRow("temp_id='" . encrypt($_SESSION['agent']['id']) . "'");

            if (count($row_notify) > 0 and is_array($row_notify)) {
                $data['notify_inspect_time'] = $row_notify['notify_value'];
                $notification_cls->delete("temp_id='" . encrypt($_SESSION['agent']['id']) . "'");
            }

            $property_cls->insert($data);
            $_SESSION['property']['id'] = $property_cls->insertId();
            Calendar_update($_SESSION['property']['id'], encrypt($_SESSION['agent']['id']));

            /*save Packages Data*/
            if(isset($_SESSION['packages'])){
                foreach($_SESSION['packages'] as $pack_key => $pack){
                    if($pack_key == 'package'){
                        foreach($pack as $group_id =>$_package_id){
                            $package_payment_data = array();
                            $package_payment_data['group_id'] = $group_id;
                            $package_payment_data['package_id'] = $_package_id;
                            $package_payment_data['pay_status'] = 0;
                            $package_payment_data['option_id'] = 0;
                            $package_payment_data['property_id'] = $_SESSION['property']['id'];
                            $property_package_payment_cls->insert($package_payment_data);
                        }
                    }
                    if($pack_key == 'extra_options'){
                        foreach($pack as $group_id => $options_id){
                            foreach($options_id as $option_id){
                                $package_payment_data = array();
                                $package_payment_data['group_id'] = $group_id;
                                $package_payment_data['package_id'] = 0;
                                $package_payment_data['pay_status'] = 0;
                                $package_payment_data['option_id'] = $option_id;
                                $package_payment_data['property_id'] = $_SESSION['property']['id'];
                                $property_package_payment_cls->insert($package_payment_data);
                            }
                        }
                    }
                }
                unset($_SESSION['packages']);
            }

        }

		if ($track == 1) {
			$message = 'Saved successfully.';
			/*$property_cls->update(array('step' => $step,
                                        'package_id'=>$data['package_id']),'property_id = '.$_SESSION['property']['id']);*/
		} else {
			redirect(ROOTURL.'?module='.$module.'&action=register&step='.($step+1));
		}
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
}
if (!((int)$form_data['agent']['country'] > 0)) {
	$form_data['agent']['country'] = COUNTRY_DEFAULT;
}
$options_country = R_getOptions();
$options_state = R_getOptions(COUNTRY_DEFAULT,array('0'=>'Select...'));
$options_contactable = AO_getOptions('contactable');
$options_contact_method = AO_getOptions('contact_method');

$smarty->assign(array('options_state' => $options_state,
				'options_country' => $options_country,
				'options_contactable' => $options_contactable,
				'options_contact_method' => $options_contact_method,
				'form_data' => formUnescapes($form_data)));
				
?>