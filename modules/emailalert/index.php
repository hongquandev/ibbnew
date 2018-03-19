<?php
include_once 'inc/emailalert.php';
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/modules/property/inc/property_entity_option.class.php';
include_once ROOTPATH . '/modules/property/inc/property_media.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/search_data.php';
$action = getParam('action');
$message = '';
/*$resend = $_GET['resend'];
    $pro_id = (int)$_GET['pro_id'];*/
if (!isset($_SESSION['agent']['id']) or ((int)$_SESSION['agent']['id'] == 0)) {
    redirect(ROOTURL . '/?module=agent&action=login');
}
switch ($action) {
    default:
        Report_pageRemove(Report_parseUrl());
        //redirect(ROOTURL.'/notfound.html');
        redirect('/notfound.html');
        break;
    case 'add-email':
    case 'edit-email':

        $row = $agent_cls->getRow('agent_id =' . (int)$_SESSION['agent']['id']);
        if (count($row) > 0) {
            if ($row['type_id'] == 3) {
                redirect(ROOTURL . '/?module=agent&action=view-dashboard');
            } else {
                include 'inc/emailalert.add.php';
                $form_action = '/?module=emailalert&action=add-email';
            }
        }
        break;
    case 'delete':
        $pid = (int)$_GET['id'];
        $email_cls->delete('email_id = ' . $pid);
        if ($email_cls->hasError()) {
        } else {
            redirect(ROOTURL . '/?module=emailalert&action=add-email');
        }
        break;

}
if (strlen(trim($message)) == 0) {
    $message = $session_cls->getMessage();
}
$smarty->assign('message', $message);
$smarty->assign('action', $action);
$smarty->assign('form_action', $form_action);
$smarty->assign('ROOTPATH', ROOTPATH);
$smarty->assign('rights', array('num_unread' => M_numUnread()));

?>