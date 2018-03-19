<?php 
$property_id = restrictArgs(getParam('property_id',0));
$isAgent = Property_isVendorOfProperty($property_id);
if (/*in_array($_SESSION['agent']['type'],array('agent','theblock')) &&*/ $isAgent){
	$rows = $bids_stop_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname,
			a.lastname,
			a.agent_id,
			a.email_address,
			b.*
			FROM '.$agent_cls->getTable().' AS a
			LEFT JOIN '.$bids_stop_cls->getTable().' AS b
			ON a.agent_id = b.agent_id
			WHERE b.property_id = '.$property_id.'
			ORDER BY b.time DESC',true);

	$data = array();
	if (is_array($rows) and count($rows) > 0){
		$i =  1;
		foreach ($rows as $row){
			$dt = new DateTime($row['time']);
			$row['ID'] = $i++;
			$row['email'] = $row['email_address'];
			$row['time'] = $dt->format($config_cls->getKey('general_date_format')). ' at '.$dt->format('H:i:s');
			$row['name'] = $row['firstname'].' '.$row['lastname']/*Agent_getBidderInfo($row['agent_id'],false)*/;
			$data[] = $row;
		}
	}
	die(json_encode($data));
}
?>