<?php
//view,edit,add for account
include_once 'agent.php';
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/general/inc/getbanner.php';

//UPDATE INFORMATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['field']) and is_array($_POST['field']) and count($_POST['field']) > 0) {
		$check->arr = array('current_password','new_password','confirm_new_password');
		if (!$check->checkForm()) {
			$check->showRed();
			$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields.";
			
		} else if ($_POST['field']['new_password'] != $_POST['field']['confirm_new_password']) {
		
			$message = 'New password and Confirm new password is not equivalent.';
		} else if ($config_cls->getKey('general_customer_password_length') > 0 && strlen(trim($_POST['field']['new_password'])) < $config_cls->getKey('general_customer_password_length')) {
			$message = 'New password\' length must be larger than '.$config_cls->getKey('general_customer_password_length').' characters.';
		} else {
			$row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']." AND password = '".$agent_cls->escape(encrypt($_POST['field']['current_password']))."'");
			
			if (is_array($row) and count($row)>0 and strlen(trim($_POST['field']['new_password']))>0) {
				$data = array('password'=>encrypt(trim($_POST['field']['new_password'])));
				$agent_cls->update($data,'agent_id='.$_SESSION['agent']['id']);
						
				if ($agent_cls->hasError()) {
					$message = $agent_cls->getError();
				}
				else {

                    $lkB = getBannerByAgentId($row['agent_id']);
                    $from_ = $config_cls->getKey('general_contact_email');
                    $to_ = A_getEmail($_SESSION['agent']['id']);
                    $subject = $config_cls->getKey('email_forgot_password_subject');
                    $nd = $config_cls->getKey('email_forgot_password_msg');
                    $username = 'Member';
                    $nd = str_replace(array('[username]','[email]','[password]'),array($username,$to_,$_POST['field']['new_password']),$nd);
                    $content = emailTemplatesSendBanner($nd,$lkB);
                    $mess = sendEmail_func($from_,$to_,$content,$subject,'','',true);
                    //sendSMSByKey($to_,'forgot_password');
                    include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
                    if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
                        $log_cls = new Email_log();
                    }
                    $log_cls->createLog('agent_account');

					$message = 'Updated successfully.';
				}
			}
			else {
				$message = 'Your current password is invalid.';
			}
		}
	}
}


?>