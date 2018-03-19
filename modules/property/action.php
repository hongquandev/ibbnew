<?php
if (isset($_POST["PHPSESSID"])) {
    session_id($_POST["PHPSESSID"]);
}
include '../../configs/config.inc.php';
include_once ROOTPATH . '/includes/functions.php';
include_once ROOTPATH . '/includes/model.class.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/modules/general/inc/options.php';
include_once ROOTPATH . '/modules/general/inc/documents.class.php';
include_once ROOTPATH . '/modules/property/inc/property_document.class.php';
if (!isset($property_document_cls) or !($property_document_cls instanceof Property_document)) {
    $property_document_cls = new Property_document();
}
if (!isset($document_cls) or !($document_cls instanceof Documents)) {
    $document_cls = new Documents();
}
include_once ROOTPATH . '/modules/comment/inc/comment.php';
include_once ROOTPATH . '/modules/note/inc/note.php';
include_once ROOTPATH . '/modules/property/inc/watchlists.class.php';
include_once ROOTPATH . '/modules/property/inc/property.mail.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once 'inc/property.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once ROOTPATH . '/includes/class.phpmailer.php';
include_once ROOTPATH . '/modules/general/inc/report_email.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once 'inc/property_media.class.php';
include_once ROOTPATH . '/modules/package/inc/package.php';
include_once ROOTPATH . '/modules/banner/inc/banner.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
include_once ROOTPATH . '/modules/general/inc/bids_stop.class.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/general/inc/ftp.php';
include_once ROOTPATH . '/modules/general/inc/media.php';
include_once ROOTPATH . '/modules/notification/notification.php';
include_once ROOTPATH . '/modules/notification/notification_app.class.php';
if (!($notification_app_cls) || !($notification_app_cls instanceof Notification_app)) {
    $notification_app_cls = new Notification_app();
}
//BEGIN SMARTY
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
$mobileFolder = '/';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
    $mobileFolder = '/mobile/';
} else {
    $smarty->compile_dir = ROOTPATH . '/templates_c/';
    $mobileFolder = '/';
}
$smarty->assign('MEDIAURL', MEDIAURL);
//END
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
    $bids_first_cls = new Bids_first();
}
if (!$bids_stop_cls || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
include_once ROOTPATH . '/modules/general/inc/user_online.php';
if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.facebook.class.php';
$fb = array('enable' => $config_cls->getKey('facebook_enable'),
    'security' => $config_cls->getKey('facebook_security'),
    'id' => $config_cls->getKey('facebook_application_api_id'),
    'key' => $config_cls->getKey('facebook_application_api_key'),
    'secret' => $config_cls->getKey('facebook_application_secret'),
    'url' => ROOTURL . '?module=agent&action=fb-info',
    'logout_url' => ROOTURL . '?module=agent&action=logout');
if (!isset($fb_cls) || !($fb_cls instanceof FaceBook)) {
    $fb_cls = new FaceBook($fb);
}
if (!isset($document_cls) or !($document_cls instanceof Documents)) {
    $document_cls = new Documents();
}
if (!isset($media_cls) or !($media_cls instanceof Medias)) {
    $media_cls = new Medias();
}
if (!isset($watchlist_cls) or !($watchlist_cls instanceof Watchlists)) {
    $watchlist_cls = new Watchlists();
}
if (!isset($region_cls) or !($region_cls instanceof Regions)) {
    $regions_cls = new Regions();
}
if (!isset($config_cls) or !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
if (!isset($report_email_cls) or !($report_email_cls instanceof ReportEmail)) {
    $report_email_cls = new ReportEmail();
}
if (!isset($property_term_cls) || !($property_term_cls instanceof Property_term)) {
    $property_term_cls = new Property_term();
}
if (!isset($package_cls) or !($package_cls instanceof Package)) {
    $package_cls = new Package();
}
$action = getParam('action');
define('SITE_TITLE', $config_cls->getKey('site_title'));
$smarty->assign('site_title_config', $config_cls->getKey('site_title'));
$smarty->assign('ROOTURL', ROOTURL);
/*
  $action = 'action-module';
 */
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
$path_relative = '/store/uploads/' . @$_SESSION['agent']['id'] . '/' . @$_SESSION['property']['id'];
switch ($action) {
    case 'down-term':
        $property_id = getParam('pid', 0);
        __termDocAction($property_id);
        exit();
        break;
    case 'upload-doc':
    case 'delete-doc':
    case 'down-doc':
        __propertyDocAction();
        exit();
        break;
    case 'upload-media':
    case 'delete-media':
    case 'default-media':
        __propertyMediaAction();
        exit();
        break;
    case 'status-property':
        die(_response(__propertyAttributeAction('status')));
        break;
    case 'rentnow-status-property':
        die(_response(__propertyAttributeAction('buynow_status', 'yesno')));
        break;
    case 'focus-property':
        die(_response(__propertyAttributeAction('focus')));
        break;
    case 'home-property':
        die(_response(__propertyAttributeAction('homepage')));
        break;
    case 'sold-property':
        die(_response(__propertysoldAction()));
        break;
    case 'logo-property':
        die(_response(__propertyAttributeAction('show_agent_logo', 'yesno')));
    case 'home_auction-property':
        die(__propertyHomeAction('home_auction'));
        break;
    case 'home_forthcoming-property':
        die(__propertyHomeAction('home_forthcoming'));
        break;
    case 'home_sale-property':
        die(__propertyHomeAction('home_sale'));
        break;
    case 'add-watchlist':
        die(_response(__propertyWatchlistAction()));
        break;
    case 'share-sendfriend':
        die(_response(__propertySendFriendAction()));
        break;
    case 'property_history':
        die(json_encode(__property_history()));
        break;
    case 'vm_media_photos':
        die(json_encode(__vmMediaPhotosAction()));
        break;
    case 'vm_media_videos':
        if ($config_cls->getKey('youtube_enable') == 1) {
            die(json_encode(__vmMediaYTAction()));
        } else {
            die(json_encode(__vmMediaVideosAction()));
        }
        break;
    case 'vm_doc':
        die(json_encode(__vmDocAction()));
        break;
    case 'vm_rating':
        die(json_encode(__vmRatingAction()));
        break;
    case 'vm_term':
        die(json_encode(__vmTermAction()));
        break;
    case 'vm_description':
        die(json_encode(__vmDescriptionAction()));
        break;
    case 'search':
        die(_response(__searchAction()));
        break;
    case 'validate-property':
        die(json_encode(__validateAction()));
        break;
    case 'contact':
        die(_response(__contactAction()));
        break;
    case 'buynow-property':
        die(json_encode(__buynowAction()));
        break;
    case 'buynow-accept-property':
        __buynowAcceptAction();
        break;
    case 'buynow-cancel-property':
        __buynowCancelAction();
        break;
    case 'make_an_offer':
        die(json_encode(__makeAnOfferAction()));
        break;
    case 'make_an_offer-list':
        die(json_encode(__makeAnOfferListAction((int)getParam('property_id', 0))));
        break;
    case 'make_an_offer-accept':
        die(json_encode(__makeAnOfferAcceptAction()));
        break;
    case 'make_an_offer-refuse':
        die(json_encode(__makeAnOfferRefuseAction()));
        break;
    case 'check_offer':
        die(json_encode(__checkofferAction()));
        break;
    case 'check_property':
        die(json_encode(__checkpropertyAction()));
        break;
    case 'list-copy-property':
        die(json_encode(__listCopyPropertyAction()));
        break;
    case 'copy-new-property':
        die(json_encode(__copyNewPropertyAction()));
        break;
    case 'before_auto_bid':
        die(json_encode(__beforeacceptAutoBidAction()));
        break;
    case 'auto_bid':
        $accept = (int)restrictArgs(getParam('accept', 0));
        if ($accept == 1) {
            die(json_encode(__acceptAutoBidAction()));
        } else {
            die(_response(__refuseAutoBidAction()));
        }
        break;
    case 'auto_bid_setting':
        die(_response(__autoBidSettingAction()));
        break;
    case 'get-package':
        $package = getParam('package');
        $field = getParam('field', '*');
        //$auction = getParam('auction');
        //$row = $package_cls->getRow('SELECT ' . $field . ' FROM ' . $package_cls->getTable() . ' WHERE package_id = ' . $package .' AND property_type = '.$auction , true);
        $row = $package_cls->getRow('SELECT ' . $field . ' FROM ' . $package_cls->getTable() . ' WHERE package_id = ' . $package, true);
        if (is_array($row) and count($row) > 0) {
            die(_response($row[$field]));
        }
        die(_response(array('error' => 1)));
        break;
    case 'set-focus':
    case 'set-home':
        $property_id = getParam('property_id', 0);
        $target = getParam('target');
        $mode = getParam('mode');
        die(_response(__setFocusHome($property_id, $target, $mode)));
        break;
    case 'send-mail'://contact winner
        $property_id = getParam('property_id', 0);
        $agent_name = getParam('agent_name');
        $agent_email = getParam('email_to');
        $content = getParam('content');
        die(json_encode(__sendMailwinnerAction($property_id, $agent_name, $agent_email, $content)));
        break;
    case 'require_activation'://contact winner
        $property_id = getParam('property_id', 0);
        $agent_email = getParam('agent_email');
        $agent_id = getParam('agent_id');
        $subject = getParam('subject');
        $content = getParam('content');
        die(json_encode(__sendMailRequireActiveAction($property_id, $agent_email, $agent_id, $subject, $content)));
        break;
    case 'yt_form':
        include_once ROOTPATH . '/modules/general/inc/youtube.php';
        break;
    case 'yt_delete':
        $id = trim(getParam('id'));
        $rs = array('result' => 0, 'data' => $id);
        if (strlen($id) > 0) {
            $row = $media_cls->getCRow(array('media_id'), 'file_name = \'' . $id . '\' AND type=\'video-youtube\'');
            if (is_array($row) && count($row) > 0 && @$row['media_id'] > 0) {
                $property_media_cls->delete('media_id = ' . $row['media_id']);
                $media_cls->delete('media_id =' . $row['media_id']);
                $rs['result'] = 1;
            }
        }
        die(json_encode($rs));
        break;
    case 'yt_testpackage':
        $rs = array('msg' => '');
        $property_id = (int)getParam('id');
        $row = $media_cls->getRow('SELECT COUNT(*) AS num
							FROM ' . $media_cls->getTable() . ' AS m,' . $property_media_cls->getTable() . ' AS pm
							WHERE m.media_id = pm.media_id AND m.type = \'video-youtube\' AND pm.property_id = ' . $property_id, true);
        $row_pk = PA_getPackageByPropertyId($property_id);
        if (@$row_pk['video_num'] !== 'all' && (int)@$row_pk['video_num'] == 0) {
            $rs['msg'] = 'This package does not support upload video.';
        } else if (@$row['num'] > 0) {
            if (@$row_pk['video_num'] !== 'all' && $row['num'] >= (int)@$row_pk['video_num']) {
                $rs['msg'] = 'You can not upload video more.';
            }
        }
        if (!isset($_SESSION['property']))
            $_SESSION['property'] = array();
        $_SESSION['property']['id'] = $property_id;
        die(json_encode($rs));
        break;
    case 'get_property_type':
        die(json_encode(__getPropertyTypeAction()));
        break;
    case 'change-reastatus':
        die(json_encode(__changeReaStatusAction()));
        break;
    case 'change-manager':
        __changeManager();
        break;
    case 'set-incre':
        __setIncre();
        break;
    case 'getDefaultPrice':
        __getPrice();
        break;
    case 'getPackage':
        __getPackage();
        break;
}
if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
    $banner_cls = new Banner();
}
function __sendMailRequireActiveAction($property_id, $agent_email, $agent_id, $subject, $content)
{
    global $property_cls, $config_cls, $banner_cls, $log_cls;
    $data = array('sent' => 0, 'property_id' => $property_id);
    if ($property_id > 0) {
        $lkB = getBannerByPropertyId($property_id);
        $agent_name = A_getFullName($agent_id);
        $email_from = $config_cls->getKey('general_contact_email');
        $email_to = $config_cls->getKey('general_contact_email');
        $content_ = '<label style="font-size: 16px; color: #2f2f2f;"> bidRhino REQUIRE ACTIVATION FOR ID: ' . $property_id . '</label>
                                </br>
                                </br>
                                <p style="font-size:14px; margin-bottom: 5px; color: #222222;">
                                    <strong style="width:50px;color: #222222;">Name: </strong>' . $agent_name . '
                                </p>
                                </br>
                                <p  style="font-size:14px;margin-top: 15px;color: #222222;">
                                    <strong style="width:50px;color: #222222;">Email:</strong> ' . $agent_email . '
                                </p>
                                </br>
                                <p  style="font-size:14px;margin-top: 15px;color: #222222; ">
                                    <strong style="width:50px;color: #222222;">Content:</strong> ' . $content . '
                                </p>
                            ';
        sendEmail_func('', $email_to, $content_, $subject, $lkB);
        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
        $log_cls->createLog('remind');
        $data['sent'] = 1;
    }
    return $data;
}

/**
 * @ function : __sendMailwinnerAction
 * @ argument :
 * @ output : json
 * */
function __sendMailwinnerAction($property_id = 0, $agent_name = '', $agent_email = '', $content = '')
{
    global $property_cls, $config_cls, $banner_cls, $log_cls;
    $data = array('sent' => 0, 'property_id' => $property_id);
    if ($property_id > 0) {
        $row_vendor = PE_getVendor($property_id);
        $vendor_name = A_getFullName($row_vendor['agent_id']);
        if (count($row_vendor) > 0 and is_array($row_vendor)) {
            $lkB = getBannerByPropertyId($property_id);
            $subject = 'bidRhino VENDOR CONTACT ';
            $email_from = $config_cls->getKey('general_contact_email');
            $content_ = '<label style="font-size: 16px; color: #2f2f2f;"> Vendor Information </label>
						</br>
						</br>
						</br>
						</br>
						<p style="font-size:14px; margin-bottom: 5px; color: #222222;">
							<strong style="width:50px;color: #222222;">Name: </strong>' . $vendor_name . '
						</p>
						</br>
						<p  style="font-size:14px;margin-top: 15px;color: #222222;">
							<strong style="width:50px;color: #222222;">Email:</strong> ' . $row_vendor['email_address'] . '
						</p>
						</br>
						<p  style="font-size:14px;margin-top: 15px;color: #222222; ">
							<strong style="width:50px;color: #222222;">Content:</strong> ' . $content . '
						</p>';
            sendEmail_func($email_from, $agent_email, $content_, $subject, $lkB);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
            $data['sent'] = 1;
        }
    }
    return $data;
}

/**
 * @ function : __termDocAction
 * @ argument :
 * @ output :
 * */
function __termDocAction($property_id)
{
    global $config_cls, $document_cls, $property_document_cls;
    $termDoc = DO_getTermDocument($property_id);
    if (is_array($termDoc) and count($termDoc) > 0) {
        $file_name = $termDoc['file_name'];
        $path_file = ROOTPATH . '/' . trim($file_name, '/');
    } else {
        $file_name = $config_cls->getKey('termdoc_filename');
        $path_file = ROOTPATH . '/' . trim($file_name, '/');
    }
    // if (file_exists($path_file)  && !isset($_SESSION['down-term']) ) {
    if (file_exists($path_file)) {
        //$_SESSION['down-term'] = 1;
        if (detectBrowserMobile()) {
            header("Cache-Control: maxage=1");
            header('Pragma: public');  // required
            header('Expires: 0');  // no cache
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type:' . __getMini($file_name));
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path_file)) . ' GMT');
            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
            header("Content-Transfer-Encoding:  binary");
            header('Content-Length: ' . filesize($path_file)); // provide file size
            header('Connection: close');
        } else {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename = ' . basename($file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check = 0, pre-check = 0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path_file));
        }
        ob_clean();
        flush();
        echo readfile($path_file);
    }
    exit();
}

function __renameExtFile($fileName)
{
    try {
        $arrFilnames = explode('.', $fileName);
        return $arrFilnames[0] . '.' . strtoupper($arrFilnames[1]);
    } catch (Exception $e) {
        return $fileName;
    }
}

function __getMini($fileName)
{
    try {
        $arrFilnames = explode('.', $fileName);
        if (strtoupper($arrFilnames[1]) == 'PDF') {
            return 'application/pdf';
        }
    } catch (Exception $e) {
    }
    return 'application/octet-stream';
}

/**
 * @ function : __propertyDocAction
 * @ argument : void
 * @ output : string
 * */
function __propertyDocAction()
{
    global $action, $property_document_cls, $document_cls, $path_relative;
    $document_id = (int)restrictArgs(getQuery('document_id', 0));
    if ($document_id <= 0)
        die(_response(array('error' => 'It can not find the type of document.')));
    $target = getPost('target');
    $property_id = (int)$_SESSION['property']['id'];
    $agent_id = (int)$_SESSION['agent']['id'];
    $path = $_SESSION['property']['path'];
    switch ($action) {
        case 'upload-doc':
            ini_set('max_input_time', 300);
            ini_set('max_execution_time', 300);
            createFolder($path, 2);
            if ($agent_id <= 0 or $property_id <= 0)
                die(_response(array('error' => 'No permission.')));
            //BEGIN SETTING FOR UPLOADER
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array('pdf', 'png', 'jpg');
            // max file size in bytes
            $sizeLimit = 10 * 1024 * 1024 * 1024;
            $isCheckSetting = false;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
            $result = $uploader->handleUpload($path);
            // to pass data through iframe you will need to encode all html tags
            $result['info'] = 'testing';
            //END
            $property_document_id = 0;
            if (isset($result['success'])) {
                $row = $property_document_cls->getCRow(array('property_document_id'), 'property_id=' . $property_id . ' AND document_id = ' . $document_id);
                if (is_array($row) && count($row) > 0) {
                    $property_document_id = $row['property_document_id'];
                    $datas = array('file_name' => $path_relative . '/' . $result['filename'],
                        'active' => 1);
                    $property_document_cls->update($datas, 'property_document_id=' . $row['property_document_id']);
                } else {
                    $datas = array('property_id' => $property_id,
                        'document_id' => $document_id,
                        'file_name' => $path_relative . '/' . $result['filename'],
                        'active' => 1);
                    $property_document_cls->insert($datas);
                    $property_document_id = $property_document_cls->insertId();
                }
                ftp_propertyUploadDoc($path, basename($result['filename']));
            }
            $result['nextAction'] = array();
            $result['nextAction']['method'] = 'showDoc';
            $result['nextAction']['args'] = array('actionDelete' => '/modules/property/action.php?action=delete-doc&property_id=' . $property_id . '&document_id=' . $document_id,
                'actionDown' => '/modules/property/action.php?action=down-doc&property_id=' . $property_id . '&document_id=' . $document_id,
                'target' => 'lst_' . $document_id,
                'file_name' => $result['filename'],
                'document_id' => $document_id,
                'property_document_id' => $property_document_id,
                'property_id' => $property_id);
            die(_response($result));
            break;
        case 'delete-doc':
            if ($agent_id <= 0 or $property_id <= 0)
                die(_response(array('error' => 'No permission.')));
            $row = $property_document_cls->getCRow(array('file_name'), 'property_id = ' . $property_id . ' AND document_id = ' . $document_id);
            $result = array('success' => 1,
                'type' => 'doc',
                'target' => $target,
                'replace_text' => 'No file chosen');
            if (is_array($row) && count($row) > 0) {
                $row['file_name'] = trim($row['file_name'], '/');
                $infoAr = pathinfo($row['file_name']);
                propertyDeleteDoc($infoAr['dirname'], $infoAr['basename']);
                ftp_propertyDeleteDoc($infoAr['dirname'], $infoAr['basename']);
                $property_document_cls->delete('property_id = ' . $property_id . ' AND document_id = ' . $document_id);
            }
            die(json_encode($result));
            break;
        case 'down-doc':
            $property_id = restrictArgs((int)getParam('property_id', 0));
            if ($document_id > 0 && $property_id > 0) {
                $row = $property_document_cls->getCRow(array('file_name'), 'property_id = ' . $property_id . ' AND document_id = ' . $document_id);
                if (is_array($row) && count($row) > 0) {
                    $file = trim($row['file_name'], '/');
                    $path_file = ROOTPATH . '/' . $file;
                    //die($path_file);
                    //ftp_propertyDownDoc($file, $path_file);
                    if (file_exists($path_file)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename=' . basename($path_file));
                        header('Content-Transfer-Encoding: binary');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($path_file));
                        ob_clean();
                        flush();
                        readfile($path_file);
                    }
                    /*if($fd = @fopen($path_file,'rb')){
                        //echo "OKI";
                        while(!feof($fd)) {
                            $buffer = fread($fd, 2048);
                            echo $buffer;
                        }
                    }else{
                        echo "File can't exit";
                    }
                    fclose($fd);
                    echo ($path_file);*/
                }
            }
            exit;
            break;
        default:
            die(json_encode(array('error' => 1, 'info' => $document_id)));
            break;
    }
}

