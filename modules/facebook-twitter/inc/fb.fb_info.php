<?php
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/general/inc/getbanner.php';
$user = $fb_cls->getUser();
if (!is_null($user)) {
	if (checkEmail($user->email)) {
		//insert or update token facebook
        if (FD_hasID($agent_cls->escape($user->email))){//update
            $fb_detail_cls->update($_SESSION['fb_info'],
                                   'email_address = \''.$agent_cls->escape($user->email).'\'');
        }else{//insert
            $data = $_SESSION['fb_info'];
            $data['email_address'] = $agent_cls->escape($user->email);
            $fb_detail_cls->insert($data);
        }
        //end

		$row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
						FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_type
						WHERE agt.type_id = agt_type.agent_type_id 
								AND email_address = '".$agent_cls->escape($user->email)."'",true);
		if (is_array($row) && count($row) > 0) {
			$_SESSION['agent'] = array('id' => $row['agent_id'],
								'firstname' => $row['firstname'],
								'lastname' => $row['lastname'],
								'email_address' => $row['email_address'],
								'type' => $row['type'],
								'type_id' => $row['type_id'],
								'login' => true);
            //GET INFORMATION TWITTER
            include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
            if (TD_getInfo($row['provider_id']) != null){
                    $_SESSION['tw_info'] = TD_getInfo($row['provider_id']);
            }
			redirect(ROOTURL.'/?module=agent&action=view-dashboard');					
			exit();
		} else {
			$type = 'buyer';
			$type_id = 2;
			$atype_row = $agent_cls->getRow('SELECT agent_type_id
								FROM '.$agent_cls->getTable('agent_type').'
								WHERE title = '."'".$type."'",true);
			if (is_array($atype_row) && count($atype_row) > 0) {
				$type_id = $atype_row['agent_type_id'];
			}
			
					
			$pw = strrand(6);
			$data = array('firstname' => $user->first_name,
							'lastname' => $user->middle_name.' '.$user->last_name,
							'email_address' => $user->email,
							'password' => encrypt($pw),
							'type_id' => $type_id,
							'creation_time' => date('Y-m-d H:i:s'), 
							'is_active' => 1,
							'ip_address' => $_SERVER['REMOTE_ADDR']
							);
							
							
			$agent_cls->insert($data);
			
			$_SESSION['agent'] = array('id' => $agent_cls->insertId(),
								'firstname' => $data['firstname'],
								'lastname' => $data['lastname'],
								'email_address' => $data['email_address'],
								'type' => $type,
								'login' => true);
								
			$email_from = $config_cls->getKey('general_contact_email');					
			$mail = new PHPMailer();
			$nd = '<h3 style="font-size: 16px; color: #2f2f2f;"> Retrieve Your Password </h3>
						<div style="margin-top:12px;font-size: 14px;">
							Welcome to '.SITE_TITLE.'
						</div>
						<div style="margin-top:20px">
							Your new password : '.$pw.'
						</div>';

            $banner = getBannerByAgentId($_SESSION['agent']['id']);
            sendEmail_func($email_from,$data['email_address'],$nd,"Your new password.",$banner);
					
			redirect(ROOTURL.'/?module=agent&action=view-dashboard');
			exit();
		}
	}
}

redirect(ROOTURL);
?>