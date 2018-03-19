<?php
	$form_data = $banner_setting_cls->getFields();
	$form_data[$banner_setting_cls->id] = getParam('id',0);
    $row = $banner_setting_cls->getRow('setting_id = '.$form_data[$banner_setting_cls->id]);
    if (is_array($row) and count($row) > 0){
        $form_data = $row;
    }
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$check->arr = array('title', 'setting_value');
		if (isset($_POST['fields'])) {
			//$data = $form_data;
            if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
                foreach ($_POST['fields'] as $key => $val) {
                    if (isset($_POST['fields'][$key])) {
                        $data[$key] = $banner_setting_cls->escape($_POST['fields'][$key]);
                    } else {
                        unset($data[$key]);
                    }
                }
            }
        
            if ($form_data[$banner_setting_cls->id] != 0){
                $banner_setting_cls->update($data,$banner_setting_cls->id.'='.$form_data[$banner_setting_cls->id]);
                $form_data = $data;
			    $message = 'Edited successful';
            }else{
                $banner_setting_cls->insert($data);
                unset($form_data);
                $message = 'Added successful';
            }
			$smarty->assign('message', $message);
	    }

    }
$smarty->assign('row',$form_data);
?>