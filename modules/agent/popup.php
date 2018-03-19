<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
include_once ROOTPATH.'/modules/report/inc/property_log.class.php';

if (!isset($property_log_cls) || !($property_log_cls instanceof Property_Log)) {
	$property_log_cls = new Property_Log();
}

$smarty = new Smarty; 
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}

$action = getParam('action');

switch ($action) {
    case 'view-report-property-view':
	case 'view-report-property-detail':
		include_once ROOTPATH.'/modules/report/inc/report.php';
		include_once ROOTPATH.'/modules/general/inc/bids.php';
		$schedule = restrictArgs(getParam('schedule'),'[^0-9\-]');	
		
		$id = restrictArgs(getParam('id',0));
		if ($id > 0) {
			$form_action = '/?module=agent&action=view-report-property-detail&id='.$id;
			$row = $property_cls->getRow('SELECT SQL_CALC_FOUND_ROWS pro.property_id, pro.address, pro.price, pro.suburb, pro.postcode, 
							(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
							(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
							(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
							(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code
							
						FROM '.$property_cls->getTable().' AS pro
						WHERE property_id = '.$id,true);
			$info = '';
			if (is_array($row) && count($row) > 0) {
				$info = $row['address'].' '.$row['suburb'].' '.$row['postcode'].' '.$row['state_name'].' '.$row['country_name'];
			}
            if ($schedule != ''){
                $info .= ' ('.$schedule.')';
            }
			$data = array();
			$type = array('bid' => 'Bid', 'view'=>'View');
			
			
			$wh_str = '';
			if (strlen($schedule) == 7) {
				$wh_str = "AND DATE_FORMAT(__,'%Y-%m') = '".$schedule."' GROUP BY DATE_FORMAT(__,'%Y-%m-%d') ASC";
			} else if (strlen($schedule) == 4){
                $wh_str = "AND DATE_FORMAT(__,'%Y') = '".$schedule."' GROUP BY DATE_FORMAT(__,'%Y-%m') ASC";}
              else {
                //test
                 $start_day = $property_cls->getRow('property_id = '.$id);
                 $dt = new DateTime($start_day['creation_date']);
                 $schedule = $dt->format('Y');
                 $wh_str = "AND DATE_FORMAT(__,'%Y') = '".$schedule."' GROUP BY DATE_FORMAT(__,'%Y-%m') ASC";}

			//BEGIN BID
			$bid_rows = $bid_cls->getRows('SELECT COUNT(*) AS num,bid.time
							FROM '.$bid_cls->getTable().' AS bid
							WHERE bid.property_id = '.$id." ".str_replace('__','bid.time',$wh_str)
							,true);
			$bid_data = array();				
			if (is_array($bid_rows) && count($bid_rows) > 0) {
				foreach ($bid_rows as $row) {
					$dt = new DateTime($row['time']);
//					if (strlen($schedule) == 7) {
//						$bid_data[(int)$dt->format('d')] = $row['num'];
//					} else {
//						$bid_data[1] = $row['num'];
//					}
                    if (strlen($schedule)  == 7 ) {
						$bid_data[(int)$dt->format('d')] = $row['num'];
					} else {
						$bid_data[(int)$dt->format('m')] = $row['num'];
					}
				}
			}				
			//END
			//print_r($bid_cls->sql);
			//BEGIN VIEW
			$view_rows = $property_log_cls->getRows('SELECT SUM(pro_log.view) AS num, pro_log.created_at
							FROM '.$property_log_cls->getTable().' AS pro_log
							WHERE pro_log.property_id = '.$id." ".str_replace('__','pro_log.created_at',$wh_str)
							,true);
			$view_data = array();				
			if (is_array($view_rows) && count($view_rows) > 0) {
				foreach ($view_rows as $row) {
					$dt = new DateTime($row['created_at']);
//					if (strlen($schedule) == 7) {
//						$view_data[(int)$dt->format('d')] = $row['num'];
//					} else {
//						$view_data[1] = $row['num'];
//					}
                     if (strlen($schedule)  == 7) {
						$view_data[(int)$dt->format('d')] = $row['num'];
					} else {
						$view_data[(int)$dt->format('m')] = $row['num'];
					}
				}
			}				
			
			//END
			if (strlen($schedule) == 7) {
					$loop = lastDayOfMonth($schedule);
				} else{ //year or none
					$loop = 12;
			}
			
			foreach ($type as $key => $val) {
//				if (strlen($schedule) == 7) {
//					$loop = lastDayOfMonth($schedule);
//				} else {
//					$loop = 1;
//				}
				
				for ($i = 1; $i <= $loop; $i++) {
					switch ($key) {
						case 'bid':
							$data[$key][$i] = isset($bid_data[$i]) ? $bid_data[$i]: 0;
							$day_str .= '<th scope="col">'.$i.'</th>';
//							if ($loop == 1) {
//								$day_str .= '<th scope="col"></th>';
//							} else {
//								$day_str .= '<th scope="col">'.$i.'</th>';
//							}
							
						break;
						case 'view':
							$data[$key][$i] = isset($view_data[$i]) ? $view_data[$i]: 0;	
						break;
					}
				}
			}

			$smarty->assign('form_action',ROOTURL.'/modules/agent/popup.php?action='.$action.'&id='.$id);
            $smarty->assign('action',$action);
			$smarty->assign('day_str',$day_str);
			$smarty->assign('data',$data);
			$smarty->assign('type',$type);
			$smarty->assign('info',$info);
			//$smarty->assign('option_month_str',Report_optionsTime($schedule));
            //print_r($schedule);
            $smarty->assign('option_month_str',Report_optionsMonthForBid($id,substr($schedule,0,4),$schedule));
            $smarty->assign('option_view_str',Report_optionsMonthForView($id,substr($schedule,0,4),$schedule));
			$smarty->template_dir = ROOTPATH.'/modules/agent/templates/';
			$smarty->display('agent.report.popup.tpl');
		} else {
			redirect('?module=agent&action=view-report');
		}			
	break;
}


?>