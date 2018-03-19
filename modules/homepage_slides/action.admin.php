<?php
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include ROOTPATH . '/admin/functions.php';
include ROOTPATH . '/modules/systemlog/inc/systemlog.php';
include ROOTPATH . '/modules/configuration/inc/config.class.php';
include ROOTPATH . '/modules/homepage_slides/inc/homepage_slides.class.php';
ini_set('display_errors', 0);
$module = getParam('module');
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
    case 'list-homepage_slides':
        if ($perm_ar['view'] == 0) {
            die(json_encode($perm_msg_ar['view']));
        }
        __listAction();
        break;
    case 'delete-homepage_slides':
    case 'multidelete-homepage_slides':
        if ($perm_ar['delete'] == 0) {
            die(json_encode($perm_msg_ar['delete']));
        }
        _slideDeleteAction();
        break;
    case 'active-homepage_slides':
        if ($perm_ar['edit'] == 0) {
            die(json_encode($perm_msg_ar['edit']));
        }
        _slideActiveAction();
        break;
}
/*----*/
/*
@ function : _slideListAction
*/
function __listAction()
{
    global $slide_cls, $config_cls;
    $start = (int)restrictArgs(getParam('start', 0));
    $limit = (int)restrictArgs(getParam('limit', 20));
    $sort_by = getParam('sort', 'slides.id');
    $dir = getParam('dir', 'ASC');
    //search grid
    $search_where = '';
    $search_query = getParam('query');
    if (strlen($search_query) > 0) {
        $search_where = "WHERE (slides.id = '" . $search_query . "')";
    }
    $rows = $slide_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
									  FROM ' . $slide_cls->getTable() . ' AS slides '
                                    . $search_where
                                    . ' ORDER BY ' . $sort_by . ' ' . $dir
                                    . ' LIMIT ' . $start . ',' . $limit, true);
    $totalCount = $slide_cls->getFoundRows();
    $retArray = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $dt = new DateTime($row['create_time']);
            $row['date_creation'] = $dt->format($config_cls->getKey('general_date_format'));
            $row['status'] = $row['active'] ? 'Active' : 'Inactive';
            $row['image'] = ROOTURL.$row['image'];
            $retArray[] = $row;
        }
    }
    $arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
    die(json_encode($arrJS));
}

/*
@ function : _slideDeleteAction
*/
function _slideDeleteAction()
{
    global $slide_cls, $systemlog_cls;
    $ids = getParam('id');
    if (strlen($ids) > 0) {
        $slide_cls->delete('id IN (\'' . str_replace(",", "','", $ids) . '\')');
        $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
            'Action' => 'DELETE',
            'Detail' => "DELETE SLIDE ID :" . $ids,
            'UserID' => $_SESSION['Admin']['EmailAddress'],
            'IPAddress' => $_SERVER['REMOTE_ADDR']));
    }
    die(json_encode('Deleted successful!'));
}

function _slideActiveAction()
{
    global $slide_cls, $systemlog_cls;
    $id = getParam('id');
    if ($id != '') {
        $row = $slide_cls->getRow('id = ' . $id);
        if (is_array($row) and count($row) > 0) {
            $status = 1 - (int)$row['active'];
            $_st = $status == 1 ? 'ACTIVE' : 'INACTIVE';
            $slide_cls->update(array('active' => $status),
                'id = ' . $id);
            $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
                'Action' => 'UPDATE',
                'Detail' => $_st . ' SLIDE ID: ' . $id,
                'UserID' => $_SESSION['Admin']['EmailAddress'],
                'IPAddress' => $_SERVER['REMOTE_ADDR']));
        }
    }
    die(json_encode('This information has been updated!'));
}

?> 
