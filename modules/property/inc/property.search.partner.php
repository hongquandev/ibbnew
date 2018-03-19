<?php
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/agent/inc/partner.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
	$banner_cls = new Banner();
}
//$mode = getParam('mode','list') == 'grid' ? getParam('mode','list'): 'list';
$mode = getParam('mode','list') == 'grid' ? 'grid': 'list';
$form_data = array();

//BEGIN FOR QUERY SEARCH
$where_str = '1';
$where_ar = array();

//BEGIN FOR PAGGING
$p = restrictArgs(getParam('p',1));
if ($p <= 0) {
	$p = 1;
}

$len = 9;
//END
$smarty->assign('len',$len);
$search_queries = array('firstname'
                        ,'region'
                        ,'suburb'
                        ,'postcode'
                        ,'state'
                        ,'state_code'
                        ,'country'
                        ,'other_state'
                        ,'address'
                        ,'telephone'
                        ,'postal_address'
                        ,'general_contact_partner'
                        ,'website_partner');
$search_query = '';

$ar_ = array();
$order_ar = array();

//BEGIN FOR POST & GET
//print_r($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
	if (isset($_POST['search']) and is_array($_POST['search']) and count($_POST['search']) > 0) {
		foreach ($_POST['search'] as $key => $val) {
			$form_data[$key] = rawurldecode($banner_cls->escape($val));
            //$form_data[$key] = utf8_decode($form_data[$key]);
            $form_data[$key] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$form_data[$key]);
            $form_data[$key] = utf8_to_latin9($form_data[$key]);

			if (in_array($key, array('state_code','region','address')) || ( !in_array($key, array('state_code','region','address')) && $form_data[$key] > 0) ) {
				$ar_[] = $key.'='.rawurlencode($form_data[$key]);
			}
		}
	}
	$search_query = implode('&',$ar_);
	
} else {
	foreach ($search_queries as $key) {
		if (isset($_GET[$key])) {
			$form_data[$key] = rawurldecode($property_cls->escape($_GET[$key]));
            //$form_data[$key] = utf8_decode($form_data[$key]);
            $form_data[$key] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$form_data[$key]);
            $form_data[$key] = utf8_to_latin9($form_data[$key]);

			if (in_array($key, array('state_code','region','address')) || ( !in_array($key, array('state_code','region','address')) && $form_data[$key] > 0) ) {
				$ar_[] = $key.'='.rawurlencode($form_data[$key]);
			}
		}
	}	
	$search_query = implode('&',$ar_);
}



if (isset($form_data['state_code']) && $form_data['state_code'] != '') {
	$form_data['region'] = $agent_cls->escape($form_data['state_code']);
}

