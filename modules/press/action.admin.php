<?php
include '../../configs/config.inc.php';
include ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include 'inc/press.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$action = getParam('action');
$token = getParam('token');

if (!$_SESSION['Admin']) {
	die('logout');
}
restrict4AjaxBackend();

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

$action_arr = explode('-',$action);

switch ($action){
    case 'list-article':
    case 'list-cat':
    case 'list-category':
       if ($perm_ar['view'] == 1) {
          switch ($action_arr[1]){
              case 'article':
                  __listArticleAction();
                  break;
              case 'cat':
                  __listCatAction();
                  break;
              case 'category':
                    $options[] = array('value'=>'','title'=>'All');
                    foreach (Press_getCategory() as $key=>$row){
                       $options[] = array('value'=>$key,'title'=>$row);
                    }
                    $result = array('data'=>$options);
                    die(json_encode($result));
                  break;
          }
	   } else {
		    die(json_encode($perm_msg_ar['view']));
	   }
       break;
    case 'change-status-article':
    case 'change-status-cat':
       if ($perm_ar['edit'] == 1) {
		  __changeStatusAction($action_arr[2]);
	   } else {
		    die(json_encode($perm_msg_ar['edit']));
	   }
       break;
    case 'delete-article':
    case 'delete-cat':
    case 'multidelete-article':
    case 'multidelete-article':
       if ($perm_ar['delete'] == 1) {
		  __deleteAction($action_arr[1]);
	   } else {
		    die(json_encode($perm_msg_ar['delete']));
	   }
       break;
}

function __listArticleAction(){
    global $press_cat_cls,$press_article_cls,$config_cls;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = 'pa.'.getParam('sort','press_id');
	$dir = getParam('dir','ASC');

	//search grid
	$search_where = '';
	$search_query = getParam('query');
    $catID = getParam('catID',0);
	if (strlen($search_query) > 0) {
		$search_arr[] = " (pa.press_id = '".$search_query."'
						   OR pa.content LIKE '%".$search_query."%'
						   OR pa.title LIKE '%".$search_query."%')";
	}
    if ($catID != 0 and $catID != ''){
        $search_arr[] = ' pa.cat_id = '.$catID;
    }
    $where_str = is_array($search_arr) && count($search_arr) > 0?' AND '.implode(' AND ',$search_arr):'';

	$rows = $press_article_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pa.*,
	                                                                pc.title AS cat_name
							    FROM '.$press_article_cls->getTable().' AS pa
							    LEFT JOIN '.$press_cat_cls->getTable(). ' AS pc
							    ON pa.cat_id = pc.cat_id
							    WHERE 1 '. $where_str
								.' ORDER BY '.$sort_by.' '.$dir
							    .' LIMIT '.$start.','.$limit,true);
	$totalCount = $press_article_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$dt =  new DateTime($row['creation_date']);
			$dt2 =  new DateTime($row['modified_date']);
            $dt3 =  new DateTime($row['show_date']);

			$row['creation_date']= $dt->format($config_cls->getKey('general_date_format')).' '.$dt->format('H:i:s');
            $row['show_date']= $dt3->format($config_cls->getKey('general_date_format')).' '.$dt3->format('H:i:s');
			if ($row['modified_date'] != '0000-00-00 00:00:00'){
                $row['modified_date']= $dt2->format($config_cls->getKey('general_date_format')).' '.$dt2->format('H:i:s');
            }else{
                $row['modified_date'] = '';
            }

            $row['short_content'] = safecontent(strip_tags($row['content']),300).'...';
            $row['url'] = ROOTURL.'/press/'.$row['seo_url'].'.html';
			$retArray[] = $row;
		}
	}
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}

function __listCatAction(){
    global $press_cat_cls,$press_article_cls,$token;
	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = 'pc.'.getParam('sort','cat_id');
	$dir = getParam('dir','ASC');

	$search_where = '';
	$search_query = getParam('query');
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (c.catID = '".$search_query."'
								OR c.title LIKE '%".$search_query."%')";
	}
	$rows = $press_cat_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pc.*,
	                                (SELECT count(pa.press_id) FROM '.$press_article_cls->getTable().' AS pa WHERE pa.cat_id = pc.cat_id) AS count

							         FROM '.$press_cat_cls->getTable().' AS pc'
							         . $search_where
								     .' ORDER BY '.$sort_by.' '.$dir
							         .' LIMIT '.$start.','.$limit,true);
	$totalCount = $press_cat_cls->getFoundRows();
	$retArray = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['Delete'] = '<a onclick ="outAction(\'delete\','.$row['cat_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
            $edit_link = '?module=press&action=edit-category&id='.$row['cat_id'].'&token='.$token;
			$row['Edit'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
            $view_link = '?module=press&action=list-article&catID='.$row['cat_id'].'&token='.$token;
            $row['View'] = '<a class="grid_default" href="'.$view_link.'">View</a>';
			$retArray[] = $row;
		}
	}
	$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
	die(json_encode($arrJS));
}
function __changeStatusAction($type){
    global $press_cat_cls,$press_article_cls,$systemlog_cls;
    $id = getParam('id',0);
    if ($type == 'cat'){
        $row = $press_cat_cls->getCRow(array('cat_id','title','active'),'cat_id = '.$id);
        if (is_array($row) and count($row)> 0){
            $press_cat_cls->update(array('active'=>1-$row['active']),'cat_id = '.$id);
            $status_label = 1-$row['active'] == 0?'DISABLE':'ENABLE';
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." PRESS CATEGORY ID:". addslashes($row['title']),
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
    }else{
        $row = $press_article_cls->getCRow(array('press_id','title','active'),'press_id = '.$id);
        if (is_array($row) and count($row)> 0){
            $press_article_cls->update(array('active'=>1-$row['active']),'press_id = '.$id);
            $status_label = 1-$row['active'] == 0?'DISABLE':'ENABLE';
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => $status_label,
									  'Detail' => $status_label." PRESS POST:". addslashes($row['title']),
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
    }
    die(json_encode('This information has been updated!'));
}

function __deleteAction($type){
    global $press_cat_cls,$press_article_cls,$systemlog_cls;
    $ids = getParam('id','');
    if ($ids != ''){
         if ($type == 'cat'){
            $press_cat_cls->delete('cat_id IN ('.$ids.')');
            $press_article_cls->delete('cat_id IN ('.$ids.')');
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'DELETE',
									  'Detail' => "DELETE PRESS CATEGORY:". $ids,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }else{
            $press_article_cls->delete('press_id IN ('.$ids.')');
            $systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
									  'Action' => 'DELETE',
									  'Detail' => "DELETE PRESS POST:". $ids,
									  'UserID' => $_SESSION['Admin']['EmailAddress'],
									  'IPAddress' =>$_SERVER['REMOTE_ADDR']));
        }
        die(json_encode('Deleted successful !'));
    }else{
        die(json_encode('Process fail ! Try Again'));
    }
}

?>