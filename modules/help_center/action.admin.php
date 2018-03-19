<?php
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'inc/help_center.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$action = getParam('action');
$_action = explode('-',$action);
$token = getParam('token');

if (!$_SESSION['Admin']) {
	die('logout');
}
restrict4AjaxBackend();

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
include_once ROOTPATH.'/utils/ajax-upload/server/php.php';

switch ($action){
    case 'list-center':
       if ($perm_ar['view'] == 1) {
		  __listActionCenter();
	   } else {
		    die(json_encode($perm_msg_ar['view']));
	   }
       break;
    case 'list-cat':
       if ($perm_ar['view'] == 1) {
		  __listActionCat();
	   } else {
		    die(json_encode($perm_msg_ar['view']));
	   }
       break;
    case 'change-status-center':
    case 'change-status-cat':
       if ($perm_ar['edit'] == 1) {
		  __changeStatusAction($_action[2]);
	   } else {
		    die(json_encode($perm_msg_ar['edit']));
	   }
       break;
    case 'delete-center':
    case 'delete-cat':
    case 'multidelete-cat':
    case 'multidelete-center':
       if ($perm_ar['delete'] == 1) {
		  __deleteAction($_action[1]);
	   } else {
		    die(json_encode($perm_msg_ar['delete']));
	   }
       break;
    case 'list-question':
       __listQuestion();
       break;
    case 'list-category':
       __listCategory();
       break;

}

function __listActionCenter(){
    global $help_cls,$cat_cls,$config_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = 'h.'.getParam('sort','helpID');
	$dir = getParam('dir','ASC');

	//search grid
	$search_where = '';
	$search_query = getParam('query');
    $catID = getParam('catID',0);
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (h.helpID = '".$search_query."'
								OR h.question LIKE '%".$search_query."%'
								OR h.answer LIKE '%".$search_query."%')";
	}
    if ($catID != 0 and $catID != ''){
        $cat_str = ' h.catID = '.$catID;
        $cat_str = $search_where == ''? ' WHERE '.$cat_str:' AND '.$cat_str;
    }

	$rows = $help_cls->getRows('SELECT SQL_CALC_FOUND_ROWS h.*, c.title
							    FROM '.$help_cls->getTable().' AS h
							    LEFT JOIN '.$cat_cls->getTable(). ' AS c
							    ON h.catID = c.catID '
							    . $search_where.$cat_str
								.' ORDER BY '.$sort_by.' '.$dir
							    .' LIMIT '.$start.','.$limit,true);
	$totalCount = $help_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
            //$row['answer'] = stripslashes($row['answer']);

			$dt =  new DateTime($row['create_time']);
			$dt2 =  new DateTime($row['update_time']);

			$row['create_time']= $dt->format($config_cls->getKey('general_date_format'));
			$row['update_time']= $dt2->format($config_cls->getKey('general_date_format'));
            $row['cat_name'] = $row['title'];
            $row['intro'] = safecontent(strip_tags($row['answer']),300).'...';
            $row['intro'] = strip_tags($row['intro']);

            $allow = array();
            if (strlen($row['allow']> 0)) {
                $roles = explode(',',$row['allow']);
                if (is_array($roles) and count($roles)> 0){
                    foreach($roles as $role){
                        $allow[] = Role_getRole($role);
                    }
                }
                $row['permission'] = implode(', ',$allow);
            }
			$retArray[] = $row;
		}
	}
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}

