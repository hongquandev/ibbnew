<?php
include_once ROOTPATH . '/modules/facebook-twitter/inc/twitter_detail.class.php';
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.fb_detail.class.php';

$email = getParams('username', "");
$password = getParams('password', "");
if (count($email) > 0 && count($password) > 0) {
    $password = encrypt($password);

    $row = $agent_cls->getRow("email_address='" . $agent_cls->escape($email) . "' AND password='" . $agent_cls->escape($password) . "'");
    if ($agent_cls->hasError()) {
        out(0,'Login failed!');
    } else if (is_array($row) and count($row) > 0) {
        if ($row['is_active'] == 0) {
            out(0,'Your account is not activated yet.');
        } else {
            $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $row['type_id'], true);

            $type = 'buyer';
            if (is_array($type_row) and count($type_row) > 0) {
                $type = $type_row['title'];
            }

            $fn = $row['firstname'] . ' ' . $row['lastname'];
            $len = 60;
            $_SESSION['agent'] = array('id' => $row['agent_id'],
                                       'agent_id' => $row['agent_id'],
                                       '3x_id' => $row['agent_id'],
                                       'full_name' => strlen($fn) > $len ? safecontent($fn, $len) . '...' : $fn,
                                       'firstname' => $row['firstname'],
                                       'lastname' => $row['lastname'],
                                       'email_address' => $row['email_address'],
                                       'auction_step' => $row['auction_step'],
                                       'maximum_bid' => $row['maximum_bid'],
                                       'type' => $type,
                                       'type_id' => $row['type_id'],
                                       'login' => true,
                                       'parent_id' => $row['parent_id']);


            out(1,'',$_SESSION['agent']);
        }
    } else {
         out(0,'The email address or password is not valid for this account, please try again.');
    }
}

 out(0,'Please enter email and password!');

?>