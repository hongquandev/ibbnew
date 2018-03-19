<?php
$module = 'agent';
$module2 = 'note';
$module3 = 'property';
if ($_SESSION['language'] == 'vn') {
    include 'lang/' . $module . '.vn.lang.php';
} else {
    include 'lang/' . $module . '.en.lang.php';
}
if (!isset($_SESSION['agent'])) {
    $_SESSION['agent'] = array();
}
if (!isset($_SESSION['agent']['id'])) {
    $_SESSION['agent']['id'] = 0;
}
if (!isset($_SESSION['agent']['step'])) {
    $_SESSION['agent']['step'] = 1;
}
if (!isset($_SESSION['new_agent'])) {
    $_SESSION['new_agent'] = array();
}
if (!isset($_SESSION['new_agent']['id'])) {
    $_SESSION['new_agent']['id'] = 0;
}
if (!isset($_SESSION['new_agent']['step'])) {
    $_SESSION['new_agent']['step'] = 1;
}
//RESET property_id
/*
$_SESSION['property']['id'] = 0;
$_SESSION['property']['step'] = 0;
*/
include_once ROOTPATH . '/includes/checkingform.class.php';
$action = getParam('action');
$message = '';
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once 'inc/agent.php';
include_once 'inc/agent.function.php';
// DUC CODING AGENT DELETE BANNER
include_once ROOTPATH . '/modules/banner/inc/banner.php';
//
//escapeParam();
$_GET['agent-delete'] = isset($_GET['agent-delete']) ? $_GET['agent-delete'] : 0;
$agent_delete = (int)$_GET['agent-delete'] ? (int)$_GET['agent-delete'] : 0;
if (isset($agent_delete) && $agent_delete > 0) {
    $rowsDBan = $banner_cls->getRow('banner_id =' . $agent_delete);
    if (count($rowsDBan) > 0) {
        @unlink(ROOTPATH . '/store/uploads/banner/images/' . $rowsDBan['banner_file']);
        @unlink(ROOTPATH . '/store/uploads/banner/images/thumbs/' . $rowsDBan['banner_file']);
        @unlink(ROOTPATH . '/store/uploads/banner/images/thumbs/dashboard/' . $rowsDBan['banner_file']);
        @unlink(ROOTPATH . '/store/uploads/banner/images/thumbs/mybanner/' . $rowsDBan['banner_file']);
        $banner_cls->delete('banner_id =' . $agent_delete);
        redirect(ROOTURL . '?module=' . $module . '&action=view-dashboard');
    }
}
// END DUC CODING
switch ($action) {
    case "export_csv_property_offers": //CSV
        include_once ROOTPATH . '/modules/agent/inc/agent.property_offers.php';
        __exportPropertyOffersCSV();
        exit;
    case "export_csv_registered_offers":
        include_once ROOTPATH . '/modules/agent/inc/agent.registered_bidders.php';
        __exportRegisteredOffersCSV();
        exit;
    case "exportCustomerCSV":
        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        __exportCustomerCSV();
        exit;
        break;
    case 'view-detail-agent':
    case 'view-detail-agency':
        $action_ar = explode('-', $action);
        include_once 'inc/agent.detail.php';
        $form_action = '/view-search-advance-agent.html&rs=1';
        $smarty->assign('action_ar', $action_ar);
        break;
    case 'agent-active':
        $id_active = (int)$_GET['id'] ? (int)$_GET['id'] : '';
        if (isset($id_active) && $id_active > 0) {
            $bannersql = $banner_cls->getRow('banner_id =' . $id_active);
            if ($bannersql['agent_status'] == 1) {
                $banner_cls->update(array('agent_status' => 0), 'banner_id = ' . $id_active);
            } else {
                $banner_cls->update(array('agent_status' => 1), 'banner_id = ' . $id_active);
            }
            redirect(ROOTURL . '/?module=' . $module . '&action=view-dashboard');
        }
        break;
    case 'landing' :
        if (isset($_SESSION['agent']) AND $_SESSION['agent']['id'] > 0) {
            redirect(ROOTURL . '/?module=agent&action=view-dashboard');
        }
        include_once ROOTPATH . '/modules/agent/inc/landing.php';
        $smarty->assign('landing', "landing");
        break;
    case 'register-buyer':
    case 'register-vendor':
    case 'register-agent':
    case 'register-partner':
        if (getParam('agent') == 'new') // New agent
        {
            if (isset($_SESSION['new_agent'])) {
                unset($_SESSION['new_agent']);
            }
        }
        $type = 'buyer';
        $type_id_arr = AgentType_getArr();
        $title_id_arr = AgentType_getOptions_();
        if (eregi('-', $action)) {
            $action_ar = explode('-', $action);
            $type = $action_ar[1];
            $_type = $title_id_arr[$type_id_arr[$type]];
            $smarty->assign('type', $type);
            $smarty->assign('_type', strtoupper($_type));
        }
        $agent_id = $_SESSION['agent']['id'];
        $smarty->assign('agent_id', $agent_id);
        /*if (isset($_SESSION['agent']['login'])) {
            $_SESSION['register_page'] = $type;
            redirect(ROOTURL . '?module=' . $module . '&action=view-dashboard');
        }*/
        $step = (int)restrictArgs(getQuery('step'), 1);
        $max_step = $type == 'agent' ? 5 : 4;
        if (($step <= 0) or ($step > $max_step)) {
            $step = 1;
        }
        if ((!isset($_SESSION['reg']) or !isset($_SESSION['new_agent']['id']) or $_SESSION['new_agent']['id'] < 1) and $step > $_SESSION['new_agent']['step']) {
            redirect(ROOTURL . '?module=' . $module . '&action=' . $action);
        }
        $form_action = ROOTURL . '/?module=' . $module . '&action=' . $action . '&step=' . $step;
        if (in_array($step, array(1, 2)) && in_array($type, array('partner', 'agent'))) {
            $_type = $type != 'partner' ? 'agent.auction' : $type;
            include_once 'inc/' . $_type . '.step' . $step . '.php';
        } else {
            include_once 'inc/' . $module . '.step' . $step . '.php';
        }
        for ($i = 1; $i <= $max_step; $i++) {
            $array[] = $i;
        }
        $smarty->assign('step', $step);
        $smarty->assign('array', $array);
        include_once ROOTPATH . '/modules/video/inc/video.php';
        $smarty->assign('video_file', getVideo());
        if (getParam('kind', 'none') == 'transact') {
            include_once 'inc/agent.step.transact.php';
        }
        break;
    case 'finish-register':
        include_once 'inc/' . $module . '.finish_register.php';
        break;
    case 'register-application':
        include_once 'inc/agent.step.register_application.php';
        $transact_step = getParam('transact_step', 3);
        $smarty->assign('transact_step', $transact_step);
        $property_id = $_SESSION['registerToTransact_id'];
        $smarty->assign('property_id', $property_id);
        $transact_type = PE_isRentProperty($property_id) ? 'rental' : 'sales';
        $smarty->assign('transact_type', $transact_type);
        $form_action_transact = ROOTURL . '/?module=agent&action=register-application&transact_step=' . $transact_step;
        $smarty->assign('form_action_transact', $form_action_transact);
        $transact_agent_id = $_SESSION['registerToTransact_agent_id'];
        $smarty->assign('transact_agent_id', $transact_agent_id);
        $smarty->assign('link_application_form', ROOTURL . '/?module=term&action=view-application&pid=' . $property_id);
        break;
    case 'files-management':
        include_once 'inc/' . $module . '.files-management.php';
        break;
    case 'confirm':
        include_once 'inc/' . $module . '.confirm.php';
        break;
    case 'fb-info':
        include_once 'inc/' . $module . '.fb_info.php';
        break;
    case 'tw-info':
        include_once 'inc/' . $module . '.tw_info.php';
        break;
    case 'login':
        include_once 'inc/' . $module . '.login.php';
        break;
    case 'logout':
        include_once 'inc/' . $module . '.logout.php';
        break;
    case 'forgot':
        if (isset($_SESSION['agent']) AND $_SESSION['agent']['id'] > 0) {
            redirect(ROOTURL . '/?module=agent&action=view-dashboard');
        }
        include_once 'inc/' . $module . '.forgot.php';
        break;
    case 'view-partner-list':
        include_once ROOTPATH . '/includes/pagging.class.php';
        if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
            $pag_cls = new Paginate();
        }
        include_once 'inc/partner.view.php';
        break;
    case 'add-info':
    case 'add-info-partner':
        include_once 'inc/agent.information.php';
        if ($_SESSION['agent']['id'] > 0) {
            if ($_SESSION['agent']['type'] == 'partner') {
                $action = 'add-info-partner';
            } else {
                $action = 'add-info';
            }
        } else {
            redirect(ROOTURL);
        }
        break;
    case 'view-report-banner-detail':
        include_once 'inc/agent.report.banner.php';
        break;
    default:
        include_once ROOTPATH . '/includes/pagging.class.php';
        if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
            $pag_cls = new Paginate();
        }
        include_once ROOTPATH . '/modules/general/inc/medias.class.php';
        if (!isset($media_cls) or !($media_cls instanceof Medias)) {
            $media_cls = new Medias();
        }
        include_once ROOTPATH . '/modules/general/inc/bids.php';
        include_once ROOTPATH . '/modules/property/inc/property.php';
        $action_ar = explode('-', $action);
        switch ($action_ar[0]) {
            case 'view':
            case 'add':
            case 'edit':
            case 'delete':
                //BEGIN DUC CHECK ACCOUNT WITH PARTNER, VENDOR, BUYER.
                $row = $agent_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
                $db_checkpartner = array();
                if (is_array($row) and count($row) > 0) {
                    $db_checkpartner = $row;
                }
                $smarty->assign('db_checkpartner', $db_checkpartner);
                if (isset($action_ar[1]) &&
                    ($action_ar[1] == 'property'
                        || $action_ar[1] == 'lawyer'
                        || $action_ar[1] == 'contact'
                        || $action_ar[1] == 'property_bids'
                        || $action_ar[1] == 'watchlist'
                        || $action_ar[1] == 'notification'
                        || $action_ar[1] == 'email')
                ) {
                    if ($_SESSION['agent']['type'] == 'partner' AND ($action_ar[1] != 'property_bids' AND $action_ar[1] != 'watchlist')) {
                        redirect(ROOTURL . '?module=agent&action=view-dashboard');
                    }
                }
                //END
                if (!isset($_SESSION['agent']['id']) or ((int)$_SESSION['agent']['id'] == 0)) {
                    redirect(ROOTURL . '?module=agent&action=login');
                }
                //RESTRICT CHILD LIVE AUCTION USER: Nhung
                if ($action_ar[1] == 'user') {
                    if (!in_array($_SESSION['agent']['type'], array('theblock', 'agent')) || $_SESSION['agent']['parent_id'] > 0) {
                        redirect(ROOTURL . '?module=agent&action=view-dashboard');
                    }
                }
                if ($action_ar[1] == 'payment') {
                    if (!in_array($_SESSION['agent']['type'], array('agent'))) {
                        redirect(ROOTURL . '?module=agent&action=view-dashboard');
                    }
                }
                if (!isset($check) or !($check instanceof CheckingForm)) {
                    $check = new CheckingForm();
                }
                $form_action = '?module=' . $module . '&action=' . $action;
                $file = 'inc/' . $module . '.' . $action_ar[1] . '.php';
                if ($action_ar[1] == 'auction') {
                    $file = 'inc/' . $module . '.property.php';
                }
                //NHUNG
                if ($action_ar[1] == 'company') {
                    switch ($_SESSION['agent']['type']) {
                        case 'agent':
                        case 'theblock':
                            if ($_SESSION['agent']['parent_id'] == 0) {
                                $file = 'inc/' . $module . '.auction.company.php';
                            } else redirect(ROOTURL . '?module=agent&action=view-dashboard');
                            break;
                        case 'partner':
                            $file = 'inc/' . $module . '.company.php';
                            break;
                        default:
                            redirect(ROOTURL . '?module=agent&action=view-dashboard');
                    }
                }
                if (file_exists(ROOTPATH . '/modules/agent/' . $file)) {
                    include_once $file;
                } else {
                    redirect(ROOTURL);
                }
                $smarty->assign('action_ar', $action_ar);
                $smarty->assign('rights', array('num_unread' => M_numUnread()));
                break;
            case 'list':
                include_once 'inc/' . $module . '.list.php';
                $smarty->assign('action_ar', $action_ar);
                break;
            default:
                //redirect(ROOTURL.'/?module=agent&action=view-dashboard');
                Report_pageRemove(Report_parseUrl());
                //redirect(ROOTURL.'/notfound.html');
                //redirect('/notfound.html');
                break;
        }
        break;
}
$agent_id = isset($_SESSION['new_agent']['id']) && ((int)$_SESSION['new_agent']['id'] > 0) ? $_SESSION['new_agent']['id'] : $_SESSION['agent']['id'];
if (strlen(trim($message)) == 0) {
    $message = $session_cls->getMessage();
}
$smarty->assign('agent_id', $agent_id);
//print_r(' stepped='.$_SESSION['new_agent']['step']);
$smarty->assign('stepped', $_SESSION['new_agent']['step']);
$smarty->assign('message', $message);
$smarty->assign('form_action', $form_action);
$smarty->assign('action', $action);
$smarty->assign('module', $module);
$smarty->assign('module2', $module2);
$smarty->assign('module3', $module3);
$smarty->assign('ROOTPATH', ROOTPATH);
$smarty->assign('mode', @$mode);
$smarty->assign('captcha_private_key', $config_cls->getKey('captcha_private_key'));
$smarty->assign('captcha_public_key', $config_cls->getKey('captcha_public_key'));
?>