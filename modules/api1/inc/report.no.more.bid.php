<?php
try {
    $p = (int)restrictArgs(getParams('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 10;
    $min = (($p - 1) * $len);
    $max = $len;
    $property_id = restrictArgs(getParam('property_id', 0));
    $isAgent = Property_isVendorOfProperty($property_id);
    $data1 = array();
    if (in_array($_SESSION['agent']['type'], array('agent', 'theblock')) && $isAgent) {
        $rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
			a.lastname,
			a.agent_id,
			a.email_address,
			b.*
			FROM ' . $agent_cls->getTable() . ' AS a
			LEFT JOIN ' . $bids_stop_cls->getTable() . ' AS b
			ON a.agent_id = b.agent_id
			WHERE b.property_id = ' . $property_id . '
			ORDER BY b.time DESC LIMIT  ' . $min . ',' . $max, true);

        $item_count = $property_cls->getFoundRows();
        if (is_array($rows) and count($rows) > 0) {
            $i = 1;
            foreach ($rows as $row) {
                $dt = new DateTime($row['time']);
                $row['ID'] = $i++;
                $row['name'] = $isAgent ? $row['firstname'] . ' ' . $row['lastname']
                    : getShortName($row['firstname'], $row['lastname']);
                $row['time'] = $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s');
                $row['info'] = ''; /*Agent_getBidderInfo($row['agent_id'],false)*/
                 
                $data1[] = $row;
            }
        }
    }
    $data = array('p' => $p, 'item_per_page' => $len, 'item_count' => $item_count, 'data' => $data1);
    out('1', '', $data);
} catch (Exception $e) {
    out('0', $e->getMessage());
}


?>