/**
 * @ function : __propertyMediaAction
 * @ argument : void
 * @ output : string
 * */
function __propertyMediaAction_old()
{
    global $action, $media_cls, $property_media_cls, $property_cls, $package_cls, $path_relative;
    $action2 = 'delete-media';
    $property_id = (int)$_SESSION['property']['id'];
    $agent_id = (int)$_SESSION['agent']['id'];
    $path = $_SESSION['property']['path'];
    $rs = $_SESSION;
    if (($agent_id <= 0 or $property_id <= 0) && $action == 'upload-media')
        die(_response(array('error' => 'No permission.')));
    $target = getParam('target');
    $type = getQuery('type');
    switch ($action) {
        case 'upload-media':
            ini_set('max_input_time', 900);
            ini_set('max_execution_time', 900);
            createFolder($path, 3);
            $temp = array('post_max_size' => ini_get('post_max_size'),
                'upload_max_filesize' => ini_get('upload_max_filesize'));
            $row = $property_cls->getRow('SELECT pk.*
										  FROM ' . $property_cls->getTable() . ' AS p, ' . $package_cls->getTable() . ' AS pk
										  WHERE p.package_id = pk.package_id AND p.property_id = ' . $property_id, true);
            if (!is_array($row) || count($row) == 0) {
                die(json_encode(array('error' => 'Please select the package for this property.' . "<br/>" . '<a style="color:#006BD7" href = "/?module=property&action=register&step=2">Back to step 2.</a>')));
            }
            $path_pre = '';
            $sizeLimit = 10 * 1024 * 1024;
            if ($type == 'photo') {
                $sizeLimit = 2 * 1024 * 1024;
                if ($row['photo_num'] != 'all') {
                    $photo_ar = PM_getPhoto($property_id);
                    $row['photo_num'] = (int)$row['photo_num'];
                    if ($row['photo_num'] == 0) {
                        die(_response(array('error' => 'You can not upload image with current package.')));
                    } else if (count(@$photo_ar['photo']) >= $row['photo_num']) {
                        die(_response(array('error' => 'You have reached to maximun image that you can upload (' . $row['photo_num'] . ' images).')));
                    }
                }
                $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
                $path_pre = $path_relative . '/thumbs/';
            } else if ($type == 'video') {
                $video_ar = PM_getVideo($property_id);
                if ($row['video_num'] != 'all') {
                    $row['video_num'] = (int)$row['video_num'];
                    if ($row['video_num'] == 0) {
                        die(_response(array('error' => 'You can not upload video with current package.')));
                    } else if (count(@$video_ar['video']) >= $row['video_num']) {
                        die(_response(array('error' => 'You have reached to maximun video that you can upload (' . $row['video_num'] . ' videos).')));
                    }
                }
                if (strlen($row['video_capacity']) > 0) {
                    $mb = (int)str_replace('mb', '', $row['video_capacity']);
                    if ($mb > 0) {
                        $sizeLimit = $mb * 1024 * 1024;
                    }
                }
                $allowedExtensions = array('flv', 'mp4');
                $path_pre = $path_relative . '/';
            }
            $isCheckSetting = false;
            if (getParam('flash') == 1) {
                unset($_GET['qqfile']);
            }
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
            $result = $uploader->handleUpload($path);
            //print_r($result);
            // to pass data through iframe you will need to encode all html tags
            if (isset($result['success'])) {
                $datas = array('file_name' => $path_relative . '/' . $result['filename'], 'type' => $type, 'active' => 1);
                if ($type == 'photo') {
                    propertyUploadMedia($path, $result['filename']);
                    ftp_propertyUploadMedia($path, $result['filename']);
                } else {
                    //ini_set('display_errors', 1);
                    include_once ROOTPATH . '/modules/general/youtube.php';
                    $filePath = ROOTPATH . $path_relative . '/' . $result['filename'];
                    $_arg = array('filePath' => $filePath, 'client' => $client, 'youtube' => $youtube, 'title' => $property_id);
                    $result = array_merge($result, ytUpload($_arg));
                    $datas['file_name'] = $result['id'];
                    $datas['datas'] = $result['url'];
                    $datas['type'] = 'video-youtube';
                    unlink($filePath);
                }
                $media_id = 0;
                $media_cls->insert($datas);
                if (!$media_cls->hasError()) {
                    $media_id = $media_cls->insertId();
                    $datas = array('property_id' => $property_id, 'media_id' => $media_id);
                    $property_media_cls->insert($datas);
                }
                // END
                $result['nextAction'] = array();
                $result['nextAction']['method'] = 'show' . ucfirst($type);
                $result['nextAction']['args'] = array('actionDelete' => '/modules/property/action.php?action=delete-media&type=' . $type . '&media_id=' . $media_id,
                    'actionDefault' => '/modules/property/action.php?action=default-media&type=' . $type . '&media_id=' . $media_id,
                    'target' => $target,
                    'image' => MEDIAURL . $path_pre . $result['filename'],
                    'file_name' => $result['filename'],
                    'url' => @$result['url'],
                    'media_id' => @$datas['media_id'],
                    'property_id' => $property_id,
                    'is_admin' => 0,
                    'ext' => strtolower(end(explode(".", $result['filename'])))
                );
            } else if (!isset($result['error'])) {
                $result['error'] = 'Error';
            }
            die(_response($result));
            break;
        case 'delete-media':
            $media_id = (int)restrictArgs(getQuery('media_id', 0));
            if ($media_id <= 0)
                die(_response(array('error' => 'It can not find the type of media.')));
            $property_media_cls->delete('property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            $row = $media_cls->getCRow(array('file_name', 'type'), 'media_id = ' . $media_id);
            if (is_array($row) and count($row) > 0) {
                $infoAr = pathinfo($row['file_name']);
                propertyDeleteMedia($infoAr['dirname'], $infoAr['basename']);
                if ($row['type'] == 'video-youtube') {
                    include_once ROOTPATH . '/modules/general/youtube.php';
                    $_arg = array('client' => $client, 'youtube' => $youtube, 'id' => $row['file_name']);
                    ytDelete($_arg);
                } else {
                    ftp_propertyDeleteMedia($infoAr['dirname'], $infoAr['basename']);
                }
                $media_cls->delete('media_id = ' . $media_id);
                $data = array('url' => ROOTURLS . '/modules/property/action.php?action=delete-media-balancing&type=' . $type,
                    'post' => array('file_name' => $row['file_name']));
            }
            $result = array('success' => 1, 'target' => $target);
            die(_response($result));
            break;
        case 'default-media':
            $media_id = (int)restrictArgs(getQuery('media_id', 0));
            $property_id = (int)restrictArgs(getQuery('property_id', 0));
            $target = getPost('target');
            $default = getParam('default', 0);
            if ($media_id == 0 || $property_id == 0)
                die(_response(array('error' => 'default')));
            $row = $property_media_cls->getCRow(array('property_media_id'), 'property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            if (is_array($row) and count($row) > 0) {
                $property_media_cls->update(array('default' => 0), 'property_id = ' . $property_id);
                $property_media_cls->update(array('default' => $default), 'property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            }
            $result = array('success' => 1, 'target' => $target, 'property_id' => $property_id, 'default' => $default);
            die(_response($result));
            break;
    }
}

function wlog($msg)
{
    $handle = fopen(ROOTPATH . '/store/log.txt', 'wb');
    fputs($handle, $msg);
    fclose($handle);
}

function __propertyMediaAction()
{
    global $action, $media_cls, $property_media_cls, $property_cls, $package_property_cls, $path_relative, $config_cls;
    $action2 = 'delete-media';
    $property_id = (int)$_SESSION['property']['id'];
    $agent_id = (int)$_SESSION['agent']['id'];
    $path = $_SESSION['property']['path'];
    $rs = $_SESSION;
    if (($agent_id <= 0 or $property_id <= 0) && $action == 'upload-media')
        die(_response(array('error' => 'No permission.')));
    $target = getParam('target');
    $type = getQuery('type');
    switch ($action) {
        case 'upload-media':
            ini_set('max_input_time', 900);
            ini_set('max_execution_time', 900);
            createFolder($path, 3);
            $temp = array('post_max_size' => ini_get('post_max_size'),
                'upload_max_filesize' => ini_get('upload_max_filesize'));
            $row = PA_getPackageByPropertyId($property_id);
            if (!is_array($row) || count($row) == 0) {
                die(json_encode(array('error' => 'Please select the package for this property.' . "<br/>" . '<a style="color:#006BD7" href = "/?module=property&action=register&step=2">Back to step 2.</a>')));
            }
            $path_pre = '';
            $sizeLimit = 10 * 1024 * 1024;
            if ($type == 'photo') {
                $sizeLimit = 10 * 1024 * 1024;
                if ($row['photo_upload'] != 'all') {
                    $photo_ar = PM_getPhoto($property_id);
                    $row['photo_upload'] = (int)$row['photo_upload'];
                    if ($row['photo_upload'] == 0) {
                        die(_response(array('error' => 'You can not upload image with current package.')));
                    } else if (count(@$photo_ar['photo']) >= $row['photo_upload']) {
                        die(_response(array('error' => 'You have reached to maximun image that you can upload (' . $row['photo_upload'] . ' images).')));
                    }
                }
                $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
                $path_pre = $path_relative . '/thumbs/';
            } else if ($type == 'video') {
                $sizeLimit = (int)$row['video_size'] * 1024 * 1024;
                $video_ar = $config_cls->getKey('youtube_enable') == 1 ? PM_getYT($property_id) : PM_getVideo($property_id);
                //$video_ar = PM_getVideo($property_id);
                if ($row['video_upload'] != 'all') {
                    $row['video_upload'] = (int)$row['video_upload'];
                    if ($row['video_upload'] == 0) {
                        die(_response(array('error' => 'You can not upload video with current package.')));
                    } else if (count(@$video_ar['video']) >= $row['video_upload']) {
                        die(_response(array('error' => 'You have reached to maximun video that you can upload (' . $row['video_upload'] . ' videos).')));
                    }
                }
                /*if (strlen($row['video_capacity']) > 0) {
                    $mb = (int) str_replace('mb', '', $row['video_capacity']);
                    if ($mb > 0) {
                        $sizeLimit = $mb * 1024 * 1024;
                    }
                }*/
                $allowedExtensions = array('flv', 'mp4');
                $path_pre = $path_relative . '/';
            }
            $isCheckSetting = false;
            if (getParam('flash') == 1) {
                unset($_GET['qqfile']);
            }
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
            $result = $uploader->handleUpload($path);
            //print_r($result);
            // to pass data through iframe you will need to encode all html tags
            if (isset($result['success'])) {
                $datas = array('file_name' => $path_relative . '/' . $result['filename'], 'type' => $type, 'active' => 1);
                if ($type == 'photo') {
                    propertyUploadMedia($path, $result['filename']);
                    ftp_propertyUploadMedia($path, $result['filename']);
                } else {
                    //ini_set('display_errors', 1);
                    include_once ROOTPATH . '/modules/general/youtube.php';
                    $filePath = ROOTPATH . $path_relative . '/' . $result['filename'];
                    $_arg = array('filePath' => $filePath, 'client' => $client, 'youtube' => $youtube, 'title' => $property_id);
                    $result = array_merge($result, ytUpload($_arg));
                    $datas['file_name'] = $result['id'];
                    $datas['datas'] = $result['url'];
                    $datas['type'] = 'video-youtube';
                    unlink($filePath);
                }
                $media_id = 0;
                $media_cls->insert($datas);
                if (!$media_cls->hasError()) {
                    $media_id = $media_cls->insertId();
                    $datas = array('property_id' => $property_id, 'media_id' => $media_id);
                    $property_media_cls->insert($datas);
                }
                // END
                $result['nextAction'] = array();
                $result['nextAction']['method'] = 'show' . ucfirst($type);
                $result['nextAction']['args'] = array('actionDelete' => '/modules/property/action.php?action=delete-media&type=' . $type . '&media_id=' . $media_id,
                    'actionDefault' => '/modules/property/action.php?action=default-media&type=' . $type . '&media_id=' . $media_id,
                    'target' => $target,
                    'image' => MEDIAURL . $path_pre . $result['filename'],
                    'file_name' => $result['filename'],
                    'url' => @$result['url'],
                    'media_id' => @$datas['media_id'],
                    'property_id' => $property_id,
                    'is_admin' => 0,
                    'ext' => strtolower(end(explode(".", $result['filename'])))
                );
            } else if (!isset($result['error'])) {
                $result['error'] = 'Error';
            }
            die(_response($result));
            break;
        case 'delete-media':
            $media_id = (int)restrictArgs(getQuery('media_id', 0));
            if ($media_id <= 0)
                die(_response(array('error' => 'It can not find the type of media.')));
            $property_media_cls->delete('property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            $row = $media_cls->getCRow(array('file_name', 'type'), 'media_id = ' . $media_id);
            if (is_array($row) and count($row) > 0) {
                $infoAr = pathinfo($row['file_name']);
                propertyDeleteMedia($infoAr['dirname'], $infoAr['basename']);
                if ($row['type'] == 'video-youtube') {
                    include_once ROOTPATH . '/modules/general/youtube.php';
                    $_arg = array('client' => $client, 'youtube' => $youtube, 'id' => $row['file_name']);
                    ytDelete($_arg);
                } else {
                    ftp_propertyDeleteMedia($infoAr['dirname'], $infoAr['basename']);
                }
                $media_cls->delete('media_id = ' . $media_id);
                $data = array('url' => ROOTURLS . '/modules/property/action.php?action=delete-media-balancing&type=' . $type,
                    'post' => array('file_name' => $row['file_name']));
            }
            $result = array('success' => 1, 'target' => $target);
            die(_response($result));
            break;
        case 'default-media':
            $media_id = (int)restrictArgs(getQuery('media_id', 0));
            $property_id = (int)restrictArgs(getQuery('property_id', 0));
            $target = getPost('target');
            $default = getParam('default', 0);
            if ($media_id == 0 || $property_id == 0)
                die(_response(array('error' => 'default')));
            $row = $property_media_cls->getCRow(array('property_media_id'), 'property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            if (is_array($row) and count($row) > 0) {
                $property_media_cls->update(array('default' => 0), 'property_id = ' . $property_id);
                $property_media_cls->update(array('default' => $default), 'property_id = ' . $property_id . ' AND media_id = ' . $media_id);
            }
            $result = array('success' => 1, 'target' => $target, 'property_id' => $property_id, 'default' => $default);
            die(_response($result));
            break;
    }
}

/**
 * @ function : __propertyWatchlistAction
 * @ argument : void
 * @ output : string
 * */
function __propertyWatchlistAction()
{
    global $watchlist_cls, $property_cls, $config_cls, $agent_cls, $region_cls, $result, $banner_cls, $log_cls;
    $result = array('error' => 'Error');
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $auction_sale = PEO_getAuctionSale();
    if (!isset($_SESSION['agent']['id']) or $_SESSION['agent']['id'] <= 0) {
        $result = array('error' => 'login-popup');
    } else {
        $p_row = $property_cls->getRow('SELECT pro.confirm_sold,
											   pro.agent_id,
											   pro.stop_bid,
											   pro.property_id,
											   pro.address,
											   pro.suburb,
											   pro.auction_sale,
											   pro.state,
											   ag.email_address,
											   ag.mobilephone,
											   ag.notify_email,
											   ag.notify_sms
										FROM ' . $property_cls->getTable() . ' AS pro, ' . $agent_cls->getTable() . ' as ag
										WHERE property_id = ' . $property_id . '
                                              AND ag.agent_id = pro.agent_id'
            , true);
        if ($p_row['confirm_sold'] == 1) {
            $result = array('error' => 'This property had been sold ');
            return $result;
        }
        /* $partner = $agent_cls->getRow('SELECT *,
          (SELECT at.title FROM '.$agent_cls->getTable('agent_type') .' AS at WHERE a.type_id = at.agent_type_id) AS type
          FROM '.$agent_cls->getTable().' AS a
          WHERE a.agent_id = '.$_SESSION['agent']['id'],true);
          if ($partner['type'] == 'partner'){
          $result = array('error' => 'Access denied. Please login as a vendor or buyer to use this function.');
          return $result;
          } */
        //print_r($p_row);
        if (is_array($p_row) && $p_row['agent_id'] == $_SESSION['agent']['id']) {
            $result = array('error' => 'You are not allow to add your property to your watchlist.');
            return $result;
        }
        /* if (is_array($p_row) && $p_row['stop_bid'] == '1' && $p_row['auction_sale'] == $auction_sale['auction']){
          $result = array('error'=>'Property has been stop bid. You are not add to your watchlist.');
          return $result;
          } */
        /*
          $row = $watchlist_cls->getRow("SELECT
          CONCAT(pro.suburb,' ',
          (SELECT reg.name FROM ".$region_cls->getTable()." AS reg
          WHERE pro.state = reg.region_id),' ',pro.postcode) AS address
          FROM ".$property_cls->getTable()." AS pro
          WHERE pro.property_id = ".$property_id.' AND agent_id = '.$_SESSION['agent']['id'],true);
         */
        $row = $watchlist_cls->getCRow(array('watchlist_id'), 'property_id = ' . $property_id . ' AND agent_id = ' . (int)@$_SESSION['agent']['id']);
        $result = array('error' => 'Error');
        if (is_array($row) && count($row) > 0) {
            $result = array('success' => 'This item is already in your watch list.');
        } else {
            $watchlist_cls->insert(array('agent_id' => $_SESSION['agent']['id'], 'property_id' => $property_id));
            $result = array('success' => 'This item has been added to your watch list, all the best.');
            //send email to vendor and user
            $email_from = $config_cls->getKey('general_contact_email');
            /* $agent = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
              $vendor = $agent_cls->getRow('agent_id ='.$p_row['agent_id']); */
            $vendor = array('email_address' => $p_row['email_address'],
                'mobilephone' => $p_row['mobilephone']
            , 'notify_email' => $p_row['notify_email'],
                'notify_sms' => $p_row['notify_sms']
            );
            //$agent = array('email_address' => $_SESSION['agent']['email_address']);
            //$agent = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
            $agent = $agent_cls->getCRow(array('notify_email', 'email_address', 'notify_sms', 'mobilephone'), 'agent_id = ' . $_SESSION['agent']['id']);
            $lkB = getBannerByPropertyId($property_id);
            // END DUC CODING
            if (is_array($agent) and count($agent) > 0) {
                $msg_agent = $config_cls->getKey('email_watchlist_agent');
                $msg_agent = str_replace('[ID]', $p_row['property_id'], $msg_agent);
                $msg_agent = str_replace('[address]', $p_row['address'], $msg_agent);
                $msg_agent = str_replace('[rooturl]', ROOTURL, $msg_agent);
                $subject = $config_cls->getKey('email_watchlist_agent_subject');
                if ($agent['notify_email'] == 1) {
                    sendEmail_func($email_from, $agent['email_address'], $msg_agent, $subject, $lkB);
                    include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                    $log_cls->createLog('notify');
                }
                if ($agent['notify_sms'] == 1) {
                    sendSMS($agent['mobilephone'], $msg_agent);
                }
            }
            /* if (is_array($vendor)){
              $msg_vendor = $config_cls->getKey('email_watchlist_vendor');
              $msg_vendor = str_replace('[ID]',$p_row['property_id'],$msg_vendor);
              $msg_vendor = str_replace('[address]',$p_row['address'],$msg_vendor);
              $msg_vendor = str_replace('[agent_name]',$agent['firstname'].' '.$agent['lastname'],$msg_vendor);
              $msg_vendor = str_replace('[rooturl]',ROOTURL,$msg_vendor);

              $subject = $config_cls->getKey('email_watchlist_vendor_subject');
              if ($vendor['notify_email'] == 1) {
              sendEmail($email_from,$vendor['email_address'],$msg_vendor,$subject,$lkB);
              }
              if ($vendor['notify_sms'] == 1) {
              sendSMS($vendor['mobilephone'],$msg_vendor);
              }
              } */
            //end send email
        }
    }
    return $result;
}

/**
 * @ function : __propertySendFriendAction
 * @ argument : void
 * @ output : string
 * */
function __propertySendFriendAction()
{
    global $property_cls, $property_entity_option_cls, $banner_cls, $log_cls;
    $email_from = getPost('email_from');
    $email_to = getPost('email_to');
    $message = getPost('message');
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $result = array('error' => 'Error');
    if (!checkEmail($email_from) or !checkEmail($email_to) or strlen(trim($message)) == 0 or $property_id == 0) {
        $result = array('error' => 'Please input enough information.');
    } else {
        $row = $property_cls->getRow('SELECT pro_opt.code
					FROM ' . $property_cls->getTable() . ' AS pro,' . $property_entity_option_cls->getTable() . ' AS pro_opt
					WHERE pro.auction_sale = pro_opt.property_entity_option_id AND pro.property_id = ' . $property_id, true);
        if ($property_cls->hasError()) {
            //die(array('error'=>'Error'));
        } else if (!is_array($row) or count($row) == 0) {
            $result = array('error' => 'Error.');
        } else {
            $type = $row['code'] == 'auction' ? 'auction' : 'sale';
            $link = ROOTURL . '/?module=property&action=view-' . $type . '-detail&id=' . $property_id;
            $nd = '<br>
                   <label style="font-size: 16px; color: #CC8C04; margin-top: 20px; font-weight: bold;" >
                   Share property information </label>
                   <br><br>

                   Share property information : <a href="' . $link . '">' . SITE_TITLE . '</a><br>
                                    ' . $message . '
                   <br>';
            $lkB = getBannerByPropertyId($property_id);
            /* $mail = new PHPMailer();
              $content = emailTemplatesSendBanner($nd,$lkB);
              $mail->IsMail();
              $mail->From = $email_from;
              $mail->FromName = "";
              $mail->Sender = $email_from;
              $mail->AddReplyTo($email_from,"");
              $mail->AddAddress($email_to);
              $mail->Subject = 'Share property information.';
              $mail->IsHTML(true);
              $mail->Body = stripslashes($content);

              ob_start();
              if (!$mail->Send()) {
              $message = $mail->ErrorInfo;
              } else {
              $message = '';
              }
              ob_clean(); */
            $mail = sendEmail_func($email_from, $email_to, $nd, 'Share property information', $lkB);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('email_to_friend');
            if ($mail !== 'send')
                die('error=' . $mail);
            $result = array('success' => $message);
            StaticsReport('send_friend');
        }
    }
    return $result;
}

/**
 * @ function : __propertyAttributeAction
 * @ argument : type
 * @ output : string
 * */
function __propertyAttributeAction($type = '', $return = '')
{
    global $property_cls;
    $property_id = (int)restrictArgs(getPost('property_id', 0));
    $target = restrictArgs(getPost('target'), '[^0-9a-z\-\_]');
    $rs = array('success' => 0,
        'target' => $target,
        'value' => 0,
        'msg' => '');
    try {
        if ($property_id <= 0) {
            throw new Exception('This property is not valid.');
        }
        $field = '';
        switch ($type) {
            case 'status':
                $field = 'agent_active';
                break;
            case 'focus':
                $field = 'focus';
                break;
            case 'homepage':
                $field = 'set_jump';
                break;
            case 'show_agent_logo':
                $field = 'show_agent_logo';
                break;
            default:
                $field = $type;
                break;
        }
        switch ($return) {
            case 'yesno':
                $return_arr = array(0 => 'No', 1 => "Yes");
                break;
            default:
                $return_arr = array(0 => "Disable", 1 => "Enable");
                break;
        }
        if (strlen($field) > 0) {
            $property_cls->update(array($field => array('fnc' => 'ABS(`' . $field . '`-1)')), 'property_id = ' . $property_id);
            //$row = $property_cls->getCRow(array('focus', 'set_jump'), 'property_id = '.$property_id);
            $row = $property_cls->getRow('property_id = ' . $property_id);
            $rs['msg'] = $return_arr[$row[$field]];
            $rs['success'] = 1;
            $rs['focus'] = (int)$row['focus'];
            $rs['set_jump'] = (int)$row['set_jump'];
            if (is_array($row) && count($row) > 0 && $row[$field] > 0) {
                //$rs['msg'] = 'Enable';
                $rs['value'] = 1;
            }
        }
    } catch (Exception $e) {
        $rs['msg'] = $e->getMessage();
    }
    // UPDATE NOTIFICATION TO ANDROID
    push(0, array('type_msg' => 'update-property'));
    //push1(0, array('type_msg' => 'update-property'));
    return $rs;
}

/**
 * @ funciton : __validateAction
 * @ argument : void
 * @ output : array
 * */
function __validateAction()
{
    global $property_cls;
    $result = array('value' => '');
    $region = ($_REQUEST['region'] == '') ? getPost('region') : $_REQUEST['region'];
    $region = strtoupper($region);
    $row = $property_cls->getRow("SELECT c.id
								  FROM " . $property_cls->getTable('code') . " AS c
								  WHERE CONCAT(UCASE(suburb),' ',(SELECT reg_1.region_id
										FROM " . $property_cls->getTable('regions') . " AS reg_1
										WHERE reg_1.code = c.state), ' ',pcode) LIKE '%" . $region . "%'", true);
    if ($property_cls->hasError()) {
        $result['value'] = 'Error';
    } else if (is_array($row) and count($row)) {
        $result['value'] = $row['id'];
    }
    return ($result);
}

/**
 * @ function : __propertyPackagesAction
 * @ argument : void;
 * @ output : string
 * */
/*
  function __propertyPackagesAction() {
  global $property_cls, $package_cls, $smarty;
  $property_id = (int)getParam('property_id',0);

  $rs = '';
  $auction_sale_ar = PEO_getAuctionSale();
  $rows = $package_cls->getRows('property_type = '.$auction_sale_ar['auction'].' ORDER BY `order` ASC');
  if (is_array($rows) && count($rows) > 0) {
  foreach ($rows as $key => $row) {
  $rows[$key]['price'] = '$'.number_format($row['price'], 0, ',', '');
  }

  if ($property_id > 0) {
  $row = $property_cls->getRow('property_id = '.$property_id);
  if (is_array($row) && count($row) > 0) {
  $smarty->assign('package_id', $row['package_id']);
  }
  }

  $smarty->assign('package_data', $rows);
  //$rs = $smarty->fetch(ROOTPATH.'/modules/property/templates/property.packages.item.tpl');
  $rs = $smarty->fetch(ROOTPATH.'/modules/property/templates/property.packages.info.tpl');
  }

  return array('data' => $rs);
  }
 */
/**
 * @ function : __propertysoldAction
 * @ argument : void
 * @ output : string
 * */
function __propertysoldAction()
{
    global $property_cls;
    $property_id = (int)restrictArgs(getPost('property_id', 0));
    $target = restrictArgs(getPost('target'), '[^0-9a-z\-\_]');
    $auction_sale_arr = PEO_getAuctionSale();
    $row = $property_cls->getCRow(array('property_id', 'auction_sale', 'confirm_sold'), 'property_id = ' . $property_id);
    if ($row['property_id'] > 0) {
        if ($row['auction_sale'] == $auction_sale_arr['auction']) {
            $property_cls->update(array('stop_bid' => '1',
                'confirm_sold' => 1,
                'sold_time' => date('Y-m-d H:i:s')), 'property_id = ' . $property_id);
            Property_afterSold($property_id);
        } else {
            $property_cls->update(array('confirm_sold' => 1, 'sold_time' => date('Y-m-d H:i:s')), 'property_id = ' . $property_id);
            Property_afterSold($property_id);
        }
    }
    $result = array('success' => 1, 'target' => $target, 'msg' => 'None', 'confirm' => $row['confirm_sold']);
    $row = $property_cls->getCRow(array('property_id', 'auction_sale', 'confirm_sold'), 'property_id = ' . $property_id);
    if (is_array($row) && count($row) > 0 && $row['confirm_sold'] > 0) {
        $result['msg'] = 'Sold';
    }
    return $result;
}

/**
 * @ function : __propertyHomeAction
 * @ argument : type
 * @ output : string
 * */
function __propertyHomeAction2($type = '')
{
    //$container = getParam('container');
    global $property_cls, $region_cls, $property_entity_option_cls, $property_rating_mark_cls, $config_cls, $agent_cls, $bid_cls, $smarty, $property_term_cls, $auction_term_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $auction_sale = $auction_sale_ar['auction'];
    switch ($type) {
        case 'home_auction':
            $wh_clause = ' AND pro.end_time > \'' . date('Y-m-d H:i:s') . '\' AND pro.confirm_sold = 0 AND pro.stop_bid = 0 AND pro.start_time <= \'' . date('Y-m-d H:i:s') . '\'';
            break;
        case 'home_forthcoming':
            $wh_clause = ' AND pro.confirm_sold = 0 AND pro.stop_bid = 0 AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\'';
            break;
        case 'home_sale':
            $auction_sale = $auction_sale_ar['private_sale'];
            $wh_clause = 'AND IF (pro.confirm_sold = 1  AND datediff(\'' . date('Y-m-d H:i:s') . '\', pro.sold_time) >14 ,0,1) = 1';
            break;
    }
    $_type = explode('_', $type);
    unset($_SESSION['type_prev']);
    unset($_SESSION['wh_str']);
    $_SESSION['where'] = 'list';
    $view_all_link = '?module=property&action=view-' . $_type[1] . '-list';
    $rand_ar = array('DESC', 'ASC', 'ASC', 'DESC');
    $order_by = $rand_ar[rand(0, 3)];
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,
											pro.address,
											pro.confirm_sold,
											pro.suburb,
											pro.state,
											pro.open_for_inspection,
											pro.postcode,
											pro.end_time,
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.last_bid_time,
											pro.description,
											pro.open_for_inspection,
											pro.agent_active,
											pro.start_time,
											pro.end_time,
											pro.auction_sale,

											(SELECT pro_term.value
											 FROM " . $property_cls->getTable('property_term') . " AS pro_term
											 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
													ON pro_term.auction_term_id = term.auction_term_id
											 WHERE term.code = 'auction_start_price'
													AND pro.property_id = pro_term.property_id
											) AS start_price,

											(SELECT reg1.name
											FROM " . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg2.name
											FROM ' . $region_cls->getTable() . ' AS reg2
											WHERE reg2.region_id = pro.country
											) AS country_name,

											(SELECT pro_opt1.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
											WHERE pro_opt1.property_entity_option_id = pro.bathroom
											) AS bathroom_value,

											(SELECT pro_opt2.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
											WHERE pro_opt2.property_entity_option_id = pro.bedroom
											) AS bedroom_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_port
											) AS carport_value,

											(SELECT CASE
															WHEN auction_sale = ' . $auction_sale_ar['auction'] . ' AND pro.start_time != \'0000-00-00 00:00:00\' AND( pro.start_time > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN

																(SELECT pro_term.value
																 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
																 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
																 ON pro_term.auction_term_id = term.auction_term_id
																 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
																 )

															WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' OR (auction_sale = ' . $auction_sale_ar['auction'] . ' AND pro.start_time = \'0000-00-00 00:00:00\') THEN pro.price
															ELSE max(bid.price)
															END
													FROM ' . $property_cls->getTable('bids') . ' AS bid
													WHERE bid.property_id = pro.property_id
													) AS price

									FROM ' . $property_cls->getTable() . ' AS pro


									WHERE pro.auction_sale = ' . $auction_sale . '
											AND pro.active = 1
											AND pro.agent_active = 1
											AND pro.set_jump = 1
											AND pro.pay_status = ' . Property::CAN_SHOW . '

											AND IF (pro.auction_sale = ' . $auction_sale_ar['auction'] . '
                                            AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                ON pro_term.auction_term_id = term.auction_term_id
                                                WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id ) = 0, 0, 1) = 1
                                            ' . $wh_clause . '
									ORDER BY pro.property_id ' . $order_by . '
									LIMIT 0,6', true); //AND pro.focus = 0
    /*
     * under:AS pro
      INNER JOIN '.$property_cls->getTable('agent').' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
      (SELECT agt_typ.agent_type_id
      FROM '.$property_cls->getTable('agent_type').' AS agt_typ
      WHERE agt_typ.title != \'theblock\')
      AND IF(pro.hide_for_live = 1 AND pro.start_time > "'.date('Y-m-d H:i:s').'", 0, 1) = 1
     */
    //echo $property_cls->sql;
    $auction_data = array();
    if (!is_array($rows) || count($rows) == 0) {
        return '';
    }
    foreach ($rows as $row) {
        $end_time = $row['end_time'];
        $dt = new DateTime($row['end_time']);
        $start_time = $row['start_time'];
        $dt1 = new DateTime($start_time);
        $now = new DateTime(date('Y-m-d H:i:s'));
        $row['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
        $row['start_time'] = $dt1->format($config_cls->getKey('general_date_format'));
        //CHECK PRICE
        $row['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');
        $row['check_price'] = (int)$row['price'] >= (int)$row['reserve_price'] ? 'true' : 'false';
        $row['check_start'] = (int)$row['price'] == (int)$row['start_price'] ? 'true' : 'false';
        if ($row['auction_sale'] == $auction_sale_ar['auction']) {//AUCTION
            $row['title'] = 'AUCTIONS ENDS: ' . $row['end_time'];
            if ($dt1 > $now) {//FORTHCOMING
                $row['type'] = 'forthcoming';
                $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                $row['price'] = '<div style="float:left;margin-left:10px;font-size:12px;">From<span>: ' . showLowPrice($reserve_price) . '</span></div><div style="float:left;clear:both;margin-left:10px;font-size:12px;*margin-left: 10px;*float: none;*text-align: left;">To<span style="margin-left:15px;">: ' . showHighPrice($reserve_price) . '</span></div>';
            } else {
                $row['type'] = 'auction';
                $row['price'] = showPrice($row['price']);
                $row['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
            }
        } else {
            $row['type'] = 'sale';
            $row['title'] = 'FOR SALE: ' . $row['suburb'];
            $row['price'] = showPrice($row['price']);
        }
        $row['livability_rating_mark'] = showStar($row['livability_rating_mark']);
        $row['green_rating_mark'] = showStar($row['green_rating_mark']);
        $row['link'] = '?module=property&action=view-' . $_type[1] . '-detail&id=' . $row['property_id'];
        //print_r($row['property_id'].','.$row['livability_rating_mark'].','.$row['green_rating_mark']);
        //BEGIN MEDIA
        $_media = PM_getPhoto($row['property_id'], true);
        $row['file_name'] = $_media['photo_thumb_default'];
        //END
        //CALC REMAIN TIME
        $row['remain_time'] = (int)remainTime($end_time);
        $row['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection']);
        $row['awl'] = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=" . $row['property_id'] . "')";
        //RE-EDIT ADDRESS
        $row['address_full'] = $row['address'] . ', ' . $row['suburb'] . ', ' . $row['state_name'] . ', ' . $row['postcode'];
        $row['address_short'] = strlen($row['address_full']) > 30 ? substr($row['address_full'], 0, 27) . ' ...' : $row['address_full'];
        $auction_data[] = $row;
    }
    $smarty->assign('auction_data', $auction_data);
    //$smarty->assign('title_bar',$property_title_bar);
    $smarty->assign('view_all_link', $view_all_link);
    $result = array();
    $result['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.home.auction.live.tpl');
    //$result['container'] = $container;
    return $result['data'];
}

function __propertyHomeAction($type = '')
{
    //$container = getParam('container');
    global $property_cls, $region_cls, $property_entity_option_cls, $property_rating_mark_cls, $config_cls, $agent_cls, $bid_cls, $smarty, $property_term_cls, $auction_term_cls, $bids_first_cls, $agent_payment_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $auction_sale = array($auction_sale_ar['auction'], $auction_sale_ar['ebiddar'], $auction_sale_ar['ebidda30'], $auction_sale_ar['bid2stay']);
    switch ($type) {
        case 'home_auction':
            $wh_clause = " AND pro.end_time > '" . date('Y-m-d H:i:s') . "'
		                   AND IF(agt.type_id IN (SELECT agent_type_id AS at
								                  FROM agent_type AS at
								                  WHERE at.title != 'theblock')
                                  ,pro.stop_bid = 0 AND pro.confirm_sold = 0
                                  ,IF(pro.stop_bid = 0 AND pro.confirm_sold = 0,1,datediff('" . date('Y-m-d H:i:s') . "', pro.sold_time) <= 15 AND pro.confirm_sold = 1)
                                  )
		                   AND pro.start_time <= '" . date('Y-m-d H:i:s') . "'";
            break;
        case 'home_forthcoming':
            $wh_clause = ' AND pro.confirm_sold = 0
			               AND pro.stop_bid = 0
			               AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\'';
            break;
        case 'home_sale':
            $auction_sale = array($auction_sale_ar['private_sale']);
            $wh_clause = 'AND (IF (pro.confirm_sold = 1  AND datediff(\'' . date('Y-m-d H:i:s') . '\', pro.sold_time) <14,1,0) = 1
                               OR pro.confirm_sold = 0)';
            break;
    }
    $_type = explode('_', $type);
    unset($_SESSION['type_prev']);
    unset($_SESSION['wh_str']);
    $_SESSION['where'] = 'list';
    $view_all_link = '?module=property&action=view-' . $_type[1] . '-list';
    $rand_ar = array('DESC', 'ASC', 'ASC', 'DESC');
    $order_by = $rand_ar[rand(0, 3)];
    $count = array();
    $count['once'] = $config_cls->getKey('count_going_once');
    $count['twice'] = $config_cls->getKey('count_going_twice');
    $count['third'] = $config_cls->getKey('count_going_third');
    $wh_arr = Property_getCondition();
    /* bidRhino-1022:Hide The Block properties from view in the Online Auctions section: NHUNG */
    $show_theblock_homepage = (int)$config_cls->getKey('theblock_show_homepage');
    if ($show_theblock_homepage == 0) {
        $wh_arr[] = " agt.type_id IN (SELECT agent_type_id AS at
								          FROM agent_type AS at
								          WHERE at.title != 'theblock')";
    }
    $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
    $rows = $property_cls->getRows("SELECT SQL_CALC_FOUND_ROWS pro.property_id,
											pro.address,
											pro.confirm_sold,
											pro.suburb,
											pro.state,
											pro.open_for_inspection,
											pro.postcode,
											pro.end_time,
											pro.livability_rating_mark,
											pro.green_rating_mark,
											pro.last_bid_time,
											pro.description,
											pro.open_for_inspection,
											pro.agent_active,
											pro.start_time,
											pro.end_time,
											pro.auction_sale,
											pro.set_count,
											pro.owner,
											pro.kind,
											pro.parking,
											pro.date_to_reg_bid,
											pro.price_on_application,

											(SELECT pro_term.value
											 FROM " . $property_cls->getTable('property_term') . " AS pro_term
											 LEFT JOIN " . $property_cls->getTable('auction_terms') . " AS term
													ON pro_term.auction_term_id = term.auction_term_id
											 WHERE term.code = 'auction_start_price'
													AND pro.property_id = pro_term.property_id
											) AS start_price,

											(SELECT reg1.name
											FROM " . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg2.name
											FROM ' . $region_cls->getTable() . ' AS reg2
											WHERE reg2.region_id = pro.country
											) AS country_name,

											(SELECT pro_opt1.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt1
											WHERE pro_opt1.property_entity_option_id = pro.bathroom
											) AS bathroom_value,

											(SELECT pro_opt2.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt2
											WHERE pro_opt2.property_entity_option_id = pro.bedroom
											) AS bedroom_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_port
											) AS carport_value,

											(SELECT pro_opt3.value
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt3
											WHERE pro_opt3.property_entity_option_id = pro.car_space
											) AS carspace_value,

											(SELECT pro_opt4.code
											FROM ' . $property_entity_option_cls->getTable() . ' AS pro_opt4
											WHERE pro_opt4.property_entity_option_id = pro.auction_sale
											) AS auctionsale_code,


											(SELECT CASE
															WHEN auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.start_time != \'0000-00-00 00:00:00\' AND( pro.start_time > \'' . date('Y-m-d H:i:s') . '\' OR isnull(max(bid.price)) ) THEN

																(SELECT pro_term.value
																 FROM ' . $property_cls->getTable('property_term') . ' AS pro_term
																 LEFT JOIN ' . $property_cls->getTable('auction_terms') . ' AS term
																 ON pro_term.auction_term_id = term.auction_term_id
																 WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id
																 )

															WHEN (auction_sale != ' . $auction_sale_ar['private_sale'] . ' AND pro.start_time = \'0000-00-00 00:00:00\') THEN pro.price
															WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price != 0 THEN pro.price
                                                            WHEN auction_sale = ' . $auction_sale_ar['private_sale'] . ' AND pro.price = 0 AND pro.price_on_application !=0 THEN pro.price_on_application
															ELSE max(bid.price)
															END
													FROM ' . $property_cls->getTable('bids') . ' AS bid
													WHERE bid.property_id = pro.property_id
													) AS price

									FROM ' . $property_cls->getTable() . ' AS pro
                                    INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id
									WHERE pro.auction_sale IN (' . implode(',', $auction_sale) . ')
											AND pro.active = 1
											AND pro.agent_active = 1
											AND pro.set_jump = 1

											AND pro.pay_status = ' . Property::CAN_SHOW . '

											AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
                                            AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                FROM ' . $property_term_cls->getTable() . ' AS pro_term
                                                LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
                                                ON pro_term.auction_term_id = term.auction_term_id
                                                WHERE term.code = \'auction_start_price\' AND pro.property_id = pro_term.property_id ) = 0, 0, 1) = 1
                                            ' . $wh_clause . '
                                            AND IF (pro.auction_sale != ' . $auction_sale_ar['private_sale'] . '
														AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
															 FROM ' . $property_term_cls->getTable() . ' AS pro_term
															 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'auction_start_price\'
																AND pro.property_id = pro_term.property_id )
														AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
															 FROM ' . $property_term_cls->getTable() . ' AS pro_term
															 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'reserve\'
																AND pro.property_id = pro_term.property_id )
														AND  IF((SELECT pro_term.value
															 FROM ' . $property_term_cls->getTable() . ' AS pro_term
															 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'auction_start_price\'
																AND pro.property_id = pro_term.property_id )
														     >
															 (SELECT pro_term.value
															 FROM ' . $property_term_cls->getTable() . ' AS pro_term
															 LEFT JOIN ' . $auction_term_cls->getTable() . ' AS term
																ON pro_term.auction_term_id = term.auction_term_id
															 WHERE term.code = \'reserve\'
																AND pro.property_id = pro_term.property_id ),0,1)
													    = 0, 0, 1) = 1
													    ' . $wh_str . '
									ORDER BY RAND()
									LIMIT 0,6', true);
    //ORDER BY pro.property_id '.$order_by.'
    //AND pro.focus = 0
    //print_r($property_cls->sql);
    $auction_data = array();
    if (!is_array($rows) || count($rows) == 0) {
        return '';
    }
    foreach ($rows as $row) {
        $end_time = $row['end_time'];
        $dt = new DateTime($row['end_time']);
        $start_time = $row['start_time'];
        $dt1 = new DateTime($start_time);
        $now = new DateTime(date('Y-m-d H:i:s'));
        $row['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
        $row['start_time'] = $dt1->format($config_cls->getKey('general_date_format'));
        //CHECK PRICE
        $row['reserve_price'] = PT_getValueByCode($row['property_id'], 'reserve');
        $row['check_price'] = $row['price'] >= $row['reserve_price'] && $row['reserve_price'] > 0 ? true : false;
        $row['check_start'] = $row['price'] == $row['start_price'] ? true : false;
        $row['isBlock'] = PE_isTheBlock($row['property_id']) ? 1 : 0;
        $row['ofAgent'] = PE_isTheBlock($row['property_id'], 'agent') ? 1 : 0;
        $row['pro_type_code'] = $row['auctionsale_code'];
        if ($row['auction_sale'] != $auction_sale_ar['private_sale']) {//AUCTION
            if ($dt1 > $now) {//FORTHCOMING
                $row['title'] = $row['isBlock'] == 1 ? /* 'OWNER: '. */
                    $row['owner'] : 'AUCTION STARTS: ' . $row['start_time'];
                $row['remain_time'] = (int)remainTime($start_time);
                $row['pro_type'] = 'forthcoming';
                $reserve_price = PT_getValueByCode($row['property_id'], 'reserve');
                $row['price'] = $row['price_on_application'] > 0 ? '<span>Price On Application</span>' : '<div style="float:left;margin-left:10px;font-size:12px;">From<span>: ' . showLowPrice($reserve_price) . '</span></div><div style="float:left;clear:both;margin-left:10px;font-size:12px;*margin-left: 10px;*float: none;*text-align: left;">To<span style="margin-left:15px;">: ' . showHighPrice($reserve_price) . '</span></div>';
                if (in_array($row['auction_sale'], array($auction_sale_ar['ebiddar'], $auction_sale_ar['bid2stay']))) {
                    $row['price'] = $row['price_on_application'] > 0 ? '<span>Price On Application</span>' : 'Starting at ' . showPrice($row['start_price']);
                }
            } else {
                if ($row['isBlock'] == 1)
                    $row['title'] = /* 'OWNER: '. */
                        $row['owner'];
                else
                    $row['title'] = strtoupper($row['auctionsale_code']) . 'S ENDS: ' . $row['end_time'];
                $row['title'] = '';
                $row['pro_type'] = 'auction';
                $row['price'] = showPrice($row['price']);
                $row['bidder'] = Bid_getShortNameLastBidder($row['property_id']);
                $row['remain_time'] = (int)remainTime($end_time);
                //COUNTDOWN FOR LIVE
                if ($row['confirm_sold'] == 1) {
                    $row['count'] = 'Sold';
                } else {
                    if ($row['remain_time'] <= $count['once'] and $row['remain_time'] > $count['twice']) {
                        $row['count'] = 'Going once';
                    } elseif ($row['remain_time'] <= $count['twice'] and $row['remain_time'] > $count['third']) {
                        $row['count'] = 'Going twice';
                    } elseif ($row['remain_time'] <= $count['third'] and $row['stop_bid'] != 1) {
                        $row['count'] = 'Third and final call';
                    } else {
                        $row['count'] = '';
                    }
                }
                if (PE_isTheBlock($row['property_id'])) {
                    $row['count'] = $row['set_count'];
                }
            }
        } else {
            $row['pro_type'] = 'sale';
            $row['title'] = 'FOR SALE: ' . $row['suburb'];
            $row['price'] = $row['price_on_application'] == 1 ? 'Price On Application' : showPrice($row['price']);
        }
        $row['livability_rating_mark'] = showStar($row['livability_rating_mark']);
        $row['green_rating_mark'] = showStar($row['green_rating_mark']);
        //$row['detail_link'] = ROOTURL.'?module=property&action=view-'.$_type[1].'-detail&id='.$row['property_id'];
        $row['detail_link'] = shortUrl(array('module' => 'property', 'action' => 'view-' . $_type[1] . '-detail', 'id' => $row['property_id']) + array('data' => $row), (PE_isTheBlock($row['property_id'], 'agent') ? Agent_getAgent($row['property_id']) : array()));
        //BEGIN MEDIA
        global $property_media_cls, $media_cls;
        $mobileBrowser = detectBrowserMobile();
        $_media = PM_getPhoto($row['property_id'], true);
        $row['photo_default'] = $_media['photo_thumb_default'];
        if ($mobileBrowser) {
            $media_row = $property_media_cls->getRow('SELECT med.media_id,
														 med.file_name
												  FROM ' . $media_cls->getTable() . ' AS med,' . $property_media_cls->getTable() . " AS pro_med
												  WHERE med.media_id = pro_med.media_id
														AND med.type = 'photo'
														AND pro_med.property_id = " . $row['property_id'] . '
												  ORDER BY pro_med.default DESC', true);
            if ($property_media_cls->hasError()) {
            } elseif (is_array($media_row) and count($media_row) > 0) {
                $row['photo_default'] = trim($media_row['file_name'], '/');
                $file_name = basename($row['photo_default']);
                $ar = explode('/', $row['photo_default']);
                unset($ar[count($ar) - 1]);
                $dir_rel = implode('/', $ar);
                $row['photo_default'] = $dir_rel . '/' . $file_name;
                //print_r($row['photo_default']);
            }
            /*if (!is_file($row['photo_default'])) {
                $row['photo_default'] = $_media['photo_thumb_default'];
            }*/
        }
        //END
        $row['ebidda_watermark'] = PE_getEbiddaWatermark($row['property_id']);
        //CALC REMAIN TIME
        $row['o4i'] = Calendar_createPopup($row['property_id'], $row['open_for_inspection']);
        $row['awl'] = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=" . $row['property_id'] . "')";
        if ($row['carport_value'] == null AND $row['parking'] == 1) {
            $row['carport_value'] = $row['carspace_value'];
        }
        //RE-EDIT ADDRESS
        $row['isSold'] = $row['confirm_sold'] == 1 && $row['stop_bid'] == 0;
        $row['isRent'] = PE_isAuction($row['property_id'], 'ebiddar') || PE_isAuction($row['property_id'], 'bid2stay') ? true : false;
        $row['address_full'] = $row['address'] . ', ' . $row['suburb'] . ', ' . $row['state_name'] . ', ' . $row['postcode'];
        $row['address_short'] = strlen($row['address_full']) > 30 ? substr($row['address_full'], 0, 27) . ' ...' : $row['address_full'];
        //$row['title'] = '';
        $auction_option = PEO_getOptionById($row['auction_sale']);
        $row['auction_title'] = strtoupper($auction_option['title']);
        if ($row['ofAgent']) {
            $row['agent'] = A_getCompanyInfo($row['property_id']);
        }
        $auction_data[] = $row;
    }
    //print_r($auction_data);
    if (count($auction_data) % 3 == 0) {
        $count = count($auction_data);
    } else {
        if (count($auction_data) < 3) {
            $count = count($auction_data);
        } else {
            $count = 3;
        }
    }
    $auction_ = array();
    for ($i = 0; $i < $count; $i++) {
        $auction_[] = $auction_data[$i];
    }
    $smarty->assign('auction_data', $auction_);
    //$smarty->assign('title_bar',$property_title_bar);
    $smarty->assign('view_all_link', $view_all_link);
    $smarty->assign('ROOTPATH', ROOTPATH);
    $smarty->assign('action', $type);
    $link_target = strlen(getParam('link_target')) > 0 ? 'target="' . getParam('link_target') . '"' : '';
    $smarty->assign('link_target', $link_target);
    $result = array();
    $mobileBrowser = detectBrowserMobile();
    $platform = $mobileBrowser ? 'mobile/' : '';
    $result['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/' . $platform . 'property.home.grid.tpl');
    //$result['container'] = $container;
    return $result['data'];
}

/* * property_history
 * @return array
 */
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}
function __property_history()
{
    global $property_history_cls, $property_cls, $config_cls;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $rows = $property_cls->getRows('SELECT *
										FROM ' . $property_cls->getTable('property_transition_history') . ' AS pro_his
                                        WHERE pro_his.property_id=' . $property_id, true);
        $i = 0;
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $i = $i + 1;
                $arrow_next = '';
                $arrow_prev = '';
                $data_temp = array();
                /* if($row['auction_sale']==9){
                  $data_temp['title']='AUCTION';
                  }
                  else
                  {
                  $data_temp['title']='FOR SALE';
                  } */
                $data_temp['title'] = PEO_getTitleOfAuctionSale($row['auction_sale'], $property_id);
                $dt = new DateTime($row['end_time']);
                $data_temp['end_time'] = $dt->format($config_cls->getKey('general_date_format'));
                $dt = new DateTime($row['start_time']);
                $data_temp['start_time'] = $dt->format($config_cls->getKey('general_date_format'));
                $dt = new DateTime($row['transition_time']);
                $data_temp['transition_time'] = $dt->format($config_cls->getKey('general_date_format'));
                $data_temp['reserve_price'] = showPrice($row['reserve_price']);
                $data_temp['bid_price'] = showPrice($row['bid_price']);
                $data_temp['start_price'] = showPrice($row['start_price']);
                $data_temp['last_bidder'] = $row['last_bidder'];
                //FOR TEMPLATE
                if ($i > 1 && $i < count($rows)) {
                    //$arrow_next='<div class="arrow_history_pro" style="float: left;"></div> ';
                    $arrow_next = '<div class="img-next"><img src="modules/general/templates/images/next_blue.png"/></div>';
                    $arrow_prev = '<div class="img-next"><img src="modules/general/templates/images/next_blue.png"/></div>';
                }
                if (count($rows) == 2) {
                    if ($i == 1) {
                        $arrow_prev = '';
                    }
                }
                /* $data['data'].=$arrow_prev.'<div class="detail-info-box" style="width: 220px; height: 200px;float: left;">
                  <div class="detail-info-history"  style="">
                  <div class="title-history"><span class="title-his"> '.$data_temp['title'].' </span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> End time: </span><span class="f-right">'.$data_temp['end_time'].' </span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Start time: </span><span class="f-right"> '.$data_temp['start_time'].' </span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Switch time: </span><span class="f-right">'.$data_temp['transition_time'].'</span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Bid price: </span><span class="f-right">'.$data_temp['bid_price'].' </span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Start price: </span><span class="f-right">'.$data_temp['start_price'].' </span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Reserve price:</span><span class="f-right"> '.$data_temp['reserve_price'].'</span></div>
                  <div class="clearthis"></div>
                  <div class="text"><span class="f-left"> Last Bidder:</span><span class="f-right"> '.$data_temp['last_bidder'].' </span></div>
                  <div class="clearthis"></div>
                  </div>
                  </div>'.$arrow_next; */
                $data['data'] .= $arrow_prev . '<div class="detail-info-box detail-info-history">
                        <div class="title-history"><span class="title-his"> ' . $data_temp['title'] . ' </span></div>
                        <table>
                            <tr><td>End time </td><td>' . $data_temp['end_time'] . '</td></tr>
                            <tr><td>Start time </td><td>' . $data_temp['start_time'] . '</td></tr>
                            <tr><td>Switch time </td><td>' . $data_temp['transition_time'] . '</td></tr>
                            <tr><td>Bid price </td><td>' . $data_temp['bid_price'] . ' </td></tr>
                            <tr><td>Start price </td><td>' . $data_temp['start_price'] . '</td></tr>
                            <tr><td>Reserve price </td><td>' . $data_temp['reserve_price'] . '</td></tr>
                            <tr><td>Last Bidder </td><td>' . $data_temp['last_bidder'] . ' </td></tr>
                        </table>
                </div>' . $arrow_next;
            }
        }
    }
    return $data;
}

/**
 * @ function : __vmMediaPhotosAction
 * @ argument : void
 * @ output : array
 * ----------------
 * view more for Media
 * */
function __vmMediaPhotosAction()
{
    global $media_cls, $property_media_cls, $smarty;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $rows = $media_cls->getRows('SELECT m.*
							FROM ' . $media_cls->getTable() . ' AS m,' . $property_media_cls->getTable() . ' AS pm
							WHERE m.media_id = pm.media_id AND pm.property_id = ' . $property_id, true);
        $info = array('photo' => array());
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                if ($row['type'] == 'photo') {
                    $file_ar = explode('/', $row['file_name']);
                    $file_name = $file_ar[count($file_ar) - 1];
                    $file_ar[count($file_ar) - 1] = 'overlay_' . $file_name;
                    $row['overlay_file_name'] = $row['file_name'] = '/' . trim($row['file_name'], '/');
                    if (file_exists(ROOTPATH . '/' . trim(implode('/', $file_ar), '/'))) {
                        $row['overlay_file_name'] = '/' . trim(implode('/', $file_ar), '/');
                    }
                    $thumb_ar = getThumbFromOriginal($row['file_name']);
                    if (is_array($thumb_ar) && file_exists(ROOTPATH . '/' . trim($thumb_ar['file_thumb_path'], '/'))) {
                        $row['file_name'] = $thumb_ar['file_thumb_path'];
                    }
                    //$file_ar[count($file_ar)-1] = 'thumbs';
                    //$file_path = ROOTURL.'/'.trim(implode('/',$file_ar).'/'.$file_name,'/');
                    $info['photo'][] = $row;
                }
            }
        }
        $smarty->assign('info', $info);
    }
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.media_photos.tpl');
    return $data;
}

