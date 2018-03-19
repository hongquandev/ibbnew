<?php
include_once ROOTPATH . '/modules/agent/inc/agent.payment.class.php';
include_once ROOTPATH . '/modules/general/inc/getbanner.php';

$days = $config_cls->getKey('agent_remind_date');

$check = $agent_payment_cls->getRows("SELECT agent_id, date_to
                                          FROM " . $agent_payment_cls->getTable() . "
                                          WHERE payment_id
                                            IN (
                                            SELECT MAX(payment_id)
                                            FROM " . $agent_payment_cls->getTable() . "
                                            GROUP BY agent_id
                                            )
                                          AND DATEDIFF(DATE_FORMAT(date_to,'%Y-%m-%d'),'" . date('Y-m-d') . "') <= {$days}
                                              AND DATEDIFF(DATE_FORMAT(date_to,'%Y-%m-%d'),'" . date('Y-m-d') . "') >= 0", true);

if (is_array($check) and count($check) > 0) {
    $subject = $config_cls->getKey('agent_email_subject');
    $content = $config_cls->getKey('agent_email_content');
    foreach ($check as $item) {
        $agent = $agent_cls->getCRow(array('firstname', 'lastname', 'email_address'),
            'agent_id = ' . $item['agent_id']);
        if (is_array($agent) and count($agent) > 0) {
            $username = $agent['firstname'] . ' ' . $agent['lastname'];
            $dt = new DateTime($item['date_to']);
            $expire_date = $dt->format($config_cls->getKey('general_date_format'));
            $text = str_replace(array('[username]', '[expire_date]'), array($username, $expire_date), $content);
            $banner_data = getBannerByAgentId($item['agent_id']);
            sendEmailOnly($config_cls->getKey('general_contact_email'), $agent['email_address'], $text, $subject, $lkB);

            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
                $log_cls = new Email_log();
            }
            $log_cls->createLog('agent_expire');
        }
    }
}
/*
 *
 *
 *
 * setup test notification emails every day For registration For posting For concierge
 * */
    $subject = 'bidRhino: Testing notification email every day For registration For posting For concierge';
    $mgs = 'This is a testing notification email every day For registration For posting For concierge';
    //sendEmailOnly($config_cls->getKey('general_contact_email'), $config_cls->getKey('general_contact_email'), $mgs, $subject);
    $params = array('subject'=> $subject,'email_content' => $mgs,'to' => $config_cls->getKey('general_contact_name'));
    sendNotificationByEventKey('testing_email_every_day',$params);
?>