function __listActionCat(){
    global $cat_cls,$help_cls,$token;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','c.catID');
	$dir = getParam('dir','ASC');

	$search_where = '';
	$search_query = getParam('query');
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (c.catID = '".$search_query."'
								OR c.title LIKE '%".$search_query."%')";
	}
	$rows = $cat_cls->getRows('SELECT SQL_CALC_FOUND_ROWS c.*,
	                            (SELECT count(h.helpID) FROM help_center AS h WHERE c.catID = h.catID) AS count
							    FROM '.$cat_cls->getTable().' AS c'
							    . $search_where
								.' ORDER BY '.$sort_by.' '.$dir
							    .' LIMIT '.$start.','.$limit,true);
	$totalCount = $cat_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['Delete'] = '<a onclick ="outAction(\'delete\','.$row['catID'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
            $edit_link = '?module=help_center&action=edit-cat&id='.$row['catID'].'&token='.$token;
			$row['Edit'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
            $view_link = '?module=help_center&action=list-center&catID='.$row['catID'].'&token='.$token;
            $row['View'] = '<a class="grid_default" href="'.$view_link.'">View</a>';
            $allow = array();
            if (strlen($row['allow']> 0)) {
                $roles = explode(',',$row['allow']);
                if (is_array($roles) and count($roles)> 0){
                    foreach($roles as $role){
                        $allow[] = Role_getRole($role);
                    }
                }
                $row['permission'] = implode(', ',$allow);
            }            
			$retArray[] = $row;
		}
	}
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}
function __changeStatusAction($type){
    global $cat_cls,$help_cls,$systemlog_cls;
    $id = getParam('id',0);
    if ($type == 'cat'){
        $row = $cat_cls->getRow('catID = '.$id);
        if (is_array($row) and count($row)> 0){
            $cat_cls->update(array('active'=>1-$row['active']),'catID = '.$id);
            $status_label = 1-$row['active'] == 0?'DISABLE':'ENABLE';
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." CATEGORY ID:". $row['catID'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
    }else{
        $row = $help_cls->getRow('helpID = '.$id);
        if (is_array($row) and count($row)> 0){
            $help_cls->update(array('active'=>1-$row['active']),'helpID = '.$id);
            $status_label = 1-$row['active'] == 0?'DISABLE':'ENABLE';
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." QUESTION:". $row['helpID'],
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
    }
    die(json_encode('This information has been updated!'));
}

function __deleteAction($type){
    global $cat_cls,$help_cls,$systemlog_cls;
    $ids = getParam('id','');
    if ($ids != ''){
         if ($type == 'cat'){
            $cat_cls->delete('catID IN ('.$ids.')');
            $help_cls->delete('catID IN ('.$ids.')');
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'DELETE',
									  'Detail' => "DELETE CATEGORY:". $ids,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }else{
            $help_cls->delete('helpID IN ('.$ids.')');
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'DELETE',
									  'Detail' => "DELETE QUESTION:". $ids,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
        die(json_encode('Deleted successful !'));
    }else{
        die(json_encode('Process fail ! Try Again'));
    }
}

function __listQuestion(){
    global $help_cls,$pag_cls,$token;
    $p = (int)restrictArgs(getQuery('p',1));
	$p = $p <= 0 ? 1 : $p;
    $len = 20;
    $catID = getParam('catID',0);
    $rows = $help_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
                                FROM '.$help_cls->getTable().'
                                WHERE catID = '.$catID."
                                AND allow LIKE '%".$_SESSION['Admin']['role_id']."%'
                                AND active = 1 ORDER BY position
                                LIMIT ".(($p-1)*$len).','.$len,true);
    $total_row = $help_cls->getFoundRows();
    $pag_cls->setTotal($total_row)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage(10)
            ->setUrl('../modules/help_center/action.admin.php?action=list-question&token='.$token)
            ->setLayout('ajax')
            ->setFnc('help.list');
    $html = '';
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $html .= '
                        <div class="ques-container">
                            <a class="ques-close" href="javascript:void(0)" onclick="pull(this)">
                               <span>'.$row['question'].'</span>
                            </a>
                            <div class="answer">'.$row['answer'].'</div>
                        </div>
                     ';
        }

    }
    $html .= $pag_cls->layout();
    die($html);
}

function __listCategory(){
    $options[] = array('value'=>'','title'=>'All');
    foreach (HC_getCategory() as $key=>$row){
       $options[] = array('value'=>$key,'title'=>$row);
    }
    $result = array('data'=>$options);
    die(json_encode($result));
}

?>