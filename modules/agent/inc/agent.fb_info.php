<?php
include_once ROOTPATH.'/includes/class.phpmailer.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.facebook.class.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
$user = $fb_cls->getUser();
   if (!is_null($user)) {
       $fb_cls->setExtendedAccessToken();
       $user_data = $fb_cls->api('/me');
       $access_token = $_SESSION['fb_'.$config_cls->getKey('facebook_application_api_id').'_access_token'];
       $fb_cls->setAccessToken($access_token);
       if (!isset($_SESSION['agent']) || $_SESSION['agent']['id'] <= 0){//create new acc or sync acc
           $_SESSION['fb_info'] = array('access_token' => $fb_cls->getAccessToken(),
                                        'uid'=> $user_data['id']);
           if (checkEmail($user_data['email'])) {
               if (FD_getInfo($user_data['email']) != null){
                   $agent = FD_getInfo($user_data['email']);
                   $row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
                                      FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_type
                                      WHERE agt.type_id = agt_type.agent_type_id
                                      AND agt.agent_id = '".$agent['agent_id']."'",true);
                   if ($row['is_active'] == 0 ) {
                       msg_alert('Your account active yet.',ROOTURL);
                   }else{
                       $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $row['type_id'], true);

                       if (is_array($type_row) and count($type_row) > 0) {
                           if (!$type_row['active']) {
                               $message = 'Sorry, your account is disabled.';
                               msg_alert($message,ROOTURL);
                               //redirect(ROOTURL);
                               exit();
                           }
                       }
                       $_SESSION['agent'] = array('id' => $row['agent_id'],
                                                         'full_name' => strlen($row['firstname'].' '.$row['lastname']) > 300 ? safecontent($row['firstname'].' '.$row['lastname'], 300).'...' : $row['firstname'].' '.$row['lastname'],
                                                         'firstname' => $row['firstname'],
                                                         'lastname' => $row['lastname'],
                                                         'email_address' => $row['email_address'],
                                                         'type' => $row['type'],
                                                         'type_id' => $row['type_id'],
                                                         'login' => true);

                   }
                   $url = ROOTURL.'/?module=agent&action=view-dashboard';
               }else{
                   $row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
                                              FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_type
                                              WHERE agt.type_id = agt_type.agent_type_id
                                              AND agt.email_address = '".$user_data['email']."'",true);
                   if (is_array($row) && count($row) > 0) {
                         if ($row['is_active'] == 0 ) {
                                    msg_alert('Your account active yet.',ROOTURL);
                         }else{
                           $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $row['type_id'], true);

                           if (is_array($type_row) and count($type_row) > 0) {
                               if (!$type_row['active']) {
                                   $message = 'Sorry, your account is disabled.';
                                   msg_alert($message,ROOTURL);
                                   //redirect(ROOTURL);
                                   exit();
                               }
                           }
                             $_SESSION['agent'] = array('id' => $row['agent_id'],
                                                             'full_name' => strlen($row['firstname'].' '.$row['lastname']) > 300 ? safecontent($row['firstname'].' '.$row['lastname'], 300).'...' : $row['firstname'].' '.$row['lastname'],
                                                             'firstname' => $row['firstname'],
                                                             'lastname' => $row['lastname'],
                                                             'email_address' => $row['email_address'],
                                                             'type' => $row['type'],
                                                             'type_id' => $row['type_id'],
                                                             'login' => true);

                         }
                         $url = ROOTURL.'/?module=agent&action=view-dashboard';
                   } else {
                       $type = 'buyer';
                       $type_id = 2;
                       $atype_row = $agent_cls->getRow('SELECT agent_type_id
                                                        FROM '.$agent_cls->getTable('agent_type').'
                                                        WHERE title = '."'".$type."'",true);
                       if (is_array($atype_row) && count($atype_row) > 0) {
                             $type_id = $atype_row['agent_type_id'];
                       }
                       $pass_length = (int)$config_cls->getKey('general_customer_password_length');
                       $pw = strrand($pass_length > 0 ? $pass_length : 6);
                       $data = array('firstname' => $user_data['first_name'],
                                     'lastname' => $user_data['last_name'],
                                     'email_address' => $user_data['email'],
                                     'password' => encrypt($pw),
                                     'type_id' => $type_id,
                                     'creation_time' => date('Y-m-d H:i:s'),
                                     'is_active' => 1,
                                     'ip_address' => $_SERVER['REMOTE_ADDR'],
                                     'allow_facebook'=>1
                                    );
                       $agent_cls->insert($data);

                             $_SESSION['agent'] = array('id' => $agent_cls->insertId(),
                                                        'full_name' => strlen($data['firstname'].' '.$data['lastname']) > 300 ? safecontent($data['firstname'].' '.$data['lastname'], 300).'...' : $data['firstname'].' '.$data['lastname'],
                                                        'firstname' => $data['firstname'],
                                                        'lastname' => $data['lastname'],
                                                        'email_address' => $data['email_address'],
                                                        'type' => $type,
                                                        'type_id' => $type_id,
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

                             $banner =  getBannerByAgentId($_SESSION['agent']['id']);
                             sendEmail_func($email_from,$data['email_address'],$nd,'Your new password.',$banner);

                        }
                        $url = ROOTURL.'/?module=agent&action=view-dashboard';
           }
           //insert or update token facebook
           if (FD_hasID($user_data['email'])){//update
                 $data = $_SESSION['fb_info'];
                 $data['agent_id'] = $_SESSION['agent']['id'];
                 $fb_detail_cls->update($_SESSION['fb_info'],
                                        'email_address = \''.$agent_cls->escape($user_data['email']).'\'');
           }else{//insert
                $data = $_SESSION['fb_info'];
                $data['email_address'] = $agent_cls->escape($user_data['email']);
                $data['agent_id'] = $_SESSION['agent']['id'];
                $fb_detail_cls->insert($data);
           }
           //GET INFORMATION TWITTER
           include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
           if (TD_getInfo($row['provider_id']) != null){
                $_SESSION['tw_info'] = TD_getInfo($row['provider_id']);
           }
           redirect($url);
		   //redirect($_SERVER['HTTP_REFERER']);
              exit();
           }
       }else{//add account
            $data = array('access_token'=>$fb_cls->getAccessToken(),
                          'uid'=>$user_data['id'],
                          'agent_id'=>$_SESSION['agent']['id'],
                          'email_address'=>$agent_cls->escape($user_data['email']));
            if(FD_getInfo($data['email_address']) == null){//hadn't account
                $fb_detail_cls->insert($data);
                $_SESSION['fb_info'] = array('access_token' => $fb_cls->getAccessToken(),
                                    'uid'=> $user_data['id']);
            }else{
                msg_alert('Account "'.$user_data['email'].'" has been add to another iBB account. Please choose another account !',ROOTURL.'/?module=agent&action=view-dashboard');
            }
            redirect(ROOTURL.'/?module=agent&action=view-dashboard');
		   //redirect($_SERVER['HTTP_REFERER']);
            exit();
       }
   }
   redirect(ROOTURL);

?>