if (isset($form_data['region']) && (trim($form_data['region']) != '')) {
	$str = "(a.agent_id IN (SELECT r.agent_id
	                       FROM ".$partner_region_cls->getTable()." AS r
                           WHERE CONCAT(r.suburb,
                                        IF( ISNULL(r.state) || r.state = '',
                                        '',
                                        (SELECT reg.code
                                         FROM ".$region_cls->getTable()." AS reg
                                         WHERE reg.region_id = r.state)
                                         ),
					                    r.other_state,
					                    r.postcode,
					                    (SELECT reg.name
	                                     FROM ".$region_cls->getTable()." AS reg
	                                     WHERE reg.region_id = r.country))
	                              LIKE '%".str_replace(' ','%',$agent_cls->escape($form_data['region']))."%'
	                              OR CONCAT(r.suburb,
                                        IF( ISNULL(r.state) || r.state = '',
                                        '',
                                        (SELECT reg.name
                                         FROM ".$region_cls->getTable()." AS reg
                                         WHERE reg.region_id = r.state)
                                         ),
					                    r.other_state,
					                    r.postcode,
					                    (SELECT reg.name
	                                     FROM ".$region_cls->getTable()." AS reg
	                                     WHERE reg.region_id = r.country))
	                              LIKE '%".str_replace(' ','%',$agent_cls->escape($form_data['region']))."%'
	                       )
	                       OR
	                       CONCAT(a.street,
                                  a.suburb,
                                  IF(ISNULL(a.state)|| a.state = '',
                                   '',
                                   (SELECT reg_s1.code
                                    FROM ".$region_cls->getTable()." AS reg_s1
                                    WHERE reg_s1.region_id = a.state)
                                   ),
                                  a.other_state,
                                  a.postcode,
                                  (SELECT reg.name
                                    FROM ".$region_cls->getTable()." AS reg
                                    WHERE reg.region_id = a.country)
                                  ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['region'])))."%'
                           OR
                           CONCAT(a.street,
                                  a.suburb,
                                  IF(ISNULL(a.state)|| a.state = '',
                                   '',
                                   (SELECT reg_s1.name
                                    FROM ".$region_cls->getTable()." AS reg_s1
                                    WHERE reg_s1.region_id = a.state)
                                   ),
                                  a.other_state,
                                  a.postcode,
                                  (SELECT reg.name
                                    FROM ".$region_cls->getTable()." AS reg
                                    WHERE reg.region_id = a.country)
                                  ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['region'])))."%'
                           OR
                           CONCAT(p.postal_address,
                                p.postal_suburb,
                                IF(ISNULL(p.postal_state)|| p.postal_state = '',
                                   '',
                                  (SELECT reg_s1.code
                                   FROM ".$region_cls->getTable()." AS reg_s1
                                   WHERE reg_s1.region_id = p.postal_state)
                                ),
                                p.postal_other_state,
                                p.postal_postcode,
                                (SELECT reg.name
                                    FROM ".$region_cls->getTable()." AS reg
                                    WHERE reg.region_id = p.postal_country)
                                ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['region'])))."%'
                           OR CONCAT(p.postal_address,
                                p.postal_suburb,
                                IF(ISNULL(p.postal_state)|| p.postal_state = '',
                                   '',
                                  (SELECT reg_s1.name
                                   FROM ".$region_cls->getTable()." AS reg_s1
                                   WHERE reg_s1.region_id = p.postal_state)
                                ),
                                p.postal_other_state,
                                p.postal_postcode,
                                (SELECT reg.name
                                    FROM ".$region_cls->getTable()." AS reg
                                    WHERE reg.region_id = p.postal_country)
                                ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['region'])))."%')
                           ";
	$where_ar[] = $str;
}


/*if (isset($form_data['general_contact_partner']) && strlen($form_data['general_contact_partner']) > 0) {
	$where_ar[] = "a.general_contact_partner LIKE '%".$agent_cls->escape($form_data['general_contact_partner'])."%'";
}
if (isset($form_data['website_partner']) && strlen($form_data['website_partner']) > 0) {
	$where_ar[] = "a.website_partner LIKE '%".$agent_cls->escape($form_data['website_partner'])."%'";
}*/

if (isset($form_data['firstname']) && strlen($form_data['firstname']) > 0) {
	$where_ar[] = "a.firstname LIKE '%".$agent_cls->escape($form_data['firstname'])."%'";
}

/*if (isset($form_data['telephone']) && strlen($form_data['telephone']) > 0) {
	$where_ar[] = "a.telephone LIKE '%".$agent_cls->escape($form_data['telephone'])."%'";
}*/

//BEGIN SEARCH ADDRESS
/*if (isset($form_data['address']) && strlen($form_data['address']) > 0) {
    $str = "CONCAT(a.street,
                    a.suburb,
					IF(ISNULL(a.state)|| a.state = '',
					   '',
					   (SELECT reg_s1.code
						FROM ".$region_cls->getTable()." AS reg_s1
					    WHERE reg_s1.region_id = a.state)
					   ),
				    a.other_state,
					a.postcode,
					(SELECT reg.name
	                    FROM ".$region_cls->getTable()." AS reg
	                    WHERE reg.region_id = a.country)
	                ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['address'])))."%'";
	$where_ar[] = $str;
}*/
//END


//BEGIN SEARCH POSTAL ADDRESS
/*if (isset($form_data['postal_address']) && strlen($form_data['postal_address']) > 0) {
	 $str = "CONCAT(p.postal_address,
                    p.postal_suburb,
					IF(ISNULL(p.postal_state)|| p.postal_state = '',
					   '',
					  (SELECT reg_s1.code
					   FROM ".$region_cls->getTable()." AS reg_s1
					   WHERE reg_s1.region_id = p.postal_state)
					),
				    p.postal_other_state,
					p.postal_postcode,
					(SELECT reg.name
	                    FROM ".$region_cls->getTable()." AS reg
	                    WHERE reg.region_id = p.postal_country)
	                ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['postal_address'])))."%'";
	$where_ar[] = $str;
}*/
//END


