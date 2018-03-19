<?php
//print_r($_SESSION);
ini_set('display_errors', 0);
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
$transact_agent_id = $_SESSION['registerToTransact_agent_id'];
$step = getParam('step',3);
$continue = getParam('continue',0);
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($transact_agent_id > 0){
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
        $files_application_supporting = $result = array();
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
        if (is_array($_FILES) && count($_FILES) > 0) {
            foreach ($_FILES as $key => $file) {
                $uploader->addFileToUpload($file);
                $result[$key] = $uploader->handleUpload($path . '/');
                if ($result[$key]['success']) {
                    if($key == 'file_application'){
                        $file_application_form = $url_path . '/' . $result[$key]['filename'];
                    }else{
                        $files_application_supporting[$key] = $url_path . '/' . $result[$key]['filename'];
                    }
                }
            }
        }
        if(count($files_application_supporting) > 0){
            $bid_term_cls->addFileApplicationSupport($transact_agent_id,$files_application_supporting);
        }
        if(!empty($file_application_form)){
            $bid_term_cls->addApplicationForm($transact_agent_id, $file_application_form);
        }
        if($continue == 1){
            redirect(ROOTURL . '/?module=agent&action=register-application&transact_step='.((int)$step+1));
        }
    }
}
if((int)$transact_agent_id > 0){
    $smarty->assign('files', $bid_term_cls->getFilesSupporting($transact_agent_id));
    $smarty->assign('file_application', $bid_term_cls->getFileApplication($transact_agent_id));
}
$message = '';
if(!empty($_SESSION['rental_form_message'])){
    $message = $_SESSION['rental_form_message'];
    unset($_SESSION['rental_form_message']);
}
$smarty->assign('message', $message);


