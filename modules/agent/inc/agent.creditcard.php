<?php
$cc_id = (int) preg_replace('/[^0-9]/','',isset($_GET['cc_id']) ? $_GET['cc_id'] : 0);
$form_data = array();
switch ($action_ar[0]) {
	case 'delete':
		$cc_id_ar = isset($_POST['cc_id']) ? $_POST['cc_id'] : (isset($_GET['cc_id']) ? $_GET['cc_id'] : 0);
		
		if (!is_array($cc_id_ar)) {
			$cc_id_ar = array($cc_id_ar);
		}
		
		if (is_array($cc_id_ar) and count($cc_id_ar) > 0) {
			$agent_creditcard_cls->delete('agent_creditcard_id IN ('."'".implode("','",$cc_id_ar)."'".') AND agent_id = '.$_SESSION['agent']['id']);	
			$message = 'The information has been deleted.';
		}
		
		
		$action = 'view-creditcard';
		$action_ar[0] = 'view';
		$form_action = '?module='.$module.'&action='.$action;
	break;
	case 'add':
		$form_data = array();
		
		if (is_array($_POST['field']) and count($_POST['field']) > 0) {
			foreach ($_POST['field'] as $key => $val) {
				$form_data[$key] = $agent_creditcard_cls->escape($val);
			}
		}
		
		$data = $agent_creditcard_cls->getFields();
		foreach ($data as $key => $val) {
			$data[$key] = $form_data[$key];
		}
		
		$data['expiration_date'] = $form_data['expiration_year'].'-'.$form_data['expiration_month'].'-01';
		$data['agent_id'] = $_SESSION['agent']['id'];
		
		if ($cc_id > 0) {
			$agent_creditcard_cls->update($data,'agent_creditcard_id = '.$cc_id.' AND agent_id = '.$_SESSION['agent']['id']);
			$message = 'The information has been updated.';
		} else {
			$agent_creditcard_cls->insert($data);
			$cc_id = $agent_creditcard_cls->insertId();
			$message = 'The information has been inserted.';
		}
		$form_action .='&cc_id='.$cc_id;
	break;
	case 'edit':
		if ($cc_id > 0) {
			$form_action .='&cc_id='.$cc_id;
			$row = $agent_creditcard_cls->getRow('agent_creditcard_id = '.$cc_id.' AND agent_id = '.$_SESSION['agent']['id']);
			$form_data = $agent_creditcard_cls->getFields();
			if (is_array($row) and count($row)>0) {
				foreach ($row as $key => $val) {
					if (isset($form_data[$key])) {
						$form_data[$key] = $val;
					}
				}
				$dt = new DateTime($row['expiration_date']);
				$form_data['expiration_year'] = $dt->format('Y');
				$form_data['expiration_month'] = $dt->format('m');
			}
		}
	break;
}

//BEGIN LIST
$creditcard_data = array();
$rows = $agent_creditcard_cls->getRows('SELECT acc.*,
					(SELECT ct.name FROM '.$card_type_cls->getTable().' AS ct WHERE ct.code = acc.card_type) AS card_typename
					FROM '.$agent_creditcard_cls->getTable().' AS acc 
					WHERE acc.agent_id = '.$_SESSION['agent']['id'],true);
					
if (is_array($rows) and count($rows)>0) {
	foreach ($rows as $key => $row) {
		$dt = new DateTime($row['expiration_date']);
		$rows[$key]['expiration_date'] = $dt->format('F, Y');
	}
	$creditcard_data = $rows;
}
//END

$smarty->assign('form_data',$form_data);
$smarty->assign('options_year',ACC_getOptionsYear(date('Y')+10));
$smarty->assign('options_month',ACC_getOptionsMonth());
$smarty->assign('creditcard_data',$creditcard_data);
$smarty->assign('options_card_type',CT_getOptions());
?>