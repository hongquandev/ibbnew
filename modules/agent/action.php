<?php
//session_start();
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include_once ROOTPATH . '/includes/pagging.class.php';
include 'lang/agent.en.lang.php';
$action = getParam('action');
include_once ROOTPATH . '/includes/checkingform.class.php';
include_once ROOTPATH . '/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH . '/modules/facebook-twitter/inc/twitter_detail.class.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
include_once ROOTPATH . '/includes/class.phpmailer.php';
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/includes/recaptchalib.php';
include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
include_once ROOTPATH . '/includes/smarty/Smarty.class.php';
include_once ROOTPATH . '/modules/agent/inc/partner.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
include_once ROOTPATH . '/modules/general/inc/ftp.php';
include_once ROOTPATH . '/modules/general/inc/media.php';
include_once ROOTPATH . '/modules/general/inc/user_online.php';
include_once ROOTPATH . '/modules/theblock/inc/background.php';
if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
} else {
    $smarty->compile_dir = ROOTPATH . '/templates_c/';
}
$smarty->assign('MEDIAURL', MEDIAURL);
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
define('SITE_TITLE', $config_cls->getKey('site_title'));
$smarty->assign('site_title_config', $config_cls->getKey('site_title'));
if (!isset($check)) {
    $check = new CheckingForm();
}
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
    $pag_cls = new Paginate();
}
if (eregi('-', $action)) {
    $action_ar = explode('-', $action);
    switch ($action_ar[1]) {
        case 'agent':
            break;
    }
} else {
    switch ($action) {
        case 'reload_captcha':
            $data = array('success' => 1, 'form ' => '', 'error' => '');
            $captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $error);
            $data['error'] = $error;
            $data['form'] = $captcha_form;
            die((_response($data)));
            break;
        case 'exist_email':
            $agent_id = (int)restrictArgs(getParam('agent_id', 0));
            $email = getPost('email');
            $email = $agent_cls->escape($email);
            $jsons = array('error' => 0, 'num_rows' => 0);
            $row = $agent_cls->getRow("email_address = '" . $email . "' AND agent_id != " . $agent_id);
            if (is_array($row) and count($row) > 0) {
                $jsons['num_rows'] = 1;
            }
            echo json_encode($jsons);
            break;
        case 'login':
        case 'log':
            /*$email = getPost('email');
            $password = getPost('password');*/
            $email = getParam('email');
            $password = getParam('password');
            $email = $agent_cls->escape($email);
            $password = $agent_cls->escape($password);
            if (!$check->checkEmail($email) or strlen(trim($password)) == 0) {
            } else {
                $agent_row = $agent_cls->getRow("email_address ='" . $email . "' AND password = '" . encrypt($password) . "'");
                if (is_array($agent_row) and count($agent_row) > 0) {
                    $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $agent_row['type_id'], true);
                    $type = 'buyer';
                    if (is_array($type_row) and count($type_row) > 0) {
                        $type = $type_row['title'];
                    }
                    if ($agent_row['is_active'] == 0) {
                        die(_response(array('error' => 'Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you!')));
                    } else {
                        /*//CHECK CC IS EXIST
                        $row = $agent_creditcard_cls->getRow('agent_id = '.$agent_row['agent_id']);
                        if (!is_array($row) || count($row) <= 0) {
                            //die(_response(array('error' => 'You need to finish your information (ex:creditcard information) before bidding.')));
                        } else {
                        //END*/
                        $fn = $agent_row['firstname'] . ' ' . $agent_row['lastname'];
                        $len = 55;
                        $_SESSION['agent'] = array('id' => $agent_row['agent_id'],
                            'full_name' => strlen($fn) > $len ? safecontent($fn, $len) . '...' : $fn,
                            'firstname' => $agent_row['firstname'],
                            'lastname' => $agent_row['lastname'],
                            'email_address' => $agent_row['email_address'],
                            'type' => $type,
                            'type_id' => $agent_row['type_id'],
                            'login' => true,
                            'parent_id' => $agent_row['parent_id']);
                        //GET INFORMATION TWITTER
                        if (TD_getInfo($row['provider_id']) != null) {
                            $_SESSION['tw_info'] = TD_getInfo($row['provider_id']);
                        }
                        //GET INFROMATION FACEBOOK
                        if (FD_getInfoID($row['agent_id']) != null) {
                            $_SESSION['fb_info'] = FD_getInfoID($row['agent_id']);
                        }
                        if (isset($_SESSION['redirect']) and strlen($_SESSION['redirect']) > 0) {
                            $link = ROOTURL . $_SESSION['redirect'];
                            unset($_SESSION['redirect']);
                        } else {
                            $default_link = ROOTURL . '?module=agent&action=view-dashboard';
                            $link = getParam('re_url', $default_link);
                        }
                        die(_response(array('success' => 1, 'redirect' => $link)));
                    }
                    /*}*/
                }
            }
            die(_response(array('error' => 'Email or password is not valid. Please check again.')));
            break;
        case 'check-info':
            $check_agent = (AI_isBasic($_SESSION['agent']['id'])) ? true : false;
            $result['isBasic'] = $check_agent;
            die(_response($result));
            break;
        default:
            break;
        case 'saveEmail':
            $info = getParam('info');
            if ((int)$info['agent_id'] == 0) $info['agent_id'] = $_SESSION['agent']['id'];
            if ($info['agent_id'] > 0) {
                //valid data
                if ($agent_cls->hasEmail($info['email_agent']) and ($info['button'] != 'Login')) {
                    die(_response(array('error' => 1, 'login' => 1, 'msg' => 'This email address is currently used to identify another iBB\'s user. If it\'s yours, please confirm it with iBB password to login iBB system. Unless, please confirm another email address. Thank you!')));
                }
                //check login
                $email = $info['email_agent'];
                $password = $info['pass'];
                $data = array();
                $row = $agent_cls->getRow("email_address='" . $agent_cls->escape($email) . "' AND password='" . $agent_cls->escape($password) . "'");
                if (is_array($row) and count($row) > 0) {
                    unset($_SESSION['agent']);
                    $_SESSION['agent'] = array('id' => $row['agent_id'],
                        'firstname' => $row['firstname'],
                        'lastname' => $row['lastname'],
                        'full_name' => strlen($row['firstname'] . ' ' . $row['lastname']) > 300 ? safecontent($row['firstname'] . ' ' . $row['lastname'], 300) . '...' : $row['firstname'] . ' ' . $row['lastname'],
                        'email_address' => $row['email_address'],
                        'auction_step' => $row['auction_step'],
                        'maximum_bid' => $row['maximum_bid'],
                        'type' => $type,
                        'type_id' => $row['type_id'],
                        'login' => true);
                    //update information twitter, delete account twitter
                    $tw = $agent_cls->getRow('agent_id = ' . $info['agent_id']);
                    $agent_cls->update(array('provider_id' => $tw['provider_id'], 'allow_twitter' => 1), 'agent_id = ' . $_SESSION['agent']['id']);
                    $agent_cls->delete('agent_id = ' . $info['agent_id']);
                    die(_response(array('success' => 1)));
                } else {
                    if (!$agent_cls->hasEmail($info['email_agent'])) {
                        $data['email_address'] = $info['email_agent'];
                        //get Pass;
                        $pass_length = (int)$config_cls->getKey('general_customer_password_length');
                        $info['pass'] = strlen(trim($info['pass'])) > 0 ? $info['pass'] : encrypt(strrand($pass_length > 0 ? $pass_length : 6));
                        $data['password'] = $info['pass'];
                        $agent_cls->update($data, 'agent_id = ' . $info['agent_id']);
                        $_SESSION['agent']['email_address'] = $info['email_agent'];
                        //send Email
                        $email_from = $config_cls->getKey('general_contact_email');
                        $nd = '<h3 style="font-size: 16px; color: #2f2f2f;"></h3>
                                                           <div style="margin-top:12px;font-size: 14px;">
                                                               Welcome to eBidda
                                                           </div>
                                                           <div style="margin-top:20px">
                                                               <b>Thank you for registering ebidda.com.au.</b><br />
                                                               <b>Your eBidda\'username :</b>' . $data['email_address'] . '<br />
                                                           </div>';
                        //$content =  emailTemplatesSend($nd);
                        $banner = getBannerByAgentId($_SESSION['agent']['id']);
                        $to_ = $data['email_address'];
                        $subject = 'Welcome to ' . SITE_TITLE;
                        sendEmail_func($email_from, $to_, $nd, $subject, $banner);
                        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
                        if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
                            $log_cls = new Email_log();
                        }
                        $log_cls->createLog('register');
                        die(_response(array('success' => 1)));
                    }
                    die(_response(array('error' => 1, 'msg' => 'Password is invalid. Please try again or confirm another email.')));
                }
            } else {
                die(_response(array('error' => 1, 'msg' => 'Please login !')));
            }
            break;
        case 'delete_fb':
            $agent = $_SESSION['agent']['id'];
            $fb_detail_cls->delete('agent_id =' . $agent);
            if (!$fb_detail_cls->hasError()) {
                unset($_SESSION['fb_info']);
                die(_response(array('success' => 1)));
            } else {
                die(_response(array('error' => 1)));
            }
            break;
        case 'delete_tw':
            $provider_id = getParam('provider');
            $twitter_detail_cls->delete("agent_id ='" . $provider_id . "'");
            $agent_cls->update(array('provider_id' => ''),
                'agent_id = ' . $_SESSION['agent']['id']);
            if (!$twitter_detail_cls->hasError() and !$agent_cls->hasError()) {
                unset($_SESSION['tw_info']);
                die(_response(array('success' => 1)));
            } else {
                die(_response(array('error' => 1)));
            }
            break;
        case 'sq_save':
            $new_question = getParam('new_question');
            $rs = array('success' => 0);
            if (strlen($new_question) > 0) {
                $parent_id = 0;
                $row = $agent_option_cls->getRow("code = 'security_question'");
                if (is_array($row) && count($row) > 0) {
                    $parent_id = $row['agent_option_id'];
                }
                $order = 1;
                $row = $agent_option_cls->getRow("title = '" . $new_question . "' AND parent_id = " . (int)$parent_id);
                if (is_array($row) && count($row) > 0) {
                    $rs['msg'] = 'This question is existed.';
                } else {
                    $row = $agent_option_cls->getRow('parent_id = ' . (int)$parent_id . '. ORDER BY `order` DESC');
                    if (is_array($row) && count($row) > 0) {
                        $order = $row['order'] + 1;
                    }
                    $agent_option_cls->insert(array('title' => $new_question,
                        'order' => (int)$order,
                        'code' => str_replace(' ', '', $new_question),
                        'active' => 1,
                        'parent_id' => $parent_id));
                    $rs['success'] = 1;
                    $rs['id'] = $agent_option_cls->insertId();
                    $rs['title'] = $new_question;
                    $rs['msg'] = 'This information has been saved.';
                }
            } else {
                $rs['msg'] = 'Question is required.';
            }
            die(_response($rs));
            break;
        case 'changeStatus':
            global $agent_cls;
            $agent_id = (int)preg_replace('#[^0-9]#', '', isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : 0);
            $status = A_getStatus($agent_id);
            if ($status != '') {
                $status = 1 - (int)$status;
                $status_label = $status == 0 ? 'InActive' : 'Active';
                $agent_cls->update(array('is_active' => $status), 'agent_id=' . $agent_id);
                if (!$agent_cls->hasError()) {
                    $result = array('success' => 1, 'status' => $status_label);
                } else {
                    $result = array('error' => 1);
                }
            } else {
                $result = array('error' => 1);
            }
            die(json_encode($result));
            break;
        case 'partner_info':
            $id = (int)preg_replace('#[^0-9]#', '', isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
            $row = $agent_cls->getRow('SELECT a.agent_id,
                                              a.firstname,
                                              a.website_partner,
                                              a.general_contact_partner,
                                              a.street,
                                              a.suburb,
                                              a.postcode,
                                              a.other_state,
                                              a.telephone,
                                              p.partner_logo,
                                              p.postal_address,
                                              p.postal_suburb,
                                              p.postal_postcode,
                                              p.postal_other_state,
                                              p.description,
                                        (SELECT r1.name
                                        FROM ' . $region_cls->getTable() . ' AS r1
                                        WHERE r1.region_id = a.state) AS state_name,

                                        (SELECT r2.name
                                        FROM ' . $region_cls->getTable() . ' AS r2
                                        WHERE r2.region_id = a.country) AS country_name,

                                        (SELECT r1.name
                                        FROM ' . $region_cls->getTable() . ' AS r1
                                        WHERE r1.region_id = p.postal_state) AS postal_state_name,

                                        (SELECT r2.name
                                        FROM ' . $region_cls->getTable() . ' AS r2
                                        WHERE r2.region_id = p.postal_country) AS postal_country_name

                                       FROM ' . $agent_cls->getTable() . ' AS a
                                       LEFT JOIN ' . $partner_cls->getTable() . ' AS p ON a.agent_id = p.agent_id
                                       WHERE a.agent_id = ' . $id, true);
            if (is_array($row) and count($row) > 0) {
                if (strlen(trim($row['website_partner'])) > 0 && !preg_match('@^(http|https)@', $row['website_partner'])) {
                    $row['website_partner'] = showWebsite($row['website_partner']);
                }
                $row['full_address'] = implode(' ', array($row['suburb'], $row['state_name'], $row['other_state'], $row['postcode'], $row['country_name']));
                $row['full_postal_address'] = implode(' ', array($row['postal_suburb'], $row['postal_state_name'], $row['postal_other_state'], $row['postal_postcode'], $row['postal_country_name']));
                $row['firstname_bar'] = strlen($row['firstname']) > 60 ? substr($row['firstname'], 0, 60) . ' Information...' : $row['firstname'];
                $smarty->assign('company', $row);
            }
            $data['html'] = $smarty->fetch(ROOTPATH . '/modules/agent/templates/partner.popup.tpl');
            die(json_encode($data));
            break;
        case 'upload_logo':
            $path_pre = ROOTPATH . '/store/uploads/banner/images/partner/';
            createFolder($path_pre, 3);
            $sizeLimit = 2 * 1024 * 1024;
            $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
            $result = $uploader->handleUpload($path_pre);
            if (isset($result['success'])) {
                list($width, $height) = getimagesize($path_pre . $result['filename']);
                if ($width > 185 && $height > 154) {
                    if ($width == $height) {
                        $new_width = $new_height = 154;
                    } elseif ($width > $height) { //max:185px
                        $new_width = 185;
                        $new_height = $height * (185 / $width);
                    } else {
                        $new_height = 154;
                        $new_width = $height * (154 / $height);
                    }
                    resizeImage($path_pre . $result['filename'], $new_width, $new_height);
                }
                ftp_mediaUpload($path_pre, $result['filename']);
                $row = $partner_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
                if (is_array($row) and count($row) > 0) {
                    @unlink($row['partner_logo']);
                    ftp_mediaDelete($path_pre, basename($row['partner_logo']));
                }
                $partner_cls->update(array('partner_logo' => $result['filename']), 'agent_id = ' . $_SESSION['agent']['id']);
                $result['nextAction'] = array();
                $result['nextAction']['method'] = 'showLogo';
                $result['nextAction']['args'] = array(
                    'image' => MEDIAURL . '/store/uploads/banner/images/partner/' . $result['filename'],
                    'file_name' => $result['filename'],
                    'ext' => strtolower(end(explode(".", $result['filename']))),
                    'container' => getParam('container')
                );
            } else if (!isset($result['error'])) {
                $result['error'] = 'Error';
            }
            die(_response($result));
            break;
//        case 'upload_logo_block':
//             $agent_id = (int)getParam('id');
//             $df_width = 205;
//             //$df_height = 1000;
//			 $path_pre = '/store/uploads/logo/';
//             $dir = ROOTPATH . $path_pre;
//             createFolder(ROOTPATH.'/store/uploads/logo',2);
//             $sizeLimit = 2 * 1024 * 1024;
//             $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
//             $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
//             $result = $uploader->handleUpload($dir);
//             if (isset($result['success'])) {
//                 list($width, $height) = getimagesize($dir . $result['filename']);
//                 if ($width  > $df_width /*&& $height > $df_height*/){
//                     if ($width == $height) {
//                         $new_width = $new_height = $df_width;
//                     } else/*if ($width > $height)*/ { //max:185px
//                         $new_width = $df_width;
//                         $new_height = $height * ($df_width / $width);
//                     }/* else {
//                         $new_height = $df_height;
//                         $new_width = $height * ($df_height / $height);
//                     }*/
//                     resizeImage($dir . $result['filename'], $new_width, $new_height);
//                 }
//                 if (isset($_SESSION['block'][$agent_id]['logo']) && strlen($_SESSION['block'][$agent_id]['logo']) > 0){
//                     @unlink($_SESSION['block'][$agent_id]['logo']);
//                 }
//                 $_SESSION['block'][$agent_id]['logo'] = $path_pre.$result['filename'];
//                 $result['nextAction'] = array();
//                 $result['nextAction']['method'] = 'showLogo';
//                 $result['nextAction']['args'] = array(
//                     'image' => ROOTURLS . $path_pre . $result['filename'],
//                     'file_name' => $result['filename'],
//                     'ext' => strtolower(end(explode(".", $result['filename'])))
//                 );
//             } else if (!isset($result['error'])) {
//                 $result['error'] = 'Error';
//             }
//             die(_response($result));
//            break;
        case 'upload_banner_agent':
            $default_width = 420;
            $result = uploadLogo($default_width);
            $agent_id = (int)$_SESSION['agent']['id'];
            if (isset($result['nextAction'])) {
                if (isset($_SESSION['auction'][$agent_id]['logo']) && strlen($_SESSION['auction'][$agent_id]['logo']) > 0) {
                    $inforAr = pathinfo($_SESSION['auction'][$agent_id]['logo']);
                    ftp_mediaDelete($inforAr['dirname'], $inforAr['basename']);
                    @unlink($_SESSION['auction'][$agent_id]['logo']);
                }
                $_SESSION['auction'][$agent_id]['logo'] = $result['nextAction']['args']['file_name'];
            }
            die(json_encode($result));
            break;
        case 'upload_logo_block':
            $default_width = 205;
            $result = uploadLogo($default_width);
            $agent_id = (int)getParam('id', $_SESSION['agent']['id']);
            if (isset($result['nextAction'])) {
                if (isset($_SESSION['block'][$agent_id]['logo']) && strlen($_SESSION['block'][$agent_id]['logo']) > 0) {
                    $inforAr = pathinfo($_SESSION['block'][$agent_id]['logo']);
                    ftp_mediaDelete($inforAr['dirname'], $inforAr['basename']);
                    @unlink($_SESSION['block'][$agent_id]['logo']);
                }
                $_SESSION['block'][$agent_id]['logo'] = $result['nextAction']['args']['file_name'];
            }
            die(json_encode($result));
            break;
        case 'prepareRegion':
            $p = (int)restrictArgs(getQuery('p', 1));
            $p = $p <= 0 ? 1 : $p;
            $len = getParam('len', 20);
            $str = '<table cellspacing="0" cellpadding="0" class="tbl-messages">
                                <colgroup>
                                   <col width="500px"/> <col width="120px"/> <col width="120px"/>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <td>Region </td>
                                        <td style="text-align:center">Edit</td>
                                        <td style="text-align:center">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>';
            $page = '';
            $rows = $partner_region_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *,
                                                    (SELECT reg1.name
                                                     FROM ' . $region_cls->getTable() . ' AS reg1
                                                     WHERE reg1.region_id = p.state
                                                     ) AS state_name,

                                                     (SELECT reg1.name
                                                     FROM ' . $region_cls->getTable() . ' AS reg1
                                                     WHERE reg1.region_id = p.country
                                                     ) AS country_name

                                                  FROM ' . $partner_region_cls->getTable() . ' AS p
                                                  WHERE p.agent_id = ' . $_SESSION['agent']['id'] . '
                                                  LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
            $total = $partner_region_cls->getFoundRows();
            $pag_cls->setTotal($total)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setUrl('')
                ->setLayout('ajax')
                ->setFnc('agent.prepareList');
            if (is_array($rows) and count($rows) > 0) {
                foreach ($rows as $row) {
                    $row['region'] = implode(' ', array($row['suburb'], $row['state_name'], $row['other_state'], $row['postcode'], $row['country_name']));
                    $str .= '<tr id="row_' . $row['ID'] . '">
                                <td style="padding-left:5px;">
                                    <strong>' . $row['region'] . '</strong>
                                </td>
                                <td style="text-align:center;"><a href="javascript:void(0)" onclick="agent.editRegion(' . $row['ID'] . ',\'row\')"> Edit </a></td>
                                <td style="text-align:center;"><a  href="javascript:void(0)" onclick="agent.deleteRegion(' . $row['ID'] . ',\'row\')">Delete </a>
                                </td>
                            </tr>';
                }
            }
            $page = '<div class="clearthis"></div>' . $pag_cls->layout();
            $str .= '</tbody></table>' . $page;
            die($str);
            break;
        case 'preparePartner':
            $p = (int)restrictArgs(getQuery('p', 1));
            $p = $p <= 0 ? 1 : $p;
            $len = getParam('len', 20);
            $str = '<table cellspacing="0" cellpadding="0" class="tbl-messages">
                                <colgroup>
                                   <col width="300px"/> <col width="120px"/><col width="120px"/><col width="70px"/><col width="70px"/>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <td>Company </td>
                                        <td>Address </td>
                                        <td>Telephone </td>
                                        <td style="text-align:center">Edit</td>
                                        <td style="text-align:center">Delete</td>
                                    </tr>
                                </thead>
                                <tbody>';
            $page = '';
            $rows = $partner_ref_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
                                                  FROM ' . $partner_ref_cls->getTable() . '
                                                  WHERE agent_id = ' . $_SESSION['agent']['id'] . '
                                                  LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
            $total = $partner_ref_cls->getFoundRows();
            $pag_cls->setTotal($total)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setUrl('')
                ->setLayout('ajax')
                ->setFnc('agent.prepareList');
            if (is_array($rows) and count($rows) > 0) {
                foreach ($rows as $row) {
                    //$row['region'] = implode(' ',array($row['suburb'],$row['state'],$row['other_state'],$row['postcode'],$row['country']));
                    $str .= '<tr id="par_' . $row['ref_id'] . '">
                                <td style="padding-left:5px;">
                                    <strong>' . $row['company_name'] . '</strong>&nbsp;
                                    <br />
                                    <i>' . $row['email_address'] . '</i>&nbsp;
                                </td>
                                <td style="padding-left:5px;">
                                    ' . $row['address'] . '&nbsp;
                                </td>
                                <td style="padding-left:5px;">
                                    ' . $row['telephone'] . '&nbsp;
                                </td>
                                <td style="text-align:center;"><a href="javascript:void(0)" onclick="agent.editRegion(' . $row['ref_id'] . ',\'par\')"> Edit </a></td>
                                <td style="text-align:center;"><a  href="javascript:void(0)" onclick="agent.deleteRegion(' . $row['ref_id'] . ',\'par\')">Delete </a>
                                </td>
                            </tr>';
                }
            }
            $page = '<div class="clearthis"></div>' . $pag_cls->layout();
            $str .= '</tbody></table>' . $page;
            die($str);
            break;
        case 'addRegion':
            $param = getPost('params');
            if ($param['country'] == 1) {
                $param['other_state'] = '';
            } else {
                $param['state'] = '';
            }
            $param['agent_id'] = $_SESSION['agent']['id'];
            $id = (int)restrictArgs($param['ID']);
            unset($param['ID']);
            if ($id == 0) {
                $partner_region_cls->insert($param);
            } else {
                $row = $partner_region_cls->getRow('agent_id = ' . $_SESSION['agent']['id'] . ' AND ID = ' . $id);
                if (is_array($row) and count($row) > 0) {
                    $partner_region_cls->update($param, ' ID = ' . $id);
                } else {
                    die(json_encode(array('msg' => 'You have not permission to edit it.')));
                }
            }
            if ($partner_region_cls->hasError()) {
                die(json_encode(array('msg' => 'Process fail ! Try again.')));
            } else {
                die(json_encode(array('success' => 1)));
            }
            break;
        case 'addPartner':
            $param = getPost('params');
            $param['agent_id'] = $_SESSION['agent']['id'];
            $id = (int)restrictArgs($param['ref_id']);
            unset($param['ref_id']);
            if ($id == 0) {
                $partner_ref_cls->insert($param);
            } else {
                $row = $partner_ref_cls->getRow('agent_id = ' . $_SESSION['agent']['id'] . ' AND ref_id = ' . $id);
                if (is_array($row) and count($row) > 0) {
                    $partner_ref_cls->update($param, ' ref_id = ' . $id);
                } else {
                    die(json_encode(array('msg' => 'You have not permission to edit it.')));
                }
            }
            if ($partner_ref_cls->hasError()) {
                die(json_encode(array('msg' => 'Process fail ! Try again.')));
            } else {
                die(json_encode(array('success' => 1)));
            }
            break;
        case 'deleteRegion':
            $id = (int)restrictArgs(getParam('id'));
            $row = $partner_region_cls->getRow("ID = '{$id}' AND agent_id = {$_SESSION['agent']['id']}");
            if (is_array($row) and count($row) > 0) {
                $partner_region_cls->delete("ID = '{$id}'");
                die(json_encode(array('success' => 1)));
            }
            die(json_encode(array('msg' => 'You have not permission to delete it!')));
            break;
        case 'editRegion':
            $id = (int)restrictArgs(getParam('id'));
            $row = $partner_region_cls->getRow("ID = '{$id}' AND agent_id = {$_SESSION['agent']['id']}");
            if (is_array($row) and count($row) > 0) {
                die(json_encode($row));
            }
            die(json_encode(array('msg' => 'You have not permission to edit it!')));
            break;
        case 'deletePartner':
            $id = (int)restrictArgs(getParam('id'));
            $row = $partner_ref_cls->getRow("ref_id = '{$id}' AND agent_id = {$_SESSION['agent']['id']}");
            if (is_array($row) and count($row) > 0) {
                $partner_ref_cls->delete("ref_id = '{$id}'");
                die(json_encode(array('success' => 1)));
            }
            die(json_encode(array('msg' => 'You have not permission to delete it!')));
            break;
        case 'editPartner':
            $id = (int)restrictArgs(getParam('id'));
            $row = $partner_ref_cls->getRow("ref_id = '{$id}' AND agent_id = {$_SESSION['agent']['id']}");
            if (is_array($row) and count($row) > 0) {
                die(json_encode($row));
            }
            die(json_encode(array('msg' => 'You have not permission to edit it!')));
            break;
        case 'loadRef':
            $row = $partner_cls->getRow('SELECT contact_references
                                             FROM ' . $partner_cls->getTable() . '
                                             WHERE agent_id = ' . $_SESSION['agent']['id'], true);
            if (is_array($row) and count($row) > 0) {
                die(json_encode($row));
            }
            die(json_encode(array()));
        case 'checkUser':
            $key = $agent_cls->escape(getParam('key', ''));
            $site_id = restrictArgs(getParam('site', 0));
            $site_id = $site_id > 0 ? $site_id : 0;
            $result = Agent_checkValidSite($key, $site_id, $message);
            if ($result) {
                die(json_encode(array('avai' => 1)));
            } else {
                die(json_encode(array('unavai' => 1, 'msg' => $message)));
            }
            /*$rows = $website_cls->getRow("name = '{$key}' AND agent_id != {$_SESSION['agent']['id']}");
            if ((is_array($rows) and count($rows) > 0) || in_array($key,array('dev','www','mdev','m','facebook','fb'))){
                die(json_encode(array('unavai'=>1)));
            }else{
                die(json_encode(array('avai'=>1)));
            }
            break;*/
            break;
        case 'upload_background_left':
        case 'upload_background_right':
        case 'upload_background_top':
            $action_ar = explode('_', $action);
            if (!(isset($_SESSION['agent']) && $_SESSION['agent']['id'] > 0)) {
                die(json_encode(array('error' => 'Please login first!')));
            }
            $target = getParam('target');
            $sizeLimit = 5 * 1024 * 1024;
            $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
            $path = ROOTPATH . '/store/uploads/background';
            $path_relative = '/store/uploads/background';
            createFolder($path, 2);
            createFolder($path . '/thumbs', 1);
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
            $result = $uploader->handleUpload($path . '/img/');
            if (isset($result['success'])) {
                switch ($action_ar[2]) {
                    case 'left':
                    case 'right':
                        resizeImgByPercent($path . '/img/' . $result['filename'],
                            $path . '/thumbs/' . $result['filename'],
                            136, 0
                        );
                        $ftp_path = ftp_getPath($path);
                        ftp_mediaUpload($path . '/img/', $result['filename']);
                        $ftp_cls->copyFile($path . '/thumbs/' . $result['filename'], $ftp_path . '/thumbs');
                        break;
                    case 'top':
                        list($width, $height) = getimagesize($path . '/img/' . $result['filename']);
                        if ($width > 376) {
                            resizeImgByPercent($path . '/img/' . $result['filename'],
                                $path . '/img/' . $result['filename'],
                                376, 0
                            );
                            list($width, $height) = getimagesize($path . '/' . $result['filename']);
                        } elseif ($height > 79) {
                            resizeImgByPercent($path . '/img/' . $result['filename'],
                                $path . '/' . $result['filename'],
                                0, 79
                            );
                        } else {
                            resizeImgByPercent($path . '/img/' . $result['filename'],
                                $path . '/img/' . $result['filename'],
                                $width, $height
                            );
                        }
                        ftp_mediaUpload($path . '/img/', $result['filename']);
                        break;
                }
                $_SESSION['agent']['bg'][$action_ar[2]] = $result['filename'];
                $result['nextAction'] = array();
                $result['nextAction']['method'] = $action_ar[2] == 'top' ? 'viewLogo' : 'viewBackground';
                $result['nextAction']['args'] = array('target' => $target,
                    'image' => $action_ar[2] == 'top' ? MEDIAURL . $path_relative . '/img/' . $result['filename'] : MEDIAURL . $path_relative . '/thumbs/' . $result['filename'],
                    'type' => 'background_' . $action_ar[2]
                );
                die(_response($result));
            } else {
                die(_response($result));
            }
            break;
        case 'viewAgent':
            $agent_id = restrictArgs(getParam('uid', 0));
            $p = restrictArgs(getParam('p', 1));
            $p = $p <= 0 ? 1 : $p;
            $len = 3;
            //SUB ACCOUNT
            $sub_agent = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname
                                                  , a.lastname,
                                                  l.logo,
                                                  a.agent_id,
                                                  c.suburb,
                                                  c.other_state,
                                                  c.postcode,
                                                  c.telephone,
                                                  c.address,
                                                  c.website,
                                                 (SELECT r1.code
                                                  FROM ' . $region_cls->getTable('regions') . ' AS r1
                                                  WHERE r1.region_id = c.state) AS state_code,

                                                 (SELECT r2.name
                                                  FROM ' . $region_cls->getTable('regions') . ' AS r2
                                                  WHERE r2.region_id = c.country) AS country_name
                                              FROM ' . $agent_cls->getTable() . ' AS a
                                              LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS l
                                              ON a.agent_id = l.agent_id
                                              LEFT JOIN ' . $company_cls->getTable() . ' AS c
                                              ON a.agent_id = c.agent_id
                                              WHERE IF(a.parent_id > 0,a.parent_id = ' . $agent_id . ',a.agent_id = ' . $agent_id . ') AND a.is_active = 1
                                              ORDER BY a.agent_id ASC
                                              LIMIT ' . ($p - 1) * $len . ',' . $len, true);
            $total_row = $agent_cls->getFoundRows();
            $pag_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(5)
                ->setUrl('/modules/agent/action.php?action=viewAgent&uid=' . $agent_id)
                ->setLayout('ajax')
                ->setFnc('viewAgent');
            $smarty->assign('mode', $mode);
            $smarty->assign('sub_pag_str', $pag_cls->layout());
            if (is_array($sub_agent) and count($sub_agent) > 0) {
                foreach ($sub_agent as $row) {
                    $row['website'] = str_replace(array('http://', 'https://'), '', $row['website']);
                    $row['logo'] = strlen($row['logo']) > 0 ? $row['logo'] : '/modules/general/templates/images/photo_default.jpg';
                    $row['parent_id'] = $row['parent_id'] == 0 ? $row['agent_id'] : $row['parent_id'];
                    $row['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
                    $row['full_address'] = $row['address'] . '<br />' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], '<br />' . $row['country_name']));
                    $sub_account[] = $row;
                }
            }
            $smarty->register_block('seo', 'smarty_url', false);
            $smarty->assign('sub_account', $sub_account);
            $data = $smarty->fetch(ROOTPATH . '/modules/agent/templates/agent.detail.agent-list.tpl');
            die($data);
            break;
        case 'delete_background_top':
        case 'delete_background_left':
        case 'delete_background_right':
            $action_ar = explode('_', $action);
            $row = $background_cls->getCRow(array('background_id', 'link'), "type = '{$action_ar[2]}' AND agent_id = " . $_SESSION['agent']['id']);
            if (is_array($row) and count($row) > 0) {
                $background_cls->delete('background_id = ' . $row['background_id']);
                if (is_file(ROOTPATH . '/store/uploads/background/img/' . $row['link'])) {
                    @unlink(ROOTPATH . '/store/uploads/background/img/' . $row['link']);
                }
                if (is_file(ROOTPATH . '/store/uploads/background/thumbs/' . $row['link'])) {
                    @unlink(ROOTPATH . '/store/uploads/background/thumbs/' . $row['link']);
                }
            }
            unset($_SESSION['agent']['bg']);
            die(json_encode(array('success' => 1)));
            break;
        /*-----------------TRANSACT STEP-----------------*/
        case 'transact_step_3':
            $result = array('success' => 1, 'message' => '', 'html' => '');
            $agent_id = getParam('agent_id', 0);
            $property_id = $_SESSION['registerToTransact_id'];
            if ($agent_id == 0) {
                $agent_id = !empty($_SESSION['agent']['id']) ? $_SESSION['agent']['id'] : 0;
            }
            if ($agent_id > 0 && $property_id > 0) {
                $smarty->assign('agent_id', getParam('agent_id'));
                $isRental = PE_isRentProperty($property_id);
                //$result['html'] = $smarty->fetch(ROOTPATH.'/modules/agent/templates/agent.'.$isRental?'rental':'sales'.'.user_declaration.tpl');
            } else {
                $result['success'] = 0;
                $result['message'] = 'Can not processing data';
            }
            die(json_encode($result));
            break;
        case 'submit_application':
            $result = array('success' => 1, 'message' => '', 'html' => '');
            $agent_id = getParam('agent_id', 0);
            if ($_SESSION['registerToTransact_id'] > 0 && $agent_id > 0) {
                $result['redirect_link'] = ROOTURL . '/?module=payment&action=option&type=bid&item_id=' . $_SESSION['registerToTransact_id'] . '&agent_id=' . $agent_id;
            } else {
                $result['success'] = 0;
                $result['message'] = 'Not processing.';
            }
            die(json_encode($result));
            break;
        case 'save_application':
            $result = array('success' => 1, 'message' => '', 'html' => '');
            $agent_id = getParam('agent_id', 0);
            if ($_SESSION['registerToTransact_id'] > 0 && $agent_id > 0) {
                $result['redirect_link'] = PE_getUrl($_SESSION['registerToTransact_id']);
            } else {
                $result['success'] = 0;
                $result['message'] = 'Not processing.';
            }
            die(json_encode($result));
            break;
    }
}
function uploadLogo($default_width)
{
    $path_pre = '/store/uploads/logo/';
    $dir = ROOTPATH . $path_pre;
    createFolder(ROOTPATH . '/store/uploads/logo', 2);
    $sizeLimit = 2 * 1024 * 1024;
    $allowedExtensions = array('gif', 'jpg', 'jpeg', 'bmp', 'png');
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, false);
    $result = $uploader->handleUpload($dir);
    if (isset($result['success'])) {
        list($width, $height) = getimagesize($dir . $result['filename']);
        if ($width > $default_width) {
            if ($width == $height) {
                $new_width = $new_height = $default_width;
            } else {
                $new_width = $default_width;
                $new_height = $height * ($default_width / $width);
            }
            resizeImage($dir . $result['filename'], $new_width, $new_height);
        }
        ftp_mediaUpload($dir, $result['filename']);
        $result['nextAction'] = array();
        $result['nextAction']['method'] = 'showLogo';
        $result['nextAction']['args'] = array(
            'image' => MEDIAURL . $path_pre . $result['filename'],
            'file_name' => $path_pre . $result['filename'],
            'ext' => strtolower(end(explode(".", $result['filename']))),
            'container' => getParam('container')
        );
    } else if (!isset($result['error'])) {
        $result['error'] = 'Error';
    }
    return $result;
}

?>