<?php
/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:58 AM
 * To change this template use File | Settings | File Templates.
 */
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
//prepare update
	$form_data = $cat_cls->getFields();
	$form_data[$cat_cls->id] = getParam('id',0);
    $row = $cat_cls->getRow('catID ='.$form_data[$cat_cls->id]);
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
                        $data[$key] = $help_cls->escape($_POST['fields'][$key]);
                    } else {
                        unset($data[$key]);
                    }
                }
            }
            $role_ar = array();
            $allow = array();
            foreach (Role_getOptions() as $k=>$role){
                if (isset($_POST['fields'][$role])){
                    $role_ar[] = $k;
                    $allow[] = $k;
                    $_allow[$role] = 1;
                }
            }
            $data['allow'] = implode(',',$allow);

            if ($form_data[$cat_cls->id] > 0){//update
			    $cat_cls->update($data,'catID ='.$form_data[$cat_cls->id]);
                $form_data = $data;
                $form_data['allow'] = $_allow;
                $message = 'Edited successful';
                $status_label = 'UPDATE';
            }else{
                $data['create_time'] = date('Y-m-d');
                $data['active'] = 1;
			    $cat_cls->insert($data);
                $message = 'Added successful';
                $status_label = 'INSERT';
            }
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." CATEGORY:". $form_data['title'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));

	    }
    }

$smarty->assign(array('options_role'=>Role_getOptions(),
                      'options_category'=>HC_getCategory(),
                      'form_data'=>$form_data,
                      'message'=>$message));

?>
