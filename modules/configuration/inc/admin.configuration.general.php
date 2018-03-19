<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
if (isSubmit()) {
	if (isset($_POST['fields']['general_ban_from_country']) && is_array($_POST['fields']['general_ban_from_country']) && count($_POST['fields']['general_ban_from_country']) > 0) {
		$_POST['fields']['general_ban_from_country'] = implode(',', $_POST['fields']['general_ban_from_country']);
	} else {
		$_POST['fields']['general_ban_from_country'] = '';
	}
	$message = configPostDefault();
}

// filter Action
function filterGeneral(&$params) {
	if (isset($params['general_ban_from_country']) && strlen($params['general_ban_from_country']) > 0) {
		$params['general_ban_from_country'] = explode(',', $params['general_ban_from_country']);
	}
	
	if (isset($params['general_secure_url_scanned'])) {
	//	$params['general_secure_url_scanned'] = nl2br($params['general_secure_url_scanned']);
	}
}

$form_action = '?module=configuration&action='.$action.'&token='.$token;
$options_date_format = array();
$date_ar = array('m.d.Y', 'm-d-Y', 'm/d/Y', 'M d, Y', 'F j, Y', 'F j Y');
foreach ($date_ar as $date) {
	$options_date_format[$date] = date($date);
}
$smarty->assign('options_date_format',$options_date_format);	

$options_country = R_getOptions();
unset($options_country[0]);
$smarty->assign('options_country', $options_country);

if (getParam('autobid',0) == 1) {
	$form_action .= '&autobid=1';
	$smarty->assign('autobid', true);
}
$filterFnc = 'filterGeneral';
?>