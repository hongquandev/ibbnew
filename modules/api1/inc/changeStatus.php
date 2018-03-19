<?php 
$ids = getParam('ids');
if (!isset($_SESSION['agent'])){
	redirect(ROOTURL);
}
if ($ids != 'null'){//yourself change
	$id_arr = explode(',',$ids);
	foreach ($id_arr as $id){
		$row = $agent_cls->getCRow(array('is_active'),'agent_id = '.(int)$id);
		if (is_array($row) and count($row) > 0){
			$agent_cls->update(array('is_active'=>1-$row['is_active']),'agent_id = '.(int)$id);
		}
	}
}else{//auto inactive account
	$min = (int)restrictArgs(getParam('min',0));
	$rows = $agent_cls->getRows('SELECT agent_id, is_active
			FROM '.$agent_cls->getTable().'
			WHERE parent_id = '.$_SESSION['agent']['id'].' AND is_active = 1
			ORDER BY agent_id DESC
			LIMIT 0,'.$min,true);
	if (is_array($rows) and count($rows) > 0){
		foreach ($rows as $row){
			$agent_cls->update(array('is_active'=>1-$row['is_active']),'agent_id = '.(int)$row['agent_id']);
		}
	}
}

if ($agent_cls->hasError()){
	die(json_encode(array('error'=>1)));
}
die(json_encode(array('success'=>1)));
?>