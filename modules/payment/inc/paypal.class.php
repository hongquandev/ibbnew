<?php
class Paypal {
	private $_paypal_url = '';
	private $_ipn_response = '';
	private $_last_error = '';
	private $_fields = array();
	private $_ipn_data = array();
	private $_ipn_log = true;
	private $_ipn_log_file = 'store/log/paypal_ipn.log';
	private $_ipn_log_file_pre = 'paypal_ipn_';
	
	/**
	@ function : __construct
	@ param : array
	@ output : void
	------------------------
	Construct method
	**/
	
	public function __construct($options = array()) {
		$this->_paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        //$this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		if (isset($options['sandbox_mode']) && $options['sandbox_mode'] == 1) {
			$this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}
		$this->addField('rm','2')->addField('cmd','_xclick');
		$this->_ipn_log_file = 'store/log/'.$this->_ipn_log_file_pre.date('YmdHis').'.log';
	}
	
	/**
	@ function : addField
	@ param : key, value
	@ output : this
	---------------------
	collect pair data 
	**/
	
	public function addField($key, $value) {
		$this->_fields[$key] = $value;
		return $this;
	}
	
	/**
	@ function : setIpnLogFilePre
	@ param : string
	@ output : this
	**/
	
	public function setIpnLogFilePre($pre = '') {
		$this->_ipn_log_file_pre = $pre;
		$this->_ipn_log_file = 'store/log/'.$this->_ipn_log_file_pre.date('YmdHis').'.log';
		return $this;
	}
	
	/**
	@ function : send
	@ param : void
	@ output : this
	**/
	
	public function send() {
		/*
		$data = array();
		foreach ($this->_fields as $key => $value) {
			$data[] = $key.'='.$value;
		}
		*/
		
		$ch = curl_init($this->_paypal_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_fields);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
		curl_close($ch);
		return $this;
	}
	
	/**
	@ function : exportForm
	@ param :
	@ output :
	**/
	
	public function exportForm() {
		$rs_ar = array();
		$rs_ar[] =  '<head><title>Processing Payment...</title></head>';
		$rs_ar[] =  '<body>';
		$rs_ar[] =  '<center><h2>Please wait, your payment is being processed and you will be redirected to the paypal website.</h2></center>';
		$rs_ar[] =  '<form method="post" id="paypal_form" name="paypal_form" action="'.$this->_paypal_url.'">';
		
		foreach ($this->_fields as $name => $value) {
			$rs_ar[] =  '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
		}
		
		$rs_ar[] =  '<center><br/><br/>If you are not automatically redirected to paypal within 5 seconds...<br/><br/></center>';
		$rs_ar[] =  '</form><script>document.getElementById(\'paypal_form\').submit()</script>';
		$rs_ar[] =  '</body></html>';
		
		return implode("\n", $rs_ar);
	}
	
	/*
	public function pdtForm($tx,$it) {
		$str =  '<form id="pdt_form"  method="post" action="'.$this->_paypal_url.'"> 
				<input type="hidden" name="cmd" value="_notify-synch"> 
				<input type="hidden" name="tx" value="'.$tx.'"> 
				<input type="hidden" name="at" value="'.$it.'"> 
				<input type="submit" value="PDT"> 
				</form><script>document.getElementById("pdt_form").submit()</script>';
		return $str;
	}
	*/
	/**
	@ function : validateIpn
	@ param : void
	@ output : bool
	**/
	
	public function validateIpn() {
		$url_parsed = parse_url($this->_paypal_url);        
		$post_ar = array();
        $post_ar[] = "cmd=_notify-validate";
		foreach ($_POST as $field => $value) { 
			$value = urlencode(stripslashes($value));
			//$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
			$this->_ipn_data[$field] = $value;
			$post_ar[] = $field.'='.$value;
		}
		
		$port = 80;
		$ssl = '';
		if ($url_parsed['scheme'] == 'https') {
			$port = 443;
			$ssl = 'ssl://';
		}
		$fp = fsockopen($ssl.$url_parsed['host'], $port, $err_num, $err_str, 30);
		
		if(!$fp) {
			$this->_last_error = "fsockopen error no. $errnum: $errstr";
			$this->logIpnResult(false);       
			return false;
		} else { 
			// Post the data back to paypal
			/*
			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			*/
			
			//fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");

			fputs($fp, "POST /cgi-bin/webscr HTTP/1.0\r\n"); 
			fputs($fp, "Host: $url_parsed[host]\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			fputs($fp, "Content-length: ".strlen(implode('&',$post_ar))."\r\n"); 
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, implode('&',$post_ar) . "\r\n\r\n");
            
			while(!feof($fp)) { 
				$this->_ipn_response .= fgets($fp, 1024); 
			} 
			fclose($fp); // close connection         


		}
        
		
		if (eregi("VERIFIED",$this->_ipn_response)) {
			$this->logIpnResult(true);
			return true;       
		} else {
			$this->_last_error = 'IPN Validation Failed.';
			$this->logIpnResult(false);   
			return false;
		}		
	}

    public function validateIpn1() {
            // read the post from PayPal system and add 'cmd'
            $header='';
            $req = 'cmd=_notify-validate';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $this->_ipn_data[$key] = $value;
                $req .= "&$key=$value";
            }

            // post back to PayPal system to validate
            $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
            $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $item_number = $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            $payment_amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];

            if (!$fp) {

                $this->_last_error = "fsockopen error no. $errno: $errstr";
			    $this->logIpnResult(false);
			    return false;

            } else {
                fputs ($fp, $header . $req);
                while (!feof($fp)) {
                    $res = fgets ($fp, 1024);
                    $this->_ipn_response .= $res;
                    if (strcmp ($res, "VERIFIED") == 0) {
                    // check the payment_status is Completed
                    // check that txn_id has not been previously processed
                    // check that receiver_email is your Primary PayPal email
                    // check that payment_amount/payment_currency are correct
                    // process payment


                        $this->logIpnResult(true);
                        return true;

                    }
                    else if (strcmp ($res, "INVALID") == 0) {
                    // log for manual investigation
                        $this->_last_error = 'IPN Validation Failed.';
                        $this->logIpnResult(false);
                        return false;
                    }
                }
                fclose ($fp);
            }
        return false;
    }
    /**
	@ function : getLastError
	@ param : void
	@ output : this->_last_error
	**/
    public  function  getLastError()
    {
        return $this->_last_error;
    }

	/**
	@ function : getIpnData
	@ param : void
	@ output : array
	**/
	
	public function getIpnData() {
		return $this->_ipn_data;
	}
	
	/**
	@ function : parseResponse
	@ param : void
	@ output : array
	**/
	
	public function parseResponse() {
		$output = array();
		if (strlen($this->_ipn_response) > 0) {
			$output1 = explode(',', $this->_ipn_response);
			if (is_array($output1) && count($output1) > 0) {
				foreach ($output1 as $value1) {
					$output2 = explode('=', $value1);
					$output[trim($output2[0])] = trim($output2[1]);
				}
			}
		}
		
		return $output;
	}
	
	/**
	@ function : logIpnResult
	@ param : bool
	@ output : void
	-------------------------
	log from ipn result
	**/
	
	public function logIpnResult($success) {
		if (!$this->_ipn_log) return;
		
		// Timestamp
		$text_ar = array();
		$text_ar[] = '['.date('m/d/Y g:i A').'] - '; 
		
		// Success or failure being logged?
		if ($success) $text_ar[] = "SUCCESS!\n";
		else $text_ar[] = 'FAIL: '.$this->_last_error."\n";
		
		// Log the POST variables
		$text_ar[] = "IPN POST Vars from Paypal:\n";
		foreach ($this->_ipn_data as $key => $value) {
			$text_ar[] = "$key=$value, ";
		}
		
		// Log the response from the paypal server
		$text_ar[] = "\nIPN Response from Paypal Server:\n ".$this->_ipn_response;
		
		// Write to log
		$fp = fopen($this->_ipn_log_file,'a+');
		fwrite($fp, implode('',$text_ar) . "\n\n"); 
		fclose($fp);  // close file
	}
}
?>