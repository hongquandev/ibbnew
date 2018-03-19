<?php
include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
$message = '';

if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
	if ($_SERVER['REDIRECT_URL'] == '/v-login.html') {
		/*
		if (AI_isBasic($_SESSION['agent']['id'])) {
            msg_alert('This is the first time you register property on iBB. We need your full information before you can proceed. Please click OK to complete. Thank you !',ROOTURL.'/?module=agent&action=add-info');
			redirect(ROOTURL.'/?module=agent&action=add-info');
		} else {
			redirect(ROOTURL.'/?module=property&action=register');
		}
		*/
		//redirect(ROOTURL.'/?module=property&action=register');
        redirect(ROOTURL.'/?module=package');
	} else {
    	redirect(ROOTURL.'/?module=agent&action=view-dashboard');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['fields']) and is_array($_POST['fields'])) {
		$email = $_POST['fields']['username'];
		$password = encrypt($_POST['fields']['password']);
		$instance = !empty($_POST['fields']['instance']) ? $_POST['fields']['instance'] : "";
		$instance = $instance == "bidrhino" ? "": $instance;
		if(!empty($instance)) {
            $row = $agent_cls->getRow("email_address='" . $agent_cls->escape($email) . "' AND password='" . $agent_cls->escape($password) . "' AND instance='" . $instance . "'");
        }else{
            $row = $agent_cls->getRow("email_address='" . $agent_cls->escape($email) . "' AND password='" . $agent_cls->escape($password) . "'");
        }
		if ($agent_cls->hasError()) {
		
		} else if (is_array($row) and count($row)>0) {
			if ($row['is_active'] == 0 ) {
				//msg_alert('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !',ROOTURL);
                $_SESSION['is_active'] = 0;
                redirect(ROOTURL);
                /*$smarty->assign('is_active',false); */

			} else {
				$type_row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent_type')." WHERE agent_type_id = ".$row['type_id'],true);
				
				$type = 'buyer';
				if (is_array($type_row) and count($type_row)>0) {
					$type = $type_row['title'];
                    if (!$type_row['active']){
                       $message = 'Sorry, your account is disabled.';
                       $smarty->assign('message',$message);
                       return;
                    }
				}

                $fn = $row['firstname'].' '.$row['lastname'];
                $len = 60;
				$_SESSION['agent'] = array('id' => $row['agent_id'],
                                    'agent_id' => $row['agent_id'],
                                    '3x_id' => $row['agent_id'],
                                    'full_name' => strlen($fn) > $len ? safecontent($fn, $len).'...' : $fn,
									'firstname' => $row['firstname'],
								    'lastname' => $row['lastname'],
									'email_address' => $row['email_address'],
									'auction_step' => $row['auction_step'],
									'maximum_bid' => $row['maximum_bid'],
									'type' => $type,
                                    'type_id' => $row['type_id'],
									'login' => true,
                                    'parent_id'=>$row['parent_id']);
               

                //GET INFORMATION TWITTER
                if (TD_getInfo($row['provider_id']) != null){
                    $_SESSION['tw_info'] = TD_getInfo($row['provider_id']);
                }

                //GET INFROMATION FACEBOOK
                if (FD_getInfoID($row['agent_id']) != null){
                    $_SESSION['fb_info'] = FD_getInfoID($row['agent_id']);
                }

                //END
				/* if (isset($_SESSION['redirect']) and strlen($_SESSION['redirect']) > 0) {
					$link = ROOTURL.$_SESSION['redirect'];
					unset($_SESSION['redirect']);
					redirect($link);
				} else {	
					redirect(ROOTURL.'?module=agent&action=view-dashboard'); 								
				} */
				
				unset($_SESSION['redirect']);
				$action = getQuery('action');
				if($type == 'agent'){
					redirect(ROOTURL . '?module=agent&action=view-dashboard');
					exit;
				}
				if (isset($_POST['dindex']) && $_POST['dindex'] > 0 && !isset($_POST['dlgindex'])) {
					redirect($_SERVER['HTTP_REFERER']);
					exit;
				} else if (isset($_POST['dindex']) && $_POST['dindex'] > 0 && isset($_POST['dlgindex']) && $_POST['dlgindex'] > 0) {
					redirect(ROOTURL . '?module=agent&action=view-dashboard');
					exit;
				} else {
					redirect(ROOTURL . '?module=agent&action=view-dashboard');
					exit;
				}
				/*if ($action == '' || !isset($action)) {
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					redirect($_SERVER['HTTP_REFERER']);
				}*/
			}
		} else {
			$message = 'The email address or password is not valid for this account, please try again.';
			//redirect(ROOTURL.'?module=agent&action=login');
			//msg_alert('Invalid information.',ROOTURL);
			/*
			$message = 'Invalid information.';
			$smarty->assign('form_datas',array('username'=>$email,'password'=>''));
			*/
		}
	}
} else {
    //print_r($_SESSION);
    $form_datas = array();
    if(isset($_SESSION['login-active']))
    {
        $form_datas['username'] = $_SESSION['login-active'];
        unset($_SESSION['login-active']);
    }
    $smarty->assign('form_datas',$form_datas);

}
$agentOptions = AgentType_getActiveCustomerType();
$smarty->assign('agentOptions',$agentOptions);
$smarty->assign('message',$message);
?>
