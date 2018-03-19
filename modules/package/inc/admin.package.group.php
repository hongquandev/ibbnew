<?php
global $package_id;
$form_data = $package_property_group_cls->getFields();
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $value) {
		if (isset($_POST[$key])) {
			$data[$key] = $_POST[$key];
		}
	}

	$package_property_group_cls->addValid(array('field' => 'name', 'label' => 'Title', 'fnc' => array('isRequire' => null)));

	try {
		if (!$package_property_group_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $package_property_group_cls->getErrorsValid()));
		}

        $data['is_active'] = isset($data['is_active'])?1:0;
        if ($data[$package_property_group_cls->id]) { // UPDATE
            $package_id = $data[$package_property_group_cls->id];
			$package_property_group_cls->update($data, $package_property_group_cls->id.' = '.$data[$package_property_group_cls->id]);
		} else { //INSERT
			$package_property_group_cls->insert($data);
            $package_id = $package_property_group_cls->insertId();
            //auto create price option
            $systemOption = array();
            $systemOption[] = array('group_id'=>$package_id,
                                    'name'=>'Package Price',
                                    'code'=>'price',
                                    'is_required'=>1,
                                    'type'=>'price',
                                    'is_active'=>1,
                                    'is_system'=>1,
                                    'order'=>1,
                                    'show_in_frontend'=>1);
            $systemOption[] = array('group_id'=>$package_id,
                                    'name'=>'Launch Special',
                                    'code'=>'special_price',
                                    'is_required'=>0,
                                    'type'=>'price',
                                    'is_active'=>1,
                                    'is_system'=>1,
                                    'order'=>2,
                                    'show_in_frontend'=>1);
            $systemOption[] = array('group_id'=>$package_id,
                                    'name'=>'Special Price From',
                                    'code'=>'special_price_from',
                                    'is_required'=>0,
                                    'type'=>'date',
                                    'is_active'=>1,
                                    'is_system'=>1,
                                    'order'=>3,
                                    'show_in_frontend'=>0);
            $systemOption[] = array('group_id'=>$package_id,
                                    'name'=>'Special Price To',
                                    'code'=>'special_price_to',
                                    'is_required'=>0,
                                    'type'=>'date',
                                    'is_active'=>1,
                                    'is_system'=>1,
                                    'order'=>4,
                                    'show_in_frontend'=>0);
            foreach ($systemOption as $option){
                $package_property_option_cls->insert($option);
            }
		}

		if ($package_property_group_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}

        //save options
        $options = $_POST['options'];
        //print_r($options);die();
        $options = json_decode($options,true);
        foreach ($options as $option){
            if (isset($option['remove']) && $option['remove']){
                //remove
                if (isset($option['option_id'])){
                    $package_property_group_option_cls->delete('option_id = '.$option['option_id']);
                    $package_property_option_cls->delete('option_id = '.$option['option_id']);
                }
                continue;
            }
            $option['group_id'] = $package_id;
            if ($option['is_system']){
                unset($option['code']);
                unset($option['type']);
            }
            if (isset($option['option_id'])){//update
                $package_property_option_cls->update($option,$package_property_option_cls->id.' = '.$option['option_id']);
                $optionId = $option['option_id'];
            }else{
                $package_property_option_cls->insert($option);
                $optionId = $package_property_option_cls->insertId();
            }

            if (in_array($option['type'], array('select','multiselect')) && isset($option['option'])){
                $selectOptions = $option['option'];
                foreach ($selectOptions as $k=>$childOption){
                    //remove
                    if ($k == 'remove'){
                        $removeIds = explode(',',$childOption);
                        foreach ($removeIds as $id){
                            $keyAr = explode('_',$id);
                            if (count($keyAr) == 3){
                                $entityId = $keyAr[2];
                                $package_option_cls->delete('entity_id = '.$entityId);
                            }
                        }
                        continue;
                    }
                    $childOption['option_id'] = $optionId;
                    $keyAr = explode('_',$k);
                    if (count($keyAr) == 3){
                        $entityId = $keyAr[2];
                        $package_option_cls->update($childOption,'entity_id = '.$entityId);
                    }else{
                        $package_option_cls->insert($childOption);
                    }
                }
            }

            if ($package_property_option_cls->hasError()) {
                throw new Exception('Error when inserting / updating option.');
            }
        }

		$session_cls->setMessage($form_data[$package_property_group_cls->id] > 0 ? 'Edited successful.' : 'Added successful.');
	} catch (Exception $e) {
		$message = $e->getMessage();
        $session_cls->setMessage($message);
	}
    if (getPost('next', 0) == 1) {
        redirect(ROOTURL . '/admin/?module=' . $module . '&action=edit-group&token=' . $token);
    } else {
        redirect(ROOTURL . '/admin/?module=' . $module . '&action=edit-group&package_id=' . $package_id . '&token=' . $token);
    }
} else {
    $row = $package_property_group_cls->getRow('group_id = ' . $package_id);
    if (is_array($row) && count($row) > 0) {
        //get all options of group
        $options = $package_property_option_cls->getRows('group_id = '.$package_id.' ORDER BY `order` ASC');
        if (is_array($options) and count($options) > 0){
            foreach ($options as $k=>$option){
                if (in_array($option['type'],array('select','multiselect'))){
                    //get select option
                    $childOptions = $package_option_cls->getRows('option_id = '.$option['option_id']);
                    if (is_array($childOptions) and count($childOptions) > 0){
                        foreach ($childOptions as $_option){
                            $options[$k]['option']['_'.time().'_'.$_option['entity_id']] = $_option;
                        }
                    }
                }
            }
        }

        $row['options'] = json_encode($options,JSON_HEX_APOS);
        $form_data = $row;
    }
}


switch ($action) {

    case 'edit-group':
        if($package_id > 0){
            $package_row = $package_property_group_cls->getRow('group_id = ' . $package_id);
            $smarty->assign(array('package_row' => $package_row));
        }
        break;

	case 'active-group':
		if ($package_id > 0) {
			$package_property_group_cls->update(array('is_active' => array('fnc' => 'abs(is_active - 1)')), 'group_id = '.$package_id);
			$session_cls->setMessage('Changed group\'s status success.');
		}
		redirect('?module=package&action=edit-group&token='.$token);
	break;

	case 'delete-group':
		if ($package_id > 0) {
            //delete all package value
            $options = $package_property_option_cls->getRows('group_id = '.$package_id);
            if (is_array($options) and count($options) > 0){
                foreach ($options as $option){
                    $package_property_group_option_cls->delete('option_id = '.$option['option_id']);
                }
            }
            //delete all option
            $package_property_option_cls->delete('group_id = '.$package_id);
			$package_property_group_cls->delete('group_id = '.$package_id);
			$session_cls->setMessage('Deleted successful.');
		}
		redirect('?module=package&action=edit-group&token='.$token);
	break;
}

$smarty->assign(array('form_data' => $form_data));
?>