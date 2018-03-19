<?php

include_once ROOTPATH.'/modules/general/inc/user_online.php';
if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->logout();

$_SESSION['agent'] = array();
unset($_SESSION['agent']);
unset($_SESSION['fb_info']);
unset($_SESSION['item_number']);
//session_destroy();
$tw_cls->logout();
//$fb_cls->logout();

redirect(ROOTURL);
?>