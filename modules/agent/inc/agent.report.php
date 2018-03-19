<?php
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/includes/pagging.class.php';

$schedule = restrictArgs(getParam('schedule'),'[^0-9\-]');
if (getPost('len',0) > 0) {
	$_SESSION['len'] = (int)restrictArgs(getPost('len'));
}
$len = isset($_SESSION['len']) ? $_SESSION['len'] : 30;
$p = (int)restrictArgs(getQuery('p',0));
$p = $p <= 0 ? 1 : $p;


if ($action == 'view-report') {
    $agent = $agent_cls->getRow('SELECT *,
                            (SELECT at.title FROM '.$agent_cls->getTable('agent_type').' AS at
                                WHERE a.type_id = at.agent_type_id) AS type
                                FROM '.$agent_cls->getTable().' AS a
                                WHERE agent_id = '.$_SESSION['agent']['id'],true);
    if($agent['type'] == 'partner' ){
        $action = 'view-report-banner';
    }
	else { $action = 'view-report-property';}
	$action_ar = explode('-',$action);
}

$form_action = '/?module=agent&action=view-report';

switch ($action) {
	case 'view-report-banner':
		include_once ROOTPATH.'/modules/banner/inc/banner.php';
        $rows = array();
		$rows = $banner_cls->getRows('SELECT SQL_CALC_FOUND_ROWS 
											 a.banner_id, 
											 a.url,
											 a.display, 
											 a.banner_file, 
											 a.views,
											(SELECT SUM(b.click) 
											FROM '.$banner_log_cls->getTable().' AS b 
											WHERE b.banner_id = a.banner_id ) AS clicks
									FROM '.$banner_cls->getTable().' AS a 
									WHERE a.agent_id = '.$_SESSION['agent']['id'] 
									.' ORDER BY banner_id DESC '
									.' LIMIT '.($p - 1) * $len.','.$len,true);
        if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $key => $row) {
				if ((int)$row['clicks'] == 0) {
					$rows[$key]['clicks'] = 0;
				}
				$rows[$key]['url_detail'] = '/index.php?module=agent&action=view-report-banner-detail&id='.$row['banner_id'];
				// Using Resize Image 
				
				/*if ($row['banner_file'] != '') {
				
					$path = 'store/uploads/banner/images';
					$file_ar = explode('/',$row['banner_file']);
					$file_name = $file_ar[count($file_ar)-1];
					
					$file_ar[count($file_ar)-1] = 'thumbs';
					$file_path = trim(implode('/',$file_ar).'/'.$file_name,'/');
					
					if ($row['display'] == 1) { // Banner Right
						
						if (!file_exists($file_path)) {
							createFolder($path.'/report/thumbs',1);
							createThumbs($file_name, $path, $path.'/report/thumbs', 285, 120);
						}
					}  else { // Banner Center
						if (!file_exists($file_path)) {
							createFolder($path.'/report/thumbs',1);
							createThumbs($file_name, $path, $path.'/report/thumbs', 400, 120);
						}
					}
					
	
				} // End If
				
				
				// End Resize Image
				*/
			}
		}

        $pag_cls->setTotal($total_row = $banner_cls->getFoundRows())
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(10)
				->setUrl('/?module=agent&action='.getParam('action'))
				->setLayout('link_simple');
        $smarty->assign('banner_rows',$rows);
		$smarty->assign('pag_str',$pag_cls->layout());
	
	    break;
	default://view-report-property

		$wh_str = '';
        $wh_time = '';
		if (strlen($schedule) > 0) {
			//$wh_str = "AND DATE_FORMAT(__,'%Y-%m')= '".$schedule."'";
            $wh_str = "AND DATE_FORMAT(__,'%Y')= '".$schedule."'";
            $wh_time = " AND DATE_FORMAT(bid.time,'%Y') = '".$schedule."' OR DATE_FORMAT(pro_log,'%Y') = '".$schedule."'";
		}

		$auction_sale_ar = PEO_getAuctionSale();
        if (strlen($schedule) > 0 ){
            $str = ' AND ((SELECT COUNT(*)
						   FROM '.$bid_cls->getTable().' AS bid
						   WHERE bid.property_id = pro.property_id '.str_replace('__','bid.time',$wh_str).') > 0
						   OR

						   (SELECT SUM(pro_log.view)
						   FROM '.$property_log_cls->getTable().' AS pro_log
						   WHERE pro_log.property_id = pro.property_id '.str_replace('__','pro_log.created_at',$wh_str).') > 0)';
        }

        //FOR THE BLOCK
        if (in_array($_SESSION['agent']['type'],array('theblock','agent'))){
            $where_clause .= ' (pro.agent_id IN (SELECT agent_id FROM '.$agent_cls->getTable().' WHERE parent_id = '.$_SESSION['agent']['id'].')
                                    OR IF(ISNULL(pro.agent_manager)
                                          OR pro.agent_manager = 0
                                          OR (SELECT parent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$_SESSION['agent']['id'].') = 0
                                          ,pro.agent_id = '.$_SESSION['agent']['id'].'
                                          , pro.agent_manager = '.$_SESSION['agent']['id'].'))';
        }else{
            $where_clause = ' pro.agent_id = '.$_SESSION['agent']['id'];
        }
        $rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.property_id, pro.address, pro.price, pro.suburb, pro.postcode,
							            (SELECT reg1.name
							             FROM '.$region_cls->getTable().' AS reg1
							             WHERE reg1.region_id = pro.state) AS state_name,

							            (SELECT reg2.code
							             FROM '.$region_cls->getTable().' AS reg2
							             WHERE reg2.region_id = pro.state) AS state_code,

							            (SELECT reg3.name
							             FROM '.$region_cls->getTable().' AS reg3
							             WHERE reg3.region_id = pro.country) AS country_name,

							            (SELECT reg4.code
							             FROM '.$region_cls->getTable().' AS reg4
							             WHERE reg4.region_id = pro.country) AS country_code,

							            (SELECT COUNT(*)
							             FROM '.$bid_cls->getTable().' AS bid
							             WHERE bid.property_id = pro.property_id '.str_replace('__','bid.time',$wh_str).') AS bids,

							            (SELECT SUM(pro_log.view)
							            FROM '.$property_log_cls->getTable().' AS pro_log
							            WHERE pro_log.property_id = pro.property_id '.str_replace('__','pro_log.created_at',$wh_str).') AS views

                                        FROM '.$property_cls->getTable().' AS pro
                                        WHERE '.$where_clause.$str.'

                                        ORDER BY pro.property_id DESC
                                        LIMIT '.($p - 1) * $len.','.$len,true);
		$property_rows = array();
        $total_row = 0;
		if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $key => $row) {
				//$link_ar = array('module' => 'agent', 'action' => 'view-report-property-detail' , 'id' => $row['property_id'], 'schedule' => $schedule);
				$link_ar = array( 'action' => 'view-report-property-detail' , 'id' => $row['property_id'], 'schedule' => $schedule);
                $link_view = array( 'action' => 'view-report-property-view' , 'id' => $row['property_id'], 'schedule' => $schedule);
				$dt = new DateTime($row['end_time']);
			
				/*
				if ($row['auction_sale'] == $auction_sale_ar['auction']) {
					$link_ar['action'] = 'view-auction-detail';
				} else {
					$link_ar['action'] = 'view-sale-detail';
				}
				*/
			
				$rows[$key]['views'] = (int)$rows[$key]['views'];
				$rows[$key]['title'] = $row['address'].' '.$row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
				//$rows[$key]['url'] = '/?'.http_build_query($link_ar);
				$rows[$key]['url'] = ROOTURL.'/modules/agent/popup.php?'.http_build_query($link_ar);
                $rows[$key]['view_url'] = ROOTURL.'/modules/agent/popup.php?'.http_build_query($link_view);

               /* if (strlen($schedule) > 0 ){
                    if ($row['views'] != 0 || $row['bids'] != 0){
                        $property_rows[] = $rows[$key];
                    }
                }*/
               $property_rows = $rows;
			}
			$smarty->assign('property_rows',$property_rows);
            $pag_cls->setTotal($total_row = $property_cls->getFoundRows())
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(10)
				->setUrl('/?module=agent&action='.getParam('action'))
				->setLayout('link_simple');
		    $smarty->assign('pag_str',$pag_cls->layout());
		}


	break;
}
$smarty->assign('agent',$agent);
$smarty->assign('len', $len);
$smarty->assign('len_ar', PE_getItemPerPage());
$smarty->assign('option_month_str',Report_optionsTime($schedule));
$smarty->assign('option_year',Report_optionsYear($schedule,$_SESSION['agent']['id']));
$smarty->assign('review_pagging',(($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)');
$smarty->assign('bid_data',$bid_data);
?>