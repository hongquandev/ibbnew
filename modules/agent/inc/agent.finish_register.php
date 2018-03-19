<?php
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
$message = '';
/*print_r($_SESSION);*/
if (is_array($_SESSION['new_agent']) && count($_SESSION['new_agent']) > 0) {
    $agent = $agent_cls->getRow('SELECT a.agent_id, a.type_id, p.payment_id
                                 FROM '.$agent_cls->getTable().' AS a
                                 LEFT JOIN '.$agent_cls->getTable('agent_payment').' AS p
                                 ON a.agent_id = p.agent_id
                                 WHERE a.agent_id = '.$_SESSION['new_agent']['id'],true);
    if (is_array($agent) and count($agent) > 0){
        $arr = AgentType_getOptions();
        $type = $arr[$agent['type_id']];
        if ($type == 'agent' && $agent['payment_id'] == 0){
            redirect(ROOTURL.'?module=agent&action=register-agent');
        }else{
            $confirm = encrypt($_SESSION['new_agent']['agent']['email_address']);
            $agent_cls->update(array('confirm' => $confirm),'agent_id = '.$_SESSION['new_agent']['id']);
            //$url = ROOTURL.'/?module=agent&action=confirm&key='.$confirm;
            include_once ROOTPATH . '/modules/shorturl/inc/short_url.class.php';
            $url =  ROOTURL.$shortUrl_cls->addShortUrl('/?module=agent&action=confirm&key='.$confirm);
            $msg_active = 'Click link below to active your account :<a href="'.$url.'">'.$url.'</a>';
            $username = $_SESSION['new_agent']['agent']['firstname'].' '.$_SESSION['new_agent']['agent']['lastname'];
            if($username == ''){
                $username = 'member';
            }
            $email = $_SESSION['new_agent']['agent']['email_address'];
            if ($type == 'agent'){
                $pass_length = (int)$config_cls->getKey('general_customer_password_length');
                $password = strrand($pass_length > 0 ? $pass_length : 6);
                $agent_cls->update(array('password'=>encrypt($password)),'agent_id = '.$_SESSION['new_agent']['id']);
            }else{
                $password = $_SESSION['new_agent']['agent']['password2'];
            }
            $general_contact1_email = $config_cls->getKey('general_contact1_name');

            $params_email = array('to' => array($email,$general_contact1_email));
            $variables = array('[username]' => $username,'[email]' => $email,'[password]' => $password,
                '[link_active]' => $url,
                '[msg_active]' => $msg_active,
                '[key]' => $confirm,
                '[ROOTURL]' => ROOTURL);
            sendNotificationByEventKey('user_finished_account',$params_email,$variables);

            include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
            $log_cls->createLog('register');

            unset($_SESSION['new_agent']['agent']['password2']);
            $message = 'Thank you for your registration. <br />
                        We have sent you a confirmation email to the email address you used to register with bidRhino.com<br />
                        Please check your inbox and click on the activation link to activate your new account.<br />
                        Thank you !<br />
                        bidRhino.com Support.';
            if (isset($_SESSION['new_agent']['redirect_url'])){
                $smarty->assign('register_property_url',$_SESSION['new_agent']['redirect_url']);
            }
            unset($_SESSION['new_agent']);
        }
    }
}
$smarty->assign('message',$message);
?>