//BEGIN SEARCH REGION
/*if (isset($form_data['suburb']) && strlen($form_data['suburb']) > 0) {
	$str = 'a.agent_id IN (SELECT r.agent_id
	                       FROM '.$partner_region_cls->getTable()." AS r
	                       WHERE r.suburb LIKE '%".$agent_cls->escape($form_data['suburb'])."%')";
    $where_ar[] = $str;
}
if (isset($form_data['country']) && ($form_data['country'] > 0)) {
    $country_name = R_getItemFromCondition("region_id = '".$agent_cls->escape($form_data['country'])."'");
	$str = 'a.agent_id IN (SELECT r.agent_id
	                       FROM '.$partner_region_cls->getTable()." AS r
	                       WHERE r.country = '".$agent_cls->escape($form_data['country'])."')";
    $where_ar[] = $str;
}
if (isset($form_data['postcode']) && strlen($form_data['postcode']) > 0) {
	$str = 'a.agent_id IN (SELECT r.agent_id
	                       FROM '.$partner_region_cls->getTable()." AS r
	                       WHERE r.postcode LIKE '%".$agent_cls->escape($form_data['postcode'])."%')";
    $where_ar[] = $str;
}
if (isset($form_data['state']) && ($form_data['state'] > 0)) {
	$state_name = R_getItemFromCondition("region_id = '".$agent_cls->escape($form_data['state'])."'");
    $str = 'a.agent_id IN (SELECT r.agent_id
	                       FROM '.$partner_region_cls->getTable()." AS r
	                       WHERE r.state = '".$agent_cls->escape($form_data['state'])."')";
    $where_ar[] = $str;
}
if (isset($form_data['other_state']) && strlen($form_data['other_state']) > 0) {
	$str = 'a.agent_id IN (SELECT r.agent_id
	                       FROM '.$partner_region_cls->getTable()." AS r
	                       WHERE r.other_state LIKE '%".$agent_cls->escape($form_data['other_state'])."%')";
    $where_ar[] = $str;
}*/

//END

/*if ($form_data['country'] == 0) {
	//$where_ar[] = "b.other_state LIKE '%".$form_data['other_state']."%'";	
	if (strlen($form_data['other_state']) > 0) {
		$where_ar[] = "b.other_state LIKE '%".$form_data['other_state']."%' 
						   OR c.name LIKE '%".$form_data['other_state']."%'
						   AND  b.is_active = 1 AND b.type_id = 3";
	}
	if (strlen($form_data['other_state']) > 0) { 
		if (strlen($form_data['firstname']) > 0) {
			$where_ar[] = "b.firstname LIKE '%".$form_data['firstname']."%'";
		}
		if (isset($form_data['suburb']) && strlen($form_data['suburb']) > 0) {
			$where_ar[] = "b.suburb LIKE '%".$banner_cls->escape($form_data['suburb'])."%'";
		}	
		if (isset($form_data['register_number']) && strlen($form_data['register_number']) > 0) {
			$where_ar[] = "a.register_number LIKE '%".$form_data['register_number']."%'";
		}
		if (isset($form_data['postal_address']) && strlen($form_data['postal_address']) > 0) {
			$where_ar[] = "a.postal_address LIKE '%".$form_data['postal_address']."%'";
		}
        if (isset($form_data['general_contact_partner']) && strlen($form_data['general_contact_partner']) > 0) {
			$where_ar[] = "a.general_contact_partner LIKE '%".$form_data['general_contact_partner']."%'";
		}
        if (isset($form_data['website_partner']) && strlen($form_data['website_partner']) > 0) {
			$where_ar[] = "a.website_partner LIKE '%".$form_data['website_partner']."%'";
		}
		if (isset($form_data['postcode']) && strlen($form_data['postcode']) > 0) {
			$where_ar[] = "b.postcode = '".$form_data['postcode'].'\'';
		}
	} 	
			   
}*/
$where_str = '';
if (count($where_ar) > 0) {
	$where_str = ' AND ' .implode(' AND ',$where_ar);
}

/*$form_data['region'] = isset($form_data['region']) && strlen($form_data['region']) > 0?
                       $form_data['region']:
                       trim(implode(' ',array($form_data['suburb'],$state_name['code'],$form_data['other_state'],$form_data['postcode'],$country_name['name'])));*/


