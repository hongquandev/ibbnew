<?php 
include_once 'permission.class.php';
if (!isset($permission_cls) or !($permission_cls instanceof Permission)) {
	$permission_cls = new Permission();
}


/**
*@function : Permission_add
*/
function Permission_add($tab_id = 0, $role_id = 0) {
	global $permission_cls;
	if ($tab_id > 0 and $role_id > 0) {
		$permission_cls->insert(array('tab_id' => $tab_id, 'role_id' => $role_id, 'add' => 0 , 'view' => 0, 'edit' => 0, 'delete' => 0));
	}
}

/**
*@function : Permission_has
*/
function Permission_has($tab_id = 0, $role_id = 0) {
	global $permission_cls;
	$row = $permission_cls->getRow('tab_id = '.$tab_id.' AND role_id = '.$role_id);
	if (is_array($row) and count($row) > 0) {
		return true;
	}
	return false;
}

/**
*@function : Permission_check
*/
function Permission_getRole($tab_id = 0, $role_id = 0) {
	global $permission_cls;
	$rs = array('view' => 0, 'add' => 0, 'edit' => 0, 'delete' => 0);
	$row = $permission_cls->getRow('tab_id = '.$tab_id.' AND role_id = '.$role_id);
	if (is_array($row) and count($row) > 0 ) {
		$rs['view'] = $row['view'];
		$rs['add'] = $row['add'];
		$rs['edit'] = $row['edit'];
		$rs['delete'] = $row['delete'];
	}
	return $rs;
}

/**
*@function : Permission_items
*/
function Permission_items($role_id = 0){
	global $permission_cls;
	$item_ar  = array();
	$tab_ar = Tab_getTreeOptions();
	if (is_array($tab_ar) and count($tab_ar) > 0) {
		foreach ($tab_ar as $tab_id => $tab_title) {
			$_item = Permission_getRole($tab_id, $role_id);
			$item_ar[$tab_id] = array('title' => $tab_title,'permission' => $_item);
		}
	}
	
	return $item_ar;
}

/**
*@function : Permission_addByRole
*/
function Permission_addByRole($role_id = 0){
	$tab_ar = Tab_getTreeOptions();
	if (is_array($tab_ar) and count($tab_ar) > 0 and $role_id > 0) {
		foreach ($tab_ar as $tab_id => $tab_title) {
			if (!Permission_has($tab_id, $role_id)) {
				Permission_add($tab_id, $role_id);
			}
		}
	}
}

/**
*@function : Permission_addByTab
*/
function Permission_addByTab($tab_id = 0){
	$role_ar = Role_getOptions();
	if (is_array($role_ar) and count($role_ar) > 0 and $tab_id > 0) {
		foreach ($role_ar as $role_id => $role_title) {
			if (!Permission_has($tab_id, $role_id)) {
				Permission_add($tab_id, $role_id);
			}
		}
	}
}

/**
*@function : Permission_deleteByTab
*/
function Permission_deleteByTab($tab_id = 0){
	global $permission_cls;
	if ($tab_id > 0) {
		$permission_cls->delete('tab_id = '.$tab_id);
	}
}

/**
*@function : Permission_deleteByRole
*/
function Permission_deleteByRole($role_id = 0){
	global $permission_cls;
	if ($role_id > 0) {
		$permission_cls->delete('role_id = '.$role_id);
	}
}
?>