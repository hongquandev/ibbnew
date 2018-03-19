<?php
$form_data = $package_property_cls->getFields();
$form_data['color'] = 'white';
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $value) {
		if (isset($_POST[$key])) {
			$data[$key] = $_POST[$key];
		}
	}
    $form_data = $data;

	$package_property_cls->addValid(array('field' => 'name', 'label' => 'Title', 'fnc' => array('isRequire' => null)));

	//get all option
    $optionData = array();
    $options = $package_property_option_cls->getRows();
    $optData = array();
    if (is_array($options) and count($options) > 0){
        $validSystemFields = $validData = array();
        foreach ($options as $option){
            $optData[$option['group_id']][$option['code']] = $option;
            if (isset($_POST['group_'.$option['group_id']][$option['code']])) {
                $optionData[$option['group_id']][$option['code']] = $_POST['group_'.$option['group_id']][$option['code']];
                $validData[$option['group_id'].'_'.$option['code']] = $_POST['group_'.$option['group_id']][$option['code']];
                if (is_array($_POST['group_'.$option['group_id']][$option['code']])){
                    $validData[$option['group_id'].'_'.$option['code']] = implode(',',$_POST['group_'.$option['group_id']][$option['code']]);
                }
                $form_data['group_'.$option['group_id']][$option['code']] = $_POST['group_'.$option['group_id']][$option['code']];
                if ($option['type'] == 'price') {
                    $priceValue = '';
                    if (strlen($_POST['group_'.$option['group_id']][$option['code']])){
                        $priceValue = showPrice_cent($_POST['group_'.$option['group_id']][$option['code']]);
                    }
                    $form_data['group_' . $option['group_id']][$option['code'] . '_show'] = $priceValue;
                }
            }
            if ($option['is_required']){
                $package_property_option_cls->addValid(array('field' => $option['group_id'].'_'.$option['code'],
                                                             'label' => $option['name'],
                                                             'fnc' => array('isRequire' => null)));
            }
            if ($option['is_system']){
                $validSystemFields[$option['group_id']][$option['code']] = array('name' =>$option['name'],
                                                                                 'value'=>$_POST['group_'.$option['group_id']][$option['code']]);
            }
        }
        if (isset($validSystemFields) and count($validSystemFields) > 0){
            foreach ($validSystemFields as $groupId=>$fields){
                if (isset($fields['price']) && isset($fields['special_price']) && $fields['special_price']['value'] > 0){
                    $package_property_option_cls->addValid(array('field' => $groupId.'_special_price', 'label' => $fields['special_price']['name'],
									'fnc' => array('isSmaller' => array($fields['price']['value'],'float')),
									'fnc_msg' => array('isSmaller' => $fields['special_price']['name'].' must be smaller than '.$fields['price']['name'].'.')));
                }
                if (isset($fields['special_price_from']) && isset($fields['special_price_to']) && strlen($fields['special_price_from']['value'])  && strlen($fields['special_price_to']['value'])){
                    $package_property_option_cls->addValid(array('field' => $groupId.'_special_price_from', 'label' => $fields['special_price_from']['name'],
									'fnc' => array('isDate'=>null,'isMaxLen' => array($fields['special_price_to']['value'])),
									'fnc_msg' => array('isMaxLen' => $fields['special_price_from']['name'].' must be before the '.$fields['special_price_to']['name'].'.')));
                }
            }
        }
    }


	try {

		if (!$package_property_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $package_property_cls->getErrorsValid()));
		}


        if (!$package_property_option_cls->isValid($validData)) {
			throw new Exception(implode('<br/>', $package_property_option_cls->getErrorsValid()));
		}


        $data['is_active'] = isset($data['is_active'])?1:0;
        if ($data[$package_property_cls->id]) { // UPDATE
			$package_property_cls->update($data, $package_property_cls->id.' = '.$package_id);
		} else { //INSERT
			$package_property_cls->insert($data);
            $package_id = $package_property_cls->insertId();
		}

		if ($package_property_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}

        foreach ($optionData as $groupId=>$groupOptionData){
            foreach ($groupOptionData as $code=>$value){
                if (isset($optData[$groupId][$code])){
                    $option = $optData[$groupId][$code];
                    $data['group_'.$groupId][$code] = $value;
                    if ($option['type'] == 'price'){
                        $priceValue = '';
                        if (strlen($optionRow['value'])){
                            $priceValue = showPrice_cent($optionRow['value']);
                        }
                        $data['group_'.$groupId][$code.'_show'] = $priceValue;
                    }elseif ($option['type'] == 'multiselect'){
                        $value = implode(',',$value);
                    }
                    if ($groupOptionId = PPN_hasOption($package_id,$option['option_id'])){
                        $package_property_group_option_cls->update(array('package_id'=>$package_id,
                                                                 'option_id'=>$option['option_id'],
                                                                 'value'=>$value),'entity_id = '.$groupOptionId);
                    }else{
                        $package_property_group_option_cls->insert(array('package_id'=>$package_id,
                                                                 'option_id'=>$option['option_id'],
                                                                 'value'=>$value));
                    }
                }
            }
        }
        if ($package_property_group_option_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}

		$session_cls->setMessage($form_data[$package_property_cls->id] > 0 ? 'Edited successful.' : 'Added successful.');
	} catch (Exception $e) {
		$message = $e->getMessage();
        $session_cls->setMessage($message);
        if ($form_data[$package_property_cls->id] == 0){
            $_SESSION['package_data'] = $form_data;
        }
	}

    if (getPost('next', 0) == 1) {
        redirect(ROOTURL . '/admin/?module=' . $module . '&action=edit-property_new&token=' . $token);
    } else {
        redirect(ROOTURL . '/admin/?module=' . $module . '&action=edit-property_new&package_id=' . $package_id . '&token=' . $token);
    }
} else {
    if (isset($_SESSION['package_data'])){
        $form_data = $_SESSION['package_data'];
        unset($_SESSION['package_data']);
    }else{
        $row = $package_property_cls->getRow('package_id = '.$package_id);
        if (is_array($row) and count($row) > 0){
            //get all options
            $options = $package_property_group_option_cls->getRows('SELECT SQL_CALC_FOUND_ROWS gop.*, op.group_id, op.code, op.type
                                                                    FROM ' . $package_property_group_option_cls->getTable() . ' AS gop
                                                                    LEFT JOIN '.$package_property_option_cls->getTable().' AS op
                                                                    ON op.option_id = gop.option_id
                                                                    WHERE package_id = '.$package_id.'
                                                                    ORDER BY op.order ASC'
                                                                    ,true);
            if (is_array($options) and count($options) > 0){
                foreach ($options as $optionRow){
                    $row['group_'.$optionRow['group_id']][$optionRow['code']] = $optionRow['value'];
                    if ($optionRow['type'] == 'price'){
                        $priceValue = '';
                        if (strlen($optionRow['value'])){
                            $priceValue = showPrice_cent($optionRow['value']);
                        }
                        $row['group_'.$optionRow['group_id']][$optionRow['code'].'_show'] = $priceValue;
                    }elseif (in_array($optionRow['type'],array('multiselect'))){
                        $row['group_'.$optionRow['group_id']][$optionRow['code']] = explode(',',$optionRow['value']);
                    }
                }
            }
            $form_data = $row;
        }
    }
}

$smarty->assign(array('form_data' => $form_data));
?>