/* $sql = "SELECT a.*, b.*, c.* 
            FROM ".$banner_cls->getTable().' AS a LEFT JOIN '.$partner_cls->getTable().' AS b
            	ON a.agent_id = b.agent_id 
			LEFT JOIN '.$agent_cls->getTable().' as c
				ON a.agent_id = c.agent_id
			WHERE 	a.status = 1
					AND a.agent_status = 1
					AND '.$where_str
                    . ' LIMIT '.(($p - 1) * $len).','.$len;
*/
if (getPost('order_by') != '' || $_POST['search']['order_by'] != '') {
    $_SESSION['order_by'] = (getPost('order_by') != '')?getPost('order_by'):$_POST['search']['order_by'];
}
$order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';

         switch ($order_by) {
                case 'name':
                    $order_ar = 'a.firstname ASC';
                    break;
                case 'newest':
                    $order_ar = 'a.creation_time DESC';
                    break;
                case 'oldest':
                    $order_ar = 'a.creation_time ASC';
                    break;
                default:
                    $order_ar = 'a.creation_time DESC';
                    break;
            }

        $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar:'';

        $smarty->assign('order_by',$order_by);
 /*$sql = "SELECT SQL_CALC_FOUND_ROWS b.*, a.*, c.*,
                                    (SELECT CASE
                                           WHEN b.state < 2 OR b.state > 9 THEN b.other_state
                                           ELSE
                                               (SELECT r.name
                                                        FROM ".$region_cls->getTable()." as r
                                                        WHERE b.state = r.region_id AND r.active=1 AND r.parent_id=1
                                               )
                                           END
                                    ) as state_name

            FROM ".$agent_cls->getTable().' AS b
			LEFT JOIN '.$region_cls->getTable().' as c
			ON b.state = c.region_id 
			OR b.country = c.region_id
			LEFT JOIN '.$partner_cls->getTable().' as a
			ON a.agent_id = b.agent_id			
			WHERE b.is_active = 1
			AND b.type_id = 3
			AND '.$where_str.'
			GROUP BY b.agent_id
			'.$order_ar.'  LIMIT '.(($p - 1) * $len).','.$len;*/
$agent_ar = AgentType_getArr();
$sql = "SELECT SQL_CALC_FOUND_ROWS a.agent_id,
                                   a.website_partner,
                                   a.firstname,
                                   p.description,
                                   p.partner_logo
        FROM ".$agent_cls->getTable().' AS a
        LEFT JOIN '.$partner_cls->getTable().' AS p
        ON a.agent_id = p.agent_id
        WHERE a.is_active = 1
        AND a.type_id = '.$agent_ar['partner']
       .$where_str
	   .$order_ar.'
		LIMIT '.(($p - 1) * $len).','.$len;
$rows = $partner_cls->getRows($sql,true);
$total_row = $partner_cls->getFoundRows();

$results = array();
$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';

$url_part = '';
if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $k => $row) {
            $dt = new DateTime($row['creation_time']);
            $row['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
            $row['description'] = strlen($row['description']) > 300?safecontent($row['description'],300).'...':$row['description'];
			if (strlen(trim($row['website_partner'])) > 0 && !preg_match('@^http|https@', $row['website_partner'])) {
				$row['website_partner'] =  'http://'.str_replace(array('http://', 'https://'), '', $row['website_partner']);
			}
			
            //$row['full_address'] = implode(' ',array($row['suburb'],$row['state_name'],$row['other_state'],$row['postcode'],$row['country']));
            //$row['full_postal_address'] = implode(' ',array($row['postal_suburb'],$row['postal_state_name'],$row['postal_other_state'],$row['postal_postcode'],$row['postal_country']));

            $results[$k]['info'] = $row;
        }
}
if (isset($mode) && $mode == 'grid') {
    if (is_array($rows) and count($rows) > 0) {
         foreach ($rows as $k => $row) {
              if (strlen($row['firstname'])>20) {
                $row['firstname'] = substr($row['firstname'],0,20). '...';
             }
            $results[$k]['info'] = $row;
         }
    }

}
$mode = getParam('mode','list');
//$url_part = isset($_POST['mode']) && $_POST['mode'] == 'grid'?'&mode=grid':'';
$url_part = $mode == 'grid'?'&mode=grid':'';
$pag_cls->setTotal($total_row)
		->setPerPage($len)
		->setCurPage($p)
		->setLenPage(12)
		//->setUrl('?module=property&action='.$act.'&'.$search_query.$url_part)
		->setUrl($form_action.'&'.$search_query.$url_part)
		->setLayout('link_simple');

$smarty->assign('mode' ,$mode);
$smarty->assign('review_pagging',$review_pagging);
$smarty->assign('pag_str',$pag_cls->layout());
$smarty->assign('p',  $p);
$smarty->assign('len', $len);
$smarty->assign('total_row', $total_row);
$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('results',$results);
?>