<?php
include_once ROOTPATH.'/modules/agent/inc/company.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
$total_found = 0;
$form_data = array();

//BEGIN FOR QUERY SEARCH
$where_ar = array();

//BEGIN FOR PAGGING
$p = restrictArgs(getParam('p',1));
if ($p <= 0) {
	$p = 1;
}
$len = 9;
$smarty->assign('len_ar', PE_getItemPerPage());
//END
$search_queries = array('location'
                        ,'agent_name'
                        ,'agency_name'
                        ,'state_code'
                        ,'view'
                        ,'postcode'
                        ,'country'
                        ,'state'
                        ,'suburb');
$search_query = '';
$ar_ = array();
$order_ar = array();

//BEGIN FOR POST & GET
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['search']) and is_array($_POST['search']) and count($_POST['search']) > 0) {
		$proptype = "Property";
		foreach ($_POST['search'] as $key => $val) {
			if (!is_array($_POST['search'][$key])){
                $form_data[$key] = rawurldecode($banner_cls->escape($val));
                $form_data[$key] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$form_data[$key]);
                $form_data[$key] = utf8_to_latin9($form_data[$key]);
                if (strlen($form_data[$key]) > 0){
                     if ($key == 'state' && $form_data[$key] <= 0){
                     }else{
                         $ar_[] = $key.'='.rawurlencode($form_data[$key]);
                     }
                }
            }else{
                $form_data[$key] = $_POST['search'][$key];
            }
            $searchval = ($form_data[$key]) ? " ".strtoupper($form_data[$key]) : "";
		}
	}
	$search_query = implode('&',$ar_);

} else {
	foreach ($search_queries as $key) {
		if (isset($_GET[$key])) {
			$form_data[$key] = rawurldecode($property_cls->escape($_GET[$key]));
            $form_data[$key] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE',$form_data[$key]);
            $form_data[$key] = utf8_to_latin9($form_data[$key]);
            if (strlen($form_data[$key]) > 0){
				$proptype = "Property";
				$searchval = ($form_data[$key]) ? " ".strtoupper($form_data[$key]) : "";
                $ar_[] = $key.'='.rawurlencode($form_data[$key]);
            }
			/*if (in_array($key, array('state_code','region','address')) || ( !in_array($key, array('state_code','region','address')) && $form_data[$key] > 0) ) {
				$ar_[] = $key.'='.rawurlencode($form_data[$key]);
			}*/
		}
	}
	$search_query = implode('&',$ar_);
}
$agent_ar = AgentType_getArr();

$form_data['view'] = isset($form_data['view'])?$form_data['view']:'agent';

$arr = array('suburb','state','other_state','postcode','country');
$region = array();
if (isset($form_data['state_code'])){
    $r = R_getItemFromCode($form_data['state_code']);
    $form_data['state'] = $r['region_id'];
}
foreach ($arr as $item){
    if (isset($form_data[$item]) && strlen($form_data[$item]) > 0){
        if ($item == 'state' || $item == 'country'){
            $r = R_getItemFromCondition('region_id = '.$form_data[$item]);
            $region[] = $r['name'];
        }else{
            $region[] = $form_data[$item];
        }
    }
}

