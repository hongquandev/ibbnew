<?php

header('Content-type:text/javascript;charset=UTF-8');
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
require_once   '../../includes/functions.php';
$smarty = new Smarty;
//$smarty->cache_dir = '../modules/banner/cache/';
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}
$smarty->compile_check = true;
//$smarty->caching = true; //  caching

if ($_SESSION['language'] == 'vn') {
    include 'lang/propertystatistics.vn.lang.php';
} else {
    include 'lang/propertystatistics.en.lang.php';
}
$start = $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'];
$limit = $_REQUEST['limit'] == 0 ? 25 : $_REQUEST['limit'];
$sortby = $_REQUEST['sort'] == '' ? 'ID' : $_REQUEST['sort'];
$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'];

//  $sql = "SELECT property_id from property_entity"; 
$sql = "SELECT pro.property_id , pro.views, pro.address,  pro.type , pro.postcode , pro.country, pro.price
    ,(SELECT po1.title FROM property_entity_option AS po1 WHERE po1.property_entity_option_id=pro.auction_sale ) AS auction_name
    ,(SELECT po2.title FROM property_entity_option AS po2 WHERE po2.property_entity_option_id=pro.type ) AS type_name
	,(SELECT po3.name FROM regions AS po3 WHERE po3.region_id = pro.country) AS region_name
	,(SELECT po4.title FROM property_entity_option AS po4 WHERE po4.property_entity_option_id =  pro.price_range ) AS price_name
	,(SELECT po5.title FROM property_entity_option AS po5 WHERE po5.property_entity_option_id = 
	   pro.bedroom ) AS bedroom_name
	,(SELECT po6.title FROM property_entity_option AS po6 WHERE po6.property_entity_option_id = 
	   pro.bathroom ) AS bathroom_name
	,(SELECT po7.title FROM property_entity_option AS po7 WHERE po7.property_entity_option_id = 
	   pro.land_size ) AS land_size_name
	,(SELECT po8.title FROM property_entity_option AS po8 WHERE po8.property_entity_option_id = 
	   pro.car_space ) AS car_space_name
	,(SELECT po9.title FROM property_entity_option AS po9 WHERE po9.property_entity_option_id = 
	   pro.car_port ) AS car_port_name
	,(SELECT concat(firstname, lastname) FROM agent AS po10 WHERE po10.agent_id = 
	   pro.agent_id ) AS agent_fullname  
    FROM `property_entity` as pro";

$handle = mysql_query($sql);

if (!$handle) {
    echo mysql_error();
}

$totalCount = mysql_num_rows($handle);

//  file_put_contents(ROOTPATH.'/tam.txt', $handle);	

$handle = mysql_query($sql . " ORDER BY $sortby $dir LIMIT $start, $limit");

if (!$handle) {
    echo mysql_error();
}

$retArray = array();

while ($row = mysql_fetch_assoc($handle)) {

    $retArray[] = $row;
}
// $data = json_encode($retArray);
$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);
echo json_encode($arrJS);
?> 
