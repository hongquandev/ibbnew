<?php
include_once 'banner.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

// BEGIN GOS:MOHA 
$banner_id = getParam('banner_id', 0);
if ($banner_id > 0 && B_delete($banner_id))  {
	$session_cls->setMessage('Deleted success.');
	redirect(ROOTURL.'/?module=banner&action=my-banner');
}
// END

$form_data = array();
// $date_format=''%Y-%m-%d'';
$auction_sale_ar = PEO_getAuctionSale();

//BEGIN FOR PAGGING
$p = (int)restrictArgs(getQuery('p',1));
$p = $p <= 0 ? 1 : $p;
$page = $p;
$len = 10;
//END

// Statement 
$sql = 'SELECT SQL_CALC_FOUND_ROWS a.*, b.*, sum(c.click) as click                          
		FROM '.$banner_cls->getTable().' AS a
		LEFT JOIN '.$banner_cls->getTable('banner_log').' AS c ON a.banner_id = c.banner_id 
		LEFT JOIN '.$region_cls->getTable().' as b ON a.state = b.region_id
		WHERE a.agent_id = '.$_SESSION['agent']['id'].'
		GROUP BY a.banner_id 
		ORDER BY a.banner_id DESC
		LIMIT '.(($p - 1) * $len).','.$len;
// End Statement

$rows = $banner_cls->getRows($sql,true);
$total_row = $banner_cls->getFoundRows();

$result = array();
$type_ar = array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial');
if (is_array($rows) and count($rows) > 0) {
	foreach ($rows as $k => $row) {
		$dt = new DateTime($row['creation_time']);
		$dt2 = new DateTime($row['date_from']);
		$dt3 = new DateTime($row['date_to']);
		
		$row['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
		$row['date_from'] = $dt2->format($config_cls->getKey('general_date_format'));
		$row['date_to'] = $dt3->format($config_cls->getKey('general_date_format'));
		$row['type'] = $type_ar[$row['type']];
		$row['banner_file'] = str_replace('%20', '%2520', $row['banner_file']);
		$row['description'] = strlen($row['description']) > 100 ? safecontent($row['description'], 100). '...' : $row['description'];
		
		$page_ar = Menu_getTitleArById(explode(',', $row['page_id']));
		$row['page_list'] = is_array($page_ar) && count($page_ar) > 0 ? $page_ar : array(0 => 'None');
		
		$result[$k] = array();
		$result[$k]['info'] = $row;
	} // End Foreach
}	// End else if (is_array($rows) and count($rows) > 0) 

//echo $partner_cls->sql;
$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';

$pag_cls->setTotal($total_row)
	->setPerPage($len)
	->setCurPage($p)
	->setLenPage(10)
	->setUrl('/?module=banner&action=my-banner')
	->setLayout('link_simple');

$smarty->assign(array('mode' => $mode,
				'p' => $p,
				'len' => $len,
				'len_ar' => $len_ar,
				'total_row' => $total_row,
				'pag_str' => $pag_cls->layout(),
				'review_pagging' => $review_pagging,
				'form_data' => formUnescapes($form_data),
				'results' => $result));
	
?>