if (count($region) > 0){
    $form_data['location'] = implode(' ',$region);
}
switch ($form_data['view']){
    case 'agent':
        if (isset($form_data['location']) && (trim($form_data['location']) != '')) {
            $str = "
                                   (CONCAT(c.address,
                                          c.suburb,
                                          IF(ISNULL(c.state)|| c.state = '',
                                           '',
                                           (SELECT reg_s1.code
                                            FROM ".$region_cls->getTable()." AS reg_s1
                                            WHERE reg_s1.region_id = c.state)
                                           ),
                                          c.other_state,
                                          c.postcode,
                                          (SELECT reg.name
                                            FROM ".$region_cls->getTable()." AS reg
                                            WHERE reg.region_id = c.country)
                                          ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['location'])))."%'
                                   OR
                                   CONCAT(c.address,
                                          c.suburb,
                                          IF(ISNULL(c.state)|| c.state = '',
                                           '',
                                           (SELECT reg_s1.name
                                            FROM ".$region_cls->getTable()." AS reg_s1
                                            WHERE reg_s1.region_id = c.state)
                                           ),
                                          c.other_state,
                                          c.postcode,
                                          (SELECT reg.name
                                            FROM ".$region_cls->getTable()." AS reg
                                            WHERE reg.region_id = c.country)
                                          ) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['location'])))."%')
                                   ";
            $where_ar[] = $str;
        }
        if (isset($form_data['agent_name']) && strlen($form_data['agent_name']) > 0) {
            $where_ar[] = " CONCAT(a.firstname,a.lastname) LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['agent_name'])))."%'";
        }
        if (isset($form_data['agency_name']) && strlen($form_data['agency_name']) > 0) {
            $where_ar[] = " (a.parent_id IN (SELECT ag.agent_id
                                         FROM ".$agent_cls->getTable()." AS ag
                                         LEFT JOIN ".$company_cls->getTable()." AS c
                                         ON ag.agent_id = c.agent_id
                                         WHERE c.company_name LIKE '%".str_replace(' ','%',$agent_cls->escape($form_data['agency_name']))."%'
                                         AND ag.is_active = 1
                                         AND ag.type_id = {$agent_ar['agent']}
                                         AND ag.parent_id = 0)
                             OR (c.company_name LIKE '%".str_replace(' ','%',trim($agent_cls->escape($form_data['agency_name'])))."%' AND a.parent_id = 0))";
        }
        //$where_ar[] = ' a.parent_id > 0';

        $where_str = '';

        if (count($where_ar) > 0) {
            $where_str = ' AND ' .implode(' AND ',$where_ar);
        }

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


        $sql = "SELECT SQL_CALC_FOUND_ROWS a.agent_id,
                                           a.firstname,
                                           a.lastname,
                                           c.company_name,
                                           c.postcode,
                                           c.address,
                                           c.suburb,
                                           c.telephone,
                                           c.website,
                                           c.description,
                                           c.logo AS banner,
                                           l.logo,
                (SELECT r1.code
                 FROM ".$region_cls->getTable('regions')." AS r1
                 WHERE r1.region_id = c.state) AS state_code,

                (SELECT r2.name
                 FROM " . $region_cls->getTable('regions') . " AS r2
                 WHERE r2.region_id = c.country) AS country_name

                FROM ".$agent_cls->getTable().' AS a
                LEFT JOIN '.$company_cls->getTable().' AS c
                ON a.agent_id = c.agent_id
                LEFT JOIN '.$agent_logo_cls->getTable().' AS l
                ON a.agent_id = l.agent_id
                WHERE a.is_active = 1
                AND a.type_id = '.$agent_ar['agent']
               .$where_str
               .$order_ar.'
                LIMIT '.(($p - 1) * $len).','.$len;
        $rows = $agent_cls->getRows($sql,true);
        $total_row = $agent_cls->getFoundRows();

        $results = array();
        $review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';

        $url_part = '';
        if (is_array($rows) and count($rows) > 0) {
                foreach ($rows as $k => $row) {
                    $row['logo'] = strlen($row['logo']) > 0?$row['logo']:'/modules/general/templates/images/photo_default.jpg';
                    $row['full_name'] = $row['firstname'].' '.$row['lastname'];
                    $row['full_address'] = $row['address'].', '.implode(' ',array($row['suburb'],$row['state_code'],$row['other_state'],$row['postcode'],$row['country_name']));

                    $row['short_description'] = strlen($row['description']) > 200 ? safecontent($row['description'],200).'...': $row['description'];
                    //print_r_pre(htmlspecialchars($row['short_description']));
                    $row['parent'] = A_getAgentParentInfo($row['agent_id']);
                    //$row['link'] = Agent_seoURL('?module=agent&action=view-detail-agent&uid='.$row['agent_id']);
                    $results[] = $row;
                }
        }
        break;
    case 'property':
        if (isset($form_data['location']) && (trim($form_data['location']) != '')) {
            $str = "
                   (CONCAT(pro.address,
                          pro.suburb,
                          IF(ISNULL(pro.state)|| pro.state = '',
                           '',
                           (SELECT reg_s1.code
                            FROM " . $region_cls->getTable() . " AS reg_s1
                            WHERE reg_s1.region_id = pro.state)
                           ),
                          pro.postcode,
                          (SELECT reg.name
                            FROM " . $region_cls->getTable() . " AS reg
                            WHERE reg.region_id = pro.country)
                          ) LIKE '%" . str_replace(' ', '%', trim($agent_cls->escape($form_data['location']))) . "%'
                   OR
                   CONCAT(pro.address,
                          pro.suburb,
                          IF(ISNULL(pro.state)|| pro.state = '',
                           '',
                           (SELECT reg_s1.name
                            FROM " . $region_cls->getTable() . " AS reg_s1
                            WHERE reg_s1.region_id = pro.state)
                           ),
                          pro.postcode,
                          (SELECT reg.name
                            FROM " . $region_cls->getTable() . " AS reg
                            WHERE reg.region_id = pro.country)
                          ) LIKE '%" . str_replace(' ', '%', trim($agent_cls->escape($form_data['location']))) . "%')
                   ";
            $where_ar[] = $str;
        }
        if (isset($form_data['agent_name']) && strlen($form_data['agent_name']) > 0) {
            $where_ar[] = " IF (pro.agent_manager = '' || pro.agent_manager = 0,
                                CONCAT (agt.firstname,agt.lastname) LIKE '%" . str_replace(' ', '%', trim($agent_cls->escape($form_data['agent_name']))) . "%',
                                (SELECT CONCAT(a.firstname,a.lastname) FROM ".$agent_cls->getTable()." AS a
                                 WHERE a.agent_id = pro.agent_manager) LIKE '%" . str_replace(' ', '%', trim($agent_cls->escape($form_data['agent_name']))) . "%')";
        }
        if (isset($form_data['agency_name']) && strlen($form_data['agency_name']) > 0) {
            $where_ar[] = "IF (agt.parent_id > 0,
                               agt.parent_id,
                               agt.agent_id) IN (SELECT c.agent_id
                                         FROM ".$company_cls->getTable()." AS c
                                         WHERE c.company_name LIKE '%".str_replace(' ','%',$agent_cls->escape($form_data['agency_name']))."%'
                                         )";
        }
        $where_ar[] = ' agt.type_id = '.$agent_ar['agent'];
        $where_str = '';
        if (count($where_ar) > 0) {
            $where_str = ' AND ' .implode(' AND ',$where_ar);
        }
        $auction_sale_ar = PEO_getAuctionSale();

        $where_str .= ' AND (IF (pro.confirm_sold = 1  AND datediff(\''.date('Y-m-d H:i:s').'\',pro.sold_time) < 14,1,0) = 1
                             OR (pro.confirm_sold = 0 AND pro.auction_sale = '.$auction_sale_ar['private_sale'].')
                             OR (pro.auction_sale != '.$auction_sale_ar['private_sale'].' AND pro.confirm_sold = 0))';
        $where_str .= ' AND IF (pro.auction_sale != '.$auction_sale_ar['private_sale'].'
                                                                AND (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                                     LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  (SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                     FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                                     LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                AND  IF ((SELECT pro_term.value
                                                                     FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                                     LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'auction_start_price\'
                                                                        AND pro.property_id = pro_term.property_id )
                                                                     >
                                                                     (SELECT pro_term.value
                                                                     FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                                     LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                     WHERE term.code = \'reserve\'
                                                                        AND pro.property_id = pro_term.property_id ),0,1)

                                                                = 0, 0, 1) = 1';
        $_SESSION['wh_str'] = $where_str;
        unset($_SESSION['type_prev']);
        $_SESSION['where'] = 'search';
        $property_data = Property_getList($where_str, $p, $len, $search_query);
        $smarty->assign('property_data', $property_data);
        $total_row = $total_found;
        break;

}
$review_pagging = (($p - 1) * $len) . ' - ' . (($p * $len) > $total_row ? $total_row
                : ($p * $len)) . ' (' . $total_row . ' items)';

