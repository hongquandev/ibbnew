<?php

//header("Content-Type: application/xml; charset=utf-8");
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/newsletter/inc/newsletter.php';
require_once ROOTPATH.'/includes/functions.php';

$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
} else {
    $smarty->compile_dir = ROOTPATH . '/templates_c/';
}
global $agent_cls;
$action = getParam('action');
$module = 'newsletter';

switch ($action) {
    case 'unsubscribe':
        $mail = getParam('e');
        $type = getParam('t');
        $row = $agent_cls->getRow(" md5(email_address) = '" . $mail . "'");
        if (is_array($row) and count($row) > 0) {
            if ($type == md5('notify')) {
                $data = array('notify_email' => '0', 'notify_sms' => '0');
            }
            if ($type == md5('newsletter')) {
                $data = array('subscribe' => '0');
            }
            if ($type == md5('bid_mail')) {
                $data = array('notify_email_bid' => '0');
            }
            $agent_cls->update($data, ' agent_id = ' . $row['agent_id']);
            $result = true;
            $link_sub = ROOTURL . '/index.php?module=agent&action=view-dashboard';
            $smarty->assign('row', $row);
            $smarty->assign('link_sub', $link_sub);
        } else {
            $row = $newsletter_cls->delete(" md5(EmailAddress) = '" . $mail . "'");
            $result = false;
            $link_reg = ROOTURL . '/index.php?module=agent&action=landing';
            $smarty->assign('link_reg', $link_reg);
        }
        $smarty->assign('result', $result);
        break;
    default:
        Report_pageRemove(Report_parseUrl());
        //redirect(ROOTURL.'/notfound.html');
        redirect('/notfound.html');
        break;
}
$smarty->assign('action', $action);
$smarty->assign('module', $module);
?>
