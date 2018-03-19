<?php
error_reporting(0);
session_start();
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/banner/inc/banner.php';

include_once ROOTPATH . '/modules/general/inc/ftp.php';
include_once ROOTPATH . '/modules/general/inc/media.php';

$action = getParam('action');
$target = getParam('target');
switch ($action) {
    case 'upload':
        try {
            $path = ROOTPATH . '/store/uploads/infographic/images/';
            //createFolder($path, 3);
            if (!file_exists($path)) {
                die('die die die');
                mkdir($path, 0777, true);
            }
            $sizeLimit = 2 * 1024 * 1024;
            $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
            $result = $uploader->handleUpload($path);

            if (isset($result['success'])) {
                //ftp_mediaUpload($path, $result['filename']);
                $result['nextAction'] = array();
                $result['nextAction']['method'] = 'showIcon';
                $result['nextAction']['args'] = array(
                    'target' => $target,
                    'image' => MEDIAURL . '/store/uploads/infographic/images/' . $result['filename'],
                    'file_name' => $result['filename'],
                    'ext' => strtolower(end(explode(".", $result['filename'])))
                );
            } else if (!isset($result['error'])) {
                $result['error'] = 'Error';
            }
        } catch (Exception $er) {
            $result['message'] = $er->getMessage();
        }
        die(_response($result));
        break;
}
?>