/**
 * @ function : __vmMediaVideosAction
 * @ argument : void
 * @ output : array
 * ----------------
 * view more for Media
 * */
function __vmMediaVideosAction()
{
    global $media_cls, $property_media_cls, $smarty;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $rows = $media_cls->getRows('SELECT m.*
							FROM ' . $media_cls->getTable() . ' AS m,' . $property_media_cls->getTable() . ' AS pm
							WHERE m.media_id = pm.media_id AND pm.property_id = ' . $property_id, true);
        $info = array('video' => array());
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                if ($row['type'] == 'video') {
                    $row['file_name'] = ROOTURL . '/' . trim($row['file_name'], '/');
                    $info['video'][] = $row;
                }
            }
        }
        $smarty->assign('info', $info);
    }
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.media_videos.tpl');
    return $data;
}

/**
 * @ function : __vmMediaYTAction
 * @ argument : void
 * @ output : array
 * ----------------
 * view more for Media
 * */
function __vmMediaYTAction()
{
    global $media_cls, $property_media_cls, $smarty;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $rows = $media_cls->getRows('SELECT m.*
							FROM ' . $media_cls->getTable() . ' AS m,' . $property_media_cls->getTable() . ' AS pm
							WHERE m.media_id = pm.media_id AND m.type = \'video-youtube\' AND pm.property_id = ' . $property_id, true);
        $info = array('video' => array());
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $row['file_name'] = $row['file_name'];
                $info['video'][] = $row;
            }
        }
        $smarty->assign('info', $info);
    }
    $smarty->assign('is_yt', true);
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.media_videos.tpl');
    return $data;
}

