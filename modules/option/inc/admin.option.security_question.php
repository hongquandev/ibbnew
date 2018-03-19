<?php
$option_id = (int)restrictArgs(getParam('option_id',0));

switch (@$action_ar[0]) {
	case 'active':
		if ($option_id > 0) {
			$agent_option_cls->update(array('active' => array('fnc' => '(abs(active - 1))')),'agent_option_id = '.$option_id);
			$message = 'Updated successful.';
		}
	break;
	case 'edit':
		if ($option_id > 0) {
			$row = $agent_option_cls->getRow('agent_option_id = '.$option_id);
			if (is_array($row) && count($row) > 0) {
				$form_data = $row;
			}
			$form_action .= '&option_id='.$option_id;
		}
	break;
	case 'delete':
		if ($option_id > 0) {
			$row = $agent_option_cls->getRow('agent_option_id = '.$option_id);
			if (is_array($row) && count($row) > 0) {
				$agent_option_cls->delete('agent_option_id = '.$option_id);
				$session_cls->setMessage('Deleted successful.');
			}
		}
		redirect('?module=option&action=view-'.$action_ar[1].'&token='.$token);
	break;
	case 'save':
		$next = (int)getParam('next',0);
		
		if ($option_id > 0) {//UPDATE
			$agent_option_cls->update(array('title' => getParam('title'), 
											'order' => (int)restrictArgs(getParam('order')),
											'code' => str_replace(' ','',strtolower(getParam('title'))),
											'active' => (int)getParam('active')
											), 
											'agent_option_id = '.$option_id);
			$session_cls->setMessage('Updated successful.');								
		} else {//ADD
			$parent_id = 0;
			$row = $agent_option_cls->getRow("code = '".$action_ar[1]."'");
			if (is_array($row) && count($row) > 0) {
				$parent_id = $row['agent_option_id'];
				$agent_option_cls->insert(array('title' => getParam('title'), 
												'order' => (int)restrictArgs(getParam('order')),
												'code' => str_replace(' ','',strtolower(getParam('title'))),
												'active' => (int)getParam('active'),
												'parent_id' => $parent_id));
				$session_cls->setMessage('Added successful.');				
			}

		}
		
		if ($next == 1) {
			redirect('?module=option&action=view-'.$action_ar[1].'&token='.$token);
		} else if ($option_id > 0) {
			redirect('?module=option&action=edit-'.$action_ar[1].'&option_id='.$option_id.'&token='.$token);
		}
	break;
}

$rows = $agent_option_cls->getRows('SELECT *
								FROM '.$agent_option_cls->getTable().' AS o 
								WHERE o.parent_id = (SELECT o2.agent_option_id
													FROM '.$agent_option_cls->getTable()." AS o2
													WHERE o2.code = '".$action_ar[1]."')
								ORDER BY `order` ASC",true);
$data = array();													
if (is_array($rows) && count($rows) > 0) {
	foreach ($rows as $row) {
		$link_ar = array('module' => 'option' ,'action' => '', 'option_id' => $row['agent_option_id'],'token' => $token);
		
		$label_status = 'Disable';
		if ($row['active'] == 1) {
			$label_status = 'Enable';
		}
		
		$link_ar['action'] = 'active-'.$action_ar[1];
		$row['link_status'] = '<a href="?'.http_build_query($link_ar).'">'.$label_status.'</a>';
		
		$link_ar['action'] = 'edit-'.$action_ar[1];
		$row['link_edit'] = '?'.http_build_query($link_ar);
		
		$link_ar['action'] = 'delete-'.$action_ar[1];
		$row['link_del'] = '?'.http_build_query($link_ar);
		
		$data[] = $row;
	}
}													

$smarty->assign('data',$data);
$smarty->assign('form_data',formUnescapes($form_data));
?>