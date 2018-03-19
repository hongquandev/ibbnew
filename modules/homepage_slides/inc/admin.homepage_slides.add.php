<?php
include_once 'homepage_slides.class.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
$form_data = $slide_cls->getFields();
$form_data[$slide_cls->id] = getParam('id', 0);
$row = $slide_cls->getRow('id =' . $form_data[$slide_cls->id]);
if (is_array($row) and count($row) > 0) {
    $form_data = formUnescapes($row);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fields'])) {
        $data = $form_data;
        if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
            foreach ($data as $key => $val) {
                if (isset($_POST['fields'][$key])) {
                    $data[$key] = $slide_cls->escape($_POST['fields'][$key]);
                }
            }
            //UPLOAD IMAGE
            //SAVE FILE
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 300);
            $path = ROOTPATH . '/store/uploads/slides';
            $url_path = '/store/uploads/slides';
            createFolder($path, 1);
            //BEGIN SETTING FOR UPLOADER
            // list of valid extensions, ex. array()
            $allowedExtensions = array('png', 'jpg', "jpeg", "bmp");
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
                    }
                }
            }
            if ($form_data[$slide_cls->id] > 0){//update
                $data['update_time'] = date('Y-m-d');
                if(!empty($files_user['image_slide'])){
                    $data['image'] = $files_user['image_slide'];
                }
                $slide_cls->update($data,'id ='.$form_data[$slide_cls->id]);
                $form_data = $data;
                $message = 'Edited successful';
            }else{
                $data['date_creation'] = date('Y-m-d');
                $data['update_time'] = date('Y-m-d');
                if(!empty($files_user['image_slide'])){
                    $data['image'] = $files_user['image_slide'];
                }
                $slide_cls->insert($data);
                $message = 'Added successful';
            }
            $smarty->assign('message', $message);
        }
    }
}
$smarty->assign('row', $form_data);
?>