<?php

if(!isset($_SESSION)){
    session_start();
}

if (!isset($smarty) || !($smarty instanceof Smarty)) {
    //BEGIN SMARTY
    include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
    include_once ROOTPATH.'/includes/functions.php';
    $smarty = new Smarty;
    if(detectBrowserMobile()){ 
        $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
    }else{
        $smarty->compile_dir = ROOTPATH.'/templates_c/';
    }
}

$form_data = array();
//BEGIN FOR QUERY SEARCH
$where_str = '';
$where_ar = array();
$auction_sale_ar = PEO_getAuctionSale();
$search_queries = array('property_type','property_kind','region','suburb','postcode','state','address','bedroom','minprice','maxprice','land_size_min','land_size_max','unit','bathroom','livability_rating','green_rating','state_code','car_space','car_port','property_id','parking','auction_sale');
$search_query = '';
$ar_ = array();
$order_ar = array();
$p = (int)restrictArgs(getQuery('p',0));
$p = $p <= 0 ? 1 : $p;
$len = 9;
//BEGIN FOR POST & GET
if (isPost()) {
	$search_ar = getPost('search');
    //print_r($search_ar);die();
	if (is_array($search_ar) && count($search_ar) > 0) {
		$searchval = "";
		foreach ($search_ar as $key => $val) {
			$proptype = (!isset($proptype)) ? "Properties" : $proptype;
			$form_data[$key] = rawurldecode($property_cls->escape($val));
            $form_data[$key] = utf8_decode($form_data[$key]);
            $form_data[$key] = utf8_to_latin9($form_data[$key]);
			if ($form_data[$key] > 0) {
				switch ($key) {
					case "bedroom":
						$tempval = ($val < 30) ? $val-18 : $val-38;
						$tempval = ($val < 40) ? $tempval : "6+";
						$searchval .= ", $tempval Bedroom";
					break;case "bathroom":
						$tempval = ($val < 40) ? $val-22 : "5";
						$searchval .= ", $tempval Bathroom";
					break;case "minprice":
						$searchval .= ", From ".money_format('%.0n',$val);
					break;case "maxprice":
						$searchval .= ", Up To ".money_format('%.0n',$val);
					break;case "state":
						switch ($val) {
							case 2: $region = "ACT";
							break; case 3: $region = "NSW";
							break; case 4: $region = "NT";
							break; case 5: $region = "QLD";
							break; case 6: $region = "SA";
							break; case 7: $region = "TAS";
							break; case 8: $region = "VIC";
							break; case 9: $region = "WA";
							break; default: $region = "NSW";
						}
						$searchval = " In $region";
					break;case "property_type":
						switch ($val) {
							case 11:
								$proptype = "Houses";
							break;case 12:
								$proptype = "Apartments";
							break;case 13:
								$proptype = "Lands";
							break;case 14:
								$proptype = "Flats";
							break;case 53:
								$proptype = "Offices";
							break;case 54:
								$proptype = "Showrooms";
							break;case 55:
								$proptype = "Retail/shops";
							break;case 56:
								$proptype = "Industrial/Factory/Warehouses";
							break;default:
								$proptype = "Properties";
						}
					break;default:
						$searchval .= "";
				}
				$ar_[] = $key.'='.$val;
			}
		}
	}
	$search_query = implode('&',$ar_);
    //print_r($search_query);
} else {
	foreach ($search_queries as $key) {
		if (isset($_GET[$key])) {
			$form_data[$key] = rawurldecode($property_cls->escape($_GET[$key]));
            $form_data[$key] = utf8_decode($form_data[$key]);
            $form_data[$key] = utf8_to_latin9($form_data[$key]);
			if (in_array($key, array('state_code','region','address','suburb','parking')) || ( $form_data[$key] > 0 )) {
				$proptype = "Property";
				$searchval = ($form_data[$key]) ? " in ".strtoupper($form_data[$key]) : "";
				$ar_[] = $key.'='.rawurlencode($form_data[$key]);
			}
		}
	}
	$search_query = implode('&',$ar_);
}
//print_r_pre($form_data);die();
$action = isset($action) ? $action : getParam('action');
$where_str = getSearchQueryByFormData($form_data,$action);
$where_str_surround = getSurroundWhereStr($where_str, $search_query);
$where_str_end = getSearchQueryByFormData1($form_data,$action, $where_str_surround);
$where_str = (isset($form_data['surround_suburb']) && $form_data['surround_suburb'] == 1) ? $where_str_end : $where_str;
//print_r($where_str); die();
$_SESSION['wh_str'] = $where_str;
$_SESSION['where'] = 'search';
unset($_SESSION['type_prev']);

/*AND IF (pro.stop_bid = 1 AND pro.confirm_sold = 0 AND datediff(\''.date('Y-m-d H:i:s').'\', pro.end_time) > 14 ,0,1) = 1';*/
//print_r_pre($_SERVER);
$form_data['mode'] = getParam('mode');
$redirectUrl = parseRedirectUrl(@$_SERVER['REDIRECT_URL']);
if($_SERVER['REDIRECT_URL'] == "" or !isset($_SERVER['REDIRECT_URL'])){
   $redirectUrl =  '/?'.$_SERVER['QUERY_STRING'];
}
$smarty->assign('pag_link', $redirectUrl.'&rs=1');
$smarty->assign('pag_link_list', $redirectUrl.'&rs=1');
$smarty->assign('pag_link_grid', $redirectUrl.'&rs=1&mode=grid');
$smarty->assign('form_data',formUnescapes($form_data));

$property_data = Property_getList($where_str, $p, $len, $search_query);
$property_title_bar = 'SEARCH RESULT';
$_SESSION['property_list_title_bar'] = $property_title_bar;
$smarty->assign('property_title_bar', $property_title_bar);

$smarty->assign('property_data', $property_data);

$smarty->assign('property_title_bar', "$proptype For Sale$searchval");

$form_action = array('module' => 'property', 'action' => $action);
// For AGENT
$data_agent_info = $_SESSION['agent'];
if (is_array($data_agent_info) && count($data_agent_info) > 0) {
    foreach($data_agent_info as $key => $data_a) {
        $data_agent_info[$key] = str_replace("'",'',$data_a);
    }
}
$smarty->assign('agent_info',$data_agent_info);
?>
