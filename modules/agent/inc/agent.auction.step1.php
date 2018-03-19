<?php
include_once ROOTPATH.'/includes/recaptchalib.php';
include_once ROOTPATH.'/modules/package/inc/package.php';

if (!isset($check)) {
	$check = new CheckingForm();
}

$check->arr = array('firstname','lastname','email_address','confirm_email_address',/*'password','password2',*/
					'security_question','security_answer');

$form_datas = $agent_cls->getFields();
$form_datas[$agent_cls->id] = (int)restrictArgs(getQuery('id',$_SESSION['new_agent']['id']));

$row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent_type')." WHERE title = '".$agent_cls->escape($type)."'",true);
if (is_array($row) and count($row) > 0) {
	$form_datas['type_id'] = $row['agent_type_id'];
}

$captcha_enable = $config_cls->getKey('captcha_enable');
$captcha_error = '';

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	//set form data (form POST) to $datas
	$datas = $form_datas;

	foreach ($datas as $key => $val) {
		if (isset($_POST[$key])) {
			$datas[$key] = $agent_cls->escape($_POST[$key]);
		}
	}
    $data['package_id'] = 0;
	$package_ar = getPost('package_id');
	if (is_array($package_ar)) {
		$datas['package_id'] = $package_ar[0];
	}
   	$error = false;
	if (!$check->checkEmail($datas['email_address']) || ($datas['email_address'] != getParam('confirm_email_address'))) {
		$error = true;
		$datas['email_address'] = '';
		$message = 'Email invalid!';
	}
	
	/*
	if (!$check->checkPassword($datas['password'],@$_POST['password2'])) {
		$error = true;
		$datas['password2'] = '';
		$message = 'Password invalid!';
	}
	
	
	if ($config_cls->getKey('general_customer_password_length') > 0 && strlen(trim($datas['password'])) < $config_cls->getKey('general_customer_password_length')) {
		$error = true;
		$message = 'Password\' length must be larger than '.$config_cls->getKey('general_customer_password_length').' characters.';
	}
	*/
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
		} elseif ($_POST['recaptcha_version'] == 'v2') {
			$response = recaptcha_http_post_v2(RECAPTCHA_VERIFY_SERVER, "/recaptcha/api/siteverify",
					array(
							'secret' => $config_cls->getKey('captcha_private_key'),
							'remoteip' => $_SERVER["REMOTE_ADDR"],
							'response' => $_POST['response']
					)
			);
			if ($response == 1) {
			} else {
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
        $smarty->assign('message',$message);
	} else {
		$datas['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$datas['creation_time'] = date('Y-m-d H:i:s');

		unset($datas[$agent_cls->id]);
		/*
		if (isset($datas['password']) && strlen($datas['password']) > 0) {
			$datas['password'] = encrypt($datas['password']);
		}
		*/
        if (isset($_SESSION['new_agent']['id']) and $_SESSION['new_agent']['id'] > 0){
			
            $agent_cls->update($datas,$agent_cls->id.'='.$_SESSION['new_agent']['id']);
		}
        $_SESSION['new_agent']['agent'] = $datas;
		$form_datas = $datas;

       	$step = $step + 1;
        $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step']< $step?$step:$_SESSION['new_agent']['step'];
	    redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.$step);

    }

}else {//GET for backing
        //begin for updating
        if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
            $row = $agent_cls->getRow('agent_id='.(int)$_SESSION['new_agent']['id']);
            if ($agent_cls->hasError()) {
                $message = $agent_cls->getError();
            }else if (is_array($row) and count($row)) {
                //set form data
                foreach ($form_datas as $key=>$val) {
                    if (isset($row[$key])) {
                        $form_datas[$key] = $row[$key];
                    }
                }
            }
        }else{
             if(isset($_SESSION['new_agent']['agent']))
                 foreach ($_SESSION['new_agent']['agent'] as $key => $val) {
                      if (isset($_SESSION['new_agent']['agent'][$key])) {
                          $form_datas[$key] = $_SESSION['new_agent']['agent'][$key];
                      }
                 }
        }

            //begin security
            if ($_SESSION['new_agent']['id']>0 and $form_datas[$agent_cls->id] > 0 and  $_SESSION['new_agent']['id'] != $form_datas[$agent_cls->id]) {
                die('Access invalid!');
            }
}

$captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $captcha_error);
if (isHttps() && $config_cls->getKey('general_secure_url_enable')) {
	$captcha_form = str_replace('http://', 'https://', $captcha_form);
}

$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('form_datas',formUnescapes($form_datas));
$smarty->assign('captcha_form',$captcha_form);
$smarty->assign('captcha_enable',$captcha_enable);
$smarty->assign('package_tpl',PK_getPackageRegisterTpl());



?>