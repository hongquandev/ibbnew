<?php
$form_data = $menu_cls->getFields();
$form_data[$menu_cls->id] = $menu_id;
if (isSubmit()) {
	try {
		$data = $form_data;
		foreach ($data as $key => $val) {
			if (isset($_POST[$key])) {
				if (!is_array($_POST[$key])) {
					$data[$key] = $tab_cls->escape($_POST[$key]);
				} else {
					$data[$key] = $_POST[$key];
				}
			} else {
				unset($data[$key]);
			}
		}
		
		$form_data = $data;
		$data['active'] = isset($_POST['active']) ? 1 : 0;
        $data['show_mobile'] = isset($_POST['show_mobile']) ? 1 : 0;
		$data['area_ids'] = is_array($data['area_ids']) ? implode(',', $data['area_ids']) : ''; 
		$data['banner_area_ids'] = is_array($data['banner_area_ids']) ? implode(',', $data['banner_area_ids']) : ''; 
		$data['access'] = is_array($data['access']) ? implode(',', $data['access']) : ''; 
		$data['level'] = '';
		
		if ($data['parent_id'] == 0) {
			$data['iurl'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $data['title'])));
		} else {
			$url = '';
			$row = $menu_cls->getCRow(array('iurl'), 'menu_id = '.(int)$data['parent_id']);
			if (is_array($row) && count($row) > 0 ) {
				$url = $row['iurl'];
			}
			$data['iurl'] = $url.'/'.strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $data['title'])));
		}
		
		if (strlen(trim($data['url'])) == 0) {
			$data['url'] = $data['iurl'].'.html';
		} 
		
		if ($form_data[$menu_cls->id] > 0) {//update
			if (trim($data['url']) != '#' && $menu_cls->isExistExcludeId($data['url'], $form_data[$menu_cls->id])) {
				//throw new Exception('Url has been existed!');
			}
		
			$row = $menu_cls->getCRow(array('parent_id'), 'menu_id = '.$menu_id);
			if (isset($row['parent_id']) && $menu_id == $data['parent_id']) {
				$data['parent_id'] = $row['parent_id'];
			}
			$menu_cls->update($data, $menu_cls->id.' = '.$form_data[$menu_cls->id]);
		} else {//new
			if (trim($data['url']) != '#' && $menu_cls->isExist($data['url'])) {
				//throw new Exception('Url has been existed!');
			}
			
			$menu_cls->insert($data);
			$menu_id = $menu_cls->insertId();
		}
		
		if ($menu_cls->hasError()) {
			throw new Exception($menu_cls->getError());
		} else {
		
			if ($data['parent_id'] == 0) {
				$level_ar = array($menu_id => $data['title']);
			} else {
				$row = $menu_cls->getCRow(array('level'), 'menu_id = '.(int)$data['parent_id']);
				if (is_array($row) && count($row) > 0 ) {
					$level_ar = unserialize($row['level']);
					$level_ar[$menu_id] = $data['title'];
				} else {
					$level_ar = array($menu_id => $data['title']);
				}
			}
			
			$menu_cls->update(array('level' => serialize($level_ar)), 'menu_id = '.$menu_id);
					
			$form_action = '?module='.$module.'&action='.$action.'&menu_id='.$menu_id.'&token='.$token;
			$message = $form_data[$menu_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			$session_cls->setMessage($message);
		}
	} catch (Exception $e) {
		$session_cls->setMessage($e->getMessage());
		if ($data['menu_id'] > 0) {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&menu_id='.$data['menu_id'].'&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
		}
	}	
	
	if ($_POST['next'] == 1) {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
	} else {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=lists&token='.$token);
	}
	
} else {//GET for backing
	$row = $menu_cls->getRow('menu_id = '.(int)$menu_id);

	if ($menu_cls->hasError()) {
		$message = $menu_id->getError();
	} else if (is_array($row) and count($row)) {
		//set form data 
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
		
		if (strlen(trim($form_data['area_ids'])) > 0) {
			$form_data['area_ids'] = explode(',', $form_data['area_ids']);
		}

		if (strlen(trim($form_data['banner_area_ids'])) > 0) {
			$form_data['banner_area_ids'] = explode(',', $form_data['banner_area_ids']);
		}
		
		if (strlen(trim($form_data['access'])) > 0) {
			$form_data['access'] = explode(',', $form_data['access']);
		}
	} else {
		$row = $menu_cls->getCRow(array('`order`'), '1 ORDER BY `order` DESC');
		if (isset($row['order'])) {
			$form_data['order'] = $row['order'] + 1;
		}
		$form_data['active'] = 1;
	}
}

$smarty->assign('form_data',formUnescapes($form_data));	
?>