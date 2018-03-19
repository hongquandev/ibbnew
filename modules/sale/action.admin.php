<?php
//session_start();
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/modules/configuration/inc/configuration.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/payment/inc/payment.php';
$action = getParam('action');
$token = getParam('token');
/*
$action = 'action-module';
*/
if (!$_SESSION['Admin']) {
	die('logout');
}
restrict4AjaxBackend();

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));				 

switch ($action) {
	case 'list-property':
	case 'list-banner':
		if ($perm_ar['view'] == 1) {
			__saleListAction();
		} else {
			die(json_encode($perm_msg_ar['view']));
		}
	break;
	case 'delete-property':
	case 'delete-banner':
		if ($perm_ar['delete'] == 1) {
			$id = (int)restrictArgs(getParam('id', 0));
			if ($id > 0) {
				$payment_store_cls->delete('id = '.$id);
			}
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
	case 'multiactive-property':
	case 'multiactive-banner':
		if ($perm_ar['edit'] == 1) {
			__saleActiveAction();
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
	break;
	case 'multidelete-property':
	case 'multidelete-banner':
		if ($perm_ar['delete'] == 1) {
			__saleDeleteAction();
		} else {
			die(json_encode($perm_msg_ar['delete']));
		}
	break;
}

#=========================================================================#
/**
@ function : __saleListAction
**/

function __saleListAction() {
	global $action, $property_cls, $agent_cls, $config_cls, $banner_cls, $payment_store_cls, $region_cls, $package_cls;
		
	$start = (int)restrictArgs(getParam('start', 0));
	$limit = (int)restrictArgs(getParam('limit', 20));
	$sort_by = getParam('sort', 'sale.id');
	$dir = getParam('dir', 'ASC');	
	$id = (int)restrictArgs(getParam('id', 0));
	$query = getParam('query');
	
	$select_str = '';
	$where_str = 'WHERE sale.payment_type IS NOT NULL';
	$join_str = '';
	
	if ($action == 'list-property') {
		$property_address = '(SELECT CONCAT_WS(", ", pro.address, pro.suburb, region1.name, pro.postcode, region2.name) 
					FROM '.$property_cls->getTable().' AS pro 
					LEFT JOIN '.$region_cls->getTable().' AS region1 ON pro.state = region1.region_id
					LEFT JOIN '.$region_cls->getTable().' AS region2 ON pro.country = region2.region_id
					WHERE pro.property_id = sale.property_id)';
					
		$select_str .= $property_address.'  AS property_address, package.title AS package_name';
					
		$where_str .= ' AND sale.property_id > 0';
		
		$join_str .= 'LEFT JOIN '.$package_cls->getTable().' AS package ON sale.package_id = package.package_id';
		
		if (strlen($query) > 0) {
			$where_str .= ' AND ('.$property_address.' LIKE \'%'.$query.'%\' OR sale.id = '.(int)$query.' OR sale.property_id = '.(int)$query.')';
		}			
	} else { // list-banner
		$select_str .= 'banner.banner_name AS banner_name, package.title AS package_name';
		$join_str .= ' LEFT JOIN '.$banner_cls->getTable().' AS banner ON sale.banner_id = banner.banner_id
						LEFT JOIN '.$package_cls->getTable().' AS package ON sale.package_id = package.package_id';
		$where_str .= ' AND sale.banner_id > 0';
		
		if (strlen($query) > 0) {
			$where_str .= ' AND (banner_name LIKE \'%'.$query.'%\' OR sale.id = '.(int)$query.' OR sale.banner_id = '.(int)$query.')';
		}			
	}
	
	$rows = $payment_store_cls->getRows('SELECT SQL_CALC_FOUND_ROWS 
								sale.id,
								sale.banner_id,
								sale.property_id,
								sale.agent_id,
								(SELECT CONCAT_WS( " ", agent.firstname, agent.lastname) 
								FROM '.$agent_cls->getTable().' AS agent 
								WHERE agent.agent_id = sale.agent_id) AS agent_name,
								sale.payment_type,
								sale.amount,
								sale.cross,
								sale.is_paid,
								sale.home,
								sale.home_price,
								sale.focus,
								sale.focus_price,
								sale.bid,
								sale.bid_price,
								sale.offer,
								sale.offer_price,
								sale.notification_email,
								sale.notification_email_price,
								sale.package_price,
								sale.creation_time,
								sale.cc_transid,
								'.$select_str.'
							FROM '.$payment_store_cls->getTable().' AS sale
							'.$join_str.' 
							'.$where_str.'
							ORDER BY '.$sort_by.' '.$dir.'
							LIMIT '.$start.','.$limit, true);	
	
	$total = $payment_store_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		$topics = $rows;
	}		
	
	$result = array('totalCount' => $total, 'topics' =>formUnescapes($topics), 'limit' => $limit);
	die(json_encode($result));
}

/**
@ method : __saleActiveAction
**/

function __saleActiveAction() {
	global $property_cls, $banner_cls, $payment_store_cls;
	$ids = getParam('id');
	if (strlen($ids) > 0) {
		$id_ar = explode(',',$ids);
		if (count($id_ar) > 0) {
			foreach ($id_ar as $id) {
				$payment_store_cls->update(array('is_paid' => 1), 'id = '.(int)$id);
				$row = $payment_store_cls->getRow('id = '.(int)$id);
				if ($row['property_id'] > 0) {
					$property_cls->update(array('pay_status' => 1), 'property_id = '.(int)$row['property_id']);
				} else if ($row['banner_id'] > 0) {
					$banner_cls->update(array('pay_status' => 1), 'banner_id = '.(int)$row['banner_id']);
				}
			}
		}
	}
	die(json_encode('This information has been updated!'));
}

/**
@ method : __saleDeleteAction
**/

function __saleDeleteAction() {
	global $property_cls, $banner_cls, $payment_store_cls;
	$ids = getParam('id');
	if (strlen($ids) > 0) {
		$id_ar = explode(',',$ids);
		if (count($id_ar) > 0) {
			foreach ($id_ar as $id) {
				$payment_store_cls->delete('id = '.(int)$id);
			}
		}
	}
	die(json_encode('Deleted successful!'));
}
