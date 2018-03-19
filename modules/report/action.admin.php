<?php

ini_set('display_errors',0);
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/property/inc/property.php';

if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

restrict4AjaxBackend();
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
$action_ar = explode('-', $action);

if (in_array($action_ar[0], array('list', 'delete'))) {
	$perm_tmp_ar = array('list' => 'view', 'delete' => 'delete');
	if ($perm_ar[$perm_tmp_ar[$action_ar[0]]] == 0) {
		die(json_encode($perm_msg_ar[$perm_tmp_ar[$action_ar[0]]]));
	}
}
$typeOfEmail_arr = array('email_to_friend'=>'Send to friend Email',
                         'email_alert'=>'Email Alert',
                         'notify'=>'Notification Email',
                         'register'=>'Register Member Email',
                         'forgot_password'=>'Forgot password Email',
                         'remind'=>'Reminder Email',
                         'make_offer'=>'Make Offer Email',
                         'contact_vendor'=>'Contact vendor Email',
                         'newsletter'=>'Newsletter'
                         );
switch ($action) {
	case 'list-agent_time':
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		__reportListAgenttimeAction();
	break;
	case 'list-agent':
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		
		__reportListAgentAction();
	break;
	
	case 'list-email_alert':
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/emailalert/inc/emailalert.php';
		include_once ROOTPATH.'/modules/general/inc/regions.php';
		__reportListEmailalertAction();
	break;

	case 'list-email_system':
		include_once ROOTPATH . '/modules/general/inc/email_log_system.class.php';
		__reportListEmailSystemtAction();
	break;

	case 'delete-emailalert':
		include_once ROOTPATH.'/modules/emailalert/inc/emailalert.class.php';
		if (!isset($emailalert_cls) or !($emailalert_cls instanceof EmailAlert)) {
			$emailalert_cls = new EmailAlert();
		}
		__reportDeleteEmailalertAction();
	break;
	case 'list-email_enquire':
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		__reportListEmailEnquireAction();
	break;
	case 'list-page':
		include_once 'inc/report.php';
		include_once ROOTPATH.'/modules/cms/inc/cms.php';
		__reportListPageAction();
	break;
	case 'list-page_month':
		__reportListPageMonthAction();
	break;
	case 'list-page_year':
		__reportListPageYearAction();
	break;
	
	case 'list-property':
		include_once ROOTPATH.'/modules/general/inc/regions.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		__reportListPropertyAction();
	break;
	case 'list-banner':
	break;
	case 'list-property_time':
		include_once ROOTPATH.'/modules/property/inc/property.php';
		__reportListPropertyTimeAction();
	break;
	
	case 'list-price_range':
		include_once ROOTPATH.'/modules/general/inc/regions.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
        include_once ROOTPATH.'/modules/general/inc/search_data.php';
		__reportListPriceRangeAction();
	break;
    case 'list-range':
		include_once ROOTPATH.'/modules/general/inc/regions.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/general/inc/search_data.php';
      	__reportListRangeAction();
    break;
	
	// DUC CODING NEW REPORT
	case 'list-new_property':
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';										  
		__reportListNewPropertyAction();   
	break;
	
	case 'list-property_sold':
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/property/inc/property_term.class.php';
		include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
	
		__reportListPropertySoldAction();
    break;

    case 'report-soldpassedin':
        include_once ROOTPATH.'/modules/property/inc/property.php';
        include_once ROOTPATH.'/modules/property/inc/property_term.class.php';
        include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
        __reportSoldPassedInAction();
	break;

    case 'view-option-year':
        __viewOptionYearAction();
    break;

	case 'list-email_send':
		__reportListEmailAction();							
	break;
    case 'list-region':
		__reportListRegionAction();
    break;
    case 'search-property':
        __searchProperty();
    break;
    case 'search-email':
        __searchEmail();
	break;
	case 'list-bid-property':
		include_once ROOTPATH.'/modules/general/inc/bids.php';	
		__reportListBidPropertyAction();
	break;	
	case 'list-bid-property-agent':
		include_once ROOTPATH.'/modules/general/inc/bids.php';
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		__reportListBidPropertyAgentAction();
	break;
	case 'list-developments':
        include_once ROOTPATH.'/modules/general/inc/development.class.php';
		__reportDevelopmentsAction();
	break;
}

/*----*/
/*
@function : __reportListAgenttimeAction
*/

function __reportListAgenttimeAction() {
	global $agent_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',0));
	$sort_by = getParam('sort','pro.property_id');
	$dir = getParam('dir','ASC');	
	
	$rows = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS COUNT(*) AS num, DATE_FORMAT(creation_time,\'%Y-%m\') AS time 
			FROM '.$agent_cls->getTable().' 
			GROUP BY DATE_FORMAT(creation_time,\'%Y-%m\')
			LIMIT '.$start.','.$limit,true);
	$total = $agent_cls->getFoundRows();
	$topics = array();
			
	if (is_array($rows) && count($rows) > 0) {
		$topics = $rows;
	}
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}
/*
@ function : __reportListAgentAction
*/

function __reportListAgentAction() {
	global $agent_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',0));
	$sort_by = restrictArgs(getParam('sort','pro.property_id'));
	$dir = getParam('dir','ASC');	
	
	
	$date_begin = trim(getParam('date_begin'));
	$date_end = trim(getParam('date_end'));
	
	$wh_str = '';
	if (strlen($date_begin) > 0 && strlen($date_end) > 0) {
		$ex = explode('/',$date_begin);
		$date_begin = $ex[2].'-'.$ex[0].'-'.$ex[1];
		
		$ex = explode('/',$date_end);
		$date_end = $ex[2].'-'.$ex[0].'-'.$ex[1];
		
		$wh_str = 'AND (DATE_FORMAT(creation_time,\'%Y-%m-%d\') BETWEEN \''.$date_begin.'\' AND \''.$date_end."')";
	}
	
	
	$rows = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS DISTINCT agt_typ.agent_type_id AS type_id, agt_typ.title,
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable().' AS agt_1 
						WHERE agt_1.type_id = agt_typ.agent_type_id '.str_replace('agt','agt_1',$wh_str).') AS agent_total,
						
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable().' AS agt_2 
						WHERE agt_2.type_id = agt_typ.agent_type_id AND agt_2.is_active = 1 '.str_replace('agt','agt_1',$wh_str).') AS agent_active,
						
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable().' AS agt_3 
						WHERE agt_3.type_id = agt_typ.agent_type_id AND agt_3.is_active = 0 '.str_replace('agt','agt_1',$wh_str).') AS agent_inactive,
						
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable().' AS agt_4 
						WHERE agt_4.type_id = agt_typ.agent_type_id AND agt_4.notify_email = 1 '.str_replace('agt','agt_1',$wh_str).') AS note_email,
						
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable().' AS agt_5 
						WHERE agt_5.type_id = agt_typ.agent_type_id AND agt_5.notify_sms = 1 '.str_replace('agt','agt_1',$wh_str).') AS note_sms
						
					FROM '.$agent_cls->getTable('agent_type').' AS agt_typ 
					LIMIT '.$start.','.$limit,true);
	
	//echo $agent_cls->sql;
	$total = $agent_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		$_row = array('type_id' => '', 
					  'agent_type' => '', 
					  'total' => 0 ,
					  'note_email' => 0,
					  'note_sms' => 0,
					  'active' => 0 ,
					  'inactive' => 0);
        $agent_arr = AgentType_getOptions_(false);
		foreach ($rows as $row) {
			//$row['agent_type'] = ucfirst($row['title']);
             if ($row['title'] != 'guest'){
                $row['agent_type'] = $agent_arr[$row['type_id']];
                $row['total'] = $row['agent_total'];
                $row['active'] = $row['agent_active'];
                $row['inactive'] = $row['agent_inactive'];
                $topics[] = $row;
                
                $_row['total'] += $row['total'];
                $_row['note_email'] += $row['note_email'];
                $_row['note_sms'] += $row['note_sms'];
                $_row['active'] += $row['active'];
                $_row['inactive'] += $row['inactive'];
             }
		}
		
		$_row['total'] = '<div class="col_special">'.$_row['total'].'</div>';
		$_row['note_email'] = '<div class="col_special">'.$_row['note_email'].'</div>';
		$_row['note_sms'] = '<div class="col_special">'.$_row['note_sms'].'</div>';
		$_row['active'] = '<div class="col_special">'.$_row['active'].'</div>';
		$_row['inactive'] = '<div class="col_special">'.$_row['inactive'].'</div>';
		
		$topics[] = $_row;
	}		
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));
}

