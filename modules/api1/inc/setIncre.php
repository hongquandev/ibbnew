<?php 
$min = (int)restrictArgs(getParam('min-incre'));
$max = (int)restrictArgs(getParam('max-incre'));
$property_id = restrictArgs(getParam('property_id'));
try {
    if ((int)restrictArgs(getParam('is_reset')) != 1) {
        
        if (isset($max) && $max < $min && $max > 0 && $min > 0) {
            out('0', 'Min increment must be less than or equal to max'); 
        }
    }

    $str = $_SESSION['agent']['parent_id'] == 0 ? ' (agent_id IN (SELECT agent_id
														  FROM ' . $agent_cls->getTable() . '
														  WHERE parent_id = ' . $_SESSION['agent']['id'] . ')
											   OR agent_id = ' . $_SESSION['agent']['id'] . ')'
            :
            " IF(ISNULL(agent_manager) || agent_manager = ''
											   ,agent_id ={$_SESSION['agent']['id']}
											   ,agent_manager = {$_SESSION['agent']['id']})";

    $row = $property_cls->getRow('SELECT property_id
							  FROM ' . $property_cls->getTable() . "
							  WHERE {$str}
									AND property_id = {$property_id}"
        , true);

    if (is_array($row) and count($row) > 0) {
        $property_cls->update(array('min_increment' => $min,
                                   'max_increment' => $max),
                              'property_id = ' . $property_id);

        if ($property_cls->hasError()) {
            out('0', $property_cls->getError());
        } else {
            pushWithoutUserId($_SESSION['agent']['id'], array('type_msg' => 'update-increment', 'property_id' => $property_id));
            out('1', 'Saved successful!');
        }
    } 
} catch (Exception $e) {
    out('0', $e->getMessage());
}
out(0, 'You have not permission!')
?>