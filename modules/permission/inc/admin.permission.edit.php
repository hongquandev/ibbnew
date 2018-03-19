<?php
if (isSubmit()) {
	if ($role_id <= 0) {
		$message = 'Please chose Role';
		return ;
	}
	$tab_ar = Tab_getOptions();
	if (is_array($tab_ar) and count($tab_ar) > 0) {
		foreach ($tab_ar as $tab_id => $tab_title) {
			$_data = array();
			
			$_data['add'] = isset($_POST['add'][$tab_id]) ? 1 : 0;
			$_data['view'] = isset($_POST['view'][$tab_id]) ? 1 : 0;
			$_data['edit'] = isset($_POST['edit'][$tab_id]) ? 1 : 0;
			$_data['delete'] = isset($_POST['delete'][$tab_id]) ? 1 : 0;
			
			if (Permission_has($tab_id,$role_id)) {//UPDATE
				$permission_cls->update($_data,'tab_id = '.$tab_id.' AND role_id = '.$role_id);	
			} else {//ADD
				$_data['tab_id'] = $tab_id;
				$_data['role_id'] = $role_id;
				
				$permission_cls->insert($_data);
			}
		}
		$message = 'Edited successful.';
	}
} 

?>