/*
@ function : __reportListEmailalertAction
*/

function __reportListEmailalertAction() {
	global $email_cls, $region_cls, $property_entity_option_cls,$agent_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','ealt.email_id');
	$dir = getParam('dir','DESC');	

	
	$rows = $email_cls->getRows('SELECT SQL_CALC_FOUND_ROWS e.email_id,
								e.name_email,
								e.minprice,
								e.maxprice,
								e.address,
								e.suburb,
								e.postcode,
								e.minprice,
								e.maxprice,
								e.land_size_max,
								e.land_size_min,
								e.unit,
								e.last_cron,
								a.email_address,

								(SELECT reg3.name
								 FROM '.$region_cls->getTable().' AS reg3
								 WHERE reg3.region_id = e.country
								 ) AS country_name,

								(SELECT reg1.name
								 FROM '.$region_cls->getTable().' AS reg1
								 WHERE reg1.region_id = e.state
								 ) AS state_name,

								(SELECT pro_opt4.value
								 FROM '.$property_entity_option_cls->getTable().' AS pro_opt4
								 WHERE pro_opt4.property_entity_option_id = e.car_space
								 ) AS car_space_value,

								(SELECT pro_opt3.value
								 FROM '.$property_entity_option_cls->getTable().' AS pro_opt3
								 WHERE pro_opt3.property_entity_option_id = e.car_port
								 ) AS car_port_value,

								(SELECT pro_opt1.value
								 FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
								 WHERE pro_opt1.property_entity_option_id = e.bathroom
								 ) AS bathroom_value,

								(SELECT pro_opt2.value
								 FROM '.$property_entity_option_cls->getTable().' AS pro_opt2
								 WHERE pro_opt2.property_entity_option_id = e.bedroom
								 ) AS bedroom_value,

								(SELECT pro_opt6.title
								  FROM '.$property_entity_option_cls->getTable().' AS pro_opt6
								  WHERE pro_opt6.property_entity_option_id = e.property_type
								) AS type_name,

								(SELECT pro_opt7.title
								  FROM '.$property_entity_option_cls->getTable().' AS pro_opt7
								  WHERE pro_opt7.property_entity_option_id = e.auction_sale
								) AS as_name

						   FROM '.$email_cls->getTable().' AS e
						   LEFT JOIN '.$agent_cls->getTable().' AS a
						   ON e.agent_id = a.agent_id
						   ORDER BY '.$sort_by.' '.$dir.'
						   LIMIT '.$start.','.$limit,true);
				
	$total = $email_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {

			//print_r($row[$key]);
			//$row['address'] = $row['suburb'].' '.$row['state_name'].' '.$row['country_name'];
			$row['minprice'] = $row['minprice'] == '0'?'Any':showPrice($row['minprice']);
			$row['maxprice'] = $row['maxprice'] == '0'?'Any':showPrice($row['maxprice']);
			$row['full_address'] = $row['address'].' '.$row['suburb'].' '.$row['state_name'].' '.$row['postcode'].' '.$row['country_name'];
			$row['status'] = ($row['last_cron'] == '0000-00-00 00:00:00')?'<span style="color:red;">Pending</span>':'Sent';
			$row['unit'] = $property_entity_option_cls->getItem($row['unit'],'title');
			foreach ($row as $k=>$_r){
				$row[$k] = ($row[$k] == null || $row[$k] == '0')?'Any':$_r;
				//$row[$k] = ($row[$k] == '0')?'Any':$_r;
			   
			}

			//$row['delete'] = '<a style="cursor:pointer; text-decoration:none; color:#FF0000" onclick ="deleteItemF5(\'/modules/report/action.admin.php?action=delete-emailalert&email_id='.$row['email_id'].'\');"> Delete </a>';
			$topics[] = $row;
		}
	}		
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
	
}
/*
@ function : __reportListEmailSystemtAction
*/
function __reportListEmailSystemtAction() {
	global $email_log_system;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$date_from = (getParam('date_from','0000-00-00'));
	$date_to = (getParam('date_to','0000-00-00'));
	$date_from .= ' 00:00:00';
	$date_to .= ' 00:00:00';
	$con = '1';
	if($date_from > '0000-00-00 00:00:00'){
		$con = 'date_create >= \''. $date_from.'\'';
	}
	if($date_to > '0000-00-00 00:00:00'){
		$con .= ' AND date_create <=\''.$date_to.'\'';
	}
	$sort_by = getParam('sort','id');
	$dir = getParam('dir','DESC');
	$rows = $email_log_system->getRows('SELECT SQL_CALC_FOUND_ROWS *
						   FROM '.$email_log_system->getTable().' AS e
						   WHERE '.$con.'
						   ORDER BY '.$sort_by.' '.$dir.'
						   LIMIT '.$start.','.$limit,true);
	$total = $email_log_system->getFoundRows();
	$topics = array();
	$data = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['status'] = ($row['status'] == 0)?'<span style="color:red;">Pending</span>':'Sent';
			$data = unserialize($row['data']);
			if(is_array($data['to'])){
				$data['to'] = implode(',',$data['to']);
			}
			$data['message'] = strip_tags(nl2br($data['message']));
			$topics[] = array_merge($row,$data);
		}
	}

	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));

}
/*
@ function : __reportDeleteEmailalertAction
*/

function __reportDeleteEmailalertAction() {
	global $emailalert_cls;
	$email_id = (int)restrictArgs(getParam('email_id',0));
	$emailalert_cls->delete('email_id = '.$email_id);
	$message = 'Deleted #'.$email_id;
	die( $message);		
}

/*
@ function : __reportListEmailEnquireAction
*/

