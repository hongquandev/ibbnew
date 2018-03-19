<?php

include '../../configs/config.inc.php';
include ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include ROOTPATH . '/admin/functions.php';
include '../../includes/smarty/Smarty.class.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}
include_once 'inc/systemlog.php';
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';

$action = getParam('action');
$token = getParam('token');

restrict4AjaxBackend();
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

switch ($action) {
    case 'list':
        if ($perm_ar['view'] == 0) {
            die(json_encode($perm_msg_ar['view']));
        }
        __logListAction();
        break;
    case 'multidelete-log':
    case 'delete-log':
        if ($perm_ar['delete'] == 0) {
            die(json_encode($perm_msg_ar['delete']));
        }
        __logDeleteAction();
        break;
    case 'save-log':
        if ($perm_ar['edit'] == 0) {
            die(json_encode($perm_msg_ar['edit']));
        }
        __logSaveAction();
        break;
    case 'get-day':
        __logGetdayAction();
        break;
}

/* ---- */

/**
  @ function : __logListAction
 * */
function __logListAction() {
    global $systemlog_cls, $config_cls;
    $start = getParam('start', 0);
    $limit = getParam('limit', 20);
    $sortby = getParam('sort', 'ID');
    $dir = getParam('dir', 'ASC');
    $search_where = '';
    $search_query = getParam('query');
    if ($search_query != '') {
        $search_where = " WHERE  (ID = '" . $search_query . "'
								OR Action LIKE '%" . $search_query . "%'
								OR Detail LIKE '%" . $search_query . "%'
								OR UserID LIKE '%" . $search_query . "%'
								OR Updated LIKE '%" . $search_query . "%')";
    }

    $rows = $systemlog_cls->getRows('SELECT * 
									 FROM ' . $systemlog_cls->getTable() . $search_where . '
									 ORDER BY ' . $sortby . ' ' . $dir . '
									 LIMIT ' . $start . ',' . $limit, true);
    $totalCount = $systemlog_cls->getRows();
    $count = count($totalCount);
    $reArray = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $row['Delete'] = '<a onclick ="outAction(\'delete\',' . $row['ID'] . ')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';

            $dt = new DateTime($row['Updated']);
            $row['Updated'] = $dt->format($config_cls->getKey('general_date_format'));
            $retArray[] = $row;
        }
    }
    $arrJS = array("totalCount" => $count, "topics" => $retArray);
    die(json_encode($arrJS));
}

/**
  @ function : __logDeleteAction
 * */
function __logDeleteAction() {
    global $systemlog_cls;
    $log_ids = getParam('ID', '');
    $message = 'abc';
    if ($log_ids != '') {
        $message = 'Delete ' . $log_ids;
        $systemlog_cls->delete("ID IN (" . $log_ids . ")");
        //print_r($systemlog_cls->sql);
    }
    die(json_encode('Deleted successful!'));
}

/**
  @ function : __logSaveAction
 * */
function __logSaveAction() {
    global $config_cls;
    $day = getParam('day');
    $auto = getParam('auto');
    $row = $config_cls->getRow("`key` = 'save_log_day'");
    if (is_array($row) and count($row) > 0) {//UPDATE
        $config_cls->update(array('value' => (int) $day), "`key` = 'save_log_day'");
    } else {
        $config_cls->insert(array('key' => 'save_log_day',
            'value' => (int) $day));
    }

    $row = $config_cls->getRow("`key` = 'auto_clear'");
    if (is_array($row) and count($row) > 0) {//UPDATE
        $config_cls->update(array('value' => $auto), "`key` = 'auto_clear'");
    } else {
        $config_cls->insert(array('key' => 'auto_clear',
            'value' => $auto));
    }
    //print_r($config_cls->sql);
    die(json_encode(''));
}

/*
  @ function : __logGetdayAction
 */

function __logGetdayAction() {
    global $config_cls;
    $auto = $config_cls->getKey('auto_clear');
    $days = $config_cls->getKey('save_log_day');
    die(_response(array('auto' => $auto, 'day' => $days)));
}

?>