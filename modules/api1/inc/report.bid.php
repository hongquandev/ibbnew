<?php
try {
    $p = (int)restrictArgs(getParams('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 10;
    $min = (($p - 1) * $len);
    $max = $len;

    $property_id = restrictArgs(getParam('property_id', 0));
    $isAgent = Property_isVendorOfProperty($property_id);
    $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
		bid.price,
		bid.time,
		bid.in_room,
		bid.agent_id,
		agt.firstname,
		agt.lastname,
		agt.agent_id as Agent_id,
		agt.email_address
		FROM ' . $bid_cls->getTable() . ' AS bid,' . $agent_cls->getTable() . ' AS agt
		WHERE bid.agent_id = agt.agent_id AND bid.property_id = ' . $property_id . '
		ORDER BY bid.price DESC
		LIMIT  ' . $min . ',' . $max, true); 
    $item_count = $property_cls->getFoundRows();
    $actualBid_rows = array();

    if (is_array($bid_rows) and count($bid_rows) > 0) {
        $i = 1;
        foreach ($bid_rows as $key => $row) {
            $row['name'] = $isAgent ? $row['firstname'] . ' ' . $row['lastname']
                    : getShortName($row['firstname'], $row['lastname']);

            if (Property_isVendorOfProperty($property_id, $row['agent_id'])) {
                $row['name'] = $row['in_room'] == 1 ? 'In Room Bid' : 'Vendor Bid';
            }

            $dt = new DateTime($row['time']);
            $actualBid_rows[] = array('ID' => $i++,
                                      'name' => $row['name'],
                                      'raw_price' => $row['price'],
                                      'price' => showPrice($row['price']),
                                      'info' => '' /*Agent_getBidderInfo($row['agent_id'],false)*/,
                                      'agent_id' => $row['agent_id'],
                                      'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s')
            );
        }


    }
    $data = array('p' => $p, 'item_per_page' => $len, 'item_count' => $item_count, 'data' => $actualBid_rows);
    out('1', '', $data);
} catch (Exception $e) {
    out('0', $e->getMessage());
}
?>