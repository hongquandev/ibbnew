<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once "fb.base.class.php";
include_once ROOTPATH.'/modules/general/inc/sendmail.php';
/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Facebook extends BaseFacebook
{
  /**
   * Identical to the parent constructor, except that
   * we start a PHP session to store the user ID and
   * access token if during the course of execution
   * we discover them.
   *
   * @param Array $config the application configuration.
   * @see BaseFacebook::__construct in facebook.php
   */
  public function __construct($config) {
    if (!session_id()) {
      session_start();
    }
    parent::__construct($config);
  }

  protected static $kSupportedKeys =
    array('state', 'code', 'access_token', 'user_id');

  /**
   * Provides the implementations of the inherited abstract
   * methods.  The implementation uses PHP sessions to maintain
   * a store for authorization codes, user ids, CSRF states, and
   * access tokens.
   */
  protected function setPersistentData($key, $value) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to setPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    $_SESSION[$session_var_name] = $value;
  }

  protected function getPersistentData($key, $default = false) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to getPersistentData.');
      return $default;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    return isset($_SESSION[$session_var_name]) ?
      $_SESSION[$session_var_name] : $default;
  }

  protected function clearPersistentData($key) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to clearPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    unset($_SESSION[$session_var_name]);
  }

  protected function clearAllPersistentData() {
    foreach (self::$kSupportedKeys as $key) {
      $this->clearPersistentData($key);
    }
  }

  protected function constructSessionVariableName($key) {
    return implode('_', array('fb',
                              $this->getAppId(),
                              $key));
  }

  public function loginFacebook(){
        include_once ROOTPATH.'/includes/class.phpmailer.php';
        include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
        include_once ROOTPATH.'/modules/agent/inc/agent.php';
        include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
        require_once ROOTPATH.'/includes/functions.php';

      

        if (!isset($config_cls) || !($config_cls instanceof Config)) {
            $config_cls = new Config();
        }

        if (!isset($agent_cls) || !($agent_cls instanceof Agent)) {
            $agent_cls = new Agent();
        }



        $user = $this->getUser();
        if ($user) {
            $user_data = $this->api('/me');
            $access_token_title = 'fb_'.$config_cls->getKey('facebook_application_api_id').'_access_token';
            $_SESSION['fb_info']['access_token'] = $_SESSION[$access_token_title];
            $_SESSION['fb_info']['uid'] = $user_data['id'];

            if (checkEmail($user_data['email'])) {
                //insert or update token facebook
                 /*if (!isset($fb_detail_cls) || !($fb_detail_cls instanceof Facebook_detail)) {
                        $fb_detail_cls = new Facebook_detail();
                    }
                if (FD_hasID($agent_cls->escape($user_data['email']))){//update
                    $fb_detail_cls->update($_SESSION['fb_info'],
                                           'email_address = \''.$agent_cls->escape($user_data['email']).'\'');
                }else{//insert
                        $data = $_SESSION['fb_info'];
                        $data['email_address'] = $agent_cls->escape($user_data['email']);
                        $fb_detail_cls->insert($data);
                }
                //end*/

                $row = $agent_cls->getRow("SELECT agt.*,agt_type.title AS type
                                FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_type
                                WHERE agt.type_id = agt_type.agent_type_id
                                        AND email_address = '".$agent_cls->escape($user_data['email'])."'",true);
                if (is_array($row) && count($row) > 0) {
                    if ($row['is_active'] == 0 ) {
                        $_SESSION['is_active'] = 0;
                        redirect(ROOTURL);
                    }
                    $type_row = $agent_cls->getRow("SELECT * FROM ".$agent_cls->getTable('agent_type')." WHERE agent_type_id = ".$row['type_id'],true);

                    if (is_array($type_row) and count($type_row)>0) {
                        if (!$type_row['active']){
                           $message = 'Sorry, your account is disabled.';
                           //msg_alert($message,ROOTURL);
                           redirect(ROOTURL);
                           //exit();
                        }
                    }
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
                    $data = array('firstname' => $user_data['first_name'],
                                    'lastname' => $user_data['last_name'],
                                    'email_address' => $user['email'],
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
                    $site_title = $config_cls->getKey('site_title');
                    $mail = new PHPMailer();
                    $nd = '<h3 style="font-size: 16px; color: #2f2f2f;"> Retrieve Your Password </h3>
                                <div style="margin-top:12px;font-size: 14px;">
                                    Welcome to '.$site_title.'
                                </div>
                                <div style="margin-top:20px">
                                    Your new password : '.$pw.'
                                </div>';

                    $content =  emailTemplatesSend($nd);
                    $mail->IsMail();
                    $mail->From = $email_from;
                    $mail->FromName = "Receive your new password from {$site_title}";
                    $mail->Sender = $email_from;
                    $mail->AddReplyTo($email_from, "Replies for {$site_title} site");
                    $mail->AddAddress($data['email_address']);
                    $mail->Subject = 'Your new password.';
                    $mail->IsHTML(true);
                    $mail->Body = $content;

                    /*ob_start();
                    if (!$mail->Send()) {
                        $message = $mail->ErrorInfo;
                    } else {
                        $message = '';
                    }
                    ob_clean();*/
                    sendEmail_func($email_from,$data['email_address'],$content,"Your new password.","","",true);
                    //redirect(ROOTURL.'/?module=agent&action=view-dashboard');
                    //exit();
                }
            }
        }
        //redirect(ROOTURL);
    }
    /* POST STATUS TO WALL
     *
     */
	public function postMessage($msg = '') {
		if (isset($_SESSION['fb_info']['access_token']) && strlen($_SESSION['fb_info']['access_token']) > 0 && strlen($msg) > 0) {
			$content = array('access_token' => $_SESSION['fb_info']['access_token'],
							'message' => $msg);

            $url = "https://graph.facebook.com/".$_SESSION['fb_info']['uid']."/feed";
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $content,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_VERBOSE => true
            ));
            $rs = curl_exec($ch);

			if(curl_errno( $ch ) == CURLE_OK) {
				//print_r($rs);
			}
			//$fb_log_cls->insert(array('message' => $msg."-RESPONSE:".$rs,'created_at' => date('Y-m-d H:i:s')));
		} /*else {
			if (isset($_SESSION['fb_info']['access_token']) && strlen($_SESSION['fb_info']['access_token']) > 0) {
				//$fb_log_cls->insert(array('message'=>$msg,'created_at'=>date('Y-m-d H:i:s')));
			} else {
				//$fb_log_cls->insert(array('message'=>'No existed access_token','created_at'=>date('Y-m-d H:i:s')));
			}
		}*/
	}

    public function postFull($content_arr = null,$fb_info = null){
      if ($fb_info != null){
         $content_arr['access_token'] = $fb_info['token'];
      }else{
         if (isset($_SESSION['fb_info']['access_token']) && strlen($_SESSION['fb_info']['access_token']) > 0){
            $content_arr['access_token'] =  $_SESSION['fb_info']['access_token'];
         }
      }
      if (strlen($content_arr['access_token']) > 0){
          $params = $content_arr;
          $uid = strlen($fb_info['uid']) > 0?$fb_info['uid']:$_SESSION['fb_info']['uid'];
          $url = "https://graph.facebook.com/".$uid."/feed";
          $ch = curl_init();
          curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_POSTFIELDS => $params,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_VERBOSE => true
          ));
          $rs = curl_exec($ch);
          die($rs);
      }
    }

	public function logout() {
		unset($_SESSION['fb_info']);
		unset($_COOKIE['fbs_' . $this->appId]);
	}
}
