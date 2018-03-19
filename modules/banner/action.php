<?php
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

if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
define('SITE_TITLE',$config_cls->getKey('site_title'));
$smarty->assign('site_title_config',$config_cls->getKey('site_title'));

include_once ROOTPATH . '/modules/general/inc/user_online.php';

if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();

$action = getParam('action');
switch ($action) {
    case 'upload':
        try {
            $path = ROOTPATH . '/store/uploads/banner/images/';
            createFolder($path, 3);
            $sizeLimit = 2 * 1024 * 1024;
            $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
            $result = $uploader->handleUpload($path);

            if (isset($result['success'])) {
                ftp_mediaUpload($path, $result['filename']);
                $result['nextAction'] = array();
                $result['nextAction']['method'] = 'showBanner';
                $result['nextAction']['args'] = array(
                    'image' => MEDIAURL . '/store/uploads/banner/images/' . $result['filename'],
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