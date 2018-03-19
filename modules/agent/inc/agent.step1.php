<?php
include_once ROOTPATH . '/includes/recaptchalib.php';
if (!isset($check)) {
    $check = new CheckingForm();
}
$check->arr = array('firstname', 'lastname', 'street', 'suburb', 'state',
    'postcode', 'country', 'telephone', 'mobilephone',
    'email_address', 'confirm_email_address', 'license_number', 'preferred_contact_method',
    'password', 'password2', 'security_question', 'security_answer');
$form_datas = $agent_cls->getFields();
$form_datas[$agent_cls->id] = (int)restrictArgs(getQuery('id', $_SESSION['new_agent']['id']));
$form_datas['password2'] = '';
$form_datas['type_id'] = 2;
$row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE title = '" . $agent_cls->escape($type) . "'", true);
if (is_array($row) and count($row) > 0) {
    $form_datas['type_id'] = $row['agent_type_id'];
}
$captcha_enable = $config_cls->getKey('captcha_enable');
$captcha_error = '';
$_POST['email_address'] = strtolower($_POST['email_address']);
$package_id = getParam('pid', '');
$packageId = new_decrypt($package_id);
if (is_numeric($packageId)) {
    $encryptPackageId = new_encrypt($packageId);
    $_SESSION['new_agent']['redirect_url'] = ROOTURL . '/?module=property&action=register&pid=' . $encryptPackageId;
}
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
    //set form data (form POST) to $datas
    $datas = $form_datas;
    foreach ($datas as $key => $val) {
        if (isset($_POST[$key])) {
            $datas[$key] = $agent_cls->escape($_POST[$key]);
        }
    }
    // For Auto update contact info
    $datas['auto_update_contact'] = 0;
    if (isset($_POST['auto_update_contact'])) {
        $datas['auto_update_contact'] = 1;
        $row = $datas;
        if (count($row) > 0 and is_array($row)) {
            // Auto add information into contact fields
            $_SESSION['new_agent']['contact'] = array();
            foreach ($row as $key => $val) {
                $_SESSION['new_agent']['contact'][$key] = $val;
            }
            $_SESSION['new_agent']['contact']['name'] = $row['firstname'] . ' ' . $row['lastname'];
            $_SESSION['new_agent']['contact']['address'] = $row['street'];
            $_SESSION['new_agent']['contact']['email'] = $row['email_address'];
        }
    }
    if ($_POST['state'] > 0 && $_POST['country'] == 1) {
        $datas['other_state'] = '';
    }
    if ($_POST['other_state'] != '' && $_POST['country'] > 1) {
        //$datas['other_state'] = $_POST['other_state'];
        $datas['state'] = '';
    }
    //begin valid
    $error = false;
    if (!$check->checkEmail($datas['email_address']) || ($datas['email_address'] != strtolower(getParam('confirm_email_address')))) {
        $error = true;
        $datas['email_address'] = '';
        $message = 'Email invalid!';
    } else if (!$check->checkPassword($datas['password'], $datas['password2'])) {
        $error = true;
        $datas['password2'] = '';
        $message = 'Password invalid!';
    }
    if ($config_cls->getKey('general_customer_password_length') > 0 && strlen(trim($datas['password'])) < $config_cls->getKey('general_customer_password_length')) {
        $error = true;
        $message = 'Password\' length must be larger than ' . $config_cls->getKey('general_customer_password_length') . ' characters.';
    }
    //BEGIN CAPTCHA
    $captcha_error = false;
    if ($captcha_enable == 1) {
        if (getPost('recaptcha_response_field') && $_POST['recaptcha_version'] != 'v2') {
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
                $captcha_error = $error = true;
            }
        } elseif ($_POST['recaptcha_version'] == 'v2') {
            $response = recaptcha_http_post_v2(RECAPTCHA_VERIFY_SERVER, "/recaptcha/api/siteverify",
                array('secret' => $config_cls->getKey('captcha_private_key'),
                    'remoteip' => $_SERVER["REMOTE_ADDR"],
                    'response' => $_POST['response']
                )
            );
            if ($response == 1) {
            } else {
                $message = 'Please input correct Captcha information.';
                $captcha_error = $error = true;
            }
        } elseif(!empty($_POST['response']) || !empty($_POST['recaptcha_response_field'])) {
            $captcha_error = 'Please input information.';
            $message = 'Please input Captcha information.';
            $captcha_error = $error = true;
        }
    }
    //END
    if (!$error) {
        if ($datas['country'] == 1 && !empty($datas['suburb']) && !empty($datas['state']) && !empty($datas['postcode'])) {
            if ($agent_cls->invalidRegion(trim($datas['suburb']) . ' ' . trim($datas['state']) . ' ' . trim($datas['postcode']))) {
                $error = true;
                $message = 'Wrong suburb/postcode or state!';
            }
        }
    }
    if (!$error) {
        if ($form_datas[$agent_cls->id] > 0) {//edit
        } else if ($agent_cls->hasEmail(getPost('email_address'))) {//new
            $error = true;
            $datas['email_address'] = '';
            $message = 'Email existed!';
        }
    }
    //end valid
    if ($error) {
        $form_datas = $datas;
        $smarty->assign('message', $message);
    } else {
        $datas['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $datas['creation_time'] = date('Y-m-d H:i:s');
        $pass = $datas['password'];
        $datas['password'] = encrypt($datas['password']);
        unset($datas[$agent_cls->id]);
        /*AUTO CHECKED NOTIFICATION OPTION
        */
        $datas['notify_email'] = 1;
        $datas['notify_email_bid'] = 1;
        $datas['notify_sms'] = 1;
        $datas['subscribe'] = 1;
        /*if ($form_datas[$agent_cls->id]>0) {*///update
        if (isset($_SESSION['new_agent']['id']) and $_SESSION['new_agent']['id'] > 0) {
            $agent_cls->update($datas, $agent_cls->id . '=' . $_SESSION['new_agent']['id']);
            //$form_action .= '&id='.$form_datas[$agent_cls->id];
        } else {
        }
        $_SESSION['new_agent']['agent'] = $datas;
        $form_datas = $datas;
        if (getPost('sign') == 'finish') {
            $_SESSION['new_agent']['step'] = 3;
            redirect(ROOTURL . '?module=' . $module . '&action=' . $action . '&step=3');
        } else {
            if(getParam('kind','none') == 'transact'){
                //redirect(ROOTURL . '?module=' . $module . '&action=' . $action . '&step=' . $step);
            }else{
                $step = $step + 1;
                $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step'] < $step ? $step : $_SESSION['new_agent']['step'];
                redirect(ROOTURL . '?module=' . $module . '&action=' . $action . '&step=' . $step);
            }
        }
        //@header('location:/admin/index.php?module='.$module.'&atcion=list');
    }
} else {//GET for backing
    //begin for updating
    if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0) {
        $row = $agent_cls->getRow('agent_id=' . (int)$_SESSION['new_agent']['id']);
        if ($agent_cls->hasError()) {
            $message = $agent_cls->getError();
        } else if (is_array($row) and count($row)) {
            //set form data
            foreach ($form_datas as $key => $val) {
                if (isset($row[$key])) {
                    $form_datas[$key] = $row[$key];
                }
            }
        }
    } else {
        if (isset($_SESSION['new_agent']['agent']))
            foreach ($_SESSION['new_agent']['agent'] as $key => $val) {
                if (isset($_SESSION['new_agent']['agent'][$key])) {
                    $form_datas[$key] = $_SESSION['new_agent']['agent'][$key];
                }
            }
    }
    $form_datas['auto_update_contact'] = 1;
    //$form_action .= '&id='.$form_datas[$agent_cls->id];
    $form_datas['password'] = '';
    //to show to form for updating
    //begin security
    if ($_SESSION['new_agent']['id'] > 0 and $form_datas[$agent_cls->id] > 0 and $_SESSION['new_agent']['id'] != $form_datas[$agent_cls->id]) {
        die('Access invalid!');
    }
    //end
    //end
    //$smarty->assign('agent_id', (int)$_SESSION['new_agent']['id']);
}
$captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $captcha_error);
if (isHttps() && $config_cls->getKey('general_secure_url_enable')) {
    $captcha_form = str_replace('http://', 'https://', $captcha_form);
}
if (!((int)$form_datas['country'] > 0)) {
    $form_datas['country'] = $config_cls->getKey('general_country_default');
}
//print_r($form_datas['state']);
$smarty->assign('options_yes_no', array('0' => 'No', '1' => 'Yes'));
$smarty->assign('options_state', R_getOptions(($form_datas['country'] >= 0 ? $form_datas['country'] : -1), array(0 => 'Select...')));
$smarty->assign('options_country', R_getOptions());
$smarty->assign('options_method', AO_getOptions('contact_method'));
$smarty->assign('options_question', AO_getOptions('security_question'));
$smarty->assign('form_datas', formUnescapes($form_datas));
$smarty->assign('captcha_form', $captcha_form);
$smarty->assign('captcha_enable', $captcha_enable);
$smarty->assign('subState', subRegion());
?>