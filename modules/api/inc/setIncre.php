<?php 
$min = (int)restrictArgs(getParam('min-incre'));
$max = (int)restrictArgs(getParam('max-incre'));
$property_id = restrictArgs(getParam('property_id'));

if ((int)restrictArgs(getParam('is_reset')) != 1) {
    if(($max > $min AND $min > 0) OR ($min > 0 AND getParam('max-incre','') == '' ) ){
    }else{
        /*if ($max <= 0 ) {
            die(json_encode(array('success' => 1, 'msg' =>' Max increment must be than zero')));
        }
        if (isset($max) && $max < $min && $max > 0 && $min > 0) {
            die(json_encode(array('success' => 1, 'msg' =>' Min increment must be less than or equal to max')));
        }*/
        die(json_encode(array('success' => 1, 'msg' =>' Max increment must be than min(min>0)')));
    }
}

$str = $_SESSION['agent']['parent_id'] == 0 ? ' (agent_id IN (SELECT agent_id
														  FROM '.$agent_cls->getTable().'
														  WHERE parent_id = '.$_SESSION['agent']['id'].')
											   OR agent_id = '.$_SESSION['agent']['id'].')'
											:
											  " IF(ISNULL(agent_manager) || agent_manager = ''
											   ,agent_id ={$_SESSION['agent']['id']}
											   ,agent_manager = {$_SESSION['agent']['id']})";
											   
$row = $property_cls->getRow('SELECT property_id
							  FROM '.$property_cls->getTable()."
							  WHERE {$str}
									AND property_id = {$property_id}"
							  ,true);
							  
if (is_array($row) and count($row) > 0){
	$property_cls->update(array('min_increment' => $min,
								'max_increment' => $max),
						  'property_id = '.$property_id);
						  
	if ($property_cls->hasError()) {
		die(json_encode(array('success' => 1, 'msg' => $property_cls->getError())));
	} else {
		die(json_encode(array('success' => 1, 'msg' => 'Saved successful!')));
	}
}

die(json_encode(array('success' => 1, 'msg' => 'You have not permission!')));
?>