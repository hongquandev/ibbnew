<?php
class FaceBook {
	private $_id = 0;
	private $_secret = '';
	public function __construct($info) {
		if (isset($info['id'])) {
			$this->_id = $info['id'];
		}
		
		if (isset($info['secret'])) {
			$this->_secret = $info['secret'];
		}
	}
	
	public function getUser() {
		$args = array();
		parse_str(trim($_COOKIE['fbs_' . $this->_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		
		foreach ($args as $key => $value) {
			if ($key != 'sig') {
			  $payload .= $key . '=' . $value;
			}
		}
		
		if (md5($payload . $this->_secret) != $args['sig']) {
			return null;
		}
		
		$cookie = $args;
		$_SESSION['fb_info'] = $args;
		$user = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
		return $user;
	}
	
	public function postMessage($msg = '') {
		
		include_once ROOTPATH.'/modules/general/inc/fb_log.class.php';
		
		if (!isset($fb_log_cls) || !($fb_log_cls instanceof FB_log)) {
			$fb_log_cls = new FB_log();
		}
		
		if (isset($_SESSION['fb_info']['access_token']) && strlen($_SESSION['fb_info']['access_token']) > 0 && strlen($msg) > 0) {
			$content = array('access_token' => $_SESSION['fb_info']['access_token'],
							'message' => $msg);
		
			//$content = 'access_token='.$_SESSION['fb_info']['access_token'].'&message='.$msg;
			//$ch = curl_init('https://graph.facebook.com/me/feed');
            /*$ch = curl_init('https://graph.facebook.com/'.$_SESSION['fb_info']['uid'].'/feed');
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$rs = curl_exec($ch);*/

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
				$fb_log_cls->insert(array('message'=>$msg,'created_at'=>date('Y-m-d H:i:s')));
			} else {
				$fb_log_cls->insert(array('message'=>'No existed access_token','created_at'=>date('Y-m-d H:i:s')));
			}
		}*/
	}
	
	public function logout() {
		unset($_SESSION['fb_info']);
		//unset($_COOKIE['fbs_' . $this->_id]);
	}
}
?>