<?php
class SMS {
	private $_username = '';
	private $_password = '';
	private $_sender_id = '';
	private $_portal_url = 'http://www.smsglobal.com.au/http-api.php';
	private $_result = '';
	private $_sp = ',';
	
	private $_i_ok = 0;
	private $_i_error = 0;
	
	public function __construct($info) {
		if (isset($info['username'])) {
			$this->_username = $info['username'];
		}
		
		if (isset($info['password'])) {
			$this->_password = $info['password'];
		}
		
		if (isset($info['sender_id'])) {
			$this->_sender_id = $info['sender_id'];
		}
		
		if (isset($info['portal_url'])) {
			$this->_portal_url = $info['portal_url'];
		}
	}
	
	public function send($text,$to) {

		if (is_array($to) && count($to) > 0) {
			$to = implode($this->_sp,$to);
		}
		$content = 'action=sendsms'.
					'&user='.rawurlencode($this->_username).
					'&password='.rawurlencode($this->_password).
					'&to='.rawurlencode($to).
					'&text='.rawurlencode($text).
					'&api=1'.
					'&userfield='.rawurlencode($this->_sender_id);
	
	
 		$ch = curl_init($this->_portal_url); 
		
		$url_ar = parse_url($this->_portal_url);
		if ($url_ar['scheme'] == 'https') {
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		} else {
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
		
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $this->_result = curl_exec($ch); 
        curl_close ($ch); 
		//echo '['.$this->_result.']';
        return $this->_result;  	
	}
	
	/*
	
	*/
	public function isOk() {
		$ar = explode(';',$this->_result);
		if (isset($ar[0])) {
			$ok_ar = explode(':',trim($ar[0]));
			
			if (isset($ok_ar[1]) && $ok_ar[1] == 0) {
				return true;
			}
		}
		return false;
	}
	
	public function parseResponse() {
		$this->_i_ok = substr_count($this->_result,'OK');
		$this->_i_error = substr_count($this->_result,'ERROR');
	}
	
	public function getResponse() {
		return $this->_result;
	}
	
	public function getStatus() {
		if ($this->_i_ok > 0 && $this->_i_error > 0) {
			return $this->_i_ok.'OK-'.$this->_i_error.'ERROR';
		} else if ($this->_i_ok > 0) {
			return 'OK';
		} else if ($this->_i_error > 0) {
			return 'ERROR';
		} else {
			return 'UNKNOWN';
		}
	}
} // END Class

?>