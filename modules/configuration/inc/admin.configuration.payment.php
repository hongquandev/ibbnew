<?php
if (isSubmit()) {
	$message = configPostDefault();
}

$form_action = '?module=configuration&action='.$action.'&token='.$token;
$options_securepay_gateway_url = array('http://test.securepay.com.au/xmlapi/payment' => 'Test',
							 'https://test.securepay.com.au/xmlapi/payment' => 'Test (SSL)',
 							 'https://www.securepay.com.au/xmlapi/payment' => 'Live');
							 
$smarty->assign('options_securepay_gateway_url',$options_securepay_gateway_url);	

?>