/**
 * @ function : __vmDocAction
 * @ argument : void
 * @ output : array
 * -----------------
 * view more for Doc
 * */
function __vmDocAction()
{
    global $document_cls, $property_document_cls, $smarty;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        /* $rows = $document_cls->getRows('SELECT d.document_id, pd.property_id, d.title, pd.file_name
          FROM '.$document_cls->getTable().' AS d,'.$property_document_cls->getTable().' AS pd
          WHERE d.document_id = pd.document_id AND pd.property_id = '.$property_id.'
          ORDER BY d.order ASC', true);
          $info = array();
          if (is_array($rows) && count($rows) > 0) {
          $info = $rows;
          } */
        $info = PD_getDocs($property_id);
        $smarty->assign('info', $info);
    }
    $smarty->assign('agent_id', (int)$_SESSION['agent']['id']);
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.doc.tpl');
    return $data;
}

/**
 * @ function : __vmDescriptionAction
 * @ argument : void
 * @ output : array
 * */
function __vmDescriptionAction()
{
    global $document_cls, $property_document_cls, $smarty, $property_cls;
    $property_id = (int)getParam('property_id', 0);
    $data = array();
    $auction_sale_ar = PEO_getAuctionSale();
    $row = $property_cls->getRow('SELECT pro.property_id,
									   pro.description FROM ' . $property_cls->getTable() . ' AS pro
							WHERE  IF(pro.hide_for_live = 1 AND pro.start_time > \'' . date('Y-m-d H:i:s') . '\', 0, 1) = 1
									AND pro.pay_status = ' . Property::CAN_SHOW . '
									AND pro.active = 1
									AND pro.agent_active = 1
                                    AND pro.property_id = ' . $property_id . '
							ORDER BY pro.property_id ASC', true);
    if ($property_cls->hasError()) {
    } else if (is_array($row) and count($row) > 0) {
        $data = $row;
    }
    $smarty->assign('data', $data);
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.description.tpl');
    return $data;
}

/**
 * @ function : __vnRatingAction
 * @ argument : void
 * @ output : array
 * ---------------------
 * view more for Rating
 * */
function __vmRatingAction()
{
    global $rating_cls, $smarty, $property_rating_cls;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $info = array('livability' => array(), 'green' => array());
        //BEGIN
        $items = array();
        $rows = $rating_cls->getRows('SELECT r.rating_id, r.value, r.title, r.parent_id
								FROM ' . $rating_cls->getTable() . ' AS r,' . $property_rating_cls->getTable() . ' AS pr
								WHERE r.rating_id = pr.rating_id AND pr.property_id = ' . $property_id, true);
        //print_r($rating_cls->sql);
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $row) {
                //$items[$row['parent_id']] = $row['value'];
                $items[$row['parent_id']] = $row['title'];
            }
        }
        //END
        //BEGIN
        $livability_ratings = $rating_cls->getCRows(array('title', 'rating_id'), "parent_id = (SELECT b.rating_id FROM " . $rating_cls->getTable() . " AS b WHERE b.code='livability_rating')");
        if (is_array($livability_ratings) and count($livability_ratings) > 0) {
            foreach ($livability_ratings as $row) {
                $info['livability'][] = array('title' => $row['title'], 'value' => $items[$row['rating_id']]);
            }
        }
        //END
        //BEGIN
        $green_ratings = $rating_cls->getCRows(array('title', 'rating_id'), "parent_id = (SELECT b.rating_id FROM " . $rating_cls->getTable() . " AS b WHERE b.code = 'green_rating')");
        if (is_array($green_ratings) and count($green_ratings) > 0) {
            foreach ($green_ratings as $row) {
                $info['green'][] = array('title' => $row['title'], 'value' => $items[$row['rating_id']]);
            }
        }
        //END
        //BEGIN MARK
        $info['livability_mark'] = showStar(PRM_getRatingMark('livability_rating', $property_id));
        $info['green_mark'] = showStar(PRM_getRatingMark('green_rating', $property_id));
        //END
        $smarty->assign('info', $info);
    }
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.rating.tpl');
    return $data;
}

