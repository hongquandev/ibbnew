<?php
include_once(ROOTPATH . "/includes/class.phpmailer.php");
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/cms/inc/cms.php';
include_once ROOTPATH . '/includes/recaptchalib.php';
include_once ROOTPATH . '/modules/general/inc/sendmail.php';
$mail = new PHPMailer();
$action = getQuery('action');
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
if ($action == 'contacts') {
    $captcha_enable = $config_cls->getKey('captcha_enable');
    $captcha_error = '';
    $error = false;
    $captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $captcha_error);
    if (isHttps() && $config_cls->getKey('general_secure_url_enable')) {
        $captcha_form = str_replace('http://', 'https://', $captcha_form);
    }
    $smarty->assign('captcha_form', $captcha_form);
    $smarty->assign('captcha_enable', $captcha_enable);
    if (isset($_SESSION['agent']['id'])) {
        $row = $agent_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
        $db_checkpartner = array();
        if (is_array($row) and count($row) > 0) {
            $db_checkpartner = $row;
        }
        $smarty->assign('db_checkpartner', $db_checkpartner);
    }
    $agent = $_SESSION['agent'];
    $name = $agent['firstname'] . " " . $agent['lastname'];
    $email = $agent['email_address'];
    $smarty->assign('name', $name);
    $smarty->assign('email', $email);
    $smarty->assign('countview', 'countview');
    $smarty->assign('action', $_GET['action']);
    $smarty->assign('part2', "../modules/contacts/");
    $smarty->assign('imagepart', "../modules/general/templates/images/");
    $smarty->assign('module', "../modules/general/templates/style/");
    $smarty->assign('ROOTPATH', ROOTPATH);
}
// Get Datetime Now
$today = getdate();
$currentDate = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"] . "-"
    . $today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];
//If the form is submitted
if (isset($_POST['ok'])) {
    //BEGIN CAPTCHA
    if ($captcha_enable == 1) {
        if (getPost('recaptcha_response_field')) {
            $resp = recaptcha_check_answer($config_cls->getKey('captcha_private_key'),
                $_SERVER["REMOTE_ADDR"],
                getPost('recaptcha_challenge_field'),
                getPost('recaptcha_response_field'));
            if ($resp->is_valid) {
                //echo "You got it!";
            } else {
                # set the error code so that we can display it
                $captcha_error = $resp->error;
                $message = 'Please input correct Captcha information.';
                $error = true;
            }
        } else {
            $captcha_error = 'Please input information.';
            $message = 'Please input Captcha information.';
            $error = true;
        }
    }
    if (!$error) {
        //Check to make sure that the name field is not empty
        if (trim($_POST['contactname']) == '') {
            $hasError = true;
        } else {
            $name = trim($_POST['contactname']);
        }
        //Check to make sure that the subject field is not empty
        if (trim($_POST['subject']) == '') {
            $hasError = true;
        } else {
            $subject = trim($_POST['subject']);
        }
        //Check to make sure sure that a valid email address is submitted
        if (trim($_POST['email']) == '') {
            $hasError = true;
        } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
            $hasError = true;
        } else {
            $email = trim($_POST['email']);
        }
        //Check to make sure comments were entered
        if (trim($_POST['message']) == '') {
            $hasError = true;
        } else {
            if (function_exists('stripslashes')) {
                $comments = stripslashes(trim($_POST['message']));
            } else {
                $comments = trim($_POST['message']);
            }
        }
        $telephone = trim($_POST['telephone']);
        if (!isset($hasError)) {
            $emailTo = $title; //Put your own email address here
            $nd = '<h3 style="font-size: 16px; color: #2f2f2f;"> Contacts Informations </h3>

                                <div>
                                    <label for="subject" style="font-size:12px; "> <strong style="margin-right:50px;"> Name: </strong></label> ' . $name . '

                                </div>

                                <div>
                                    <label for="subject" style="font-size:12px;"><strong style="margin-right:50px;">Email:</strong> </label> ' . $email . '

                                </div>
                                <div>
                                    <label for="subject" style="font-size:12px; "><strong style="margin-right:40px;">Subject: </strong> </label>' . $subject . '

                                </div>
                                <div>
                                   <label for="subject" style="font-size:12px; "><strong style="margin-right:24px;">Telephone: </strong> </label> ' . $telephone . '

                                </div>
                                <div>
                                  <label for="subject" style="font-size:12px; "><strong style="margin-right:22px;">Comments:</strong></label> ' . $comments . '
                                </div>	';
            $headers = 'From: My Site <' . $email . '>' . "\r\n" . 'Reply-To: ' . $email;
            $emailSent = true;
            $to = $config_cls->getKey('general_contact_email');
            $from = $email;
            sendEmail_func($from, $to, $nd, $_POST['subject']);
            include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
            $log_cls->createLog('contact_us');
            $smarty->assign('emailSent', "emailSent");
            $smarty->assign('name', $name);
        }
    }
} else {
    $smarty->assign('hasError', "hasError");
}
$smarty->assign('error', $error);
$smarty->assign('message', $message);
?>