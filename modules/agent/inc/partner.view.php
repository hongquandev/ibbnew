<?php

include 'partner.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/includes/checkingform.class.php';

if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
	$banner_cls = new Banner();
}

if (!isset($property_cls) || !($property_cls instanceof Property)) {
	$property_cls = new Property();
}

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$form_data = array();

//BEGIN FOR QUERY SEARCH
$where_str = '1';
$where_ar = array();

//BEGIN FOR PAGGING
$p = restrictArgs(getParam('p',1));
if ($p <= 0) {
	$p = 1;	
}



//Order By
        $auction_sale_ar = PEO_getAuctionSale();
        if (getPost('order_by') != '' || $_POST['search']['order_by'] != '') {
                $_SESSION['order_by'] = (getPost('order_by') != '')?getPost('order_by'):$_POST['search']['order_by'];
        }

            $order_by = isset($_SESSION['order_by']) ? $_SESSION['order_by'] : '';
            $sub_select =null;
            switch ($order_by) {
                case 'name':
                    $order_ar = 'a.firstname ASC';
                    break;
                case 'newest':
                    $order_ar = 'creation_time DESC';
                    break;
                case 'oldest':
                    $order_ar = 'creation_time ASC';
                    break;
                default:
                    $order_ar = '  creation_time DESC';
                    break;
            }
            $order_ar = ($order_ar != '') ? ' ORDER BY ' . $order_ar : '';
            $smarty->assign('order_by',$order_by);
            //End Order By

if(isSubmit()){
    $_SESSION['len'] = (int)restrictArgs(getPost('len'));
}

$len = isset($_SESSION['len']) ? $_SESSION['len'] : 6;
$link = parseRedirectUrl(@$_SERVER['REDIRECT_URL']);
$auction_sale_ar = PEO_getAuctionSale();
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
        AND a.type_id = '.$agent_ar['partner'].
        $order_ar.'
		LIMIT '.(($p - 1) * $len).','.$len;
$rows = $partner_cls->getRows($sql,true);
$total_row = $partner_cls->getFoundRows();
$mode = getParam('mode','list');
$url_part = $mode == 'grid'?'&mode=grid':'';
$pag_cls->setTotal($total_row)
		->setPerPage($len)
		->setCurPage($p)
		->setLenPage(12)
		//->setUrl('/?module=agent&action=view-partner-list'.$url_part)
		->setUrl($link.$url_part)
		->setLayout('link_simple');

$results = array();
$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';

$url_part = '';
if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $k => $row) {
            $dt = new DateTime($row['creation_time']);
            $row['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
            $row['description'] = strlen($row['description']) > 300?safecontent($row['description'],300).'...':$row['description'];
            $results[$k]['info'] = $row;
        }
}

/* $sql = "SELECT SQL_CALC_FOUND_ROWS a.*, b.*, reg.*,
                                    (SELECT CASE
                                        WHEN a.state < 2 OR a.state > 9 THEN a.other_state
                                        ELSE
                                            (SELECT r.name
                                              FROM ".$region_cls->getTable()." as r
                                              WHERE a.state = r.region_id AND r.active=1 AND r.parent_id=1
                                            )
                                        END
                                    ) as state_name
            FROM ".$agent_cls->getTable().' AS a
            
			    LEFT JOIN '.$partner_cls->getTable().' as b
			        ON a.agent_id = b.agent_id
			    LEFT JOIN '.$region_cls->getTable().'  as reg
			        ON a.country = reg.region_id
			                        
			WHERE a.is_active = 1
			AND type_id = 3
			AND '.$where_str.'
            '.$order_ar.'
			LIMIT '.(($p - 1) * $len).','.$len;
$rows = $agent_cls->getRows($sql,true);
$total_row = $agent_cls->getFoundRows();
$results = array();*/
//$subresults = array();
//move code
//echo $partner_cls->sql;
//$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';



