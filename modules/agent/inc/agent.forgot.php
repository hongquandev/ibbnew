<?php

include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/general/inc/getbanner.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']) and is_array($_POST['fields'])) {
		$email = $_POST['fields']['username'];
        $allow_fb_tw = $_POST['fields']['allow_twitter_facebook'];
        $allow = false;
        $message = 'Email is not exist.';
        if($allow_fb_tw == 1)
        {
            $row = $agent_cls->getRow("email_address = '".$agent_cls->escape($email)."'");
            if(is_array($row) and count($row) > 0)
            {
                if($row['allow_facebook'] == 1 OR $row['allow_twitter'] == 1)
                {
                    $allow = true;
                }
                else
                {
                    $allow = false;
                    $message = 'Your account is not Facebook/Twitter';
                }
            }

        }
        else{
            $security_question = $_POST['fields']['security_question'];
            $security_answer = $_POST['fields']['security_answer'];
            $row = $agent_cls->getRow("email_address = '".$agent_cls->escape($email)."' AND security_question =".$security_question." AND security_answer ='".$security_answer."'");
            if ($agent_cls->hasError()) {
		    } else if (is_array($row) and count($row)>0) {
                $allow = true;
            }
            else
            {
                 $allow = false;
                 $message = 'Email or security answer is not correct.';
            }

        }

        if($allow)
        {
			$sqlexe ='SELECT * FROM agent WHERE agent_id='.$row['agent_id'].'';
			$rowexe = $agent_cls->getRow($sqlexe,true);

			$password = strrand(6);
			$agent_cls->update(array('password'=>encrypt($password)),'agent_id='.$row['agent_id']);
            $lkB = getBannerByAgentId($row['agent_id']);
            $from_ = $config_cls->getKey('general_contact_email');
            $to_ = $email;
            //$subject = 'Your new password.';
            $subject = $config_cls->getKey('email_forgot_password_subject');

            /*$nd = '	<h3 style="font-size: 16px; color: #2f2f2f;"> Retrieve Password </h3>
                    Dear '.$rowexe['firstname'].' '.$rowexe['lastname'].' <br />You have requested to reset password.<br />
                    <div>Your email/username:  '.$rowexe['email_address'].' </div> <div>Your new password: '.$password.'</div>
                     <br /> Any problem you can  <a href="'.ROOTURL.'/contact-us.html">  contact us </a>  our support.<br />Thank you!';*/

            $nd = $config_cls->getKey('email_forgot_password_msg');
            $username = $rowexe['firstname'].' '.$rowexe['lastname'];
            $nd = str_replace(array('[username]','[email]','[password]'),array($username,$rowexe['email_address'],$password),$nd);
            $content = emailTemplatesSendBanner($nd,$lkB);
            //$mess = sendEmail_func($from_,$to_,$content,$subject,'','',true);
            $mess = sendNotificationByEventKey('forgot_password',array('email_content' => $content,'subject' => $subject,'to'=>$to_,'hasContent' => true));
            //sendSMSByKey($to_,'forgot_password');
            if($mess == 'send'){
                $message = 'Your new password has been sent.';
            }

		} else {
		}
	}
} else {
}
$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('options_question_tf',array('0' => 'No','1' =>' Yes'));
$smarty->assign('message',$message);
?>
