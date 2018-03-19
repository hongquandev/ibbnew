<?php
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/includes/recaptchalib.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/agent/inc/company.php';
//unset($_SESSION['block']);
$package_arr = array();
if ($_SESSION['agent']['type'] == 'agent') {
    $package_arr = Agent_getCurrentPackage($_SESSION['agent']['id']);
}
switch ($action_ar[0]) {
    case 'add':
    case 'edit':
        $rows = $agent_cls->getRows('SELECT a.agent_id
                                         FROM ' . $agent_cls->getTable() . ' AS a
                                         WHERE a.parent_id = ' . $_SESSION['agent']['id'], true);
        $ids = array();
        foreach ($rows as $row) {
            $ids[] = $row['agent_id'];
        }
        $form_datas['personal'] = $agent_cls->getFields();
        //if ($_SESSION['agent']['type'] == 'agent'){
        $form_datas['company'] = $company_cls->getFields();
        //}
        $form_datas[$agent_cls->id] = (int)restrictArgs(getQuery('id', 0));
        if ($form_datas[$agent_cls->id] > 0 && !in_array($form_datas[$agent_cls->id], $ids)) {
            redirect(ROOTURL . '/?module=agent&action=add-user');
        }
        if ($form_datas[$agent_cls->id] == 0) {//add account
            if (($package_arr['account_num'] > 0 && count($rows) >= $package_arr['account_num']) || count($package_arr) <= 0) {
                redirect(ROOTURL . '/?module=agent&action=view-user');
            }
        }
        if (!isset($_SESSION['block'][$form_datas[$agent_cls->id]])) {
            $_SESSION['block'][$form_datas[$agent_cls->id]] = array();
        }
        $form_action = '?module=' . $module . '&action=' . $action;
        if ($form_datas[$agent_cls->id] > 0) {
            $row = $agent_cls->getRow('SELECT a.*, logo.logo
                                       FROM ' . $agent_cls->getTable() . ' AS a
                                       LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS logo
                                       ON a.agent_id = logo.agent_id
                                       WHERE a.agent_id = ' . $form_datas[$agent_cls->id], true);
            if (is_array($row) and count($row) > 0) {
                foreach ($row as $key => $value) {
                    $form_datas['personal'][$key] = stripslashes($value);
                }
            }
            //if ($_SESSION['agent']['type'] == 'agent'){
            $row = $company_cls->getRow('agent_id = ' . $form_datas[$agent_cls->id]);
            foreach ($form_datas['company'] as $key => $val) {
                if (strlen($row[$key]) > 0) {
                    $form_datas['company'][$key] = $row[$key];
                }
            }
            //}
            $form_action .= '&id=' . $form_datas[$agent_cls->id];
        } else {
            //if ($_SESSION['agent']['type'] == 'agent'){
            $row = $company_cls->getCRow(array('address', 'suburb', 'state', 'postcode', 'other_state', 'country', 'telephone', 'website'),
                'agent_id = ' . $_SESSION['agent']['id']);
            foreach ($form_datas['company'] as $key => $val) {
                if (strlen($row[$key]) > 0) {
                    $form_datas['company'][$key] = $row[$key];
                }
            }
            //}
        }
        $captcha_enable = $form_datas[$agent_cls->id] == 0 ? $config_cls->getKey('captcha_enable') : 0;
        /*---------------*/
        if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($form_datas['personal'] as $key => $val) {
                if (isset($_POST['field'][$key])) {
                    $datas['personal'][$key] = $_POST['field'][$key];
                } else {
                    $datas['personal'][$key] = $val;
                }
            }
            //if ($_SESSION['agent']['type'] == 'agent'){
            foreach ($_POST['company'] AS $key => $val) {
                $datas['company'][$key] = $val;
            }
            //}
            $datas['personal']['parent_id'] = $_SESSION['agent']['id'];
            $type_arr = AgentType_getArr();
            $datas['personal']['type_id'] = $type_arr[$_SESSION['agent']['type']];
            $error = false;
            if ($datas['personal']['country'] == 1) {
                $datas['personal']['other_state'] = '';
            } else {
                $datas['personal']['state'] = '';
            }
            if (!$error) {
                if ($datas['personal']['country'] == 1) {
                    if ($agent_cls->invalidRegion(trim($datas['personal']['suburb']) . ' ' . trim($datas['personal']['state']) . ' ' . trim($datas['personal']['postcode']))) {
                        $error = true;
                        $message = 'Wrong suburb/postcode or state!';
                    }
                }
            }
            if (isset($datas['company'])) {
                if ($datas['company']['country'] == 1) {
                    $datas['company']['other_state'] = '';
                } else {
                    $datas['company']['state'] = '';
                }
                $datas['company']['description'] = scanContent($datas['company']['description']);
                if (!$error) {
                    if ($datas['company']['country'] == 1) {
                        if ($agent_cls->invalidRegion(trim($datas['company']['suburb']) . ' ' . trim($datas['company']['state']) . ' ' . trim($datas['company']['postcode']))) {
                            $error = true;
                            $message = 'Wrong suburb/postcode or state!';
                        }
                    }
                }
            }
            if (!$check->checkEmail($datas['personal']['email_address']) || ($datas['personal']['email_address'] != $_POST['field']['confirm_email_address'] && $form_datas[$agent_cls->id] == 0)) {
                $error = true;
                $datas['personal']['email_address'] = '';
                $message = 'Email invalid!';
            }
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
            //END
            if (!$error) {
                if ($form_datas[$agent_cls->id] > 0) { //edit
                } else if ($agent_cls->hasEmail($datas['personal']['email_address'])) { //new
                    $error = true;
                    $datas['personal']['email_address'] = '';
                    $message = 'Email existed!';
                }
            }
            //end valid
            //$form_datas['personal']['logo'] = $_SESSION['block'][$form_datas[$agent_cls->id]]['logo'];
            $logo = $form_datas['personal']['logo'];
            $form_datas = $datas;
            $form_datas['agent_id'] = $datas['personal']['agent_id'];
            $form_datas['personal']['logo'] = $logo;
            if ($error) {
                $smarty->assign('message', $message);
            } else {
                $datas['personal']['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $datas['personal']['creation_time'] = date('Y-m-d H:i:s');
                unset($datas['personal'][$agent_cls->id]);
                if ($form_datas[$agent_cls->id] > 0) { //edit
                    $agent_cls->update($datas['personal'], $agent_cls->id . '=' . $form_datas[$agent_cls->id]);
                    if (isset($datas['company']) && count($datas['company']) > 0) {
                        $company_cls->update($datas['company'], $agent_cls->id . '=' . $form_datas[$agent_cls->id]);
                    }
                    $mess = 'Updated successful!';
                } else { //new
                    $confirm = encrypt($datas['personal']['email_address']);
                    $datas['personal']['confirm'] = $confirm;
                    $pass_length = (int)$config_cls->getKey('general_customer_password_length');
                    $pw = strrand($pass_length > 0 ? $pass_length : 6);
                    $datas['personal']['password'] = encrypt($pw);
                    $agent_cls->insert($datas['personal']);
                    $form_action = '?module=' . $module . '&action=' . $action . '&id=' . $agent_cls->insertId();
                    $form_datas['agent_id'] = $agent_cls->insertId();
                    if (isset($datas['company']) && count($datas['company']) > 0) {
                        $datas['company']['agent_id'] = $form_datas[$agent_cls->id];
                        $datas['company']['email_address'] = $datas['personal']['email_address'];
                        $company_cls->insert($datas['company']);
                    }
                    $_SESSION['block'][$form_datas['agent_id']] = $_SESSION['block'][0];
                    unset($_SESSION['block'][0]);
                    $captcha_enable = 0;
                    $mess = 'Added successful! Please check email to finish.';
                    //sendmail confirm
                    $url = ROOTURL . '/?module=agent&action=confirm&key=' . $confirm;
                    $msg_active = 'Click link below to active your account :<a href="' . $url . '">' . $url . '</a>';
                    $username = $datas['personal']['firstname'] . ' ' . $datas['personal']['lastname'] != '' ? 'member'
                        : $datas['personal']['firstname'] . ' ' . $datas['personal']['lastname'];

                    include_once ROOTPATH . '/modules/shorturl/inc/short_url.class.php';
                    $url = ROOTURL . $shortUrl_cls->addShortUrl('/?module=agent&action=confirm&key=' . $confirm);
                    $msg_active = 'Click link below to active your account :<a href="' . $url . '">' . $url . '</a>';
                    $general_contact1_email = $config_cls->getKey('general_contact1_name');
                    $params_email = array('to' => array($datas['personal']['email_address'], $general_contact1_email, $_SESSION['agent']['email_address']));
                    $variables = array('[username]' => $username, '[email]' => $datas['personal']['email_address'], '[password]' => $pw,
                        '[link_active]' => $url,
                        '[msg_active]' => $msg_active,
                        '[key]' => $confirm,
                        '[ROOTURL]' => ROOTURL);
                    sendNotificationByEventKey('user_finished_account', $params_email, $variables);
                    //sendSMSByKey($to_,'finished_account');
                    include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                    $log_cls->createLog('register');
                    //end sendmail
                }
                //insert or update logo
                if (isset($_SESSION['block']) && strlen($_SESSION['block'][$form_datas['agent_id']]['logo']) > 0) {
                    $row = $agent_logo_cls->getRow('agent_id = ' . $form_datas['agent_id']);
                    if (is_array($row) and count($row) > 0) {
                        //@unlink(ROOTPATH.$row['logo']);
                        $agent_logo_cls->update(array('logo' => $_SESSION['block'][$form_datas['agent_id']]['logo']), 'agent_id = ' . $form_datas['agent_id']);
                    } else {
                        $agent_logo_cls->insert(array('agent_id' => $form_datas['agent_id'],
                            'logo' => $_SESSION['block'][$form_datas['agent_id']]['logo']));
                    }
                    //unset($_SESSION['block'][$form_datas['agent_id']]);
                }
                $form_datas['personal']['logo'] = $_SESSION['block'][$form_datas['agent_id']]['logo'];
                if (!$agent_cls->hasError()) $message = $mess;
            }
        }
        $captcha_error = '';
        $captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $captcha_error);
        if (!((int)$form_datas['personal']['country'] > 0)) {
            $form_datas['personal']['country'] = $config_cls->getKey('general_country_default');
        }
        if (!((int)$form_datas['company']['country'] > 0)) {
            $form_datas['company']['country'] = $config_cls->getKey('general_country_default');
        }
        $smarty->assign('options_state', R_getOptions($config_cls->getKey('general_country_default'), array(0 => 'Select...')));
        $smarty->assign('options_country', R_getOptions());
        $smarty->assign('captcha_form', $captcha_form);
        $smarty->assign('captcha_enable', $captcha_enable);
        $smarty->assign('subState', subRegion());
        $smarty->assign('form_datas', formUnescapes($form_datas));
        break;
    case 'view':
        if (getPost('len', 0) > 0) {
            $_SESSION['len'] = (int)restrictArgs(getPost('len'));
        }
        $len = isset($_SESSION['len']) ? $_SESSION['len'] : 30;
        $p = (int)restrictArgs(getQuery('p', 0));
        $p = $p <= 0 ? 1 : $p;
        $rows = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                            a.firstname,
                                            a.lastname,
                                            a.is_active,
                                            a.email_address,
                                            a.agent_id
                                     FROM ' . $agent_cls->getTable() . ' AS a
                                     WHERE a.parent_id = ' . $_SESSION['agent']['id'] . '
                                     ORDER BY a.agent_id DESC
                                     LIMIT ' . ($p - 1) * $len . ',' . $len, true);
        $total_row = $agent_cls->getFoundRows();
        if (is_array($rows) and count($rows) > 0) {
            foreach ($rows as $row) {
                $row['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['status'] = $row['is_active'] == 1 ? 'Active' : 'InActive';
                $row['edit_link'] = ROOTURL . '/index.php?module=agent&action=add-user&id=' . $row['agent_id'];
                $data[] = $row;
            }
        }
        //paging
        $pag_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('/?module=agent&action=' . getParam('action'))
            ->setLayout('link_simple');
        $smarty->assign('pag_str', $pag_cls->layout());
        $smarty->assign('users', $data);
        $smarty->assign('len', $len);
        $smarty->assign('len_ar', PE_getItemPerPage());
        $smarty->assign('review_pagging', (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row : ($p * $len)) . ' (' . $total_row . ' items)');
        $smarty->assign('package_arr', $package_arr);
        $smarty->assign('total_row', $total_row);
        break;
}
?>