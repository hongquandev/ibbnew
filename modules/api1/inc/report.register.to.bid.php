<?php
try {
    $p = (int)restrictArgs(getParams('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 10;
    $min = (($p - 1) * $len);
    $max = $len;
    $property_id = restrictArgs(getParam('property_id', 0));
    $isAgent = Property_isVendorOfProperty($property_id);
    $bid_rows = $payment_store_cls->getRows(' SELECT SQL_CALC_FOUND_ROWS
		pay.property_id,
		pay.agent_id,
		pay.creation_time,
		pay.is_paid,
		pay.is_disable,
                pay.allow,
		agt.firstname,
		agt.lastname,
		agt.agent_id AS Agent_id,
		agt.email_address,
		(SELECT count(bid.agent_id)
		FROM ' . $bid_cls->getTable() . ' AS bid
		WHERE bid.property_id = ' . $property_id . ' AND bid.agent_id = pay.agent_id
) AS bid_number
		FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
		WHERE   pay.agent_id = agt.agent_id
		AND pay.property_id = ' . $property_id . '
		AND (pay.bid = 1 OR pay.offer = 1)
		AND pay.is_paid > 0
		GROUP BY pay.agent_id
		ORDER BY pay.creation_time DESC LIMIT  ' . $min . ',' . $max, true);
    $item_count = $property_cls->getFoundRows();

    $rows = array();
    if (is_array($bid_rows) and count($bid_rows) > 0) {
        $i = 1;
        foreach ($bid_rows as $row) {
            $dt = new DateTime($row['creation_time']);
            if ($isAgent) {
                $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
            } else {
                $row['name'] = getShortName($row['firstname'], $row['lastname']);
            }
            $status = $row['is_disable'] == 1 ? 'No' : 'Yes';
            $allow_lable = $row['allow'] == 1 ? 'Yes' : 'No';
            $row['disable'] = $status;//'<a class="cancel-button" id="disable_' . $i . '" href="javascript:void(0)">' . $status . '</a>';

            $rows[] = array('ID' => $i++,
                            'name' => $row['name'],
                            'email' => $row['email_address'],
                            'agent_id' => $row['agent_id'],
                            'bidNumber' => $row['bid_number'],
                            'info' => '' /*Agent_getBidderInfo($row['agent_id'],false)*/,
                            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s'),
                            'disable' => $row['disable'],
                            'allow_lable' => $allow_lable,
                            'is_disable' => $row['is_disable']);
        }

    }
    $data = array('p' => $p, 'item_per_page' => $len, 'item_count' => $item_count, 'data' => $rows);
    out('1', '', $data);
} catch (Exception $e) {
    out('0', $e->getMessage());
}
?>