function __reportListEmailEnquireAction() {
	global $message_cls, $agent_cls, $token;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','m.message_id');
	$dir = getParam('dir','DESC');	

	
	$rows = $message_cls->getRows('SELECT SQL_CALC_FOUND_ROWS m.* 
					,(SELECT a1.email_address FROM '.$agent_cls->getTable().' AS a1 WHERE a1.agent_id = m.agent_id_from) AS email_from2
					,(SELECT a2.email_address FROM '.$agent_cls->getTable().' AS a2 WHERE a2.agent_id = m.agent_id_to) AS email_to2
					FROM '.$message_cls->getTable().' AS m 
					
					ORDER BY '.$sort_by.' '.$dir.'
					LIMIT '.$start.','.$limit,true);
	
	$total = $message_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			
			$row['title'] = $row['title'];
							
			$row['sender'] = $row['email_from'];
			if (strlen($row['sender']) == 0) {
				$row['sender'] = $row['email_from2'];
			}
			
			$row['receiver'] = $row['email_to'];
			if (strlen($row['receiver']) == 0) {
				$row['receiver'] = $row['email_to2'];
			}
			
			$dt = new DateTime($row['send_date']);
			$row['sent_date'] = $dt->format($config_cls->getKey('general_date_format'));
			
			
			$url = '/modules/report/popup.php?action=view-email_enquire-detail&message_id='.$row['message_id'].'&token='.$token;
			//$row['show'] = '<a href="javascript:void(0)" onclick="report.showBox(\''.$row['message_id'].'\',\'container\',\''.$token.'\')">show</a>';
			$row['show'] = '<a href="javascript:void(0)" onclick="wow(\''.$url.'\',\'300\',\'400\')">show</a>';
			
			$topics[] = $row;
		}
	}
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	

}

/*
@ function : __reportListPageAction
*/

function __reportListPageAction() {
	global $page_log_cls, $page_log_time_cls, $cms_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','page_log_id');
	$dir = getParam('dir','DESC');	
	$time_at = getParam('time_at');
	$type = getParam('type');

	$wh_str = '';		
	switch ($type) {
		case 'daily':
			$wh_str = "AND pag_log_time.create_at = '".date('Y-m-d')."'";
		break;
		case 'weekly':
			$wh_str = "AND pag_log_time.create_at BETWEEN '".beginWeek('Y-m-d')."' AND '".endWeek('Y-m-d')."' ";
		break;
		case 'monthly':
			
			if (strlen($time_at) > 0) {
				$time_ar = explode('-',$time_at);
				$wh_str = "AND DATE_FORMAT(pag_log_time.create_at,'%Y-%m') = '".$time_ar[0].'-'.$time_ar[1]."'";
			} else {
				$wh_str = "AND MONTH(pag_log_time.create_at) = ".date('m');
			}
		break;
		case 'yearly':
			if (strlen($time_at) > 0) {
				$wh_str = "AND YEAR(pag_log_time.create_at) = ".$time_at;
			} else {
				$wh_str = "AND YEAR(pag_log_time.create_at) = ".date('Y');
			}
		break;
	}
	
	$rows = $page_log_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pag_log.* ,

	                                (SELECT SUM(pag_log_time.view)
					                 FROM '.$page_log_time_cls->getTable().' AS pag_log_time
					                 WHERE pag_log_time.page_log_id = pag_log.page_log_id '.$wh_str.') AS view

					                FROM '.$page_log_cls->getTable().' AS pag_log
					                WHERE
					                    (
					                    (SELECT SUM(pag_log_time.view)
                                         FROM '.$page_log_time_cls->getTable().' AS pag_log_time
                                         WHERE pag_log_time.page_log_id = pag_log.page_log_id '.$wh_str.') > 0
					                OR (
					                    (SELECT SUM(pag_log_time.view)
                                         FROM '.$page_log_time_cls->getTable().' AS pag_log_time
                                         WHERE pag_log_time.page_log_id = pag_log.page_log_id '.$wh_str.') IS NOT NULL)
                                         )
                                    GROUP BY pag_log.page_log_id
                                    ORDER BY '.$sort_by.' '.$dir.'
                                    LIMIT '.$start.','.$limit,true);
	//die($page_log_cls->sql);
    /* INNER JOIN '.$cms_cls->getTable().' as cms
                                    ON pag_log.page_id = cms.page_id
                                    OR pag_log.title = "FAQ"
                                    OR pag_log.title = "Contact Us"
                                    OR pag_log.title ="Partners"*/
	$total = $page_log_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			if (!($row['view'] > 0) OR !isset($row['view'])) {
				$row['view'] = 0;
			}else{
                $topics[] = $row;
            }

		}
	}
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));
    //die('test');
}

/*
@ function __reportListPageMonthAction
*/

function __reportListPageMonthAction() {
	global $property_cls;
	//BEGIN MONTHLY
	$row = $property_cls->getRow('1 ORDER BY DATE_FORMAT(creation_date,\'%Y-%m\') ASC');
	$year = date('Y');
	$month = date('m');
	
	$options[] = array('value' => '', 'title' => 'All');
	for ($i = $year; $i <= date('Y'); $i++) {
		for ($j = 1; $j <= 12; $j++ ) {
			$_j = substr('00'.$j,-2);
			$options[] = array('value' => $i.'-'.$_j, 'title' => $i.'-'.$_j);
		}
	}
	
	$result = array('data'=>$options);
	die(json_encode($result));
	//END
}

/*
@ function : __reportListPageYearAction
*/

function __reportListPageYearAction() {
	global $property_cls;
	//BEGIN YEARLY
	$row = $property_cls->getRow('1 ORDER BY YEAR(creation_date) ASC');
	$year = date('Y');
	if (is_array($row) && count($row) > 0) {
		$dt = new DateTime($row['creation_date']);
		if ($dt->format('Y') > 0) {
			$year = $dt->format('Y');
		}
	}
	
	$options[] = array('value' => '', 'title' => 'All');
	for ($i = $year; $i <= date('Y'); $i++) {
		$options[] = array('value' => $i, 'title' => $i);
	}
	//END
	$result = array('data'=>$options);
	die(json_encode($result));

}

/*
@ function __reportListPropertyAction
*/

