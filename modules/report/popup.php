<?php

session_start();
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
require ROOTPATH . '/includes/smarty/Smarty.class.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}

$msg = '';
$action = getParam('action');
switch ($action) {
    case 'view-email_enquire-detail':
        $message_id = (int) restrictArgs(getParam('message_id', 0));

        include_once ROOTPATH . '/modules/agent/inc/agent.php';
        if ($message_id > 0) {
            $row = $message_cls->getRow('message_id = ' . $message_id);
            if (is_array($row) && count($row) > 0) {
                $msg = nl2br($row['content']);
            }
        }
        //die($msg);	
        break;

    case 'view-email_alert-detail':
        $email_id = (int) restrictArgs(getParam('email_id', 0));

        include_once ROOTPATH . '/modules/emailalert/inc/emailalert.class.php';

        if (!isset($emailalert_cls) or !($emailalert_cls instanceof EmailAlert)) {
            $emailalert_cls = new EmailAlert();
        }

        if ($email_id > 0) {
            $row = $emailalert_cls->getRow('email_id = ' . $email_id);
            if (is_array($row) && count($row) > 0) {
                $msg = $row['description'];
            }
        }

        break;
    case 'view-banner':
    case 'view-banner-click':
    case 'view-banner-view':
        include_once ROOTPATH . '/modules/report/inc/report.php';

        $action_ar = explode('-', $action);
        $year = getParam('year', date('Y'));
        $id = (int) restrictArgs(getParam('id', 0));
        switch (@$action_ar[2]) {
            case 'click':
                $month_ar = array();
                $data_ar = array();
                for ($i = 1; $i <= 12; $i++) {
                    $month_ar[$i] = substr('00' . $i, -2);
                    $data_ar[$i] = 0;
                }

                $rows = $banner_log_cls->getRows('SELECT SUM(click) AS num, MONTH(created_at) AS month
								FROM ' . $banner_log_cls->getTable() . ' 
								WHERE banner_id = ' . $id . " AND YEAR(created_at) = '" . $year . "'
								GROUP BY DATE_FORMAT('created_at','%Y-%m')", true);

                if (is_array($rows) && count($rows) > 0) {
                    foreach ($rows as $row) {
                        $data_ar[$row['month']] = $row['num'];
                    }
                }

                $smarty->assign('title', 'Banner Report #' . $id);
                $smarty->assign('year', $year);
                $smarty->assign('month_ar', $month_ar);
                $smarty->assign('data_ar', $data_ar);
                $smarty->assign('year_options', Report_bannerOptions());
                $smarty->assign('link_view', ROOTURL . '/modules/report/popup.php?action=view-banner-click&id=' . $id);
                $msg = $smarty->fetch(ROOTPATH . '/modules/report/templates/admin.report.banner.click.tpl');
                break;
            case 'view':
                $msg = $smarty->fetch(ROOTPATH . '/modules/report/templates/admin.report.banner.view.tpl');
                break;
            default:
                $msg = $smarty->fetch(ROOTPATH . '/modules/report/templates/admin.report.banner.tpl');
                break;
        }


        break;
};

$smarty->assign('msg', $msg);
$smarty->template_dir = ROOTPATH . '/modules/report/templates/';
$smarty->display('admin.report.popup.tpl');
?>