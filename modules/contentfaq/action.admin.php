<?php  
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include ROOTPATH.'/modules/contentfaq/inc/contentfaq.php';
include ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include ROOTPATH.'/modules/configuration/inc/config.class.php';

$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action){
	case 'list-faq':
		/*if ($perm_ar['view'] == 0) {
			die(json_encode($perm_msg_ar['view']));
		}*/
		__contentfaqListAction();
	break;
	case 'delete-faq':
	case 'multidelete-faq':
		if ($perm_ar['delete'] == 0) {
			die(json_encode($perm_msg_ar['delete']));
		}
		__contentfaqDeleteAction();
	break;
	case 'active-faq':
        if ($perm_ar['edit'] == 0) {
			die(json_encode($perm_msg_ar['edit']));
		}
		__contentfaqActiveAction();
	break;
}

/*----*/	

/*
@ function : __contentfaqListAction
*/

function __contentfaqListAction() {
	global $contentfaq_cls, $config_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','faq.content_id');
	$dir = getParam('dir','ASC');

	//search grid
	$search_where = '';
	$search_query = getParam('query');
	if (strlen($search_query) > 0) {
		$search_where = "WHERE  (faq.content_id = '".$search_query."'
								OR faq.question LIKE '%".$search_query."%'
								OR faq.answer LIKE '%".$search_query."%')";
	}
	$rows = $contentfaq_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
									  FROM '.$contentfaq_cls->getTable().' AS faq '
									  . $search_where
									  .' ORDER BY '.$sort_by.' '.$dir
									  .' LIMIT '.$start.','.$limit,true);
	$totalCount = $contentfaq_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			//$row['answer'] = safecontent($row['answer'],400).'...';
            //$row['answer'] = stripslashes($row['answer']);
            $row['answer'] = safecontent(strip_tags($row['answer']),300).'...';
            $row['answer'] = strip_tags($row['answer']);
			//$row['Edit'] = "<a href=\"?module=contentfaq&action=edit&id={$row['content_id']}\" style=\"color:#0000FF; text-decoration:none\" onClick=\"\">Edit</a>";
			//$row['Delete'] = '<a style="cursor:pointer; text-decoration:none; color:#FF0000" onclick ="deleteItemF5(\'../modules/contentfaq/admin.delete.php?action=delete&id='.$row['content_id'].'\');"> Delete </a>';
			
			$dt =  new DateTime($row['create_time']);
			$dt2 =  new DateTime($row['update_time']);
			
			$row['create_time']= $dt->format($config_cls->getKey('general_date_format'));
			$row['update_time']= $dt2->format($config_cls->getKey('general_date_format'));
			
			$retArray[] = $row;
		}
	}
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));

}

/*
@ function : __contentfaqDeleteAction
*/

function __contentfaqDeleteAction() {
	global $contentfaq_cls, $systemlog_cls;
	$faq_ids = getParam('faq_id');
	if (strlen($faq_ids) > 0) {
		$contentfaq_cls->delete('content_id IN (\''.str_replace(",","','",$faq_ids).'\')');
		$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									 'Action' => 'DELETE',
									 'Detail' => "DELETE FAQ ID :". $faq_ids,
									 'UserID' => $_SESSION['Admin']['EmailAddress'],
									 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
	}
	die(json_encode('Deleted successful!'));
}

function __contentfaqActiveAction(){
    global $contentfaq_cls,$systemlog_cls;
    $faq_id = getParam('faq_id');
	if ($faq_id != '') {
		 $row = $contentfaq_cls->getRow('content_id = '.$faq_id);
		 if (is_array($row) and count($row) > 0){
			 $status = 1 - (int)$row['active'];
			 $_st = $status == 1?'ACTIVE':'INACTIVE';
			 $contentfaq_cls->update(array('active'=>$status),
							  'content_id = '.$faq_id );
			 $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => $_st.' FAQ ID: '.$faq_id,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));

		 }
	}
	die(json_encode('This information has been updated!'));

}
	

?> 
