<?php 
include_once 'roles.class.php';
if (!isset($role_cls) or !($role_cls instanceof Roles)) {
	$role_cls = new Roles();
}

/**
*@function : Role_getOptions
*/
function Role_getOptions() {
	global $role_cls;
	$rs = array();
	$rows = $role_cls->getRows('active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['role_id']] = $row['title'];
		}
	}
	return $rs;
}

/**
*@function : Role_getFirsts
*/
function Role_getFirst(){
	global $role_cls;
	$rs = array();
	$row = $role_cls->getRow('1 ORDER BY `order` ASC');
	if (is_array($row) and count($row) > 0) {
		$rs = array('role_id' => $row['role_id'], 'title' => $row['title']);
	}
	
	return $rs;
}

function Role_getRole($role_id){
    global $role_cls;
    $row = $role_cls->getRow('role_id = '.$role_id);
    if (is_array($row) and count($row) > 0){
        return $row['title'];
    }
    return '';
}
?>