/**
 * @ function: __vmTermAction
 * @ argument : void
 * @ output : array
 * -------------------
 * view more for term
 * */
function __vmTermAction()
{
    global $property_term_cls, $auction_term_cls, $smarty, $config_cls;
    $property_id = getParam('property_id', 0);
    $data = array();
    if ($property_id > 0) {
        $info = array();
        $items = array();
        $rows = $property_term_cls->getCRows(array('auction_term_parent_id', 'value'), 'property_id = ' . $property_id);
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $items[$row['auction_term_parent_id']] = $row['value'];
            }
        }
        $rows = $auction_term_cls->getCRows(array('title', 'code', 'auction_term_id'), "code IN ('deposit_required','settlement_period','schedule','contract_and_deposit_timeframe')");
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $row['rules'] = '';
                if ($row['code'] == 'schedule') {
                    $rules_id = @$items[$row['auction_term_id']] == '' ? 1 : (int)@$items[$row['auction_term_id']];
                    $rules = $config_cls->getKey('schedule_rules_' . $rules_id);
                    $row['rules'] = $rules;
                }
                $info[] = array('title' => $row['title'], 'code' => $row['code'], 'value' => $items[$row['auction_term_id']], 'rules' => $row['rules']);
            }
        }
        $smarty->assign('info', $info);
    }
    $data['data'] = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.viewmore.term.tpl');
    return $data;
}

/**
 * @ function : __searchAction
 * @ argument : void
 * @ output : array
 * */
