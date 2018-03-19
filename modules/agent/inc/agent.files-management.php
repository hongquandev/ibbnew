<?php
//print_r($_SESSION);
ini_set('display_errors', 0);
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
$transact_agent_id = $_SESSION['agent']['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($transact_agent_id > 0) {
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
        $files_user = $files_application_supporting = $result = array();
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
        if (is_array($_FILES) && count($_FILES) > 0) {
            foreach ($_FILES as $key => $file) {
                $uploader->addFileToUpload($file);
                $result[$key] = $uploader->handleUpload($path . '/');
                if ($result[$key]['success']) {
                    if ($key == 'file_application') {
                        $file_application_form = $url_path . '/' . $result[$key]['filename'];
                    } else {
                        if(in_array($key,array('file_drivers_License','file_passport_birth'))){
                            $files_user[$key] = $url_path . '/' . $result[$key]['filename'];
                        }
                        $files_application_supporting[$key] = $url_path . '/' . $result[$key]['filename'];
                    }
                }
            }
        }
        if (count($files_user) > 0) {
            $bid_term_cls->addFileUser($transact_agent_id, $files_user);
        }
        if (count($files_application_supporting) > 0) {
            $bid_term_cls->addFileApplicationSupport($transact_agent_id, $files_application_supporting);
        }
        if (!empty($file_application_form)) {
            $bid_term_cls->addApplicationForm($transact_agent_id, $file_application_form);
        }
    }
}
if ((int)$transact_agent_id > 0) {
    $smarty->assign('files', $bid_term_cls->getFilesSupporting($transact_agent_id));
    $smarty->assign('files_user', $bid_term_cls->getDataUserDetail($transact_agent_id));
    $smarty->assign('file_application', $bid_term_cls->getFileApplication($transact_agent_id));
}
$message = '';
if (!empty($_SESSION['rental_form_message'])) {
    $message = $_SESSION['rental_form_message'];
    unset($_SESSION['rental_form_message']);
}
$smarty->assign('message', $message);
$smarty->assign('form_action', ROOTURL.'/?module=agent&action=files-management');





