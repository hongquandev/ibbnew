<?php
/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:57 AM
 * To change this template use File | Settings | File Templates.
 */
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';

//prepare update
	$form_data = $help_cls->getFields();
	$form_data[$help_cls->id] = getParam('id',0);
    $row = $help_cls->getRow('helpID ='.$form_data[$help_cls->id]);
    if (is_array($row) and count($row) > 0){
        $allow = array();
        if (strlen($row['allow']> 0)) {
            $roles = explode(',',$row['allow']);
            if (is_array($roles) and count($roles)> 0){
                foreach($roles as $role){
                    $allow[Role_getRole($role)] = 1;
                }
            }
        }
        $form_data = $row;
        $form_data['allow'] = $allow;
    }

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

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

            $allow = array();
            $_allow = array();
            foreach (Role_getOptions() as $k=>$role){
                if (isset($_POST['fields'][$role])){
                    $allow[] = $k;
                    $_allow[$role] = 1;
                }
            }
            $data['allow'] = implode(',',$allow);

            if ($form_data[$help_cls->id] > 0){//update
                $data['update_time'] = date('Y-m-d');
			    $help_cls->update($data,'helpID ='.$form_data[$help_cls->id]);
                $form_data = $data;
                $form_data['allow'] = $_allow;
                $message = 'Edited successful';
                $status_label = 'UPDATE';
            }else{
                $data['create_time'] = date('Y-m-d');
                $data['active'] = 1;
			    $help_cls->insert($data);
                $message = 'Added successful';
                $status_label = 'INSERT';
            }
			$smarty->assign('message', $message);
	    }
        $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." QUESTION:". $form_data['question'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
    }

$smarty->assign(array('options_role'=>Role_getOptions(),
                      'options_category'=>HC_getCategory(),
                      'form_data'=>$form_data));
?>