function __reportListPropertyAction() {
	global $region_cls, $property_cls, $property_entity_option_cls, $config_cls;	
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','pro.property_id');
	$dir = getParam('dir','ASC');	
	$type = getParam('key', 0);
	$type_key_str = "property_type','property_type_commercial";
	if ($type == 1) {
		$type_key_str = 'property_type_commercial';
	} else if ($type == 2) {
		$type_key_str = 'property_type';
	}
	
	$date_begin = getParam('date_begin');
	$date_end = getParam('date_end');
	
	$wh_str = '';
	if (strlen($date_begin) > 0 && strlen($date_end) > 0) {
		$ex = explode('/',$date_begin);
		$date_begin = $ex[2].'-'.$ex[0].'-'.$ex[1];
		
		$ex = explode('/',$date_end);
		$date_end = $ex[2].'-'.$ex[0].'-'.$ex[1];
		
		$wh_str = 'AND (DATE_FORMAT(creation_time,\'%Y-%m-%d\') BETWEEN \''.$date_begin.'\' AND \''.$date_end."')";
	}
	
	$total = 0;
	$topics = array();
	$region_rows = $region_cls->getRows('parent_id ='.$config_cls->getKey('general_country_default'));
	if (is_array($region_rows) && count($region_rows) > 0) {
		foreach ($region_rows as $region_row) {
		
			$state_name = $region_row['name'];
			$property_rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS peo.title AS type_name,
			                    (SELECT COUNT(pro.property_id)
								FROM '.$property_cls->getTable().' AS pro
								WHERE pro.type = peo.property_entity_option_id
								AND pro.state = '.$region_row['region_id'].') AS num,

								(SELECT MAX(pro.price)
								FROM '.$property_cls->getTable().' AS pro
								WHERE pro.type = peo.property_entity_option_id 
										AND pro.state = '.$region_row['region_id'].') AS hightest_price,

								(SELECT MIN(pro.price)
								FROM '.$property_cls->getTable().' AS pro
								WHERE pro.type = peo.property_entity_option_id
										AND pro.state = '.$region_row['region_id'].') AS lowest_price,
								
								(SELECT MIN(peo_1.value)
								FROM '.$property_cls->getTable().' AS pro,'.$property_entity_option_cls->getTable().' AS peo_1
								WHERE pro.bedroom = peo_1.property_entity_option_id 
										AND pro.type = peo.property_entity_option_id
										AND pro.state = '.$region_row['region_id'].') AS min_bedroom,
								
								(SELECT MAX(peo_1.value)
								FROM '.$property_cls->getTable().' AS pro,'.$property_entity_option_cls->getTable().' AS peo_1
								WHERE pro.bedroom = peo_1.property_entity_option_id 
										AND pro.type = peo.property_entity_option_id
										AND pro.state = '.$region_row['region_id'].') AS max_bedroom,

								(SELECT MIN(peo_1.value)
								FROM '.$property_cls->getTable().' AS pro,'.$property_entity_option_cls->getTable().' AS peo_1
								WHERE pro.bathroom = peo_1.property_entity_option_id 
										AND pro.type = peo.property_entity_option_id
										AND pro.state = '.$region_row['region_id'].') AS min_bathroom,

								(SELECT MAX(peo_1.value)
								FROM '.$property_cls->getTable().' AS pro,'.$property_entity_option_cls->getTable().' AS peo_1
								WHERE pro.bathroom = peo_1.property_entity_option_id 
										AND pro.type = peo.property_entity_option_id
										AND pro.state = '.$region_row['region_id'].') AS max_bathroom
								
								  
							FROM '.$property_entity_option_cls->getTable().' AS peo
							WHERE peo.parent_id  IN (SELECT peo_2.property_entity_option_id 
											FROM '.$property_entity_option_cls->getTable().' AS peo_2 
											WHERE peo_2.code IN (\''.$type_key_str.'\'))
							GROUP BY peo.property_entity_option_id',true);	
									
			if (is_array($property_rows) && count($property_rows) > 0) {
				foreach ($property_rows as $property_row) {
					$_row = array('state' => $state_name,
									'type' => $property_row['type_name'],
                                    'num'=>$property_row['num'],
									'hightest_price' => showPrice($property_row['hightest_price']),
									'lowest_price' => showPrice($property_row['lowest_price']),
									'bed_room' => $property_row['min_bedroom'].' - '.$property_row['max_bedroom'],
									'bath_room' => $property_row['min_bathroom'].' - '.$property_row['max_bathroom']);
					$topics[] = $_row;
					$total++;
					
				}
			}				
				
		}
	}
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}

/*
@ function : __reportListPropertyTimeAction
*/

function __reportListPropertyTimeAction() {
	global $property_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','pro.property_id');
	$dir = getParam('dir','ASC');	

	
	$rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS COUNT(*) AS num, DATE_FORMAT(creation_date,\'%Y-%m\') AS time 
			FROM '.$property_cls->getTable().' 
			GROUP BY DATE_FORMAT(creation_date,\'%Y-%m\')
			LIMIT '.$start.','.$limit,true);
	$total = $property_cls->getFoundRows();
	$topics = array();
			
	if (is_array($rows) && count($rows) > 0) {
		$topics = $rows;
	}
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	

}

/*
@ function : __reportListPriceRangeAction
*/

function __reportListPriceRangeAction() {
	global $region_cls, $property_cls, $config_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','pro.property_id');
	$dir = getParam('dir','ASC');
	$state = getParam('state');
	$wh_state = ($state == 0 )?'':' AND pro.state = '.$state;

	
	//BEGIN		
	$range_ar = array();
	$option_ar = optionsPriceMin();
	unset($option_ar[0]);
	
	$before = array();
	$data = array();
	foreach ($option_ar as $key => $val) {
		if (count($before) > 0) {
			list($_key,$_val) = each($before);
			$range_ar[] = array('min' => array($_key => $_val),'max' => array($key => $val));
		} else {
			$range_ar[] = array('min' => array(0 => '$0'),'max' => array($key => $val));
		}
		$before = array($key => $val);
	}
	list($_key,$_val) = each($before);
	$range_ar[] = array('min' => array($_key => $_val),'max' => array(0 => '>'));
	//END
	$total = 0;
	$topics = array();
	$chart = array();


	
	$region_rows = $region_cls->getRows('parent_id ='.$config_cls->getKey('general_country_default'));
	$row = $property_cls->getRow('SELECT COUNT(*) AS num
				FROM '.$property_cls->getTable().' AS pro
				WHERE pro.country = '.$config_cls->getKey('general_country_default'),true);
	$_num = 1;
	if (is_array($row) && count($row) > 0 && $row['num'] > 0) {
		$_num = $row['num'];			
	}

	$data_str = '';
	foreach ($range_ar as $item_ar) {
		list($min_key,$min_val) = each($item_ar['min']);
		list($max_key,$max_val) = each($item_ar['max']);
		
		$wh_str = '';
		if ($min_key > 0) {
			$wh_str .= ' AND pro.price > '.$min_key;
		}
		
		if ($max_key > 0) {
			$wh_str .= ' AND pro.price <= '.$max_key;
		}

		$row = $property_cls->getRow('SELECT COUNT(pro.property_id) AS num
									  FROM '.$property_cls->getTable().' AS pro
									  WHERE 1 '.$wh_state.$wh_str,true);
		$__num = 0;
		if (is_array($row) && count($row) > 0 && $row['num'] > 0) {
				$__num = $row['num'];
		}

		$_row = array('state' => '',
					  'price_range' => $min_val.' - '.$max_val,
					  'property_number' => $__num,
					  'percent' => number_format(($__num*100)/$_num,2).'%');
		$pri_range = $min_val - $max_val;
		//$data[] = array('name' => $min_val - $max_val , 'data' => number_format(($__num*100)/$_num,2) );
		$topics[] = $_row;
	}
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}

/*
@ function : __reportListRangeAction
*/

function __reportListRangeAction() {
	global $region_cls, $property_cls, $config_cls;
	//BEGIN
	$state = getParam('state');
	$wh_state = $state == 0 ? '':' AND pro.state = '.$state;
	$range_ar = array();
	$option_ar = optionsPriceMin();
	unset($option_ar[0]);

	$before = array();
	$data = array();
	foreach ($option_ar as $key => $val) {
		if (count($before) > 0) {
			list($_key,$_val) = each($before);
			$range_ar[] = array('min' => array($_key => $_val),'max' => array($key => $val));
		} else {
			$range_ar[] = array('min' => array(0 => '$0'),'max' => array($key => $val));
		}
		$before = array($key => $val);
	}
	list($_key,$_val) = each($before);
	$range_ar[] = array('min' => array($_key => $_val),'max' => array(0 => '>'));
	//END
	$total = 0;
	$chart = array();


	$region_rows = $region_cls->getRows('parent_id = '.$config_cls->getKey('general_country_default'));
	$row = $property_cls->getRow('SELECT COUNT(*) AS num
				FROM '.$property_cls->getTable().' AS pro
				WHERE pro.country = '.$config_cls->getKey('general_country_default'),true);
	$_num = 1;
	if (is_array($row) && count($row) > 0 && $row['num'] > 0) {
		$_num = $row['num'];
	}

	  //BEGIN FOR CHART
	foreach ($range_ar as $item_ar) {
		list($min_key,$min_val) = each($item_ar['min']);
		list($max_key,$max_val) = each($item_ar['max']);
		$wh_str = '';
		if ($min_key > 0) {
			$wh_str .= ' AND pro.price > '.$min_key;
		}

		if ($max_key > 0) {
			$wh_str .= ' AND pro.price <= '.$max_key;
		}
		$row = $property_cls->getRow('SELECT COUNT(pro.property_id) AS num
							FROM '.$property_cls->getTable().' AS pro
							WHERE 1'. $wh_state.$wh_str,true);
		$chart[] = array('name'=>$min_val .'-'.$max_val,'y'=>(int)$row['num']);
	}
	//END CHART
	$result = array('totalCount' => $total,'chart'=>$chart);
	die(json_encode($result));
}

/*
@ function : __reportListNewPropertyAction
*/

function __reportListNewPropertyAction() {
	global $property_cls, $property_entity_option_cls;
	$rows = $property_cls->getRows('SELECT COUNT(pro.property_id) as total,
										(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
												INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
											ON b.type = po2.property_entity_option_id 	 
												WHERE po2.title = "House" AND b.agent_active = 1 AND b.active = 0 ) as house,
										(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
												INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
											ON b.type = po2.property_entity_option_id 	 
												WHERE po2.title = "Apartment" AND b.agent_active = 1 AND b.active = 0 ) as apartment,
										(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
												INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
											ON b.type = po2.property_entity_option_id 	 
												WHERE po2.title = "Land estate" AND b.agent_active = 1 AND b.active = 0 ) as land,
										(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
												INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
											ON b.type = po2.property_entity_option_id 	 
												WHERE po2.title = "Flat" AND b.agent_active = 1 AND b.active = 0 ) as flat				
								FROM '.$property_cls->getTable().' AS pro WHERE pro.agent_active = 1 AND pro.active = 0 ',true);
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','ealt.email_id');
	$dir = getParam('dir','DESC');	
				
	$total = $property_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$topics[] = $row;
		}
	}		
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));

}

/*
@ function : __reportListPropertySoldAction
*/

function __reportListPropertySoldAction() {
	global $property_cls, $property_entity_option_cls;

	$rows = $property_cls->getRows('SELECT COUNT(pro.property_id) as total,
									(SELECT COUNT(*) FROM '.$property_cls->getTable().' 
										WHERE confirm_sold = 1) as total_sold,
									(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
											INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
										ON b.type = po2.property_entity_option_id 	 
											WHERE po2.title = "House" AND b.confirm_sold = 1) as house,
									(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
											INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
										ON b.type = po2.property_entity_option_id 	 
											WHERE po2.title = "Apartment" AND b.confirm_sold = 1) as apartment,
									(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
											INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
										ON b.type = po2.property_entity_option_id 	 
											WHERE po2.title = "Land estate" AND b.confirm_sold = 1) as land,
									(SELECT COUNT(*) FROM '.$property_cls->getTable().' AS b 
											INNER JOIN '.$property_entity_option_cls->getTable().' AS po2
										ON b.type = po2.property_entity_option_id 	 
											WHERE po2.title = "Flat" AND b.confirm_sold = 1) as flat				
							FROM '.$property_cls->getTable().' AS pro ',true);								
								
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','ealt.email_id');
	$dir = getParam('dir','DESC');	
				
	$total = $property_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
		
			$topics[] = $row;
		}
	}		
	
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}

/*
@ function : __reportListEmailAction
*/

function __reportListEmailAction() {
	global $report_email_cls;
	include_once ROOTPATH.'/modules/general/inc/report_email.php';

	$rows = $report_email_cls->getRow('SELECT
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "bids") as bids,
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "contact_vendor") as contact_vendor,
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "makeof") as makeof,
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "send_friend") as send_friend,
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "alertemail") as alertemail,
										(SELECT send_number FROM '.$report_email_cls->getTable().' WHERE title = "register_agent") as register_agent,
										sum(send_number) as total_mail
										FROM '.$report_email_cls->getTable().'', true);
	$total = $report_email_cls->getFoundRows();
	if (is_array($rows) and count($rows) > 0) {
		$topics = array();
		foreach ($rows as $key=>$row) {
			switch ($key){
				case '0':
					$key = '';
					break;
				case 'total_mail':
					$key = '<span style="font-weight: bold;">Total Email sent</span>';
					break;
				case 'bids':
					$key = 'Sent Bids';
					break;
				case 'contact_vendor':
					$key = 'Sent Contact Vendor';
					break;
				case 'makeof':
					$key = 'Sent Make Offer';
					break;
				case 'send_friend':
					$key = 'Sent Email to Friend';
					break;
				case 'alertemail':
					$key = 'Sent Email Alert';
					break;
				case 'register_agent':
					$key = 'Sent Register Agent';
					break;
				default:
					$key = '';
					break;
			}
			if ($key != ''){
				$topics[] = array('name'=>$key,'number'=>$row);
			}

		}
	}
	$result = array('totalCount' => $total, 'topics' => $topics);
	die(json_encode($result));	
}

