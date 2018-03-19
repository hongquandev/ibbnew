<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'config.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

/**
@ function : isBanned
@ param : $ip
@ output :
**/

function isBanned($ip = '') {
	global $config_cls; 
	if (strlen($ip) > 0) {
		$country_ar = $config_cls->getKey('general_ban_from_country');
		if (strlen(trim($country_ar)) > 0) {
			$country_ar = explode(',', $country_ar);
			
			if (class_exists('SoapClient')) {
				$client = new SoapClient('http://www.webservicex.net/geoipservice.asmx?WSDL');
				$params = array('IPAddress' => $ip);
				$result = $client->__SoapCall('GetGeoIP', array($params));
				$code = trim(@$result->GetGeoIPResult->CountryCode);
			} else {
				$result = simplexml_load_string(@file_get_contents('http://www.webservicex.net/geoipservice.asmx/GetGeoIP?IPAddress='.$ip));
				$code = $result->CountryCode;
			}
			
			if (strlen($code) > 0) {
			
				$item = R_getItemFromCode($code);
				if (count($item) == 0) {
					$item = R_getItemFromCode(substr($code, 0, 2));
				}
				if (count($item) > 0 && in_array(@$item['region_id'], $country_ar)) {
					return true;
				}
			}
		}
		
		$ip_str = trim($config_cls->getKey('general_ban_ip'));
		if (strlen($ip_str) > 0) {
			$ip_ar = explode(',', $ip_str);
			if (in_array($ip, $ip_ar)) {
				return true;
			}
		}
	}
	return false;
}

/**
@ function : isAllowIpAdmin
@ param : ip
@ output :
**/

function isAllowIpAdmin($ip) {
	global $config_cls;
	$ip_str = trim($config_cls->getKey('general_allow_ip_admin'));
	if (strlen($ip_str) > 0) {
		$ip_ar = explode(',', $ip_str);
		if (is_array($ip_ar) && count($ip_ar) > 0) {
			if (in_array($ip, $ip_ar)) {
				return true;
			}
			return false;
		}
	}
	return true;
}

/**
@ function : isSecure
@ param : void
@ output : 
**/

function isSecure() {
	global $config_cls, $smarty;
	$secure_url_enable = (bool)$config_cls->getKey('general_secure_url_enable');
	
	if ($secure_url_enable) {
		$secure_url_scanned = $config_cls->getKey('general_secure_url_scanned');
		
		
		//$uri = ($_SERVER['REDIRECT_HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$uri = (@$_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if(isset($_SERVER['HTTP_HOST']) AND isset($_SERVER['REQUEST_URI']))
        {
            if (isSecureScan($uri, $secure_url_enable)) {
                $uri = str_replace('http:', 'https:', $uri);
                redirect($uri);
            }
            $smarty->assign('json_secure_url_scanned', json_encode(explode("\r\n", $secure_url_scanned)));
        }
	}
}

/**
@ function : lockHtmlHttps
@ param : void
@ output :
**/

function lockHtmlHttps() {
	global $config_cls, $smarty;
		//$uri = ($_SERVER['REDIRECT_HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $html_ch = strpos($_SERVER['REQUEST_URI'],'.html');
        $cms_ch = strpos($_SERVER['REQUEST_URI'],'cms');
        if($_SERVER['REDIRECT_HTTPS'] == 'on' AND ($html_ch !== false OR $cms_ch !== false))
        {
		    $uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		    redirect($uri);
        }
}


/*
@ function : createConfigXml
@ param : file_name
@ return : void
*/
function createConfigXml($file_name = 'config_fix.xml') {
	global $config_cls;
	$rows = $config_cls->getRows();
	Cache_set(ROOTPATH.'/modules/cache/config.cache',$rows);
	/*
	createFolder(ROOTPATH.'/modules/cache',1);
	$handler = fopen(ROOTPATH.'/modules/cache/'.$file_name, 'w');
	chmod(ROOTPATH.'/modules/cache/'.$file_name,0777);
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('config');
	
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$xml->startElement($row['key']);
			$xml->writeCData($row['value']);
			$xml->endElement();
		}
	}
	
	$xml->endElement();
	
	fputs($handler, $xml->outputMemory(true));
	fclose($handler);
	*/
}

function testReadConfigXml($key = '') {
	$reader = new XMLReader();
	$reader->xml(file_get_contents(ROOTPATH.'/modules/cache/config.xml'));
	while ( $reader->read() ) {
		if ($reader->nodeType == XMLReader::ELEMENT && $reader->localName == $key) {
			$reader->read();
			print_r($reader->value);
		}
	}
}
//testReadConfigXml('general_site_off_msg');
?>