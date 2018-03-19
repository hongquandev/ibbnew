<?php 
$property_id = restrictArgs(getParam('property_id',0));
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
		', true);
$total_row = $bid_cls->getFoundRows();
$actualBid_rows = array();

if (is_array($bid_rows) and count($bid_rows) > 0) {
	$i = 1;
	foreach ($bid_rows as $key => $row) {
		$row['name'] = $isAgent?$row['firstname'].' '.$row['lastname']:getShortName($row['firstname'], $row['lastname']);

		if (Property_isVendorOfProperty($property_id,$row['agent_id'])){
			$row['name'] = $row['in_room'] == 1?'In Room Bid':'Vendor Bid';
		}

		$dt = new DateTime($row['time']);
		$actualBid_rows[] = array('ID'=>$i++,
				'name' => $row['name'],
				'raw_price'=>$row['price'],
				'price' => showPrice($row['price']),
				'info' => ''/*Agent_getBidderInfo($row['agent_id'],false)*/,
				'agent_id' => $row['agent_id'],
				'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:i:s')
				);
	}


}
	die(json_encode($actualBid_rows));	
?>