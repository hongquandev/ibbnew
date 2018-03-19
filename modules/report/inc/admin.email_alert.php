<?php
/*
include_once ROOTPATH.'/modules/emailalert/inc/emailalert.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property_option.class.php';
include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

$start = (int)restrictArgs(getParam('start',0));
$limit = (int)restrictArgs(getParam('limit',20));
$sort_by = getParam('sort','e.email_id');
$dir = getParam('dir','ASC');
$email_id = (int)restrictArgs(getParam('email_id',0));


$rows = $email_cls->getRows('SELECT e.email_id,
                                    e.name_email,
                                    e.minprice,
                                    e.maxprice,
                                    e.address,
                                    e.suburb,
                                    e.postcode,
                                    e.minprice,
                                    e.maxprice,
                                    e.land_size_max,
                                    e.land_size_min,
                                    e.unit,
                                    e.last_cron,
                                    a.email_address,

                                    (SELECT reg3.name
									 FROM '.$region_cls->getTable().' AS reg3
									 WHERE reg3.region_id = e.country
									 ) AS country_name,

                                    (SELECT reg1.name
									 FROM '.$region_cls->getTable().' AS reg1
								     WHERE reg1.region_id = e.state
								     ) AS state_name,

                                    (SELECT pro_opt4.value
									 FROM '.$property_entity_option_cls->getTable().' AS pro_opt4
								     WHERE pro_opt4.property_entity_option_id = e.car_space
								     ) AS carspace_value,

                                    (SELECT pro_opt3.value
									 FROM '.$property_entity_option_cls->getTable().' AS pro_opt3
								     WHERE pro_opt3.property_entity_option_id = e.car_port
								     ) AS carport_value,

                                    (SELECT pro_opt1.value
									 FROM '.$property_entity_option_cls->getTable().' AS pro_opt1
									 WHERE pro_opt1.property_entity_option_id = e.bathroom
									 ) AS bathroom_value,

                                    (SELECT pro_opt2.value
									 FROM '.$property_entity_option_cls->getTable().' AS pro_opt2
									 WHERE pro_opt2.property_entity_option_id = e.bedroom
									 ) AS bedroom_value

                               FROM '.$email_cls->getTable().' AS e
                               LEFT JOIN '.$agent_cls->getTable().' AS a
                               ON e.agent_id = a.agent_id
                               ORDER BY '.$sort_by.' '.$dir,true);
$total = $email_cls->getFoundRows();
if (is_array($rows) and count($rows)){
    $result = array();
    foreach ($rows as $key=>$row){
        $row[$key] = $row[$key] == 0? '_':$row[$key];
        $row['minprice'] = showPrice($row['minprice']);
        $row['maxprice'] = showPrice($row['maxprice']);
        $result[] = $row;
    }
}
$data = array('totalCount' => $total, 'topics' => $result,'limit' => $limit);
die(json_encode($data));

*/?>