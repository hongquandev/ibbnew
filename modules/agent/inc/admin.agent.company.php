<?php
include_once 'company.php';
$form_data = $company_cls->getFields();
$form_data['agent_id'] = $agent_id;
global $type;
$type_arr = AgentType_getArr();
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $val) {
		if (isset($_POST[$key])) {
			$form_data[$key] = $data[$key] = $agent_cls->escape($_POST[$key]);
		}
	}

	$company_cls->addValid(array('field' => 'company_name', 'label' => 'Company name', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'abn', 'label' => 'ACN', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'address', 'label' => 'Address', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'suburb', 'label' => 'Suburb', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'state', 'label' => 'State', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'postcode', 'label' => 'Post code', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'country', 'label' => 'Country', 'fnc' => array('isRequire' => null)));
    $company_cls->addValid(array('field' => 'telephone', 'label' => 'Telephone', 'fnc' => array('isRequire' => null)));

	try {
		if (!$company_cls->isValid($data)) {
			throw new Exception(implode("<br/>",$company_cls->getErrorsValid()));
		}

		if ($data['country'] == 1 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($data['suburb'], $data['state'], $data['postcode']))))) {
			throw new Exception('Wrong suburb/postcode or state!');
		}

        if ($data['country'] == 1){
            $data['other_state'] = '';
        }else{
            $data['state'] = 0;
        }

		$data['description'] = scanContent($data['description']);
        //LOGO FOR AGENCY
        if (isset($_SESSION['auction']) && strlen($_SESSION['auction'][$agent_id]['logo']) > 0) {
            $data['logo'] = $form_data['logo'] = $_SESSION['auction'][$agent_id]['logo'];
            unset($_SESSION['auction'][$agent_id]);
        }

        $row = $company_cls->getRow('agent_id = '.$form_data[$agent_cls->id]);
        if (is_array($row) and count($row)){//update
            if (strlen($data['logo']) > 0 && $data['logo'] != $row['logo']){
                @unlink(ROOTPATH.$row['logo']);
            }else{
                $form_data['logo'] = $row['logo'];
            }
            $company_cls->update($data, 'company_id='.$row['company_id']);
        }else{
            $company_cls->insert($data);
        }

        if ($company_cls->hasError()) {
			throw new Exception('Error when updating / inserting data.');
		}

		if (getParam('next', 0) == 1) {
            $row = $agent_cls->getCRow(array('parent_id'),'agent_id = '.$agent_id);
            if ($row['parent_id'] == 0 && $type == 'agent'){
                redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-site&agent_id='.$agent_id.'&token='.$token);
            }else{
                redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-note2&agent_id='.$agent_id.'&token='.$token);
            }
		}
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
    $form_data['agent_id'] = $agent_id;
}else{
    $row = $company_cls->getRow('SELECT a.agent_id,
                                        a.type_id,
                                        a.parent_id,
                                        c.*
                                 FROM '.$agent_cls->getTable().' AS a
                                 LEFT JOIN '.$company_cls->getTable().' AS c
                                 ON a.agent_id = c.agent_id
                                 WHERE a.agent_id = '.$agent_id,true);
    if (is_array($row) and count($row) > 0){
        if (in_array($type,array('agent','theblock')) && $row['parent_id'] > 0){
            redirect(ROOTURL.'/admin/?module=agent&action=edit-note2&agent_id=' . $agent_id . '&token=' . $token);
        }else if (!in_array($type,array('agent','theblock')) || $row['parent_id'] > 0){
            redirect(ROOTURL.'/admin/?module=agent&action=edit-lawyer&agent_id='.$agent_id.'&token='.$token);
        }else{
            foreach ($form_data as $key=>$val){
                $form_data[$key] = $row[$key];
            }
        }
    }
}


if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign(array('options_state' => R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')),
					  'options_country' => R_getOptions(),
					  'subState' => subRegion(),
					  'form_data' => formUnescapes($form_data),
                      'default_country'=>$config_cls->getKey('general_country_default'),
                      ));
?>