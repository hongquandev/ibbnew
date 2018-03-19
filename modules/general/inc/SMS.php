<?php
include_once ROOTPATH . '/configs/config.inc.php';
include_once ROOTPATH . '/modules/configuration/inc/configuration.php';
include_once ROOTPATH . '/modules/general/inc/SMS.class.php';
include_once ROOTPATH . '/modules/general/inc/sms_log.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
if (!isset($sms_cls) || !($sms_cls instanceof SMS)) {
    $sms_cls = new SMS(array('username' => $config_cls->getKey('sms_username'),
        'password' => $config_cls->getKey('sms_password'),
        'sender_id' => $config_cls->getKey('sms_sender_id'),
        'portal_url' => $config_cls->getKey('sms_gateway_url')));
}
if (!isset($sms_log_cls) || !($sms_log_cls instanceof SMS_log)) {
    $sms_log_cls = new SMS_log();
}
function sendSMS($text, $to)
{
    global $sms_cls, $sms_log_cls, $config_cls;
    $sms_enable = $config_cls->getKey('sms_enable');
    if ($sms_enable == 1 && !empty($text) && !empty($to)) {
        $sms_cls->send($text, $to);
        $sms_cls->parseResponse();
        $sms_log_cls->insert(array('message' => serialize(array('content' => $text, 'to' => $to)), 'created_at' => date('Y-m-d H:i:s'), 'status' => $sms_cls->getStatus()));
        return $sms_cls->getStatus();
    }
    return false;
}

 