/*
@ function : __reportListRegionAction
*/

function __reportListRegionAction() {
	$option = getParam('ot');
	$option_arr = array();
	$result = array();
	$option_arr = ($option == 'country')?R_getOptions(0):R_getOptions(1);
	foreach($option_arr as $key=>$_opt){
		if ($key == 0) $_opt = 'All';
		$result[] = array('value'=>$key,'title'=>$_opt);
	}
	$_r = array('data'=>$result);
	die(json_encode($_r));
}

function __searchProperty(){
    $date_from = getParam('date_from','');
    $date_to = getParam('date_to','');
    $wh_str = '';
    if ($date_from != '' || $date_to != ''){
        if ($date_to != ''){
            $wh_str .= " AND pro.creation_date <= '".$date_to."'";
        }
        if ($date_from !=''){
            $wh_str .= " AND pro.creation_date >= '".$date_from."'";
        }
    }
    $news = propertyNew($wh_str);
    $solds = propertySold($wh_str);
    $packages = propertyPackage($wh_str);
    $html = '<table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th colspan="3" class="top">
                        <span style="font-weight: bold !important;">Report new Property Registration</span>
                    </th>
                </tr>
                <tr>
                    <th width="50%"><span>Description</span></th>
                    <th><span>Property number</span></th>
                </tr>
                <tr>
                    <td colspan="3">';
    foreach ($news as $new){
        $html .= ' <div class="row">
                      <span style="float: left;margin-right: 19px;margin-left:0px !important;">'.$new['name'].'</span>
                      <span>'.$new['number'].'</span>
                       <div class="clr"></div>
                   </div>';
    }

    $html .= '</td>
            </tr>
          </table>
          <table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
             <tr>
                <th colspan="3" class="top">
                     <span style="font-weight: bold !important;">Report Property Sold</span>
                </th>
             </tr>
             <tr>
                 <th width="50%"><span>Description</span></th>
                 <th><span>Property number</span></th>
             </tr>
             <tr>
                 <td colspan="3">';
    foreach ($solds as $sold){
        $html .= '<div class="row">
                      <span style="float: left;margin-right: 19px;margin-left:0px !important;">'.$sold['name'].'</span>
                      <span>'.$sold['number'].'</span>
                      <div class="clr"></div>
                  </div>';
    }
    $html .= '</td>
             </tr>
          </table>
          <table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                  <th colspan="3" class="top">
                      <span style="font-weight: bold !important;">Report Property\'s packages</span>
                  </th>
               </tr>
               <tr>
                   <th width="50%">
                       <span>Package</span>
                   </th>
                   <th>
                       <span>Property number</span>
                   </th>
               </tr>
               <tr>
                    <td colspan="3">';
    foreach ($packages as $package){
        $html .= '<div class="row">
                       <span style="float: left;margin-right: 19px;margin-left:0px !important;">'.$package['name'].'</span>
                       <span>'.$package['number'].'</span>
                       <div class="clr"></div>
                  </div>';
    }
    $html .=' </td>
            </tr>
        </table>';
    die($html);
}

