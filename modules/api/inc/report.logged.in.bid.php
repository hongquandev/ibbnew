<?php 
$property_id = restrictArgs(getParam('property_id',0));
$isAgent = Property_isVendorOfProperty($property_id);
$rows = $user_online_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
		u.agent_id,
		FROM_UNIXTIME(u.last_active),
		a.firstname,
		a.lastname,
		a.email_address
		FROM '.$user_online_cls->getTable().' AS u
		INNER JOIN '.$agent_cls->getTable().' AS a
		ON a.agent_id = u.agent_id
		INNER JOIN '.$payment_store_cls->getTable().' AS p
		ON p.agent_id = u.agent_id
		AND p.property_id = '.$property_id.'
		WHERE (p.bid = 1 OR p.offer = 1)
		AND p.is_paid > 0
		ORDER BY u.last_active DESC',true);

$data = array();
if (is_array($rows) and count($rows) > 0 ) {
$i=1;
	foreach ($rows as $row) {
		$dt = new DateTime($row['last_active']);
		$row['name'] = $row['firstname'].' '.$row['lastname'];
		$row['ID'] = $i++;
		$row['last_active'] = $dt->format($config_cls->getKey('general_date_format')). ' at '.$dt->format('H:i:s');
		$row['info'] = ''/*Agent_getBidderInfo($row['agent_id'],false)*/;
		$data[] = $row;
	}
	
}
die(json_encode($data));
?>