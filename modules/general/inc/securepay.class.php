<?php
class SecurePay {
	private $_gateway_url = '';
	private $_merchant_id = '';
	private $_password = '';
	private $_response = '';
	private $_obj = null;
	private $_responseCode = '';
	private $_responseText = '';
	
	public function __construct($options) {
		if (isset($options['gateway_url'])) {
			$this->_gateway_url = $options['gateway_url'];
		}
		
		if (isset($options['merchant_id'])) {
			$this->_merchant_id = $options['merchant_id'];
		}
		
		if (isset($options['password'])) {
			$this->_password = $options['password'];
		}
	}
	
	public function send($data) {
		$amount = 0;
		if (isset($data['amount'])) {
			$amount = str_replace('$','',trim($data['amount']));
		}
		//$real_amount = $amount * 100;
		$real_amount = $amount;
		
		$card_number = '000';
		if (isset($data['card_number'])) {
			$card_number = trim($data['card_number']);
		}
		
		$expiry_date = '30/01';
		if (isset($data['expiry_month']) && isset($data['expiry_year'])) {
			$expiry_date = $data['expiry_month'].'/'.$data['expiry_year'];
		}
		
		$cvv = 'test';
		if (isset($data['cvv'])) {
			$cvv = $data['cvv'];
		}
		
		$card_name = 'test';
		if (isset($data['card_name'])) {
			$card_name = $data['card_name'];
		}
		
		$currency = 'AUD';
		if (isset($data['currency'])) {
			$currency = $data['currency'];
		}
		
		$order_no = 'test_'.str_replace(' ','',microtime());
		if (isset($data['order_no'])) {
			$order_no = str_replace(' ','',$data['order_no']);
		}

		$xml_request='<?xml version="1.0" encoding="UTF-8"?>
						<SecurePayMessage>
						<MessageInfo>
						<messageID>8af793f9af34bea0cf40f5fb750f64</messageID>
						<messageTimestamp>20042303111214383000+660</messageTimestamp>
						<timeoutValue>100</timeoutValue>
						<apiVersion>xml-4.2</apiVersion>
						</MessageInfo>
						<MerchantInfo>
						<merchantID>'.$this->_merchant_id.'</merchantID>
						<password>'.$this->_password.'</password>
						</MerchantInfo>
						<RequestType>Payment</RequestType>
						<Payment>
						<TxnList count="1">
						<Txn ID="1">
						<txnType>0</txnType>
						<txnSource>23</txnSource>
						<amount>'.$real_amount.'</amount>
						<currency>'.$currency.'</currency>
						<purchaseOrderNo>'.$order_no.'</purchaseOrderNo>
						<CreditCardInfo>
						<cardNumber>'.$card_number.'</cardNumber>
						<expiryDate>'.$expiry_date.'</expiryDate>
						<cvv>'.$cvv.'</cvv>
						</CreditCardInfo>
						</Txn>
						</TxnList>
						</Payment>
						</SecurePayMessage>';
						
		
		$ch = curl_init($this->_gateway_url);
		
		$url_ar = parse_url($this->_gateway_url);
		/*
		if ($url_ar['scheme'] == 'https') {
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		} else {
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
		*/
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $this->_response = curl_exec($ch);
		
        if(curl_errno( $ch ) == CURLE_OK) {
        	return $this->_response;
		}	
	}
	
	public function parseResponse() {
		try {
			ob_start();
			$this->_obj = simplexml_load_string($this->_response);
			$error = ob_get_clean();
			if (strlen($error) > 0) {
				throw new Exception($error);
			}
			$this->_responseCode = $this->_obj->Payment->TxnList->Txn->responseCode;
			$this->_responseText = $this->_obj->Payment->TxnList->Txn->responseText;
			//BEGIN GOS:MOHA
			$handle = fopen(ROOTPATH.'/securepay.log','a+');
			fputs($handle,"\r\n=======\r\n");
			fputs($handle,$this->_responseText);
			fclose($handle);
			//END
		} catch (Exception $e) {
			$this->_obj = null;
			$this->_responseCode = '';
			$this->_responseText = $e->getMessage();
		}
		return $this->_obj;
	}
	
	public function isOk() {
		if ($this->_responseCode == '00') {
			return true;
		}
		return false;
	}
	
	public function getStatusMsg() {
		if (strlen(trim($this->_responseText)) > 0) {
			return $this->_responseText;
		}
		return 'Error unknown.';
	}
}
?>