function propertyNew($wh_str){
    global $property_cls, $property_entity_option_cls;
    //BEGIN PROPERTY NEW
    $rows = $property_cls->getRows('SELECT pe.title,count(*) as count
                                   FROM '.$property_cls->getTable().' AS pro
                                   INNER JOIN '.$property_entity_option_cls->getTable().' AS pe
                                   ON pro.type = pe.property_entity_option_id
                                   WHERE pro.pay_status IN ('.Property::PAY_PENDING.','.Property::PAY_COMPLETE.') '.$wh_str.'
                                   GROUP BY pe.title',true);
    $new = array();
    $sum = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
            $sum = $sum + $row['count'];
            $new[] = array('name'=>$row['title'],
                           'number'=>$row['count']);
        }
        $new[] = array('name'=>'<b>Total Property</b>',
                   'number'=>$sum);
	}else{
        $new[] = array('name'=>'No new property.');
    }
    //END
    return $new;
}

function propertySold($wh_str){
    global $property_cls, $property_entity_option_cls;
   //BEGIN PROPERTY SOLD
    $rows = array();
    $rows = $property_cls->getRows('SELECT pe.title,count(*) as count
                                   FROM '.$property_cls->getTable().' AS pro
                                   INNER JOIN '.$property_entity_option_cls->getTable().' AS pe
                                   ON pro.type = pe.property_entity_option_id
                                   WHERE pro.confirm_sold = 1 '.$wh_str.'
                                   GROUP BY pe.title',true);
    $sold = array();
    $sum = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
            $sum = $sum + $row['count'];
            $sold[] = array('name'=>$row['title'],
                           'number'=>$row['count']);
        }
        $sold[] = array('name'=>'<b>Total Property</b>',
                        'number'=>$sum);
	}else{
        $sold[] = array('name'=>'No property sold.');
    }


    //END
    return $sold;
}

function propertyPackage($wh_str){
    global $property_cls;
    //BEGIN PROPERTY PACKAGE

    $rows = $property_cls->getRows('SELECT package_id,
                                           COUNT(package_id) AS count
                                   FROM '.$property_cls->getTable().' AS pro
                                   WHERE pro.pay_status IN ('.Property::PAY_PENDING.','.Property::PAY_COMPLETE.') '.$wh_str.'
                                   GROUP BY package_id',true);
    $package = array();
    $total = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
          if (PA_getPackage($row['package_id']) != null){
              $package[] = array('name'=>PA_getPackage($row['package_id']),
                                 'number'=>$row['count']);
              $total += $row['count'];
          }
	    }
        $package[] = array('name'=>'<b>Total Property</b>',
                       'number'=>$total);
	}else{
        $package[] = array('name'=>'No property.');
    }

    //END
    return $package;
}
function __searchEmail(){
    global $typeOfEmail_arr,$log_cls;
    $date_from = getParam('date_from','');
    $date_to = getParam('date_to','');
    $wh_str = '';
    if ($date_from != '' || $date_to != ''){
        if ($date_to != ''){
            $wh_str .= " AND log.time <= '".$date_to."'";
        }
        if ($date_from !=''){
            $wh_str .= " AND log.time >= '".$date_from."'";
        }
    }
    include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
    if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
        $log_cls = new Email_log();
    }	
    $rows = $log_cls->getRows('SELECT type,SUM(count) AS count
                               FROM '.$log_cls->getTable().' AS log
                               WHERE 1 '.$wh_str.'
                               GROUP BY type',true);
    $data = array();
    $total = 0;
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row){
            $_data[$row['type']] = $row['count'];
            $total += $row['count'];
        }
        foreach ($typeOfEmail_arr as $key=>$type){
            if (isset($_data[$key])){
                $data[] = array('name'=>$type,
                                'number'=>$_data[$key]);
            }else{
                $data[] = array('name'=>$type,
                                'number'=>0);
            }
        }
        $data[] = array('name'=>'<b>Total Property</b>',
                        'number'=>$total);
    }else{
        $data[] = array('name'=>'No email.');
    }

    $title = ($date_to == '' and $date_from == '' )?'Report Email Send Today':'Report Email Send';
    $html = '<table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th colspan="3" class="top">
                        <span style="font-weight: bold !important;">'.$title.'</span>
                    </th>
                </tr>
                <tr>
                    <th width="50%"><span>Description</span></th>
                    <th><span>Property number</span></th>
                </tr>
                <tr>
                    <td colspan="3">';
    foreach ($data as $item){
        $html .= ' <div class="row">
                      <span style="float: left;margin-right: 19px;margin-left:0px !important;">'.$item['name'].'</span>
                      <span>'.$item['number'].'</span>
                       <div class="clr"></div>
                   </div>';
    }
    $html .=' </td>
            </tr>
        </table>';
    die($html);
}

function __reportListBidPropertyAction() {
	global $action, $region_cls, $property_cls, $bid_cls, $config_cls;
		
	$start = (int)restrictArgs(getParam('start', 0));
	$limit = (int)restrictArgs(getParam('limit', 20));
	$sort_by = getParam('sort', 'num');
	$dir = getParam('dir', 'DESC');	
	$property_id = (int)restrictArgs(getParam('property_id', 0));
	$query = (int)getParam('query', 0);	

	//$where_str = 'AND (SELECT COUNT(*) FROM '.$bid_cls->getTable().' AS bid WHERE bid.property_id = pro.property_id ) > 0';
	$where_str = '';
	if ($query > 0) {
		$where_str .= ' AND pro.property_id = '.$query;
	}
	$rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.property_id, 
										pro.address, 
										pro.postcode, 
										pro.suburb,
										pro.stop_bid, 
												
										(SELECT reg1.name 
										FROM '.$region_cls->getTable().' AS reg1
										WHERE reg1.region_id = pro.state) AS state_name,
										
										(SELECT reg2.name 
										FROM '.$region_cls->getTable().' AS reg2
										WHERE reg2.region_id = pro.country) AS country_name,
										
										(SELECT COUNT(*) FROM '.$bid_cls->getTable().' AS bid WHERE bid.property_id = pro.property_id ) AS num
							FROM '.$property_cls->getTable().' AS pro 
							WHERE pro.auction_sale = 9 '.$where_str.'
							ORDER BY '.$sort_by.' '.$dir.'
							LIMIT '.$start.','.$limit,true);	
	
	$total = $property_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		$topics = $rows;
	}		
	
	$result = array('totalCount' => $total, 'topics' =>formUnescapes($topics), 'limit' => $limit);
	die(json_encode($result));
}

