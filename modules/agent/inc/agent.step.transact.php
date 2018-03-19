<?php
//ini_set('display_errors', 1);
//print_r($_SESSION);
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
function loggedIn(){
    if ($_SESSION['agent']['id'] > 0) return true;
    return false;
}
if(loggedIn()){
    $_SESSION['registerToTransact_agent_id'] = $_SESSION['agent']['id'];
}
$registerToTransact_id = $_SESSION['registerToTransact_id'];
if(!empty($registerToTransact_id) && $registerToTransact_id > 0){
    $smarty->assign('registerToTransact_id', $registerToTransact_id);
}else{
    redirect(ROOTURL);
}
$transact_step = getParam('transact_step', 1);
$smarty->assign('form_action_transact', '&kind=' . getParam('kind', 'none'));
$smarty->assign('register_kind', getParam('kind', 'none'));
$smarty->assign('transact_step', $transact_step);
//$smarty->assign('func_action', 'func_action');
if ($transact_step == 1) {
    if(loggedIn()){
        redirect(ROOTURL . '/?module=agent&action=register-buyer&step=1&kind=transact&transact_step=2');
    }
}
if ($transact_step == 2) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !loggedIn()) {
        if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] == 0) {
            //ini_set('display_errors', 1);
            // Create Account
            $agent_cls->insert($_SESSION['new_agent']['agent']);
            $id = $agent_cls->insertId();
            $_SESSION['new_agent']['id'] = $id;
            if (isset($_SESSION['new_agent']['contact'])) {
                $_SESSION['new_agent']['contact']['agent_id'] = $id;
                $agent_contact_cls->insert($_SESSION['new_agent']['contact']);
                $_SESSION['new_agent']['contact']['agent_contact_id'] = $agent_contact_cls->insertId();
            }
            // Create folder
            $path = ROOTPATH . '/store/uploads/' . $_SESSION['new_agent']['id'];
            if ($_SESSION['new_agent']['id'] > 0 and !is_dir($path)) {
                @mkdir($path, 0777);
                chmod($path, 0777);
            }
            if (!is_dir($path)) {
                $message = "It can not create folder";
            }
            // Send Mail Account Confirm
            include_once 'agent.finish_register.php';
            $_SESSION['registerToTransact_agent_id'] = $id;
            $smarty->assign('captcha_accept_before', true);
        }
    }
}
if ($transact_step == 3) {
    $transact_agent_id = $_SESSION['registerToTransact_agent_id'];
    /*if(empty($transact_agent_id)){
        redirect(ROOTURL . '/?module=agent&action=register-application&transact_step=2');
    }*/
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = $_POST;
        //ini_set('display_errors', 1);
        if ($captcha_error) {
        } else {
            //update data
            unset($data['email_address']);
            unset($data['confirm_email_address']);
            unset($data['password']);
            unset($data['password2']);
            $agent_cls->update($data, $agent_cls->id . '=' . $transact_agent_id);
            //SAVE FILE
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 300);
            $path = ROOTPATH . '/store/uploads/files_' . $transact_agent_id;
            $url_path = '/store/uploads/files_' . $transact_agent_id;
            createFolder($path, 1);
            //BEGIN SETTING FOR UPLOADER
            // list of valid extensions, ex. array()
            $allowedExtensions = array('pdf', 'png', 'jpg', "jpeg", "bmp");
            // max file size in bytes
            $sizeLimit = 10 * 1024 * 1024 * 1024;
            $isCheckSetting = false;
            $uploader_check = true;
            $files_user = $result = array();
            $message_files = '';
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
            if (is_array($_FILES) && count($_FILES) > 0) {
                foreach ($_FILES as $key => $file) {
                    $uploader->addFileToUpload($file);
                    $result[$key] = $uploader->handleUpload($path . '/');
                    if ($result[$key]['success']) {
                        $files_user[$key] = $url_path . '/' . $result[$key]['filename'];
                    } else {
                        //$uploader_check = false;
                        $message_files = $result[$key]['error'];
                        break;
                    }
                }
            }
            if($uploader_check) {
                if ($bid_term_cls->addFileUser($transact_agent_id,$files_user)) {
                    $bid_term_cls->addFileApplicationSupport($transact_agent_id,$files_user);
                    $message = 'Save Successful.';
                    $smarty->assign('message', $message);
                };
                //$smarty->assign('func_action', 'showTransactApplication');
                //$smarty->assign('transact_agent_id', $transact_agent_id);
                redirect(ROOTURL . '/?module=agent&action=register-application&transact_step=3');
            }else{
                $smarty->assign('message_transact', $message_files);
            }
        }
    }
}
if (!($_SESSION['registerToTransact_agent_id'] > 0)) {
    if ($transact_step > 1){
        redirect(ROOTURL . '/?module=agent&action=register-buyer&step=1&kind=transact');
    }
} else {
    $form_datas = $agent_cls->getRow('agent_id=' . (int)$_SESSION['registerToTransact_agent_id']);
    $agent_id = $_SESSION['registerToTransact_agent_id'];
    $form_datas['password2'] = $form_datas['password'];
    $form_datas['email_address_confirm'] = $form_datas['email_address'];
    $smarty->assign('form_datas', $form_datas);
    $smarty->assign('file', $bid_term_cls->getDataUserDetail($agent_id));
}





