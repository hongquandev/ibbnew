<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/report/inc/report.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';

include_once ROOTPATH.'/modules/general/inc/ftp.php';
include_once ROOTPATH.'/modules/general/inc/media.php';

//restrict4AjaxBackend();

$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action){
	case 'list-banner':
		/*if ($perm_ar['view'] == 0) {
			die(json_encode($perm_msg_ar['view']));
		}*/
		__bannerListAction();
	break;
	case 'delete-banner':
	case 'multidelete-banner':
		if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
		__bannerDeleteAction();
	break;
	case 'change-status-banner':
		if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
		__bannerStatusAction();
	break;
	
	// Apply With Set Status Agent;
	case 'change-agent-banner':
		if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
		__bannerStatusAgent();
	break;
	
    case 'change_pay-banner':
    case 'multichange_pay-banner':
		if ($perm_ar['edit'] == 1) {
			__bannerChangePay();
		} else {
			die(json_encode($perm_msg_ar['edit']));
		}
    break;
}


/**
@ function : __bannerListAction
*/

function __bannerListAction() {
	global $banner_cls, $cms_cls, $property_cls, $config_cls;
	$start = getParam('start', 0);
	$limit = getParam('limit', 25);
	$sort_by = getParam('sort', 'b.banner_id');
	$dir = getParam('dir', 'DESC');
	$search_query = getParam('query');

	$search_where = '';
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (b.banner_id LIKE '%".$search_query."%'
								OR b.banner_name LIKE '%".$search_query."%'
								OR b.url LIKE '%".$search_query."%'
								OR CONCAT(a.firstname ,' ', a.lastname) LIKE '%".$search_query."%')";
	}


	$rows = $banner_cls->getRows('SELECT SQL_CALC_FOUND_ROWS b.* ,
										 CONCAT(a.firstname) AS fullname
								  FROM '.$banner_cls->getTable().' AS b
								  INNER JOIN agent AS a
								  ON b.agent_id = a.agent_id  '.$search_where.'
								  ORDER BY '.$sort_by.' DESC
								  LIMIT '.$start.','.$limit,true);
	$totalCount = $banner_cls->getFoundRows();
	$retArray = array();
	
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
										
			$row['banner_file'] = '<img height="75px"  style="padding-top:8px;" src="'.MEDIAURL.'/store/uploads/banner/images/'.$row['banner_file'].'" title="'.$row['url'].'" />';							
			// Define Display pages
			$v = trim($row['page_id'], ',');
			$title = (trim($row['page_id'], ',') == 0)?'All':'';
			if (trim($row['page_id'], ',') != 0){
				$title_ar = Menu_getTitleArById(explode(',', $row['page_id']));
				$title .= implode('<span style="color: #B7B7B7;font-size: 9px;margin: 0 12px;">|</span>', $title_ar);
			}
				
			if ($row['position'] == 1000) {
				$row['position'] = 0;
			} else {
				$row['position'] = $row['position'];
			}	
			$row['title'] = $title;
			$dt =  new DateTime($row['creation_time']);
			$dt2 =  new DateTime($row['update_time']);
			
			$row['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
			$row['update_time']= $dt2->format($config_cls->getKey('general_date_format'));
			//BEGIN GOS:MOHA
			$click_num = (int)Report_bannerInfo($row['banner_id'],'click');
			if ($click_num == 0) {
				$row['clicks'] = 0;
			} else {
				$row['clicks'] = '<a href="javascript:void(0)"
				onclick="wow(\'/modules/report/popup.php?action=view-banner-click&id='.$row['banner_id'].'\',400,800)"
				style="cursor:pointer; color:#009900;text-decoration:none">'.$click_num.'</a>';
			}
	
			$row['pay_status'] = $property_cls->getPayStatus($row['pay_status']);
			//END
			$retArray[] = $row;
		}
	}

	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));

}

/*
@ function : __bannerDeleteAction
*/

function __bannerDeleteAction() {
	global $banner_cls, $systemlog_cls;
	$banner_ids = getParam('banner_id');
	if (strlen($banner_ids) > 0) {
		$banner_id_ar = explode(',',$banner_ids);
		if (count($banner_id_ar) > 0) {
			foreach ($banner_id_ar as $banner_id) {
				$row = $banner_cls->getRow('banner_id = '.$banner_id);
				if (is_array($row) && count($row) > 0) {
					
					@unlink(ROOTPATH.'/store/uploads/banner/images/'.$row['banner_file']);
					@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/'.$row['banner_file']);
					@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/dashboard/'.$row['banner_file']);
					@unlink(ROOTPATH.'/store/uploads/banner/images/thumbs/dashboard/mybanner/'.$row['banner_file']);
					
					$banner_cls->delete('banner_id = '.$banner_id);
					
					
					// Write Logs
					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'DELETE',
												 'Detail' => "DELETE BANNER ID :". $banner_id,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
				}
			}
		}
	}
	die(json_encode('Deleted successful!'));
}

function __bannerStatusAgent() {
	global $banner_cls, $systemlog_cls;
	$banner_id = getParam('banner_id');
	$row = $banner_cls->getRow('banner_id = '.$banner_id);
	if (is_array($row) and count($row) > 0){
		$agent_status = 1 - (int)$row['agent_status'];
		$_stt = ($agent_status == 0)?'Disable':'Enable';
		$banner_cls->update(array('agent_status'=>$agent_status),'banner_id = '.$banner_id);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => "BANNER #".$banner_id." SET AGENT STATUS :".$_stt,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	}
	die(json_encode('This information has been change!'));
	
}
/*
@ function : __bannerStatusAction
*/

function __bannerStatusAction() {
	global $banner_cls, $systemlog_cls;
	$banner_id = getParam('banner_id');
	$row = $banner_cls->getRow('banner_id = '.$banner_id);
	if (is_array($row) and count($row) > 0){
		$status = 1 - (int)$row['status'];
		$_stt = ($status == 0)?'Disable':'Enable';
		$banner_cls->update(array('status'=>$status),'banner_id = '.$banner_id);
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => "BANNER #".$banner_id." SET STATUS :".$_stt,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
								 
	}
	die(json_encode('This information has been change!'));
}

function __bannerChangePay(){
    global $banner_cls, $systemlog_cls,$property_cls;
    $banner_ids = getParam('banner_id');
    $new_pay_status = getParam('pay');
    $value = $property_cls->getValuePay($new_pay_status);
    $message = '';
    if (strlen($value) > 0 && strlen($banner_ids) > 0){
        $banner_cls->update(array('pay_status'=>$value),'banner_id IN ('.$banner_ids.')');
        $detail = strlen($banner_ids) > 1?'BANNERS ':'BANNER ';
        $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => $detail.$banner_ids." SET PAY STATUS: ".$new_pay_status,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        $message = 'success';

    }
    die(_response($message));
}
?>
 
