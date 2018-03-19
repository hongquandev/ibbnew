<?php
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/includes/recaptchalib.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
if (!isset($check)) {
	$check = new CheckingForm();
}
$check->arr = array('firstname','lastname','street','suburb','state','general_contact_partner','website_partner',
					'postcode','country','telephone','mobilephone',
					'email_address','confirm_email_address','license_number','preferred_contact_method',
					'password','password2','security_question','security_answer');

$form_datas = $agent_cls->getFields();
$form_datas[$agent_cls->id] = (int)restrictArgs(getQuery('id',$_SESSION['new_agent']['id']));
$form_datas['password2'] = '';

$form_datas['type_id'] = 2;
$row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent_type')." WHERE title = '".$agent_cls->escape($type)."'",true);
if (is_array($row) and count($row) > 0) {
	$form_datas['type_id'] = $row['agent_type_id'];
}

$captcha_enable = $config_cls->getKey('captcha_enable');
$captcha_error = '';

if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	$datas = $form_datas;
	
	foreach ($datas as $key => $val) {
		if (isset($_POST[$key])) {
			$datas[$key] = $agent_cls->escape($_POST[$key]);
		}
	}

    if ($datas['country'] == 1) {
	    $datas['other_state'] = '';
	}else{
        $datas['state'] = '';
    }

	//begin valid
	$error = false;
	if (!$check->checkEmail($datas['email_address']) || ($datas['email_address'] != getParam('confirm_email_address'))) {
		$error = true;
		$datas['email_address'] = '';
		$message = 'Email invalid!';
	}
	else if (!$check->checkPassword($datas['password'],$datas['password2'])) {
		$error = true;
		$datas['password2'] = '';
		$message = 'Password invalid!';
	}

	if ($config_cls->getKey('general_customer_password_length') > 0 && strlen(trim($datas['password'])) < $config_cls->getKey('general_customer_password_length')) {
		$error = true;
		$message = 'Password\' length must be larger than '.$config_cls->getKey('general_customer_password_length').' characters.';
	}


	//BEGIN CAPTCHA
	if ($captcha_enable == 1 && !$error) {
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
		if ($datas['country'] == 1) {
			if ($agent_cls->invalidRegion(trim($datas['suburb']).' '.trim($datas['state']).' '.trim($datas['postcode']))) {
						$error = true;
						$message = 'Wrong suburb/postcode or state!';
			}
		}			
	}
    if (!$error) {
        /*$row = $agent_cls->getRow('SELECT agent_id FROM '.$agent_cls->getRow().'
                                   WHERE agent_id = '.$_SESSION['new_agent']['id'].' AND email_address = \''.$datas['email_address'].'\'',true);
        if (is_array($row) and count($row) > 0){
            $error = true;
			$datas['email_address'] = '';
			$message = 'Email existed!';
        }*/
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
	} else {
		$datas['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$datas['creation_time'] = date('Y-m-d H:i:s');
		$datas['password'] = encrypt($datas['password']);
		unset($datas[$agent_cls->id]);
		
       if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
			$agent_cls->update($datas,$agent_cls->id.'='.$_SESSION['new_agent']['id']);
	   }else {//new

       }
       $_SESSION['new_agent']['agent'] = $datas;
       $form_datas['password2'] = '';

			if (getPost('sign') == 'finish') {
                $_SESSION['new_agent']['step'] = 3;
				redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='. $_SESSION['new_agent']['step']);
			}
			else {
                $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step'] < $step + 1?$step + 1:$_SESSION['new_agent']['step'];
				redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.($step+1));
			}
			//@header('location:/admin/index.php?module='.$module.'&atcion=list');

		}
}else {//GET for backing
	//begin for updating
	/*$row = $agent_cls->getRow('agent_id='.(int)$_SESSION['new_agent']['id']);
	if ($agent_cls->hasError()) {
		$message = $agent_cls->getError();
	}
	else if (is_array($row) and count($row)) {
		//set form data 
		foreach ($form_datas as $key=>$val) {
			if (isset($row[$key])) {
				$form_datas[$key] = $row[$key];
			}
		}*/
	//NH EDIT
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
       foreach ($form_datas as $key=>$val) {
            if (isset($_SESSION['new_agent']['agent'][$key])) {
                      $form_datas[$key] = $_SESSION['new_agent']['agent'][$key];
                  }
             }
    }
		//$form_action .= '&id='.$form_datas[$agent_cls->id];
		$form_datas['password'] = '';
		//to show to form for updating


		//begin security
		if ($_SESSION['new_agent']['id']>0 and $form_datas[$agent_cls->id] > 0 and  $_SESSION['new_agent']['id'] != $form_datas[$agent_cls->id]) {
			die('Access invalid!');
		}
		//end

	//end
}

$captcha_form = recaptcha_get_html($config_cls->getKey('captcha_public_key'), $captcha_error);

if (!((int)$form_datas['country'] > 0)) {
	$form_datas['country'] = $config_cls->getKey('general_country_default');
}
//print_r($form_datas['state']);
$smarty->assign('options_state',R_getOptions(($form_datas['country'] > 0 ? $form_datas['country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('options_method',AO_getOptions('contact_method'));
$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('subState', subRegion());
$smarty->assign('form_datas',formUnescapes($form_datas));
$smarty->assign('captcha_form',$captcha_form);
$smarty->assign('captcha_enable',$captcha_enable);
$smarty->assign('message',$message);
?>