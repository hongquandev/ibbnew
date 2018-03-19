<?php
include_once 'cms.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
$form_data = $cms_cls->getFields();
$form_data[$cms_cls->id] = $page_id;
//print_r($form_data);die();
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
		$data['content'] = scanContent($data['content']);
		$data['content_chinese'] = scanContent($data['content_chinese']);
		$data['sort_order'] = (int)$data['sort_order'];
		
		if ($form_data[$cms_cls->id] > 0) {//update
			$data['update_time'] = date('Y-m-d H:i:s');		
			$cms_cls->update($data, $cms_cls->id.' = '.$form_data[$cms_cls->id]);

		} else {//new
			$data['creation_time'] = date('Y-m-d H:i:s');
			$cms_cls->insert($data);
			$page_id = $cms_cls->insertId();

		}
        /*infographic*/
        $infographic_row = $infographic_cls->getCRow(array($infographic_cls->id,'page_id'),'page_id = '.(int)$page_id);
        if(is_array($infographic_row) && count($infographic_row) > 0 ){
            /*Update Infographic Data*/
            $infographic_icon_on = $_POST['infographic_icon_on'];
            $infographic_icon_off = $_POST['infographic_icon_off'];
            $infographic_title = $_POST['infographic_title'];
            $infographic_content = $_POST['infographic_content'];
            $infographic_data = array("titles" => $infographic_title, "contents" => $infographic_content, "on_icons"=>$infographic_icon_on, "off_icons"=>$infographic_icon_off);
            $infographic_data['page_id'] = $form_data[$cms_cls->id];
            //print_r_pre($infographic_data);die();
            $infographic_cls->update_infographic($infographic_data);
        }else{
            /*Insert Infographic Data*/
            $infographic_icon_on = $_POST['infographic_icon_on'];
            $infographic_icon_off = $_POST['infographic_icon_off'];
            $infographic_title = $_POST['infographic_title'];
            $infographic_content = $_POST['infographic_content'];
            $infographic_data = array("titles" => $infographic_title, "contents" => $infographic_content, "on_icons"=>$infographic_icon_on, "off_icons"=>$infographic_icon_off);
            $infographic_data['page_id'] = $page_id;
            //print_r($infographic_data);die();
            $infographic_cls->insert_infographic($infographic_data);
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
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&id='.$data['page_id'].'&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
		}
	}	
	
	if ($_POST['next'] == 1) {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
	} else {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=lists&token='.$token);
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
		$row = $cms_cls->getCRow(array('`sort_order`'), '1 ORDER BY `sort_order` DESC');
		if (isset($row['sort_order'])) {
			$form_data['sort_order'] = $row['sort_order'] + 1;
		}
		$form_data['active'] = 1;
	}
    /*---------Infographic---------*/
    $infographic_row = $infographic_cls->getRows('page_id = '.(int)$page_id);   
    
    //$form_data['infographic'] = $infographic_row;
    /*Options Styles*/
    $form_data['options_style'] = array(0 => 'Default', 1 => 'How to sell Template' , 2 => 'How it works Template');
}
$smarty->assign(array('row' => $form_data));
if(is_array($infographic_row) && count($infographic_row) > 0) {
    $smarty->assign(array('infographic_data' => $infographic_row));   
} else {
    $infographic_row = array();
    for($i=1;$i<=15;$i++) {
        $arr = array('step'=> $i);
        array_push($infographic_row, $arr);
    }
    $smarty->assign(array('infographic_data' => $infographic_row));   
}
//print_r_pre($infographic_row);die();
?>