<?php

header('Content-type:text/javascript;charset=UTF-8');
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
require_once  '../../includes/functions.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}

$start = $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'];
$limit = $_REQUEST['limit'] == 0 ? 25 : $_REQUEST['limit'];
$sortby = $_REQUEST['sort'] == '' ? 'ID' : $_REQUEST['sort'];
$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'];



$sql = "SELECT a.agent_id, a.firstname, a.lastname, a.email_address, a.telephone, a.suburb, a.update_time, a.is_active,
				(SELECT r1.name FROM regions AS r1 WHERE r1.region_id=a.suburb) AS suburb_name,
				(SELECT r2.name FROM regions AS r2 WHERE r2.region_id=a.country) AS country_name  
			FROM agent as a ";
$handle = mysql_query($sql);

if (!$handle) {
    echo mysql_error();
}

$totalCount = mysql_num_rows($handle);

$handle = mysql_query($sql . " ORDER BY $sortby $dir LIMIT $start, $limit");
if (!$handle) {
    echo mysql_error();
}
$retArray = array();

while ($row = mysql_fetch_assoc($handle)) {
    $row['Delete'] = "<div style='cursor:pointer; color:#FF0000' onclick =\"if (confirm('Are you sure you want to delete?')) { deleteItem('../modules/users/action.php?action=delete&ID={$row['agent_id']}'); document.getElementById('ext-gen54').click(); } \" >Delete</a>";

    $row['Edit'] = "<a href=\"index.php?module=users&action=edituser&ID={$row['agent_id']}\" style=\"color:#0000FF; text-decoration:none\" onClick=\"\">Edit</a>";

    $row['is_active'] = $row['is_active'] == 0 ? "<div style='cursor:pointer; color:#FF0000' onclick =\" deleteItem('../modules/users/action.php?action=active&ID={$row['agent_id']}'); document.getElementById('ext-gen54').click();   \" >InActive</a>" : "<div style='cursor:pointer; color:#009900' onclick =\" deleteItem('../modules/users/action.php?action=inactive&ID={$row['agent_id']}'); document.getElementById('ext-gen54').click();   \" >Active</a>";

    $retArray[] = $row;
}

// $data = json_encode($retArray);

$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);

echo json_encode($arrJS);
?> 