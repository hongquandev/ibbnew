<?php
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

$form_data = $banner_cls->getFields();
$id = getParam('id');
if(empty($id))$id = 0;
$form_data[$banner_cls->id] = $id;

$agent_id = (int)getParam('agent_id', 0);
$form_data['agent_id'] = $agent_id;
$form_data['agent_name'] = A_getFullName($agent_id);

$data = array();
$error_ar = array();
if (isPost()) {
	if (isset($_POST['fields']) && is_array($_POST['fields']) && count($_POST['fields']) > 0) {
		foreach ($_POST['fields'] as $key => $val){
			if (!isset($_POST['fields'][$key]) || !isset($form_data[$key]))
				continue;
			$data[$key] = !is_array($val) ? $banner_cls->escape($val) : $val;
		}
	}

	try {
		if (count($data) == 0) {
			throw new Exception('Please input data.');
		}

		$file_name = '';
		$path =  ROOTPATH.'/store/uploads/banner/images/';
        if (strlen($data['banner_file']) > 0) {
			//$file_name = renameFile($path, $data['banner_file']);
			//ftp_mediaFTP2Local($path.$data['banner_file'], $path.$data['banner_file']);
			$file_name = $data['banner_file'];
			$error_ar = B_valid($path.$data['banner_file'], $data['display']);
		}

		$from = new DateTime($data['date_from']);
		$to = new DateTime ($data['date_to']);
		if ($from > $to){
			$error_ar[] = '"Date from" must be small "Date to".';
		}

		if (is_array($data['page_id']) && count($data['page_id']) > 0) {
			$data['page_id'] = implode(',', $data['page_id']);
		} else {
			$error_ar[] = 'Page is invalid.';
		}

		if (count($error_ar) > 0) {
			throw new Exception(implode('<br/>', $error_ar));
		}
		$data['description'] = scanContent($data['description']);
		$data['notification_email'] = isset($data['notification_email']) ? 1 : 0;
		$data['position'] = trim($data['position']) == '' ? 1000 : $data['position'];

		if ($form_data[$banner_cls->id] > 0){//update
			$data['update_time'] = date('Y-m-d H:i:s');
			$row = $banner_cls->getCRow(array('banner_id', 'banner_file'), 'banner_id = '.$form_data[$banner_cls->id]);
			if ($file_name == '') {
				/*
				if (isset($row['banner_file'])) {
					$data['banner_file'] = $row['banner_file'];
					$error_ar += B_valid($path.'/'.$row['banner_file'], $data['display']);
					if (count($error_ar) > 0) {
						throw new Exception(implode('<br/>', $error_ar));
					}
				}
				*/
				unset($data['banner_file']);
			} else {
				if (@$row['banner_file'] != $file_name) {
					ftp_mediaDelete('/store/uploads/banner/images/', $row['banner_file']);
					B_deleteImage($row['banner_file']);
				}
				$data['banner_file'] = $file_name;
			}
			$banner_cls->update($data, 'banner_id = '.$form_data[$banner_cls->id]);
		} else {
			$data['banner_file'] = $file_name;
			$data['creation_time'] = date('Y-m-d H:i:s');
			$form_data[$banner_cls->id] = $banner_cls->insert($data);
		}

		if ($banner_cls->hasError()) {
			throw new Exception($banner_cls->getError());
		}

		$session_cls->setMessage('The information has been updated.');
		redirect('?module='.$module.'&token='.$token);
	} catch (Exception $e) {
		$session_cls->setMessage($e->getMessage());
		if (is_string(@$data['page_id']) && strlen(@$data['page_id']) > 0) {
			$data['page_id'] = explode(',', $data['page_id']);
		}

		$form_data = $data;
	}
} else {
	$row = $banner_cls->getRow('banner_id ='.(int)$id);
	if (is_array($row) and count($row) > 0){
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = formUnescape($row[$key]);
			}
		}

		$form_data['agent_name'] = A_getFullName($form_data['agent_id']);
		$form_data['page_id'] = explode(',',$row['page_id']);
	}

	if ($form_data['position'] == 1000) {
		$form_data['position'] = '';
	}

	$form_data['date_from'] = str_replace('0000-00-00', '', $form_data['date_from']);
	$form_data['date_to'] = str_replace('0000-00-00', '', $form_data['date_to']);
}


if ((int)$form_data['country'] == 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$display_ar = B_getOptionsDisplay();

$smarty->assign(array('options_state' => R_getOptions(($form_data['country'] >= 0 ? $form_data['country'] : -1), array('Any')),
				'options_type' => array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial'),
				'options_page' => Menu_getByBannerAreaId(0, $form_data['display'] > 0 ? $form_data['display'] : array_shift(array_keys($display_ar))),
				'options_country' => R_getOptions(),
				'options_display' => B_getOptionsDisplay(),
				'options_pos' => B_getOptionsPos(11),
				'options_pay_status' => $property_cls->getPayStatus(),
				'form_data' => $form_data,
				'message' => $message));

?>