function __searchAction()
{
    global $property_cls, $region_cls, $agent_cls;
    $data = array();
    $region = getPost('region');
    //print_r($region);
    //$type = restrictArgs(getQuery('type'),'[^a-zA-Z0-9]');
    $type = getQuery('type');
    $auction_sale_ar = PEO_getAuctionSale();
    if ($type == 'address') {
        $rows = $property_cls->getRows("SELECT pro.address
						FROM " . $property_cls->getTable() . " AS pro
						WHERE pro.address LIKE '%" . $property_cls->escape($region) . "%'
								AND pro.agent_active = 1
								AND pro.active = 1", true);
    } else if ($type == 'suburb1') {
        $rows = $property_cls->getRows("SELECT DISTINCT suburb
						 FROM " . $property_cls->getTable('code') . " WHERE suburb LIKE '" . $property_cls->escape($region) . "%'
						 LIMIT 0,30", true);
    } else if ($type == 'suburb') {
        $rows = $property_cls->getRows("SELECT *
						 FROM " . $property_cls->getTable('code') . " WHERE suburb LIKE '" . $property_cls->escape($region) . "%'
						 LIMIT 0,30", true);
    } else if ($type == 'region') {
        $rows = $property_cls->getRow("SELECT DISTINCT region_id
						 FROM " . $property_cls->getTable('regions') . " WHERE code = '" . $property_cls->escape($region) . "'", true);
    } else if (in_array($type, array('agent', 'partner', '_agent'))) {
        $wh_str = '';
        switch ($type) {
            case 'partner':
                $wh_str = "(SELECT agt.title
                           FROM " . $agent_cls->getTable('agent_type') . " AS agt
                           WHERE agt.agent_type_id = a.type_id
                           ) = 'partner'";
                break;
            case 'agent':
                $wh_str = "(SELECT agt.title
                           FROM " . $agent_cls->getTable('agent_type') . " AS agt
                           WHERE agt.agent_type_id = a.type_id
                           ) <> 'partner'";
                break;
            case '_agent':
                $wh_str = " is_active = 1 AND (SELECT agt.active
                           FROM " . $agent_cls->getTable('agent_type') . " AS agt
                           WHERE agt.agent_type_id = a.type_id
                           ) = 1";
                break;
        }
        $rows = $agent_cls->getRows("SELECT a.agent_id, a.firstname, a.lastname, a.is_active, a.email_address
						             FROM " . $agent_cls->getTable() . " AS a
						            WHERE (a.firstname LIKE '" . $property_cls->escape($region) . "%'
                                           OR a.lastname LIKE '" . $property_cls->escape($region) . "%'
                                           OR a.email_address LIKE '" . $property_cls->escape($region) . "%')

                                    AND " . $wh_str, true);
    } else {
        $rows = $property_cls->getRows("SELECT DISTINCT pro.postcode, pro.suburb,
							(SELECT reg.name FROM " . $region_cls->getTable() . " AS reg WHERE reg.region_id = pro.state) AS state_name,
							(SELECT reg.code FROM " . $region_cls->getTable() . " AS reg WHERE reg.region_id = pro.state) AS state_code
						FROM " . $property_cls->getTable() . " AS pro
						WHERE concat_ws(' ',pro.suburb,
										(SELECT reg_s1.code
											FROM " . $region_cls->getTable() . " AS reg_s1
											WHERE reg_s1.region_id = pro.state),
										pro.postcode ) LIKE '%" . $property_cls->escape($region) . "%'
								AND pro.agent_active = 1
								AND pro.active = 1
								AND IF(pro.hide_for_live = 1 AND pro.start_time < now(), 0, 1) = 1
								AND pro.pay_status = " . Property::CAN_SHOW, true);
    }
    if ($property_cls->hasError() || $agent_cls->hasError()) {
    } else if (is_array($rows) and count($rows)) {
        if ($type == 'region') {
            $data[] = $rows['region_id'];
        } else {
            foreach ($rows as $row) {
                if ($type == 'address') {
                    $data[] = $row['address'];
                } else if ($type == 'suburb') {
                    $data[] = $row['suburb'] . ' ' . $row['state'] . ' ' . $row['pcode'];
                } else if ($type == 'suburb1') {
                    $data[] = $row['suburb'];
                } else if (in_array($type, array('agent', 'partner', '_agent'))) {
                    $data[] = array('full_name' => $row['firstname'] . ' ' . $row['lastname'],
                        'agent_id' => $row['agent_id'],
                        'status' => $row['is_active'],
                        'email_address' => $row['email_address']);
                } else if (trim($row['suburb'] . ' ' . $row['state_code'] . ' ' . $row['postcode']) != trim($region)) {
                    $data[] = $row['suburb'] . ' ' . $row['state_code'] . ' ' . $row['postcode'];
                }
            }
        }
    }
    return $data;
}

/**
 * @ function : __contactAction
 * @ argument : void
 * @ output : array
 * */
function __contactAction()
{
    global $agent_cls, $message_cls, $property_cls, $banner_cls, $smarty, $log_cls;
    $agent_id_from = (int)restrictArgs(getPost('agent_id_from', 0));
    $name = getPost('contactname');
    $subject = getPost('subject');
    $email_from = getPost('email');
    $telephone = getPost('telephone');
    $message = getPost('message');
    $property_id = getPost('property_id');
    $agent_id_to = (int)restrictArgs(getPost('agent_id_to', 0));
    $email_to = getPost('email_to');
    $result['error'] = 'Error when sending data.';
    if (!checkEmail($email_from) or (strlen(trim($name)) * strlen(trim($subject)) * strlen(trim($message))) == 0) {
        $result['error'] = 'Error when sending data.';
    } else {
        $row = $agent_cls->getCRow(array('email_address'), 'agent_id = ' . $agent_id_to);
        if ($agent_cls->hasError()) {
            $result['error'] = 'Error when sending data.';
        } elseif ((is_array($row) and count($row) > 0) or checkEmail($email_to)) {
            if (!checkEmail($email_to)) {
                $email_to = $row['email_address'];
            }
            $lkB = getBannerByAgentId($agent_id_to);
            $smarty->assign(array('name' => $name, 'email' => $email_from, 'telephone' => $telephone, 'message' => $message));
            $content = $smarty->fetch(ROOTPATH . '/modules/email_template/templates/contact-vendor.tpl');
            sendEmail_func($email_from, $email_to, $content, $subject, $lkB);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('contact_vendor');
            $data = array('agent_id_from' => $agent_id_from,
                'email_from' => $message_cls->escape($email_from),
                'agent_id_to' => $agent_id_to,
                'email_to' => $email_to,
                'title' => $message_cls->escape($subject),
                'content' => $message_cls->escape($message),
                'send_date' => date('Y-m-d H:i:s'));
            $message_cls->insert($data);
            $result = array('success' => $message);
            StaticsReport('contact_vendor');
        }
    }
    return $result;
}

/**
 * @ function:__check_offer;
 * */
function __checkofferAction()
{
    global $property_cls, $bids_stop_cls, $payment_store_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    //$agent_id = (int)getParam('agent_id');
    $auction_sale_ar = PEO_getAuctionSale();
    $agent_id = $_SESSION['agent']['id'];
    $result = array('success' => false, 'error' => 'error', 'property_id' => $property_id);
    if ($property_id > 0) {
        if (!isset($agent_id) or $agent_id <= 0) {
            //$result['error'] = 'Login to use that feature !';
            $result['error'] = 'login';
            return $result;
        }
        $row = $property_cls->getCRow(array('confirm_sold', 'agent_id', 'stop_bid'), 'property_id=' . $property_id);
        if (is_array($row) && count($row) > 0) {
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                $result['error'] = 'This property had been sold';
                return $result;
            }
            if ((int)$row['agent_id'] == $agent_id) {
                $result['error'] = 'You can not make an offer for your property';
                return $result;
            }
            if (PE_isTheBlock($property_id) && $row['stop_bid'] == 0) {
                $result['error'] = 'You can not make an offer for The Block\' s property.';
                return $result;
            }
            if (!bid_first_isvalid($property_id, $agent_id)/* && PABasic_getPrice(array('bid')) > 0*/) {
                $_SESSION['item_number'] = $property_id;
                if (AI_infoNull($agent_id)) {
                    $result['error'] = '<div>This is the first time you have placed a bid or made an offer on bidRhino. We need your full information before you can proceed. <br/>Please  <a style="color:#2f2f2f;font-size: 14px;" href="' . ROOTURL . '/?module=agent&action=add-info' . '"> <b>Click Here</b> </a> to complete. Thank you !</div>';
                } else {
                    $result['term'] = 1;
                    $result['error'] = 1;
                }
                return $result;
            } else {
                $bid_row = $payment_store_cls->getCRow(array('is_disable', 'allow'), 'property_id = ' . $property_id . ' AND agent_id = ' . $agent_id . ' AND (bid = 1 OR offer = 1)');
                if (is_array($bid_row) and count($bid_row) > 0) {
                    if ($bid_row['allow'] == 0) {
                        $result['error'] = 'Your registration is still pending approval by the vendor, please await notification that you have been approved as a bidder before making an offer or placing a bid!';
                        return $result;
                    }
                    if ($bid_row['is_disable'] == 1) {
                        $result['error'] = 'You have been restricted bidding/offering. Please contact vendor/agent to be able to continue bid/offer. Thank you !';
                        return $result;
                    }
                }
                //no-more-bids:NHUNG
                $stop = $bids_stop_cls->getRow('SELECT stop_id
                                                   FROM ' . $bids_stop_cls->getTable() . '
                                                   WHERE property_id = ' . $property_id . ' AND agent_id = ' . $agent_id, true);
                if (is_array($stop) and count($stop) > 0) {
                    $result['error'] = 'You had registered no more bids.';
                    return $result;
                }
                //end
            }
            //end
            $result['success'] = true;
            return $result;
        }
    }
    return $result;
}

/**
 * @ function:__check_property;
 * */
function __checkpropertyAction()
{
    global $property_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $result = array('success' => false, 'property_id' => $property_id);
    if ($property_id > 0) {
        $row = $property_cls->getCRow(array('stop_bid', 'confirm_sold'), 'property_id=' . $property_id);
        if (is_array($row) && count($row) > 0) {
            $result['stop_bid'] = (int)$row['stop_bid'];
            $result['confirm_sold'] = (int)$row['confirm_sold'];
            $result['success'] = true;
            return $result;
        }
    }
    return $result;
}

/**
 * @ function:__listCopyPropertyAction;
 * */
function __listCopyPropertyAction()
{
    global $property_cls, $smarty;
    $result = array('success' => false, 'message' => '', 'html' => '');
    $agent_id = $_SESSION['agent']['id'];
    $properties = array();
    try {
        if ($agent_id > 0) {
            $rows = $property_cls->getRows('agent_id=' . $agent_id);
            if (is_array($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    $row['address'] = PE_getAddressProperty($row['property_id']);
                    $row['auction_type_label'] = PE_isRentProperty($row['property_id']) ? 'Rental Auction' : 'Property Auction';
                    $row['kind_label'] = PEO_getKindName($row['kind']);
                    $row['show_price'] = showPrice($row['price']);
                    $properties[] = $row;
                }
                $smarty->assign('properties', $properties);
                $result['html'] = $smarty->fetch(ROOTPATH . '/modules/agent/templates/agent.property.copy_listing_popup.tpl');
            } else {
                $result['html'] = 'You don\'t have any property.';
            }
            $result['success'] = true;
            return $result;
        }
    } catch (Exception $er) {
        $result['message'] = $er->getMessage();
    }
    return $result;
}

/**
 * @ function:__copyNewPropertyAction;
 * */
function __copyNewPropertyAction()
{
    global $property_cls, $smarty;
    $result = array('success' => false, 'message' => '');
    $agent_id = $_SESSION['agent']['id'];
    $property_id = (int)restrictArgs(getParam('property_copy_id', 0));
    try {
        if ($property_id > 0) {
            $new_property_id = NewPropertyFromPropertyId($property_id, $agent_id);
            if ($new_property_id > 0) {
                $result['success'] = true;
                $result['message'] = 'A new property ID#' . $new_property_id . ' has been created. Please wait 3s to update new property detail.<br/>';
                $result['link'] = ROOTURL . '/?module=property&action=register&step=2&id=' . $new_property_id;
                return $result;
            }
        } else {
            $result['success'] = true;
            $result['message'] = 'Please select a property to copy as new.';
        }
    } catch (Exception $er) {
        $result['message'] = $er->getMessage();
    }
    return $result;
}

/**
 * function : insertContent
 * */
function insertContent($con = '', $pro_id, $addr, $offer_price, $sending = 'agent')
{
    $offer_price = showPrice($offer_price);
    $message = $con;
    if ($pro_id > 0) {
        $link_approve = '<a href="' . ROOTURL . '/?module=agent&action=view-property_offers">' . ROOTURL . '/?module=agent&action=view-property_offers</a>';
        if ($sending == 'agent') {
            $message = '
            <table style="width: 100%;font-size: 12px">
                <tbody>
                    <tr><td><span style="text-decoration: underline">Property ID:</span></td><td>' . $pro_id . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Property Address:</span></td><td>' . $addr . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Offer Price:</span></td><td>' . $offer_price . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Content:</span></td><td>' . $con . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Approve:</span></td><td>' . $link_approve . '</td></tr>
                    <tr><td colspan="2"><br/><br/><span>The above offer has been submitted for your review. You need to accept or reject this offer once the Agent/Vendor have reviewed this offer.
                     Please click the link above or log in to bidRhino.com and go to your "Property Offers" page to action the approval or rejection this offer. <br/></span></td></tr>
                </tbody>
            </table>';
        } else { // Buyer
            $message = '
            <table style="width: 100%;font-size: 12px">
                <tbody>
                    <tr><td><span style="text-decoration: underline">Property ID:</span></td><td>' . $pro_id . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Property Address:</span></td><td>' . $addr . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Offer Price:</span></td><td>' . $offer_price . '</td></tr>
                    <tr><td><span style="text-decoration: underline">Content:</span></td><td>' . $con . '</td></tr>
                    <tr><td colspan="2"><br/><br/><span>You will be notified if this has been accepted or rejected once the Agent/Vendor have reviewed your offer.<br/></span></td><td></td></tr>
                </tbody>
            </table>';
        }
    }
    return $message;
}

function insertContentSMS($con = '', $pro_id, $addr, $offer_price)
{
    $offer_price = showPrice($offer_price);
    $message = 'Property ID:' . $pro_id . '. Address:' . $addr . ', Offer price:' . $offer_price;
    return $message;
}

function __sendMailBuyNowToBuyerAction($property_id = 0, $buynow_buyer_id = 0, $price)
{
    global $config_cls, $log_cls, $smarty;
    $data = array('sent' => 0, 'property_id' => $property_id);
    //echo '$buynow_buyer_id'.$buynow_buyer_id;
    if ($property_id > 0 && $buynow_buyer_id > 0) {
        $row_vendor = PE_getVendor($property_id);
        $buyer_name = A_getFullName($buynow_buyer_id);
        $buyer_email = A_getEmail($buynow_buyer_id);
        $agent_type = AgentType_getTypeAgent($row_vendor['agent_id']);
        /* Property Information */
        $property_data = PE_getReview($row_vendor['agent_id'], $property_id, $agent_type);
        $property = $property_data['info'];
        if (count($row_vendor) > 0 and is_array($row_vendor)) {
            $subject = 'You Buy Now price has accepted with property ID#' . $property_id;
            $email_from = $config_cls->getKey('general_contact_email');
            $smarty->assign('property', $property);
            $smarty->assign('buyer_name', $buyer_name);
            $smarty->assign('contact_email', $email_from);
            $smarty->assign('price', $price);
            $content = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.email.buynow.success.tpl');
            //sendEmail_func($email_from,array($buyer_email, $config_cls->getKey('general_contact1_name')), $content, $subject);
            $params_email_buyer = array();
            $params_email_buyer['property_id'] = $property_id;
            $params_email_buyer['to'] = array($buyer_email, $config_cls->getKey('general_contact1_name'));
            $params_email_buyer['subject'] = $subject;
            $params_email_buyer['email_content'] = $content;
            $params_email_buyer['from'] = $email_from;
            sendNotificationByEventKey('user_send_buynow_accepted_buyer', $params_email_buyer);
            $subject = 'You has accepted Buy/Rent Now with property ID#' . $property_id;
            $params_email_vendor = array();
            $params_email_vendor['property_id'] = $property_id;
            $params_email_vendor['to'] = array($row_vendor['email_address'], $config_cls->getKey('general_contact1_name'));
            $params_email_vendor['subject'] = $subject;
            $params_email_vendor['email_content'] = $content;
            $params_email_vendor['from'] = $email_from;
            sendNotificationByEventKey('user_send_buynow_accepted_vendor', $params_email_vendor);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
            $data['sent'] = 1;
        }
    }
    return $data;
}

function __sendMailBuyNowCancelToBuyerAction($property_id = 0, $buynow_buyer_id = 0, $price)
{
    global $config_cls, $log_cls, $smarty;
    $data = array('sent' => 0, 'property_id' => $property_id);
    //echo '$buynow_buyer_id'.$buynow_buyer_id;
    if ($property_id > 0 && $buynow_buyer_id > 0) {
        $row_vendor = PE_getVendor($property_id);
        $buyer_name = A_getFullName($buynow_buyer_id);
        $buyer_email = A_getEmail($buynow_buyer_id);
        $agent_type = AgentType_getTypeAgent($row_vendor['agent_id']);
        /* Property Information */
        $property_data = PE_getReview($row_vendor['agent_id'], $property_id, $agent_type);
        $property = $property_data['info'];
        if (count($row_vendor) > 0 and is_array($row_vendor)) {
            $subject = 'You Buy Now price has canceled with property ID#' . $property_id;
            $email_from = $config_cls->getKey('general_contact_email');
            $smarty->assign('property', $property);
            $smarty->assign('buyer_name', $buyer_name);
            $smarty->assign('contact_email', $email_from);
            $smarty->assign('price', $price);
            $content = $smarty->fetch(ROOTPATH . '/modules/property/templates/property.email.buynow.cancel.tpl');
            //sendEmail_func($email_from,array($buyer_email, $config_cls->getKey('general_contact1_name')) , $content, $subject);
            $params_email_buyer = array();
            $params_email_buyer['property_id'] = $property_id;
            $params_email_buyer['to'] = array($buyer_email, $config_cls->getKey('general_contact1_name'));
            $params_email_buyer['subject'] = $subject;
            $params_email_buyer['email_content'] = $content;
            $params_email_buyer['from'] = $email_from;
            sendNotificationByEventKey('user_send_buynow_canceled_buyer', $params_email_buyer);
            $subject = 'You has canceled Buy/Rent Now with property ID#' . $property_id;
            $params_email_vendor = array();
            $params_email_vendor['property_id'] = $property_id;
            $params_email_vendor['to'] = array($row_vendor['email_address'], $config_cls->getKey('general_contact1_name'));
            $params_email_vendor['subject'] = $subject;
            $params_email_vendor['email_content'] = $content;
            $params_email_vendor['from'] = $email_from;
            sendNotificationByEventKey('user_send_buynow_canceled_vendor', $params_email_vendor);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
            $data['sent'] = 1;
        }
    }
    return $data;
}

/**
 * @ function : __sendMailwinnerAction
 * @ argument :
 * @ output : json
 * */
function __sendMailBuyNowAction($property_id = 0, $buynow_buyer_id = 0, $buynow_price = 0)
{
    global $property_cls, $config_cls, $banner_cls, $log_cls, $message_cls;
    $data = array('sent' => 0, 'property_id' => $property_id);
    if ($property_id > 0) {
        $buyer_email = A_getEmail($buynow_buyer_id);
        $isRentProperty = PE_isRentProperty($property_id);
        $row_vendor = PE_getVendor($property_id);
        $vendor_name = A_getFullName($row_vendor['agent_id']);
        $vendor_email = $row_vendor['email_address'];
        if (count($row_vendor) > 0 and is_array($row_vendor)) {
            $subject = ' A Buyer wants to ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' your property ID#' . $property_id;
            $email_from = $config_cls->getKey('general_contact_email');
            //$link_accept = ROOTURL.'/modules/property/action.php?action=buynow-accept-property&property_id='.$property_id;
            //$link_cancel = ROOTURL.'/modules/property/action.php?action=buynow-cancel-property&property_id='.$property_id;
            $link_offer = ROOTURL . '/?module=agent&action=view-property_offers';
            $content = '<label style="font-size: 16px; color: #2f2f2f;"> Dear ' . $vendor_name . ',</label>
						<p  style="font-size:14px;margin-top: 15px;color: #222222;">
							A user '.$buyer_email.' has made a Buy Now unconditional offer for your property
                            Property ID: '.$property_id.'
                            Property Address: [address] [suburb]
                            Offer Price: '.$buynow_price.'
                            <br/>
                            They have extended the following offer for your property  : '.$buynow_price.'
                            <br/>
                            You can review the offer at (link to property offers), please select and click on Accept button to process this offer.
                            PLEASE NOTE - AS A BUY NOW OFFER THIS IS A PRE AGREED ACCEPTED PRICE BY YOU AND MUST BE ACCEPTED
                            <br/>
                            When you accept this offer your property will be listed as "Under offer" until you manually set the status to sold, when you have the deposit and completed contracts .
                            <br/>
                            the user is notified automatically of your aceptance
                            <br/>
                            Please login to your account and confirm  property details and the offering users contact details.
                            <br/>
                            please contact the user to organise to complete the contract and payment of the deposit.
						</p>
						</br>
						';
            $content_sms = 'Dear ' . $vendor_name . '. bidRhino user '.$buyer_email.' has made a BUY NOW offer on [ID] [address] [suburb] The  offer is '.$buynow_price.'. You can review the offer at (link to property offers), please select and click on Accept o complete this offer and contact the user to complete the contract and deposit
                            PLEASE NOTE - AS A BUY NOW OFFER THIS IS A PRE AGREED ACCEPTED PRICE BY YOU AND MUST BE ACCEPTED.';
            //sendEmail_func($email_from,array($vendor_email,$config_cls->getKey('general_contact1_name')), $content, $subject, $lkB);
            $params_email_vendor = array();
            $params_email_vendor['property_id'] = $property_id;
            $params_email_vendor['to'] = array($vendor_email, $config_cls->getKey('general_contact1_name'));
            $params_email_vendor['subject'] = $subject;
            $params_email_vendor['email_content'] = $content;
            $params_email_vendor['from'] = $email_from;
            $params_email_vendor['send_mymessage'] = true;
            $params_email_vendor['sms_content'] = $content_sms;
            sendNotificationByEventKey('user_send_buynow_vendor', $params_email_vendor);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
            $data['sent'] = 1;
            $data = array('agent_id_from' => $buynow_buyer_id,
                'email_from' => A_getEmail($buynow_buyer_id),
                'agent_id_to' => $row_vendor['agent_id'],
                'email_to' => $vendor_email,
                'title' => $subject,
                'content' => $message_cls->escape($content),
                'user_content' => PE_isRentProperty($property_id) ? 'RENT NOW' : 'BUY NOW',
                'send_date' => date('Y-m-d H:i:s'),
                'entity_id' => $property_id,
                'buynow_price' => $buynow_price,
                'offer_price' => $buynow_price
            );
            $message_cls->insert($data);
        }
        // SEND Buyer
        $buyer_name = A_getFullName($buynow_buyer_id);
        $buyer_email = A_getEmail($buynow_buyer_id);
        $subject = ' You have sent a ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' with property ID#' . $property_id;
        $email_from = $config_cls->getKey('general_contact_email');
        $content = '<label style="font-size: 16px; color: #2f2f2f;"> Dear ' . $buyer_name . ',</label>
                    <p style="font-size:14px; margin-bottom: 5px; color: #222222;">
                        You have confirmed the binding unconditional Buy Now offer as per the below
                        Property ID: '.$property_id.'
                        Property Address: [address] [suburb]
                        Offer Price: '.$buynow_price.'
                        <br/>
                        You will be notified when confirmed by the sales team.
                        <br/>
                        Please login to your account and confirm  the Sales Teams contact details.
                        <br/>
                        Please contact the Sales team to organise to complete the contract and payment of the deposit.
                    </p>
                    </br>
						';
        $content_sms = 'Dear '. $buyer_name .' you have made a binding unconditional Buy Now offer on [ID] [address] [suburb] The offer is '.$buynow_price.'. You will be informed of acceptance once the sales team has reviewed. Please contact the Sales Team to organise to complete the contract and payment of the deposit.';
        //sendEmail_func($email_from, $buyer_email, $content, $subject);
        $params_email_buyer = array();
        $params_email_buyer['property_id'] = $property_id;
        $params_email_buyer['to'] = array($buyer_email, $config_cls->getKey('general_contact1_name'));
        $params_email_buyer['subject'] = $subject;
        $params_email_buyer['email_content'] = $content;
        $params_email_buyer['from'] = $email_from;
        $params_email_vendor['send_mymessage'] = true;
        //$params_email_buyer['sms_content'] = 'You have sent a ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' with property ID#' . $property_id . ' with ' . showPrice($buynow_price) . ' successful';
        $params_email_buyer['sms_content'] = $content_sms;
        sendNotificationByEventKey('user_send_buynow_buyer', $params_email_buyer);
    }
    return $data;
}

/**
 * @ function : __buynowAction
 * */
function __buynowAction()
{
    global $property_cls, $region_cls, $agent_cls, $message_cls;
    $result = array('success' => 1, 'error' => 0, 'message' => 'You can not buy now for this property.', 'hasLoggedIn' => 1);
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    if ((int)$property_id > 0) {
        $result['property_id'] = $property_id;
        if (!isset($_SESSION['agent']) || @$_SESSION['agent']['id'] == 0) {
            $result['hasLoggedIn'] = 0;
            return $result;
        }
        $isRentProperty = PE_isRentProperty($property_id);
        $agent_id = $_SESSION['agent']['id'];
        /*CHECK VALIDATE BUY NOW*/
        $row = $property_cls->getRow('SELECT pro.property_id,
											pro.address,
											pro.suburb,
											pro.postcode,
											pro.agent_id,
                                            pro.active,
                                            pro.agent_active,
                                            pro.buynow_price,
                                            pro.buynow_buyer_id,
                                            pro.confirm_sold,

											(SELECT reg1.name
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name

									FROM ' . $property_cls->getTable() . ' AS pro
									WHERE property_id = ' . $property_id, true);
        // Check
        if (is_array($row) && count($row) > 0) {
            if ($agent_id == (int)$row['agent_id']) {
                $result['error'] = 1;
                $result['message'] = 'You can not ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' for your property.';
                return $result;
            }
            $type = PE_Get_type_property($property_id);
            /*if ($type !== 'forth_auction') {
                $result['error'] = 1;
                $result['message'] = 'You can not '.($isRentProperty == true ? 'RENT NOW' : 'BUY NOW').' for this property.';
                return $result;
            }*/
            if ($row['active'] == 0 || $row['agent_active'] == 0) {
                $result['error'] = 1;
                $result['message'] = 'You can not ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' for this property.';
                return $result;
            }
            /*if (empty($row['buynow_price']) || $row['buynow_buyer_id'] > 0) {
                $result['error'] = 1;
                $result['message'] = 'You can not '.($isRentProperty == true ? 'RENT NOW' : 'BUY NOW').' for this property.';
                return $result;
            }*/
            if ($row['confirm_sold'] == Property::SOLD_COMPLETE) {
                $result['error'] = 1;
                $result['message'] = 'This property has been sold. You can not ' . ($isRentProperty == true ? 'RENT NOW' : 'BUY NOW') . ' for this property.';
                return $result;
            }
            //BEGIN PAYMENT
            //$result['payment_url'] =  ROOTURL.'?module=payment&action=option&type=buynow&item_id='.$property_id;
            //redirect(ROOTURL.'?module=payment&action=option&type=buynow&item_id='.$property_id);
            //BUYNOW PROCESS
            if ($agent_id > 0) {
                try {
                    $buynow_price = $row['buynow_price'];
                    $property_cls->update(array(
                        'buynow_buyer_id' => $agent_id,
                    ),
                        'property_id=' . $property_id);
                    $result['message'] = 'Successful.';
                    /* MAIL TO VENDOR/BUYER To ACCEPT BUY NOW OR CANCEL */
                    __sendMailBuyNowAction($property_id, $agent_id, $buynow_price);
                    return $result;
                } catch (Exception $er) {
                    $result['error'] = 1;
                    $result['message'] = $er->getMessage();
                    return $result;
                }
            }
        } else {
            $result['error'] = 1;
            $result['message'] = 'Can not find property ID#' . $property_id;
            return $result;
        }
    }
    /*if($result['error'] != 1) {
        $mail_offer = new Mail_Property($agent_id, $property_id);
        $mail_offer->SendEmailServiceProvider('Buy now');
    }*/
    return $result;
}

function __buynowCancelAction()
{
    global $property_cls, $region_cls, $agent_cls, $message_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $agent_id = (int)restrictArgs(getParam('agent_id', 0));
    if (!isset($_SESSION['agent']['id']) || (isset($_SESSION['agent']['id']) && !($_SESSION['agent']['id'] > 0))) {
        redirect(ROOTURL . '?module=agent&action=login');
    }
    $row = $property_cls->getCRow(array('agent_id'), 'property_id=' . $property_id);
    //if(is_array($row) and count($row) > 0 )
    if ($row['agent_id'] != $_SESSION['agent']['id']) {
        redirect(ROOTURL . '?module=agent&action=login');
    }
    if ((int)$property_id > 0) {
        $property_cls->update(array(
            'buynow_buyer_id' => 0,
        ),
            'property_id=' . $property_id);
        __sendMailBuyNowCancelToBuyerAction($property_id, $row['buynow_buyer_id'], $row['buynow_price']);
        redirect(ROOTURL . '?module=property&action=buynow-cancel&property_id=' . $property_id);
    } else {
        redirect(ROOTURL);
    }
}

function __buynowAcceptAction()
{
    global $property_cls, $region_cls, $agent_cls, $message_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $agent_id = (int)restrictArgs(getParam('agent_id', 0));
    if (!isset($_SESSION['agent']['id']) || (isset($_SESSION['agent']['id']) && !($_SESSION['agent']['id'] > 0))) {
        redirect(ROOTURL . '?module=agent&action=login');
    }
    $row = $property_cls->getCRow(array('agent_id'), 'property_id=' . $property_id);
    //if(is_array($row) and count($row) > 0 )
    if ($row['agent_id'] != $_SESSION['agent']['id']) {
        redirect(ROOTURL . '?module=agent&action=login');
    }
    if ((int)$property_id > 0) {
        $row = $property_cls->getRow('SELECT pro.property_id,
											pro.address,
											pro.suburb,
											pro.postcode,
											pro.agent_id,
                                            pro.active,
                                            pro.agent_active,
                                            pro.buynow_price,
                                            pro.buynow_buyer_id,

											(SELECT reg1.name
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,

											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name

									FROM ' . $property_cls->getTable() . ' AS pro
									WHERE property_id = ' . $property_id, true);
        // Check
        if (is_array($row) && count($row) > 0) {
            $agent_id = $row['agent_id'];
            $buynow_buyer_id = $row['buynow_buyer_id'];
            // STOP BIDDING AND SOLD
            $property_cls->update(array(
                'confirm_sold' => 1,
                'stop_bid' => 1,
                'sold_time' => date('Y-m-d H:i:s')),
                'property_id=' . $property_id);
            Property_afterSold($property_id);
            __sendMailBuyNowToBuyerAction($property_id, $buynow_buyer_id, $row['buynow_price']);
            try {
                $mail_offer = new Mail_Property($agent_id, $property_id);
                $mail_offer->SendEmailServiceProvider('Buy now');
            } catch (Exception $er) {
            }
        }
        redirect(ROOTURL . '?module=property&action=buynow-accept&property_id=' . $property_id);
    }
    redirect(ROOTURL);
}

/**
 * @ function : __makeAnOfferAction
 * */
function __makeAnOfferAction()
{
    global $property_cls, $region_cls, $agent_cls, $message_cls, $bid_cls, $config_cls, $banner_cls, $log_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $agent_email = getParam('agent_email');
    $agent_id = (int)getParam('agent_id');
    $content = getParam('content');
    $content = stripcslashes($content);
    $popup_id = getParam('popup_id');
    $offer_price = (float)getParam('offer_price', 0);
    $type = PE_Get_type_property($property_id);
    $output = array('error' => 'Invalid data', 'property_id' => $property_id, 'popup_id' => $popup_id);
    if ($property_id > 0) {
        $row = $property_cls->getRow('SELECT pro.property_id,
											pro.address,
											pro.suburb,
											pro.postcode,
											pro.agent_id,
	
											(SELECT reg1.name
											FROM ' . $region_cls->getTable() . ' AS reg1
											WHERE reg1.region_id = pro.state
											) AS state_name,
	
											(SELECT reg3.name
											FROM ' . $region_cls->getTable() . ' AS reg3
											WHERE reg3.region_id = pro.country
											) AS country_name

									FROM ' . $property_cls->getTable() . ' AS pro
									WHERE property_id = ' . $property_id, true);
        if ($agent_id == (int)$row['agent_id']) {
            $output['error'] = 'You can not make an offer for your property.';
            return $output;
        }
        // compare last bid price and offer_price;
        $price = PE_getBidPrice($property_id);
        if ($type == 'forth_auction') {
            $reserve_price = PT_getValueByCode($property_id, 'reserve');
            //$price = (float)($price*90)/100;
        }
        if ($type != 'sale' and $type != 'forth_auction') {
            if ($offer_price <= $price) {
                $output['error_id'] = 2;
                $output['error'] = 'Offer price is less than the current price.';
                return $output;
            }
        }
        //end
        $address = implode(', ', array(@$row['address'], @$row['suburb'], @$row['state_name'], @$row['postcode'], @$row['country_name']));
        $row = $agent_cls->getRow('SELECT a.agent_id, a.email_address
					FROM ' . $agent_cls->getTable() . ' AS a,' . $property_cls->getTable() . ' AS p
					WHERE a.agent_id = p.agent_id AND p.property_id = ' . $property_id, true);
        if (is_array($row) && count($row) > 0) {
            /*MESSAGE TO AGENT/VENDOR*/
            $subject = 'Your Offer Property ID: ' . $property_id;
            $content_mess_buyer = insertContent($content, $property_id, $address, $offer_price, 'buyers');
            $content_mess_agent = insertContent($content, $property_id, $address, $offer_price, 'agent');
            $data = array('agent_id_from' => $agent_id,
                'email_from' => $message_cls->escape($agent_email),
                'agent_id_to' => $row['agent_id'],
                'email_to' => $row['email_address'],
                'title' => $subject,
                'content' => $message_cls->escape($content_mess_agent),
                'user_content' => $message_cls->escape($content),
                'send_date' => date('Y-m-d H:i:s'),
                'offer_price' => $offer_price,
                'entity_id' => $property_id);
            StaticsReport('makeof');
            $message_cls->insert($data);
            /*SEND MAIL to Agent*/
            $from_name = $_SESSION['agent']['firstname'] . ' ' . $_SESSION['agent']['lastname'];
            //sendEmail_func($agent_email, $row['email_address'], $content_mess_agent, $subject, $lkB, $from_name);
            $params_email_vendor = array();
            $params_email_vendor['property_id'] = $property_id;
            $params_email_vendor['to'] = array($row['email_address'], $config_cls->getKey('general_contact1_name'));
            $params_email_vendor['subject'] = $subject;
            $params_email_vendor['email_content'] = $content_mess_agent;
            $params_email_vendor['from'] = $agent_email;
            $params_email_vendor['hasFromName'] = $from_name;
            $params_email_vendor['send_mymessage'] = false;
            $params_email_vendor['sms_content'] = 'You have a offer ' . insertContentSMS($content, $property_id, $address, $offer_price);;
            sendNotificationByEventKey('user_make_an_offer_vendor', $params_email_vendor);
            if ($message_cls->hasError()) {
                $output['error'] = $message_cls->getError();
            } else {
                unset($output['error']);
                /*Message For Buyer*/
                $subject = 'New Offer Property ID: ' . $property_id;
                $data = array(
                    'email_from' => $config_cls->getKey('general_contact_email'),
                    'agent_id_to' => $agent_id,
                    'email_to' => $agent_email,
                    'title' => $subject,
                    'content' => $message_cls->escape($content_mess_buyer),
                    'user_content' => $message_cls->escape($content),
                    'send_date' => date('Y-m-d H:i:s')
                );
                StaticsReport('makeof');
                $message_cls->insert($data);
                /*SEND MAIL to BUYER*/
                //sendEmail_func('',array($agent_email, $config_cls->getKey('general_contact1_name')) , $content_mess_buyer, $subject, '');
                $params_email_buyer = array();
                $params_email_buyer['property_id'] = $property_id;
                $params_email_buyer['to'] = array($agent_email, $config_cls->getKey('general_contact1_name'));
                $params_email_buyer['subject'] = $subject;
                $params_email_buyer['email_content'] = $content_mess_buyer;
                $params_email_buyer['send_mymessage'] = false;
                $params_email_buyer['sms_content'] = 'New offer ' . insertContentSMS($content, $property_id, $address, $offer_price);
                sendNotificationByEventKey('user_make_an_offer_buyer', $params_email_buyer);
                /*Logged*/
                include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                $log_cls->createLog('make_offer');
                $output['mail'] = 'sent';
                /*send email Service Provider*/
                $mail_offer = new Mail_Property($agent_id, $property_id);
                $mail_offer->SendEmailServiceProvider('Make an offer');
            }
        }
    }
    return $output;
}

/**
 * @ function : __makeAnOfferListAction
 * */
function __makeAnOfferListAction($property_id = 0, $mode = '')
{
    global $message_cls, $agent_cls, $smarty, $config_cls, $mobileFolder;
    if ($property_id == 0)
        $property_id = (int)getParam('property_id', 0);
    $check_sold = PE_getSoldStatus($property_id);
    $data = array();
    $output = $mess = $type = '';
    $pro_price = $lastBidprice = 0;
    if ($property_id > 0) {
        try {
            $type = PE_Get_type_property($property_id);
            $row_agent_from = $message_cls->getRows('SELECT  distinct msg.agent_id_from
									   FROM ' . $message_cls->getTable() . ' AS msg
									   WHERE  msg.entity_id = ' . $property_id . ' AND msg.abort = 0
									   ORDER BY msg.send_date DESC', true);
            $lastBidprice = $price = PE_getBidPrice($property_id);
            $last_agent_offer = Bid_getLastBidByPropertyId($property_id);
            if ($type == 'forth_auction') {
                $reserve_price = PT_getValueByCode($property_id, 'reserve');
                $pro_price = showLowPrice($reserve_price) . ' - ' . showHighPrice($reserve_price);
            } else {
                $pro_price = showPrice($price);
            }
            if (is_array($row_agent_from) and count($row_agent_from) > 0) {
                $reserve_price = PT_getValueByCode($property_id, 'reserve');
                foreach ($row_agent_from as $row_agent) {
                    $max_offer_price = Mess_GetMaxOfferprice_By_id($property_id, $row_agent['agent_id_from']);
                    $row = Mess_GetField_By_maxprice($property_id, $row_agent['agent_id_from'], $max_offer_price);
                    if (is_array($row) and count($row) > 0) {
                        if (($type != 'live_auction') OR ($row['offer_price'] > $price AND $type == 'live_auction')) {
                            $dt = new DateTime($row['send_date']);
                            $row['at'] = $dt->format($config_cls->getKey('general_date_format'));
                            $row['price'] = showPrice($row['offer_price']);
                            $row['reserve'] = $reserve_price;
                            $row['content'] = substr($row['content'], 0, 300) . '...';
                            $row['type'] = $type;
                            $row['property_details'] = 'Property ID: ' . $row['entity_id'] . '<br />
                                       Address: ' . PE_getAddressProperty($row['entity_id']) . '<br />
                                       Offer Price: ' . showPrice($row['offer_price']) . '<br />
                                       Message: ' . $row['user_content'];
                            $data[] = $row;
                        }
                    }
                }// End Foreach
            }
        } catch (Exception $er) {
            $mess = $er->getMessage();
        }
        if ($mode == 'accept') {
            return array('offer' => "Offer(" . count($data) . ") -", 'isSold' => $check_sold, 'property_id' => $property_id, 'num_offer' => count($data), 'price' => showPrice($lastBidprice), 'top_price' => $pro_price);
        }
        $smarty->assign('type', $type);
        $smarty->assign('pro_price', $pro_price);
        $smarty->assign('rows', $data);
        $smarty->assign('property_id', $property_id);
        $smarty->assign('check_sold', $check_sold);
        $output = $smarty->fetch(ROOTPATH . '/modules/property/templates' . $mobileFolder . 'property.make-an-offer-list.popup.tpl');
    }
    return array('data' => $output, 'property_id' => $property_id, 'offer_number' => count($data), 'message' => $mess);
    //return $data;
}

/**
 * @ function : __makeAnOfferAcceptAction
 * */
function __makeAnOfferAcceptAction()
{
    //ini_set('display_errors', 1);
    global $message_cls, $agent_cls, $property_cls, $property_term_cls, $smarty, $config_cls, $bid_cls;
    $message_id = (int)getParam('message_id', 0);
    $property_id = (int)getParam('property_id', 0);
    $agent_id = (int)getParam('agent_id', 0);
    $money = restrictArgs(getParam('money', 0));
    $type_pro = PE_Get_type_property($property_id);
    $accept = getParam('accept', '');
    if ($accept == 'link') {
        $message_row = $message_cls->getRow('message_id = ' . $message_id);
        if (is_array($message_row) && count($message_row) > 0) {
            $agent_id = $message_row['agent_id_from'];
            $money = $message_row['offer_price'];
            $agent_id_to = $message_row['agent_id_to'];
            if ($_SESSION['agent']['id'] != $agent_id_to) {
                return array('error' => 'Please login again');
            }
        }
    }
    try {
        if (!isset($_SESSION['agent']) || @$_SESSION['agent']['id'] == 0)
            throw new Exception('Please login to use this feature.');
        if ($message_id <= 0)
            throw new Exception('Message ID is undefined.');
        $reserve = PT_getValueByCode($property_id, 'reserve');
        if (strlen($money) == 0)
            throw new Exception('Amount is undefined.');
        if ($type_pro == 'live_auction') {
            $output = Bid_isValid($agent_id, $property_id, false, true);
            if ($output['error']) {
                throw new Exception($output['msg']);
            }
            if (!$property_cls->isLocked($property_id) || $property_cls->isExpire($property_id)) {
                $property_cls->lock($property_id);
                if (Bid_addByBidder($agent_id, $property_id, 0, $money, false, false, false, false, true)) {
                }
                $property_cls->unLock($property_id);
                // send Mail to Offed Agent
                $user_name = A_getFullName($agent_id);
                $agent_email = A_getEmail($agent_id);
                $text = $config_cls->getKey('email_bid_confirm_msg');
                $subject = $config_cls->getKey('email_bid_confirm_msg_subject');
                $link = '<a href="' . ROOTURL . '/?module=property&action=view-auction-detail&id=' . $property_id . '">' . ROOTURL . '?module=property&action=view-auction-detail&id=' . $property_id . '</a>';
                $text = str_replace(array('[ID]', '[username]', '[link]', '[price]'), array($property_id, $user_name, $link, showPrice($money)), $text);
                //sendEmail_func($config_cls->getKey('general_contact_email'), $agent_email, $text, $subject);
                include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
                    $log_cls = new Email_log();
                }
                $log_cls->createLog('offer_accept_bid_confirm');
                $mail_offer = new Mail_Property($agent_id, $property_id);
                $mail_offer->SendEmailServiceProvider('Offer Accepted');
                $property_cls->update(array('underoffer' => 1), 'property_id=' . $property_id);
            } else {
                throw new Exception('Please try again.');
            }
        } else if ($type_pro == 'forth_auction') {
            $output = Bid_isValid($agent_id, $property_id, true, true);
            if ($output['error']) {
                throw new Exception($output['msg']);
            }
            try {
                //$property_cls->unLock($property_id);
                //$property_cls->update(array('confirm_sold' => 1, 'stop_bid' => 1, 'scan' => 1, 'sold_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
                //$property_cls->update(array('stop_bid' => 1), 'property_id=' . $property_id);
                $property_cls->update(array('underoffer' => 1), 'property_id=' . $property_id);
                //Property_afterSold($property_id);
                //$message_cls->update(array('active_sold' => 1), 'entity_id =' . $property_id . ' AND agent_id_from = ' . $agent_id . ' AND offer_price = ' . $money);
                if (!$property_cls->isLocked($property_id) || $property_cls->isExpire($property_id)) {
                    $property_cls->lock($property_id);
                    if (Bid_addByBidder($agent_id, $property_id, 0, $money, false, false, false, false, true)) {
                    }
                }
            } catch (Exception $er) {
            }
        } else if ($type_pro == 'sale') {
            //$property_cls->update(array('price' => $money, 'confirm_sold' => 1, 'sold_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
            //Property_afterSold($property_id);
            $property_cls->update(array('underoffer' => 1), 'property_id=' . $property_id);
            //$message_cls->update(array('active_sold' => 1), 'entity_id =' . $property_id . ' AND agent_id_from = ' . $agent_id . ' AND offer_price = ' . $money);
        } elseif ($type_pro == 'stop_auction') {
            //$property_cls->update(array('confirm_sold' => 1, 'stop_bid' => 1, 'scan' => 1, 'sold_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
            //Property_afterSold($property_id);
            $property_cls->update(array('underoffer' => 1), 'property_id=' . $property_id);
            $bid_cls->insert(array('agent_id' => $agent_id, 'property_id' => $property_id, 'price' => $money, 'time' => date('Y-m-d H:i:s'), 'is_offer' => 1));
            //$message_cls->update(array('active_sold' => 1), 'entity_id =' . $property_id . ' AND agent_id_from = ' . $agent_id . ' AND offer_price = ' . $money);
        }
        /*Message was send when Accepting offer for a Property*/
        /*To Buyer*/
        $agent_email = A_getEmail($agent_id);
        $params_email = array('to' => array($agent_email, $config_cls->getKey('general_contact1_name')), 'property_id' => $property_id);
        $bank_info = PE_getBankInfo($property_id);
        $variables = array('[name]' => $bank_info['name'], '[bsb]' => $bank_info['bsb'], '[number]' => $bank_info['number']);
        $variables['[offer_price]'] = showPrice($money);
        sendNotificationByEventKey('user_accept_offer_buyer', $params_email, $variables);
        /*To Vendor*/
        $vendor = PE_getAgent(0, $property_id);
        $variables['[bidder_email_address]'] = $agent_email ;
        sendNotificationByEventKey('user_accept_offer', array('to' => $vendor['email_address'], 'property_id' => $property_id), $variables);
        /**/
        $message_cls->update(array('abort' => 2), 'entity_id =' . $property_id . ' AND agent_id_from = ' . $agent_id . ' AND message_id =' . $message_id);
    } catch (Exception $e) {
        $msg = $e->getMessage();
        return array('error' => $msg);
    }
    if ($accept == 'link') {
        return array('onMakeAnOfferAccept' => 1);
    }
    return __makeAnOfferListAction($property_id, 'accept');
}

/**
 * @ function : __makeAnOfferRefuseAction
 * */
function __makeAnOfferRefuseAction()
{
    global $message_cls, $agent_cls, $smarty, $config_cls, $property_cls;
    $message_id = (int)getParam('message_id', 0);
    $property_id = (int)getParam('property_id', 0);
    $accept = getParam('accept', '');
    if ($message_id > 0) {
        $rows_mess = $message_cls->getCRow(array('agent_id_from', 'offer_price', 'buynow_price'), 'message_id=' . $message_id);
        if (count($rows_mess) > 0 and is_array($rows_mess)) {
            $message_cls->update(array('abort' => 1), 'entity_id=' . $property_id . ' AND agent_id_from = ' . $rows_mess['agent_id_from'] . ' AND message_id = ' . $message_id);
            //RESET BUYNOW USER
            if (!empty($rows_mess['buynow_price']) && $rows_mess['buynow_price'] > 0) {
                $property_cls->update(array('buynow_buyer_id' => ''), 'property_id=' . $property_id);
            }
            $params_email_buyer = array();
            $params_email_buyer['property_id'] = $property_id;
            $params_email_buyer['send_mymessage'] = true;
            $params_email_buyer['to'] = array(A_getEmail($rows_mess['agent_id_from']), $config_cls->getKey('general_contact1_name'));
            sendNotificationByEventKey('user_refused_offer_buyer', $params_email_buyer);
            $params_email_vendor = array();
            $params_email_vendor['send_mymessage'] = true;
            $params_email_vendor['property_id'] = $property_id;
            $params_email_vendor['to'] = array(A_getEmail($_SESSION['agent']['id']), $config_cls->getKey('general_contact1_name'));
            $variables = array();
            $variables['[bidder_email_address]'] = A_getEmail($rows_mess['agent_id_from']);
            sendNotificationByEventKey('user_refused_offer_vendor', $params_email_vendor, $variables);
        }
    }
    if ($accept == 'link') {
        return array('onMakeAnOfferRefuse' => 1);
    }
    return __makeAnOfferListAction($property_id);
}

/**
 * @ function : __beforeacceptAutoBidAction
 * */
function __beforeacceptAutoBidAction()
{
    global $agent_cls, $property_cls, $autobid_setting_cls, $bid_room_cls;
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $popup_id = getParam('popup_id');
    $output = array('msg' => 'Information is not valid.', 'success' => 0, 'property_id' => $property_id, 'popup_id' => $popup_id);
    try {
        if ((int)@$_SESSION['agent']['id'] == 0) {
            throw new Exception('You have to login to use this feature.');
        }
        $row = Bid_getLastBidByPropertyId($property_id);
        if ($row['agent_id'] != $_SESSION['agent']['id'] or true) {
            $rs = AutoBid_isValid($_SESSION['agent']['id'], $property_id, true);
            if (isset($rs['error']) && $rs['error'] == true) {
                if (isset($rs['term'])) {
                    $output['term'] = 1;
                    return $output;
                } else {
                    throw new Exception($rs['msg']);
                }
            }
        }
        if (PE_isTheBlock($property_id)) {
            $row = $property_cls->getCRow(array('autobid_enable'), 'property_id = ' . $property_id);
            if ($row['autobid_enable'] == 0) {
                throw new Exception('Disable autobid on this property.');
            }
        }
        $output['msg'] = '';
        $output['success'] = 1;
    } catch (Exception $er) {
        $output['msg'] = $er->getMessage();
    }
    return $output;
}

/**
 * @ function : __acceptAutoBidAction
 * */
function __acceptAutoBidAction()
{
    global $agent_cls, $property_cls, $autobid_setting_cls, $bid_room_cls;
    $output = array('msg' => 'Information is not valid.');
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $agent_auction_step = (float)restrictArgs(getParam('agent_auction_step', 0));
    $agent_maximum_bid = (float)restrictArgs(getParam('agent_maximum_bid', 0));
    $form_id = getParam('form_id');
    $output['property_id'] = $property_id;
    $output['form_id'] = $form_id;
    try {
        if ((int)@$_SESSION['agent']['id'] == 0) {
            throw new Exception('You have to login to use this feature.');
        }
        $row = Bid_getLastBidByPropertyId($property_id);
        if ($row['agent_id'] != $_SESSION['agent']['id']) {
            $rs = Bid_isValid($_SESSION['agent']['id'], $property_id, true);
            if (isset($rs['error']) && $rs['error'] == true) {
                throw new Exception($rs['msg']);
            }
        }
        $price = PE_getPriceForBid($property_id);
        if ($price == 0) {
            throw new Exception('This property is not valid.');
        }
        if ($price >= $agent_maximum_bid) {
            throw new Exception('Your maximum bid price has to be larger than property\'s current price');
        }
        // BEGIN SET AUTOBID SETTING
        $rs = $autobid_setting_cls->add(array('agent_id' => $_SESSION['agent']['id'],
            'property_id' => $property_id,
            'money_step' => $agent_auction_step,
            'money_max' => $agent_maximum_bid,
            'accept' => 1));
        if ($rs !== true) {
            throw new Exception($output);
        }
        // END
        // BEGIN BIDROOM
        $rs = $bid_room_cls->add(array('agent_id' => $_SESSION['agent']['id'], 'property_id' => $property_id));
        if ($rs !== true) {
            throw new Exception($output);
        }
        // END								
        $output['msg'] = 'Your auto bid settings have been set.';
        $output['label'] = 'Unaccept';
        $output['accept'] = 1;
        $output['success'] = 1;
        $output['autobid'] = 1;
    } catch (Exception $e) {
        $output['msg'] = $e->getMessage();
    }
    return $output;
}

/**
 * @ function : __autoBidSettingAction
 * */
function __autoBidSettingAction()
{
    global $agent_cls, $property_cls, $autobid_setting_cls, $bid_room_cls;
    $property_id = (int)getParam('property_id', 0);
    $autobid_enable = (int)getParam('autobid_enable', 0);
    $output = array('msg' => 'Information is not valid.');
    $output['property_id'] = $property_id;
    $output['success'] = 0;
    try {
        if ((int)@$_SESSION['agent']['id'] == 0) {
            throw new Exception('You have to login to use this feature.');
        }
        if ($property_id <= 0) {
            throw new Exception('Property id is not valid.');
        }
        if (!in_array($autobid_enable, array(0, 1))) {
            throw new Exception('Setting information is not valid.');
        }
        $property_cls->update(array('autobid_enable' => $autobid_enable), 'property_id = ' . $property_id);
        if ($autobid_enable == 0) {
            $bid_room_cls->delete('property_id = ' . $property_id);
            //$bid_room_cls->update(array('ignore' => 1), 'property_id = '.$property_id);
        }
        $r = $property_cls->getCRow(array('autobid_enable'), 'property_id = ' . $property_id);
        $output['success'] = 1;
        $output['msg'] = 'Setting information has been updated.';
    } catch (Exception $e) {
        $output['msg'] = $e->getMessage();
    }
    return $output;
}

/**
 * @ function : __refuseAutoBidAction
 * */
function __refuseAutoBidAction()
{
    global $autobid_setting_cls, $bid_room_cls;
    $output = array('msg' => 'Information is not valid.');
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $form_id = getParam('form_id');
    $output['property_id'] = $property_id;
    $output['form_id'] = $form_id;
    if (@$_SESSION['agent']['id'] > 0 && $property_id > 0) {
        $autobid_setting_cls->update(array('accept' => 0), 'agent_id = ' . $_SESSION['agent']['id'] . ' AND property_id = ' . $property_id);
        $bid_room_cls->del($_SESSION['agent']['id'], $property_id);
        $output['msg'] = 'You have been stopped auto bid.';
        $output['label'] = 'Accept';
        $output['accept'] = 0;
        $output['success'] = 1;
    }
    return $output;
}

/**
 * @ function : setFocusHome
 */
function __setFocusHome($property_id = 0, $target = '', $mode = null)
{
    global $property_cls;
    $output = array();
    $attr_name = '';
    switch ($target) {
        case 'focus':
            $attr_name = 'focus_status';
            $name = 'focus';
            $flag = 'focus_flag';
            break;
        case 'home':
            $attr_name = 'jump_status';
            $name = 'set_jump';
            $flag = 'jump_flag';
            break;
    }
    if ($mode == 'change') { // change focus or set_jump when focus or set_jump had been payment for it
        $property_cls->update(array($name => array('fnc' => 'ABS(`' . $name . '`-1)')), 'property_id = ' . $property_id);
        $output['mode'] = 'change';
        $output['success'] = 1;
        return $output;
    }
    if (strlen($attr_name) > 0 && $property_id > 0) {
        $property_cls->update(array($flag => array('fnc' => 'abs(' . $flag . '-1)')), 'property_id = ' . $property_id);
        $price = PE_getMoneyPayment($property_id);
        $output['success'] = 1;
        $output['price'] = $price;
    } else {
        $output['error'] = 1;
    }
    return $output;
}

/**
 * @ function : __getPropertyTypeAction
 * */
function __getPropertyTypeAction()
{
    $kind = (int)getParam('kind', 1);
    $search = (int)getParam('search', 0);
    $target = getParam('target');
    $def = array();
    if ($search == 1) {
        $def = array(0 => 'Any');
    }
    $data = $def;
    if (in_array($kind, array(0, 2))) {
        $data += PEO_getOptions('property_type');
    }
    if (in_array($kind, array(0, 1))) {
        $data += PEO_getOptions('property_type_commercial');
    }
    $jsons = array('error' => 0,
        'content' => $data,
        'target' => $target);
    return $jsons;
}

function __changeManager()
{
    global $property_cls, $agent_cls;
    include_once ROOTPATH . '/modules/agent/inc/message.php';
    if (!isset($message_cls) || !($message_cls instanceof Message)) {
        $message_cls = new Message();
    }
    $property_id = (int)restrictArgs(getParam('property_id', 0));
    $agent_id = (int)restrictArgs(getParam('agent_id', 0));
    if (in_array($_SESSION['agent']['type'], array('theblock', 'agent')) && $_SESSION['agent']['parent_id'] == 0) {
        //$row = $property_cls->getRow('property_id = '.$property_id.' AND (agent_id = '.$_SESSION['agent']['id'].' OR agent_id IN (SELECT agent_id FROM '.$agent_cls->getTable().' WHERE parent_id = '.$_SESSION['agent']['id'].'))');
        $row = $property_cls->getCRow(array('agent_manager', 'agent_id'), 'property_id = ' . $property_id . ' AND (agent_id = ' . $_SESSION['agent']['id'] . ' OR agent_id IN (SELECT agent_id FROM ' . $agent_cls->getTable() . ' WHERE parent_id = ' . $_SESSION['agent']['id'] . '))');
        if (is_array($row) and count($row) > 0) {
            $id_prev = (int)$row['agent_manager'] > 0 ? $row['agent_manager'] : $row['agent_id'];
            $tmp = $row['agent_manager'];
            $property_cls->update(array('agent_manager' => $agent_id), 'property_id = ' . $property_id);
            /* SEND MSG TO PREV MANAGER */
            $prev['from_email'] = $_SESSION['agent']['email_address'];
            $prev['to_email'] = A_getEmail($id_prev);
            $prev['content'] = 'Property ID: ' . $property_id . ' has been changed its management to another person.';
            $prev['subject'] = 'Property ID: ' . $property_id . ' has been changed!';
            $prev['from_id'] = $_SESSION['agent']['id'];
            $prev['to_id'] = $id_prev;
            sendMess($prev);
            /* SEND MSG TO NEW MANAGER */
            $new['from_email'] = $_SESSION['agent']['email_address'];
            $new['to_email'] = A_getEmail($agent_id);
            $new['content'] = 'You have just been set to manage property ID: ' . $property_id;
            $new['subject'] = 'New property for you!';
            $new['from_id'] = $_SESSION['agent']['id'];
            $new['to_id'] = $agent_id;
            sendMess($new);
            die(json_encode(array('success' => 1, 'prev' => $id_prev, 'tmp' => $tmp)));
        }
    }
    die(json_encode(array('error' => 1, 'msg' => 'You have not permission!')));
}

function __changeReaStatusAction()
{
    global $property_cls;
    $property_ids = getParam('property_id');
    $new_status = getParam('status');
    $endtime_ar = getParam('endtime_ar','0000-00-00 00:00:00');
    $starttime_ar = getParam('starttime_ar','0000-00-00 00:00:00');
    if (strlen($new_status) > 0 && strlen($property_ids) > 0) {
        $property_ids_ar = explode(',', $property_ids);
        if (is_array($property_ids_ar) && count($property_ids_ar) > 0) {
            foreach ($property_ids_ar as $property_id) {
                if ($property_id > 0) {
                    $current_status = PE_getPropertyStatusREA_xml($property_id);
                    $current_status = str_replace(' ', '-', $current_status);
                    if ($new_status == 'sold' || $new_status == 'leased') {
                        $property_cls->update(array('confirm_sold' => 1, 'stop_bid' => 1, 'scan' => 0, 'sold_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
                    }
                    if ($new_status == 'current') {
                        $pro_data = array('confirm_sold' => 0, 'stop_bid' => 0, 'sold_time' => '0000-00-00 00:00:00');
                        if ($endtime_ar > '0000-00-00 00:00:00')
                            $pro_data['end_time'] = $endtime_ar;
                        if ($starttime_ar > '0000-00-00 00:00:00')
                            $pro_data['start_time'] = $starttime_ar;
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    }
                    if ($new_status == 'underoffer') {
                        $pro_data = array('underoffer' => 1, 'confirm_sold' => 0, 'stop_bid' => 0, 'sold_time' => '0000-00-00 00:00:00');
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    } else {
                        $pro_data = array('underoffer' => 0);
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    }
                    if ($new_status == 'offmarket') {
                        $pro_data = array('active' => 0);
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    }
                    if ($new_status == 'withdrawn') {
                        $pro_data = array('withdrawn' => 1);
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    } else {
                        $pro_data = array('withdrawn' => 0);
                        $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
                    }
                    /*Sold or leased needs to change to current or under offer, withdrawn or offmarket*/
                    if ($current_status == 'sold' || $current_status == 'leased') {
                    }
                    if ($current_status == 'current') {
                    }
                }
            }
        }
    }
    die(json_encode(array('success' => 1, 'mgs' => 'Change status successful!')));
}

function sendMess($array)
{
    global $message_cls;
    $nd = '<h2 style="font-size: 16px; color: #2f2f2f;"> Message Information </h2>
                    <div style="margin-top:8px;">Sender : ' . $array['from_email'] . '  </div>
                    <div style="margin-top:8px;">Subject : ' . stripslashes($array['subject']) . ' </div>
                    <div style="margin-top:8px">Content : ' . stripslashes($array['content']) . ' </div> ';
    sendEmail_func($array['from_email'], $array['to_email'], $nd, $array['subject']);
    include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
    if (!isset($log_cls) or !($log_cls instanceof Email_log)) {
        $log_cls = new Email_log();
    }
    $log_cls->createLog('send_message');
    $data = array('agent_id_from' => $array['from_id'],
        'email_from' => $array['from_email'],
        'agent_id_to' => $array['to_id'],
        'email_to' => $array['to_email'],
        'title' => addslashes($array['subject']),
        'content' => addslashes($array['content']),
        'send_date' => date('Y-m-d H:i:s'));
    $message_cls->insert($data);
}

function __setIncre()
{
    global $property_cls, $agent_cls;
    $min = (int)restrictArgs(getParam('min-incre'));
    $max = (int)restrictArgs(getParam('max-incre'));
    $property_id = restrictArgs(getParam('property_id'));
    if ((int)restrictArgs(getParam('is_reset')) != 1) {
        if (($max > $min AND $min > 0) OR ($min > 0 AND getParam('max-incre', '') == '')) {
        } else {
            /* if ($max <= 0 ) {
              die(json_encode(array('success' => 1, 'msg' =>' Max increment must be than zero')));
              }
              if (isset($max) && $max < $min && $max > 0 && $min > 0) {
              die(json_encode(array('success' => 1, 'msg' =>' Min increment must be less than or equal to max')));
              } */
            die(json_encode(array('success' => 1, 'msg' => ' Max increment must be than min(min>0)')));
        }
    }
    $str = $_SESSION['agent']['parent_id'] == 0 ? ' (agent_id IN (SELECT agent_id
                                                              FROM ' . $agent_cls->getTable() . '
                                                              WHERE parent_id = ' . $_SESSION['agent']['id'] . ')
                                                   OR agent_id = ' . $_SESSION['agent']['id'] . ')' :
        " IF(ISNULL(agent_manager) || agent_manager = ''
												   ,agent_id ={$_SESSION['agent']['id']}
												   ,agent_manager = {$_SESSION['agent']['id']})";
    $row = $property_cls->getRow('SELECT property_id
                                  FROM ' . $property_cls->getTable() . "
                                  WHERE {$str}
                                        AND property_id = {$property_id}"
        , true);
    if (is_array($row) and count($row) > 0) {
        $property_cls->update(array('min_increment' => $min,
            'max_increment' => $max), 'property_id = ' . $property_id);
        if ($property_cls->hasError()) {
            die(json_encode(array('success' => 1, 'msg' => $property_cls->getError())));
        } else {
            // UPDATE NOTIFICATION TO ANDROID
            pushWithoutUserId($_SESSION['agent']['id'], array('type_msg' => 'update-increment', 'property_id' => $property_id));
            //push(0, array('type_msg' => 'update-increment', 'property_id' => $property_id));
            //push1(0, array('type_msg' => 'update-increment', 'property_id' => $property_id));
            die(json_encode(array('success' => 1, 'msg' => 'Saved successful!')));
        }
    }
    die(json_encode(array('success' => 1, 'msg' => 'You have not permission!')));
}

function __getPrice()
{
    global $property_cls;
    $property_id = restrictArgs(getPost('property_id', 0));
    $row = $property_cls->getCRow(array('min_increment'), 'property_id = ' . $property_id);
    if (is_array($row) and count($row) > 0) {
        die(json_encode(array('price' => $row['min_increment'])));
    }
    die(json_encode(array('error' => 1)));
}

function __getPackage()
{
    global $property_cls, $package_cls;
    $auction_sale_ar = PEO_getAuctionSale();
    $property_type = getParam('type', $auction_sale_ar['auction']);
    $property_id = restrictArgs(getPost('property_id'));
    $package_tpl = PK_getPackageTpl($property_id, 0, $property_type);
    die(json_encode($package_tpl));
}

?>