function __reportListBidPropertyAgentAction(){
	global $action, $property_cls, $bid_cls, $agent_cls,$config_cls;
		
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','bid.price');
	$dir = getParam('dir','DESC');	
	$agent_id = (int)restrictArgs(getParam('agent_id',0));
	$property_id = (int)restrictArgs(getParam('property_id',0));
	
	
	$where_str = '';
	if ($property_id > 0) {
		$where_str = ' WHERE bid.property_id = '.$property_id;
	}
	
	$rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS bid.agent_id, 
										bid.step, 
										bid.price, 
										bid.time, 
												
										(SELECT CONCAT(agt.firstname," ",agt.lastname) 
										FROM '.$agent_cls->getTable().' AS agt
										WHERE agt.agent_id = bid.agent_id) AS agent_name
							FROM '.$bid_cls->getTable().' AS bid '.$where_str.'
							ORDER BY '.$sort_by.' '.$dir.'
							LIMIT '.$start.','.$limit, true);
	
	$total = $bid_cls->getFoundRows();

	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		//$topics = $rows;
		$i = 0;
		foreach ($rows as $row) {
			$row['i'] = $i++;
			$topics[] = $row;
		}
	}		
	
	$result = array('totalCount' => $total, 'topics' =>formUnescapes($topics), 'limit' => $limit);
	die(json_encode($result));
}
function __reportDevelopmentsAction(){
	global $development_cls;

	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','email_address');
	$dir = getParam('dir','DESC');
	$rows = $development_cls->getRows('SELECT SQL_CALC_FOUND_ROWS dev.development_id, dev.*
							FROM '.$development_cls->getTable().' AS dev
							ORDER BY '.$sort_by.' '.$dir.' LIMIT '.$start.','.$limit, true);
	$total = $development_cls->getFoundRows();

	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		//$topics = $rows;
		$i = 0;
		foreach ($rows as $row) {
			$row['i'] = $i++;
			$topics[] = $row;
		}
	}

	$result = array('totalCount' => $total, 'topics' =>formUnescapes($topics), 'limit' => $limit);
	die(json_encode($result));
}
function __reportSoldPassedInAction()
{
    global $property_cls;
    $filter = getParam('filter');
    $filter = (!isset($filter) or $filter == '') ? 'all' : $filter;
    $time = ($filter == 'sold') ? 'pro.sold_time' : (($filter == 'passedin') ? 'pro.end_time' : '');
    $wh_case = "";
    if($filter == 'sold')
    {
        $wh_case = ' AND pro.confirm_sold = '.Property::SOLD_COMPLETE ;

    }
    elseif($filter == 'passedin'){
        $wh_case = ' AND (pro.stop_bid = 1 OR pro.end_time < \''.date('Y-m-d H:i:s').'\' )
                     AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
                     AND pro.start_time <= \''.date('Y-m-d H:i:s').'\'
                     AND pro.end_time > pro.start_time
                   ';
    }else{
        $wh_case = 'AND (pro.confirm_sold = '.Property::SOLD_COMPLETE.'
                        OR ((pro.stop_bid = 1 OR pro.end_time < \''.date('Y-m-d H:i:s').'\' )
                            AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
                            AND pro.start_time <= \''.date('Y-m-d H:i:s').'\'
                            AND pro.end_time > pro.start_time))';
    }
    $type = getParam('type');
    $sql = '';
    $auction_sale_ar = PEO_getAuctionSale();
    $wh_active = 'AND pro.pay_status = ' . Property::PAY_COMPLETE . '
                      AND pro.active = 1
                      AND pro.auction_sale = '.$auction_sale_ar['auction'];
    switch ($type) {
        case 'daily':
            $year = restrictArgs(getParam('year'), '[^0-9]');
            $year = (!isset($year) or $year == '') ? date('Y') : $year;
            $month = restrictArgs(getParam('month'));
            $month = (!isset($month) or $month == '') ? date('m') : $month;
            $sql = 'SELECT
                    SQL_CALC_FOUND_ROWS
                        pro.property_id,pro.sold_time,pro.stop_time,pro.end_time,pro.confirm_sold,pro.stop_bid
                            FROM ' . $property_cls->getTable() . ' AS pro
                            WHERE IF(pro.confirm_sold = '.Property::SOLD_COMPLETE.' ,  YEAR(pro.sold_time) = \'' . $year . '\'
                                        AND MONTH(pro.sold_time) = \'' . $month . '\',
                                        YEAR(pro.end_time) = \'' . $year . '\'
                                        AND MONTH(pro.end_time) = \'' . $month . '\')
                                  '.$wh_case.'
                                  '.$wh_active.'
                            ORDER BY DAY(pro.sold_time),DAY(pro.end_time) ASC
                ';
            $rows = $property_cls->getRows($sql, true);
            $total = $property_cls->getFoundRows();
            $topics = $data =  array();
            for ($i = 1; $i <= getMonthDays($month, $year); $i++)
            {
                $data[$i]['sold'] = 0;
                $data[$i]['passed'] = 0;
            }
            if (is_array($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    if($row['confirm_sold'] == Property::SOLD_COMPLETE)
                    {
                        $day = (int)date('d', strtotime($row['sold_time']));
                        $data[$day]['sold']++;
                    }else{
                        $day = (int)date('d', strtotime($row['end_time']));
                        $data[$day]['passed']++;
                    }
                    /*print_r_pre($row['sold_time']);
                    print_r_pre($data);*/
                }
            }
            foreach ($data as $key => $val)
            {
                $temp = array();
                $temp['day'] = $key . '/' . $month . '/' . $year;
                $temp['sold'] = $val['sold']  ;
                $temp['passed'] = $val['passed'];
                $topics[] = $temp;
            }
            $result = array('totalCount' => $total, 'data' => $topics);
            die(json_encode($result));
            break;
        case 'weekly':
            $year = restrictArgs(getParam('year'), '[^0-9]');
            $year = (!isset($year) or $year == '') ? date('Y') : $year;
            $month = restrictArgs(getParam('month'));
            $month = (!isset($month) or $month == '') ? date('m') : $month;
            $month_format = strlen($month) == 2 ? $month : '0' . $month;
            $day = getMonthDays($month, $year);
            $week_begin = array();
            $week_end = array();
            for ($i = 1; $i <= $day; $i++)
            {
                $week_range = get_week_range($i, $month, $year);
                $week_begin[$i] = $week_range['first'];
                $week_end[$i] = $week_range['last'];
            }
            $week_begin = array_unique($week_begin);
            $week_first = array();
            $week_last = array();
            foreach ($week_begin as $val)
            {
                $week_first[] = $val;
            }
            if((int)date('m', strtotime($week_first[0])) < $month)
            {
                $week_first[0] = $year . '-' . $month_format . '-01 00:00:00';
            }
            unset($week_begin);
            $week_end = array_unique($week_end);
            foreach ($week_end as $val)
            {
                $week_last[] = $val;
            }
            //print_r_pre($week_last);
            //print_r_pre($week_last[count($week_last)-1]);
            if((int)date('m', strtotime($week_last[count($week_last)-1])) > $month)
            {
                $week_last[count($week_last)-1] = $year . '-' . $month_format. '-' . getMonthDays($month, $year) . ' 00:00:00';
            }
            unset($week_end);
            $sql = 'SELECT
                    SQL_CALC_FOUND_ROWS
                        pro.property_id,pro.sold_time,pro.stop_time,pro.end_time,pro.confirm_sold,pro.stop_bid
                            FROM ' . $property_cls->getTable() . ' AS pro
                            WHERE IF(pro.confirm_sold = '.Property::SOLD_COMPLETE.' ,  YEAR(pro.sold_time) = \'' . $year . '\'
                                        AND MONTH(pro.sold_time) = \'' . $month . '\',
                                        YEAR(pro.end_time) = \'' . $year . '\'
                                        AND MONTH(pro.end_time) = \'' . $month . '\')
                                  '.$wh_case.'
                                  '.$wh_active.'
                            ORDER BY DAY(pro.sold_time),DAY(pro.end_time) ASC
                ';
            $rows = $property_cls->getRows($sql, true);
            $total = $property_cls->getFoundRows();
            $topics = array();
            $data = array();
            if (is_array($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    foreach ($week_first as $key => $val)
                    {
                        if(!isset($data[$key]['sold'])){$data[$key]['sold'] = 0;}
                        if(!isset($data[$key]['passed'])){$data[$key]['passed'] = 0 ;}
                        if($row['confirm_sold'] == Property::SOLD_COMPLETE)
                        {
                            if (date('Y-m-d', strtotime($row['sold_time'])) >= date('Y-m-d', strtotime($val))
                                and date('Y-m-d', strtotime($row['sold_time'])) <= date('Y-m-d', strtotime($week_last[$key]))
                            ){
                                $data[$key]['sold']++;
                                break;
                            }
                        }
                        else{
                            if (date('Y-m-d', strtotime($row['end_time'])) >= date('Y-m-d', strtotime($val))
                                and date('Y-m-d', strtotime($row['end_time'])) <= date('Y-m-d', strtotime($week_last[$key]))
                            ) {
                                $data[$key]['passed']++;
                                break;
                            }
                        }
                    }
                }
            }
            unset($rows);
            for ($key = 0; $key < count($week_first); $key++)
            {
                $temp = array();
                $temp['week'] = date('d', strtotime($week_first[$key])) . '-' . date('d', strtotime($week_last[$key])) . '/' . $month;
                $temp['sold'] = isset($data[$key]['sold']) ? $data[$key]['sold'] : 0;
                $temp['passed'] = isset($data[$key]['passed']) ? $data[$key]['passed'] : 0 ;
                $topics[] = $temp;
            }
            $result = array('totalCount' => $total, 'data' => $topics);
            die(json_encode($result));
            break;
        case 'monthly':
            $year = restrictArgs(getParam('year'), '[^0-9]');
            $year = (!isset($year) or $year == '') ? date('Y') : $year;
            $sql = 'SELECT
                    SQL_CALC_FOUND_ROWS
                        pro.property_id,pro.sold_time,pro.stop_time,pro.end_time,pro.confirm_sold,pro.stop_bid
                            FROM ' . $property_cls->getTable() . ' AS pro
                            WHERE IF(pro.confirm_sold = '.Property::SOLD_COMPLETE.' ,  YEAR(pro.sold_time) = \'' . $year . '\'
                                        ,YEAR(pro.end_time) = \'' . $year . '\'
                                        )
                                  '.$wh_case.'
                                  '.$wh_active.'
                            ORDER BY MONTH(pro.sold_time),MONTH(pro.end_time) ASC
                ';
            $rows = $property_cls->getRows($sql, true);
            $total = $property_cls->getFoundRows();
            $topics = array();
            $data = array();
            for ($i = 1; $i <= 12; $i++)
            {
                $month = $i;
                $data[date('F', mktime(0, 0, 0, $month, 1))]['sold'] = 0;
                $data[date('F', mktime(0, 0, 0, $month, 1))]['passed'] = 0;
            }
            if (is_array($rows) && count($rows) > 0) {
                foreach ($rows as $row) {
                    if($row['confirm_sold'] == Property::SOLD_COMPLETE)
                    {
                        $month = date('m', strtotime($row['sold_time']));
                        $month_name = date('F', mktime(0, 0, 0, $month, 1));
                        $data[$month_name]['sold']++;
                    }else{
                        $month = date('m', strtotime($row['end_time']));
                        $month_name = date('F', mktime(0, 0, 0, $month, 1));
                        $data[$month_name]['passed']++;
                    }
                }
            }
            if(count($data) > 0)
            {
                foreach ($data as $key => $val)
                {
                    $temp = array();
                    $temp['month'] = $key;
                    $temp['sold'] = $val['sold'];
                    $temp['passed'] = $val['passed'];
                    $topics[] = $temp;
                }
            }
            $result = array('totalCount' => $total, 'data' => $topics);
            die(json_encode($result));

            break;
        case 'yearly':
            $sql = 'SELECT
                    SQL_CALC_FOUND_ROWS
                        pro.property_id,pro.sold_time,pro.stop_time,pro.end_time,pro.confirm_sold,pro.stop_bid
                            FROM ' . $property_cls->getTable() . ' AS pro
                            WHERE 1
                                  '.$wh_case.'
                                  '.$wh_active.'
                            ORDER BY YEAR(pro.sold_time),YEAR(pro.end_time) ASC
                ';
            $rows = $property_cls->getRows($sql, true);
            //die(print_r($rows));
            $total = $property_cls->getFoundRows();
            $topics = array();
            $data = array();
            if (count($rows) > 0 and is_array($rows)) {
                foreach ($rows as $key => $row)
                {                   
					if($row['confirm_sold'] == Property::SOLD_COMPLETE)
					{
						if ($row['sold_time'] != '0000-00-00 00:00:00') {
							$year = date('Y', strtotime($row['sold_time']));
                            if(!isset($data[$year]['sold']) ){
                                $data[$year]['sold'] = 0;
                            }
							$data[$year]['sold']++;
						}
					}else{
						if ($row['end_time'] != '0000-00-00 00:00:00') {
							$year = date('Y', strtotime($row['end_time']));
                            if(!isset($data[$year]['passed']) ){
                                $data[$year]['passed'] = 0;
                            }
							$data[$year]['passed']++;
						}
					}                    
                }
            }
            if(count($data) > 0 )
            {
                foreach ($data as $key_ => $val)
                {
                    if($key_ <= 2000){break;}
                    $temp['year'] = $key_;
                    $temp['sold'] = isset($val['sold']) ? $val['sold'] : 0 ;
                    $temp['passed'] = isset($val['passed']) ? $val['passed'] : 0 ;
                    $topics[] = $temp;
                }
            }else{
                $temp['year'] = date('Y');
                $temp['sold'] = 0;
                $temp['passed'] = 0;
                $topics[] = $temp;
            }
            //$result =array('JSChart' => array('datasets' => array('type' => 'bar', 'data' => $topics)));
            //die(json_encode($result));
            die(json_encode(array('data' => $topics)));
            break;
        default:
            die (json_decode(array()));
            break;
    }
}

function __viewOptionYearAction() {
    global $property_cls;
    //BEGIN YEARLY
    $row = $property_cls->getRow('1 ORDER BY YEAR(creation_date) ASC');
    $year = date('Y');
    if (is_array($row) && count($row) > 0) {
        $dt = new DateTime($row['creation_date']);
        if ($dt->format('Y') > 0) {
            $year = $dt->format('Y');
        }
    }

    //$options[] = array('value' => '', 'title' => 'All');
    $options = array();
    for ($i = $year; $i <= date('Y'); $i++) {
        $options[] = array('value' => $i, 'title' => $i);
    }
    //END
    $result = array('data'=>$options);
    die(json_encode($result));

}

function getMonthDays($Month, $Year)
{
    if( is_callable("cal_days_in_month"))
    {
        return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
    }
    else
    {
        return date("d",mktime(0,0,0,$Month+1,0,$Year));
    }
}

function get_week_range($day='', $month='', $year='') {
    // default empties to current values
    if (empty($day)) $day = date('d');
    if (empty($month)) $month = date('m');
    if (empty($year)) $year = date('Y');
    // do some figurin'
    $weekday = date('w', mktime(0,0,0,$month, $day, $year));
    $sunday  = $day - $weekday;
    $start_week = date('Y-m-d H:i:00', mktime(0,0,0,$month, $sunday, $year));
    $end_week   = date('Y-m-d H:i:00', mktime(0,0,0,$month, $sunday+6, $year));
    if (!empty($start_week) && !empty($end_week)) {
        return array('first'=>$start_week, 'last'=>$end_week);
    }
    // otherwise there was an error :'(
    return false;
}
?>