//if (isset($mode) && $mode == 'grid') {
//	$url_part = '&mode=grid';
//
//    if ($banner_cls->hasError()) {
//
//    } else if (is_array($rows) and count($rows) > 0) {
//
//	    foreach ($rows as $k => $row) {
//            $dt = new DateTime($row['creation_time']);
//            $row['creation_time']=$dt->format($config_cls->getKey('general_date_format'));
//                    $results[$k] = array();
//                    if ($row['partner_logo'] != '') {
//
//                        $path = 'store/uploads/banner/images/partner';
//                        $file_ar = explode('/',$row['partner_logo']);
//                        $file_name = $file_ar[count($file_ar)-1];
//
//                        $file_ar[count($file_ar)-1] = 'thumbs';
//                        $file_path = trim(implode('/',$file_ar).'/'.$file_name,'/');
//
//                        if (!file_exists($file_path)) {
//                            createFolder($path.'/thumbs',1);
//                            createThumbs($file_name, $path, $path.'/thumbs', 185, 154);
//                        }
//
//                        $row['partner_logo'] = str_replace('%','%25',$row['partner_logo']);
//
//                    }
//                     /*if(strlen($results[$k]['info']['description']) > 20) {
//
//                        $results[$k]['description'] = substr($results[$k]['description'],0,10);
//                     }
//                    if (strlen($row['description']) > 60) {
//                        $row['description'] = substr($row['description'],0,60). '...';
//                    }
//                     if (strlen($row['postal_address'])>65) {
//                        $row['postal_address'] = substr($row['postal_address'],0,65). '...';
//                    }*/
//                   if (strlen($row['firstname'])>20) {
//                         $row['firstname'] = substr($row['firstname'],0,20). '...';
//                   }
//                    $results[$k]['info'] = $row;
//        }
//    }
//
//	$pag_cls->setTotal($total_row)
//		->setPerPage($len)
//		->setCurPage($p)
//		->setLenPage($len)
//		//->setUrl('/?module=agent&action=view-partner-list&mode=grid')
//		->setUrl($link.$url_part)
//		->setLayout('link_simple');
//} else {
//	$mode = 'list';
//    if ($banner_cls->hasError()) {
//
//    } else if (is_array($rows) and count($rows) > 0) {
//
//        foreach ($rows as $k => $row) {
//            $dt = new DateTime($row['creation_time']);
//            $row['creation_time']=$dt->format($config_cls->getKey('general_date_format'));
//                    $results[$k] = array();
//                    if ($row['partner_logo'] != '') {
//
//                        $path = ROOTPATH.'store/uploads/banner/images/partner';
//
//                        $file_ar = explode('/',$row['partner_logo']);
//                        $file_name = $file_ar[count($file_ar)-1];
//
//                        $file_ar[count($file_ar)-1] = 'thumbs';
//                        $file_path = trim(implode('/',$file_ar).'/'.$file_name,'/');
//
//                        if (!file_exists($file_path)) {
//                            createFolder($path.'/thumbs',1);
//                            createThumbs($file_name, $path, $path.'/thumbs', 185, 154);
//                        }
//
//                        $row['partner_logo'] = str_replace('%','%25',$row['partner_logo']);
//
//                    }
//                    // if(strlen($results[$k]['info']['description']) > 20) {
//
//                        //$results[$k]['description'] = substr($results[$k]['description'],0,10);
//                    // }
//                    if (strlen($row['description']) > 400) {
//                        $row['description'] = substr($row['description'],0,400). '...';
//                    }
//                    $results[$k]['info'] = $row;
//        }
//    }
//	$pag_cls->setTotal($total_row)
//		->setPerPage($len)
//		->setCurPage($p)
//		->setLenPage($len)
//		//->setUrl('/?module=agent&action=view-partner-list')
//		->setUrl($link)
//		->setLayout('link_simple');
//}


					
$smarty->assign('mode' ,$mode);
 //$len = (int)restrictArgs(getParam('len',0));
$smarty->assign('len', $len);
$smarty->assign('len_ar', PE_getItemPerPage());

$smarty->assign('p',  $p);	
$smarty->assign('total_row', $total_row);
$smarty->assign('pag_str',$pag_cls->layout());
		
$smarty->assign('review_pagging',$review_pagging);

$smarty->assign('form_data',$form_data);
$smarty->assign('results',$results);
//$form_action = '/?module=agent&action=view-partner-list';
$form_action = $link;
$smarty->assign('form_action',$form_action)	

?>