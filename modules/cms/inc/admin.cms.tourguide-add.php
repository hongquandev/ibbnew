<?php
include_once 'cms.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
$form_data = $cms_cls->getFields();
$form_data[$cms_cls->id] = $page_id;

if (isSubmit()) {
	try {
		$data = $form_data;
		foreach ($data as $key => $val) {
			if (isset($_POST[$key])) {
				$data[$key] = $tab_cls->escape($_POST[$key]);
			} else {
				unset($data[$key]);
			}
		}
		
		$form_data = $data;
		
		if (strlen(trim($data['title'])) == 0) {
			throw new Exception('Title is invalid!');
		}
		
		$data['sort_order'] = (int)$data['sort_order'];
		$data['is_tour_guide'] = 1;
		if ($form_data[$cms_cls->id] > 0) {//update
			$data['update_time'] = date('Y-m-d H:i:s');		
			$cms_cls->update($data, $cms_cls->id.' = '.$form_data[$cms_cls->id]);
		} else {//new
			$data['creation_time'] = date('Y-m-d H:i:s');
			$cms_cls->insert($data);
			$page_id = $cms_cls->insertId();
		}
		
		if ($cms_cls->hasError()) {
			throw new Exception($cms_cls->getError());
		} else {
			$form_action = '?module='.$module.'&action='.$action.'&page_id='.$page_id.'&token='.$token;
			$message = $form_data[$cms_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			$session_cls->setMessage($message);
		}
	} catch (Exception $e) {
		$session_cls->setMessage($e->getMessage());
		if ($data['page_id'] > 0) {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=tourguide-add&id='.$data['page_id'].'&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=tourguide-list&token='.$token);
		}
	}	
	
	if ($_POST['next'] == 1) {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=tourguide-add&token='.$token);
	} else {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=tourguide-list&token='.$token);
	}
} else {
	$row = $cms_cls->getRow('page_id = '.(int)$page_id);
	
	if ($cms_cls->hasError()) {
		$message = $cms_cls->getError();
	} else if (is_array($row) and count($row) > 0) {
		//set form data 
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
	} else {
		$form_data['sort_order'] = 1;
		$row = $cms_cls->getCRow(array('`sort_order`'), '1 AND is_tour_guide = 1 ORDER BY `sort_order` DESC');
		if (isset($row['sort_order'])) {
			$form_data['sort_order'] = $row['sort_order'] + 1;
		}
		$form_data['active'] = 1;
	}
}
$type = $page_id > 0 ? 'edit' : 'add';
$smarty->assign('type',$type);
$smarty->assign(array('row' => $form_data));
?>