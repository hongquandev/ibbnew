<?php 
$module = 'menu';
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/role/inc/role.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';

include_once 'inc/'.$module.'.php';
include_once 'inc/admin.'.$module.'.php';

$message = '';
$form_action = '';
$menu_id = restrictArgs(getParam('menu_id', 0));
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'edit':
		if ($perm_ar[$action] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action]);
			redirect('module='.$module.'&action=edit&token='.$token);
		}
		$message = '';
		$form_action = '?module='.$module.'&action='.$action.'&token='.$token;
		$action_ar = explode('-', $action);
		include_once 'inc/admin.'.$module.'.edit.php';
		$smarty->assign(array('action_ar' => $action_ar,
					  'form_action' => $form_action,
					  'permission_id' => $permission_id,
					  'options_access' => AgentType_getOptions(1, 'name'),
					  'options_menu' => array(0 => '- - - Default - - -') + Menu_getOptions(0, 0, ' - - '),
					  'options_area' => Menu_areaAr(),
					  'options_banner_area' => CMS_getArea()));
							  
	break;
	case 'active':
		$menu_cls->update(array('active' => array('fnc' => 'abs(1-active)')), 'menu_id = '.(int)$menu_id);
		$row = $menu_cls->getCRow(array('active'), 'menu_id = '.(int)$menu_id);
		if (is_array($row) && count($row) > 0 && $row['active'] == 0) {
			$id_ar = Menu_getBackGeneral($menu_id);
			if (is_array($id_ar) && count($id_ar) > 0) {
				$menu_cls->update(array('active' => 0), 'menu_id IN (\''.implode("','", $id_ar).'\')');
			}
		}
		$session_cls->setMessage('The information has been updated.');
		redirect('?module='.$module.'&action=lists&token='.$token);
	break;
	case 'delete':
		$row = $menu_cls->getCRow(array('parent_id', 'menu_id'),'menu_id = '.$menu_id);
		$menu_cls->delete('menu_id = '.$menu_id);
		if (is_array($row) && count($row) > 0) {
			$menu_cls->update(array('parent_id' => $row['parent_id']), 'parent_id = '.$row['menu_id']);	
		}
		$session_cls->setMessage('The information has been deleted.');
		redirect('?module='.$module.'&action=lists&token='.$token);
	break;
	case 'upd':
		
		$rows = $menu_cls->getRows();
		foreach ($rows as $row) {
			//$menu_cls->update(array('url' => str_replace('pphtml', 'html', $row['url'])), 'menu_id = '.(int)$row['menu_id']);
			if ($row['parent_id'] == 0) {
				$level_ar = array($row['menu_id'] => $row['title']);
			} else {
				$row2 = $menu_cls->getCRow(array('level'), 'menu_id = '.(int)$row['parent_id']);
				if (is_array($row2) && count($row2) > 0 ) {
					$level_ar = unserialize($row2['level']);
					$level_ar[$menu_id] = $row['title'];
				} else {
					$level_ar = array($menu_id => $data['title']);
				}
			}
			$menu_cls->update(array('level' => serialize($level_ar)), 'menu_id = '.$row['menu_id']);
		}
		die('ok');
	break;
	case 'lists':
		$area_id = restrictArgs(getParam('area_id', 0));
		$form_action = '?module=menu&action='.$action.'&token='.$token;
		$smarty->assign(array('action' => $action,
						'area_id' => $area_id,
						'list_menu' => Menu_getTreeOptions(0, '', ($area_id > 0 ? ' AND CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\'' : '')),
						'options_area' => array(0 => '--- All ---') + Menu_areaAr()));
	break;
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
				'menu_id' => $menu_id,
				'message' => $message,
				'form_action' => $form_action));
?>