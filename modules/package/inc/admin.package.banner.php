<?php
$form_data = $package_banner_cls->getFields();
$form_data[$package_banner_cls->id] = $package_id;
if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $val) {
		if (isset($_POST[$key])) {
			$data[$key] = $_POST[$key];
		}
	}
	
	$package_banner_cls->addValid(array('field' => 'price', 'label' => 'Price', 
										'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	try {
		if (!$package_banner_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $package_banner_cls->getErrorsValid()));
		}
		
		$data['page_id'] = 0;
		if ($package_id > 0) { //UPDATE
			$row = $package_banner_cls->getRow('property_type_id = '.(int)@$data['property_type_id'].' 
												AND area = '.(int)@$data['area'].' 
												AND page_id = '.(int)@$data['page_id'].' 
												AND country_id = '.(int)@$data['country_id'].' 
												AND state_id = '.(int)@$data['state_id'].'
												AND package_id != '.$package_id);
												
			if (is_array($row) && count($row) > 0) {
				throw new Exception('There is the same condition record.');
			} else {
				$package_banner_cls->update($data, $package_banner_cls->id.' = '.$package_id);
			}
		} else { //INSERT
			$row = $package_banner_cls->getRow('property_type_id = '.(int)@$data['property_type_id'].' 
												AND area = '.(int)@$data['area'].' 
												AND page_id = '.(int)@$data['page_id'].' 
												AND country_id = '.(int)@$data['country_id'].' 
												AND state_id = '.(int)@$data['state_id']);
												
			if (is_array($row) && count($row) > 0) {	
				throw new Exception('There is the same condition record.');
			} else {								
				$package_banner_cls->insert($data);
				$package_id = $package_banner_cls->insertId();
			}
		}
		
		if ($package_banner_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}
		
		$session_cls->setMessage($form_data[$package_banner_cls->id] > 0 ? 'Edited successful.' : 'Added successful.');
		
		if (getParam('next', 0) == 1) {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-banner&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-banner&package_id='.$package_id.'&token='.$token);
		}
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
	
	$form_data = $data;
}

switch ($action) {
	case 'edit-banner':
		if ($package_id > 0) {
			$row = $package_banner_cls->getRow('package_id = '.(int)$package_id);
			if (is_array($row) && count($row) > 0) {
				$form_data = $row;
				$form_data['price'] = str_replace('.00', '', $form_data['price']);
			}
		}
	break;
	case 'active-banner':
		if ($package_id > 0) {
			$package_banner_cls->update(array('active' => array('fnc' => 'abs(active - 1)')), 'package_id = '.$package_id);
			$session_cls->setMessage('Changed package\'s status success.');
		}
		redirect('?module=package&action=edit-banner&token='.$token);
	break;
	case 'delete-banner':
		if ($package_id > 0) {
			$package_banner_cls->delete('package_id = '.$package_id);
			$session_cls->setMessage('Deleted successful.');
		}
		redirect('?module=package&action=edit-banner&token='.$token);
	break;
}

if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}
$form_data['country_id'] = $config_cls->getKey('general_country_default');
$form_data['show_price'] = showPrice_cent($form_data['price']);

$smarty->assign(array('options_country' => R_getOptions(),
					  'options_status' => R_getOptions(($form_data['country'] >= 0 ? $form_data['country'] : -1 ), array('Any')),
					  'options_property_subtype' => PEO_getOptions('property_type', array('Any')) + PEO_getOptions('property_type_commercial'),
					  'options_area' => B_getOptionsDisplay(),
					  'options_position' => B_getOptionsPos(150),
					  //'options_page' => B_getPage('Any'),
					  'options_page' => CMS_getTypePage(),
					  'form_data' => $form_data,
					  'data' => PABanner_getGridAdmin()));
				  
?>