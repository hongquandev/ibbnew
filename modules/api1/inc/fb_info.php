<?php

include_once ROOTPATH . '/includes/class.phpmailer.php';
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.facebook.class.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
//include_once ROOTPATH . '/modules/agent/inc/agent.fb_detail.class.php';

$email = getParam("email", '');
$firstname = getParam("firstname", '');
$lastname = getParam("lastname", '');
$uid = getParam("uid", '');
$access_token = getParam("access_token", '');
$fb_info = array('uid' => $uid, 'email_address' => $email, 'secret' => $access_token);

if (!FD_hasID($email)) { //create new acc or sync acc
    if (checkEmail($email)) {
        $row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
                                              FROM " . $agent_cls->getTable() . " AS agt," . $agent_cls->getTable('agent_type') . " AS agt_type
                                              WHERE agt.type_id = agt_type.agent_type_id
                                              AND agt.email_address = '" . $email . "'", true);
        if (is_array($row) && count($row) > 0) {
            if ($row['is_active'] == 0) {
                out(0, 'Your account active yet.');
            }
            $_SESSION['agent'] = array('id' => $row['agent_id'],
                                       'full_name' => strlen($row['firstname'] . ' ' . $row['lastname']) > 300
                                               ? safecontent($row['firstname'] . ' ' . $row['lastname'], 300) . '...'
                                               : $row['firstname'] . ' ' . $row['lastname'],
                                       'firstname' => $row['firstname'],
                                       'lastname' => $row['lastname'],
                                       'email_address' => $row['email_address'],
                                       'type' => $row['type'],
                                       'type_id' => $row['type_id'],
                                       'login' => true);


            out(1, '', $_SESSION['agent']);
        } else {
            $type = 'buyer';
            $type_id = 2;
            $atype_row = $agent_cls->getRow('SELECT agent_type_id
                                                        FROM ' . $agent_cls->getTable('agent_type') . '
                                                        WHERE title = ' . "'" . $type . "'", true);
            if (is_array($atype_row) && count($atype_row) > 0) {
                $type_id = $atype_row['agent_type_id'];
            }

            $pass_length = (int)$config_cls->getKey('general_customer_password_length');
            $pw = strrand($pass_length > 0 ? $pass_length : 6);
            $data = array('firstname' => $firstname,
                          'lastname' => $lastname,
                          'email_address' => $email,
                          'password' => encrypt($pw),
                          'type_id' => $type_id,
                          'creation_time' => date('Y-m-d H:i:s'),
                          'is_active' => 1,
                          'ip_address' => $_SERVER['REMOTE_ADDR'],
                          'allow_facebook' => 1
            );
            $agent_cls->insert($data);

            $_SESSION['agent'] = array('id' => $agent_cls->insertId(),
                                       'full_name' => strlen($data['firstname'] . ' ' . $data['lastname']) > 300
                                               ? safecontent($data['firstname'] . ' ' . $data['lastname'], 300) . '...'
                                               : $data['firstname'] . ' ' . $data['lastname'],
                                       'firstname' => $data['firstname'],
                                       'lastname' => $data['lastname'],
                                       'email_address' => $data['email_address'],
                                       'type' => $type,
                                       'type_id' => $type_id,
                                       'login' => true);

            $email_from = $config_cls->getKey('general_contact_email');
            $mail = new PHPMailer();
            $nd = '<h3 style="font-size: 16px; color: #2f2f2f;"> Retrieve Your Password </h3>
                                                           <div style="margin-top:12px;font-size: 14px;">
                                                               Welcome to bidRhino
                                                           </div>
                                                           <div style="margin-top:20px">
                                                               Your new password : ' . $pw . '
                                                           </div>';

            $banner = getBannerByAgentId($_SESSION['agent']['id']);
            sendEmail_func($email_from, $data['email_address'], $nd, 'Your new password.', $banner);

        } 
        //insert or update token facebook
        if (FD_hasID($email)) { //update
            $fb_info['agent_id'] = $_SESSION['agent']['id'];
            $fb_detail_cls->update($fb_info,
                                   'email_address = \'' . $agent_cls->escape($email) . '\'');
        } else { //insert
            $fb_info['email_address'] = $agent_cls->escape($email);
            $fb_info['agent_id'] = $_SESSION['agent']['id'];
            $fb_detail_cls->insert($fb_info);
        }
        out(1, '', $_SESSION['agent']);
    } else {
        out(0, 'Email is invalid!');
    }
} else { //add account
    $agent = FD_getInfo($email);
    $row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
                                      FROM " . $agent_cls->getTable() . " AS agt," . $agent_cls->getTable('agent_type') . " AS agt_type
                                      WHERE agt.type_id = agt_type.agent_type_id
                                      AND agt.agent_id = '" . $agent['agent_id'] . "'", true);
    if ($row['is_active'] == 0) {
        out(0, 'Your account active yet.');
    }

    $_SESSION['agent'] = array('id' => $row['agent_id'],
                               'full_name' => strlen($row['firstname'] . ' ' . $row['lastname']) > 300
                                       ? safecontent($row['firstname'] . ' ' . $row['lastname'], 300) . '...'
                                       : $row['firstname'] . ' ' . $row['lastname'],
                               'firstname' => $row['firstname'],
                               'lastname' => $row['lastname'],
                               'email_address' => $row['email_address'],
                               'type' => $row['type'],
                               'type_id' => $row['type_id'],
                               'login' => true);


    out(1, '', $_SESSION['agent']);
}


?>