$mode = getParam('mode','list');

$url_part = getParam('mode') == 'grid' ? '&mode=grid' : '';
$pag_cls->setTotal($total_row)
		->setPerPage($len)
		->setCurPage($p)
		->setLenPage(12)
		//->setUrl('?module=property&action='.$act.'&'.$search_query.$url_part)
		->setUrl($form_action.'&'.$search_query.$url_part)
		->setLayout('link_simple');

if ((int)$form_data['country'] == 0) {
	$form_data['country'] = COUNTRY_DEFAULT;
}

$form_data['mode'] = getParam('mode');
//$link_search = '/?module='.getParam('module').'&action='.getParam('action').'&view='.$form_data['view'];
$link_search = parseRedirectUrl(@$_SERVER['REDIRECT_URL']).'&rs=1&view='.$form_data['view'];
$smarty->assign('pag_link', $link_search.'&mode='.(getParam('mode') == 'grid' ? 'grid' : 'list' ));
$smarty->assign('pag_link_list', $link_search.'&mode=list');
$smarty->assign('pag_link_grid', $link_search.'&mode=grid');
$smarty->assign('action' ,getParam('action'));
$smarty->assign('mode' ,$mode);
$smarty->assign('review_pagging',$review_pagging);
$smarty->assign('pag_str',$pag_cls->layout());
$smarty->assign('p',  $p);
$smarty->assign('len', $len);
$smarty->assign('total_row', $total_row);
$smarty->assign('form_data',formUnescapes($form_data));

$smarty->assign('property_title_bar', "$proptype For Sale$searchval");

$smarty->assign('results',$results);
$smarty->assign('options_state',R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('subState', subRegion());
?>
