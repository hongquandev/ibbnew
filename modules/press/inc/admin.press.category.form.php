<?php
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
//prepare update
	$form_data = $press_cat_cls->getFields();
	$form_data[$press_cat_cls->id] = getParam('id',0);
    $row = $press_cat_cls->getRow('cat_id ='.$form_data[$press_cat_cls->id]);
    if (is_array($row) and count($row) > 0){
        $form_data = $row;
    }

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['fields'])) {
		    if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
                foreach ($form_data as $key => $val) {
                    if (isset($_POST['fields'][$key])) {
                        $data[$key] = $press_cat_cls->escape($_POST['fields'][$key]);
                    } else {
                        unset($data[$key]);
                    }
                }
            }
            $data['active'] = isset($_POST['fields']['active'])?1:0;
            if ($form_data[$press_cat_cls->id] > 0){//update
			    $press_cat_cls->update($data,'cat_id ='.$form_data[$press_cat_cls->id]);
                $session_cls->setMessage('Edited successful');
                $status_label = 'UPDATE';
            }else{
			    $press_cat_cls->insert($data);
                $session_cls->setMessage('Added successful');
                $status_label = 'INSERT';
                $form_data[$press_cat_cls->id] = $press_cat_cls->insertId();
            }
            if (Press_SEOCategory($form_data[$press_cat_cls->id],$data['title'])){
                $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." PRESS CATEGORY:". $data['title'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
                if ($_POST['track'] == 1){
                    redirect(ROOTURL.'/admin/?module=press&action=add-category&token='.$token);
                }else{
                    redirect(ROOTURL.'/admin/?module=press&action=edit-category&id='.$form_data[$press_cat_cls->id].'&token='.$token);

                }
            }else{
                $session_cls->setMessage('Error !');
            }
	    }
    }

$smarty->assign(array('options_category'=>Press_getCategory(),
                      'form_data'=>formUnescapes($form_data),
                      'message'=>$message));

?>
