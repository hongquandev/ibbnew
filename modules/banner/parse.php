<?php
$action = getParam('action');
$id = (int)getParam('id', 0);
$p = (int)getParam('p', 0);

include_once ROOTPATH.'/includes/pagging.class.php';
include_once 'inc/banner.list.php';
		
if ($p <= 0) {
	$p = 1;
}

$args = array('view-auction-list' => 'banner-live-aution',
		'view-sale-list' => 'banner-for-sale',
		'view-forthcoming-list' => 'banner-forth-auctions',
		'view-passedin-list' => 'banner-live-passedin',
		'search-auction' => 'banner-search-auction',
		'search-sale' => 'banner-search-sale',
		'search' => 'banner-search');
		
switch($action) {
	case 'view-auction-list': case 'view-sale-list': case 'view-forthcoming-list': case 'view-passedin-list':
	case 'search-auction': case 'search-sale': case 'search':
		$form_data = array();
		$wh_ar = array();
		$search_query_ar = array('property_type', 'region', 'suburb', 'postcode', 'state', 'address', 'state_code');
		
		$data = getPost('search');
		foreach ($search_query_ar as $key) {
			if (isPost() && isset($data[$key])) {
				$form_data[$key] = rawurldecode($banner_cls->escape($data[$key])); 
			} else if (isset($_GET[$key])){
				$form_data[$key] = rawurldecode($banner_cls->escape($_GET[$key])); 
			}
		}
		
		if (isset($form_data['state_code']) && strlen($form_data['state_code']) > 0) {
			$wh_ar[] = '(a.state = (SELECT region_id FROM '.$region_cls->getTable().' WHERE code = \''.$banner_cls->escape($form_data['state_code']).'\') OR a.state = 0)';
		}
		
		if (isset($form_data['property_type']) && $form_data['property_type'] > 0) {
			$wh_ar[] = '(a.`type` = '.(int)$form_data['property_type'].' OR a.`type` = 0)';
		}
		
		if (isset($form_data['state']) && $form_data['state'] > 0) {
			$wh_ar[] = '(a.state = '.(int)$form_data['state'].' OR a.state = 0)';
		}
		
		if (isset($form_data['suburb']) && strlen($form_data['suburb']) > 0) {
			$wh_ar[] = '(TRIM(a.suburb) = \''.trim($banner_cls->escape($form_data['suburb'])).'\' OR a.suburb = \'\')';
		}

		if (isset($form_data['postcode']) && strlen($form_data['postcode']) > 0) {
			$wh_ar[] = '(TRIM(a.postcode) = \''.trim($banner_cls->escape($form_data['postcode'])).'\' OR a.postcode = \'\')';
		}
		
		if (isset($form_data['region']) && strlen($form_data['region']) > 0) {
			$con_str = 'CONCAT_WS(\' \', TRIM(a.suburb), (SELECT rg.code 
							FROM '.$region_cls->getTable().' AS rg 
							WHERE rg.region_id = a.state
							LIMIT 1), TRIM(a.postcode))';
			$wh_ar[] = '('.$con_str.' LIKE \'%'.$banner_cls->escape($form_data['region']).'%\' OR '.$con_str.' = \'\')';
		}
		
		$url = @$_SERVER['REDIRECT_URL'];
		if (preg_match('/.html/', $url)) {
			$url = parseRedirectUrl($url);
		}
		$banner_center_ar = getBanner(2, $url, (count($wh_ar) > 0 ? ' AND ' : '').implode(' AND ', $wh_ar));
		$smarty->assign(array('p' => $p,
						'len_arr' => count($banner_center_ar),
						'auction_cv' => $banner_center_ar,
						'rowbanner' => getBanner(1, $url, (count($wh_ar) > 0 ? ' AND ' : '').implode(' AND ', $wh_ar)),
						'valueBanner' => getSettingBanner($args[$action])));
	break;
	case 'view-detail':
		include_once ROOTPATH.'/modules/property/inc/property.php';
		$id = (int)getParam('id', 0);
		$row = $property_cls->getCRow(array('type', 'suburb', 'state', 'postcode'), 'property_id = '.$id);
		$wh_ar = array();
		if (is_array($row) && count($row) > 0) {
			if ($row['type'] > 0) {
				$wh_ar[] = '(a.type = '.$row['type'].' OR a.type = 0)';
			}
			
			if (strlen(trim($row['suburb'])) > 0) {
				$wh_ar[] = 'IF(a.suburb != \'\', a.suburb, \''.$row['suburb'].'\') = \''.$row['suburb'].'\'';
			}
			
			if (strlen(trim($row['postcode'])) > 0) {
				$wh_ar[] = 'IF(a.postcode != \'\', a.postcode, \''.$row['postcode'].'\') = \''.$row['postcode'].'\'';
			}
			
			if ($row['state'] > 0) {
				$wh_ar[] = '(a.state = '.$row['state'].' OR a.state = 0)';
			}
		}
		
		$smarty->assign(array('rowbanner' => getBanner(1, 'abort', count($wh_ar) > 0 ? ' AND '.implode(' AND ', $wh_ar): '')));
	break;
	case '':
		//HOME PAGE
		$smarty->assign(array('rowbanner' => getBanner(1, 'home')));
	break;
	default :
		$url = @$_SERVER['REDIRECT_URL'];
		if (preg_match('/.html/', $url)) {
			$url = parseRedirectUrl($url);
		}
		$smarty->assign(array('rowbanner' => getBanner(1, $url)));
	break;
}
?>