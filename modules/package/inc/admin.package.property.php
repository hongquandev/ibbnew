<?php
$form_data = $package_cls->getFields();
$form_data[$package_cls->id] = $package_id;
$form_data['document_ids'] = '';
$auction_sale_ar = PEO_getAuctionSale();

if (isSubmit()) {
	$data = array();
	foreach ($form_data as $key => $value) {
		if (isset($_POST[$key])) {
			$data[$key] = $package_cls->escape($_POST[$key]);
		}
	}
	$data['document_ids'] = $_POST['document_ids'];

	if ($data['property_type'] == 0){
        $data['property_type'] = $auction_sale_ar['auction'];
        $data['for_agent'] = 0;
    }else{
        $option = PEO_getOptionById($data['property_type']);
        if (in_array($option['for_agent'],array(Property::AUCTION_CODE_AGENT,Property::AUCTION_CODE_ALL))){
            $data['for_agent'] = 1;
        }else{
            $data['for_agent'] = 0;
        }
    }

	if (!isset($data['active'])) {
		$data['active'] = 0;
	}
    if (!isset($data['can_show'])) {
		$data['can_show'] = 0;
	}
	$data['package_type'] = 'property';
	$package_cls->addValid(array('field' => 'title', 'label' => 'Title', 'fnc' => array('isRequire' => null)));
	$package_cls->addValid(array('field' => 'price', 'label' => 'Price', 
								 'fnc' => array('isRequire' => null, 'isMaxLen' => array(10))));
	$package_cls->addValid(array('field' => 'description', 'label' => 'Description', 'fnc' => array('isRequire' => null)));
	$package_cls->addValid(array('field' => 'photo_num', 'label' => 'Number of photo', 'fnc' => array('isRequire' => null)));
	$package_cls->addValid(array('field' => 'video_num', 'label' => 'Number of video', 'fnc' => array('isRequire' => null)));
	$package_cls->addValid(array('field' => 'video_capacity', 'label' => 'Capacity of video', 
								 'fnc' => array('isInt' => null),
								 'fnc_msg' => array('isInt' => 'Capacity of video must be int.')));

	try {
		if (!$package_cls->isValid($data)) {
			throw new Exception(implode('<br/>', $package_cls->getErrorsValid()));
		}
		
		if (trim($data['photo_num']) != 'all' && preg_match('/[^0-9]/',$data['photo_num'])) {
			throw new Exception('Number of photo is not valid.');
		}
		
		if (trim($data['video_num']) != 'all' && preg_match('/[^0-9]/',$data['video_num'])) {
			throw new Exception('Number of video is not valid.');
		}
		
		if ($data['video_capacity'] > 0) {
			$data['video_capacity'] .= 'mb'; 
		}

        /*if( count($data['document_ids']) == 0){

            throw new Exception('Please select a least one a document.');
        }*/
		$diff_ar = array_diff(array_keys(DOC_getList()), (array)$data['document_ids']);
		if (count($diff_ar) == 0) {
			$data['document_ids'] = 'all';
		} else {
			$data['document_ids'] = implode(',', (array)$data['document_ids']);
		}


		if ($form_data[$package_cls->id]) { // UPDATE
			$package_cls->update($data, $package_cls->id.' = '.$package_id);
		} else { //INSERT
			$package_cls->insert($data);
		}
		
		if ($package_cls->hasError()) {
			throw new Exception('Error when inserting / updating data.');
		}
		
		$session_cls->setMessage($form_data[$package_cls->id] > 0 ? 'Edited successful.' : 'Added successful.');
		if (getPost('next', 0) == 1) {
			redirect(ROOTURL.'/admin/?module='.$module.'&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-property&package_id='.$package_id.'&token='.$token);
		}
	} catch (Exception $e) {
		$message = $e->getMessage();
	}
	
	// TO FORM
	$data['video_capacity'] = (int)$data['video_capacity'];
	if ($data['document_ids'] == 'all') {
		$data['document_ids'] = array_keys(DOC_getList());
        
	} else {
		if (!is_array($data['document_ids'])) {
			$data['document_ids'] = explode(',', (array)$data['document_ids']);
		}
	}

	$form_data = $data;
}

switch ($action) {
	case 'edit-property':
		$row = $package_cls->getRow('package_id = '.$package_id);
		if (is_array($row) && count($row) > 0) {
			if ($row['document_ids'] == 'all') {
				$doc_ar = DOC_getList();
				$row['document_ids'] = array_keys($doc_ar);
			} else {
				$row['document_ids'] = explode(',', $row['document_ids']);
			}

            //print_r($row['document_ids']);
			$row['video_capacity'] = (int)$row['video_capacity'];
            $row['property_type'] = PA_getAuctionTypeId($row['property_type'],$row['for_agent']);
			$form_data = $row;
			$form_data['price'] = str_replace('.00', '', $form_data['price']);
		}
	break;
	
	case 'active-property':
		if ($package_id > 0) {
			$package_cls->update(array('active' => array('fnc' => 'abs(active - 1)')), 'package_id = '.$package_id);
			$session_cls->setMessage('Changed package\'s status success.');
		}
		redirect('?module=package&token='.$token);
	break;
	
	case 'delete-property':
		if ($package_id > 0) {
			$package_cls->delete('package_id = '.$package_id);
			$session_cls->setMessage('Deleted successful.');
		}
		redirect('?module=package&token='.$token);
	break;
}
$form_data['show_price'] = showPrice_cent($form_data['price']);
$data = PA_getGridAdmin('property');
$smarty->assign(array('form_data' => $form_data,
					  'data' => $data));

?>