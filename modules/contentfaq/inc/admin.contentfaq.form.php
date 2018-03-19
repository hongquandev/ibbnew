<?php
// Insert Faq.
$form_data = $contentfaq_cls->getFields();
$form_data[$contentfaq_cls->id] = getParam('id',0);
$row = $contentfaq_cls->getRow('content_id ='.$form_data[$contentfaq_cls->id]);
if (is_array($row) and count($row) > 0){
	$form_data = formUnescapes($row);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$check->arr = array('faq_id', 'question', 'answer', 'create_time', 'update_time');
	if (isset($_POST['fields'])) {
		if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
			foreach ($_POST['fields'] as $key => $val) {
				if (isset($_POST['fields'][$key])) {
					$data[$key] = $_POST['fields'][$key];
				} else {
					unset($data[$key]);
				}
			}
		}

		if ($form_data[$contentfaq_cls->id] > 0){//update
			$data['update_time'] = date('Y-m-d');

			$contentfaq_cls->update($data,'content_id ='.$form_data[$contentfaq_cls->id]);
			$form_data = $data;
			$message = 'Edited successful';
		}else{
			$data['create_time'] = date('Y-m-d');
			$data['update_time'] = date('Y-m-d');
			$data['active'] = 1;
			$contentfaq_cls->insert($data);
			$message = 'Added successful';
		}
		$session_cls->setMessage($message);
		redirect($form_action);
	}
}
$smarty->assign('row',$form_data);
?>