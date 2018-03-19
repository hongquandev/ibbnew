<?php 
include_once ROOTPATH.'/modules/property/inc/property.php';
require_once  ROOTPATH.'/includes/functions.php';
include_once 'regions.php';
include_once 'ratings.class.php';
//BEGIN SMARTY
include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty; 
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}
//END

if (!isset($rating_cls) or !($rating_cls instanceof Ratings)) {
	$rating_cls = new Ratings();
}

function getRatingOptions($code = '',$default = array()) {
	global $rating_cls;
	// Cache get
	$file_name = ROOTPATH.'/modules/cache/rating_option.php';
	if (file_exists($file_name)) {
		return Cache_get($file_name);
	}
	$options = count($default) ? $default : array(0 => 'Select...');
	$rows = $rating_cls->getRows('SELECT rating_id, title FROM '.$rating_cls->getTable().' WHERE parent_id = (SELECT rating_id FROM '.$rating_cls->getTable().' WHERE code = \''.$code.'\') ORDER BY `order` ASC', true);
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$options[$row['rating_id']] = $row['title'];
		}
	}
	// Cache set
	Cache_set($file_name, $options);
	return $options;
}

function optionsPriceMin($default = '--'){
	$option_ar = array();
	$floor = 100000;
	$option_ar[0] = $default;
    //$option_ar[$floor - 1] = '< $'.number_format($floor,',');
	for ($i = 1; $i <= 10 ;$i++) {
		//$option_ar[$i * $floor] = number_format($i * $floor,2,'.',',')
		$option_ar[$i * $floor] = '$'.number_format($i * $floor, 0, '.', ',');
	}
	$floor = 1000000;
	for ($i = 1; $i <= 10 ;$i++) {
		$option_ar[$i * $floor] = '$'.number_format($i * $floor, 0, '.', ',');
	}
	return $option_ar;
}
function optionsPriceMax($default = '--'){
	$option_ar = array();
	$floor = 100000;
	$option_ar[0] = $default;
	for ($i = 1; $i <= 10 ;$i++) {
		//$option_ar[$i * $floor] = number_format($i * $floor,2,'.',',')
		$option_ar[$i * $floor] = '$'.number_format($i * $floor,0,'.',',');
	}
	$floor = 1000000;
	for ($i = 1; $i <= 10 ;$i++) {
		$option_ar[$i * $floor] = '$'.number_format($i * $floor,0,'.',',');
	}
    //$option_ar[10 * $floor + 1] = '> $'.number_format(10 * $floor,',');
	return $option_ar;
}
function optionsArea($default = '--'){
	$option_ar = array();
	$floor = 100;
	$option_ar[0] = $default;
    $option_ar[50] = 50;
	for ($i = 1; $i <= 10 ;$i++) {
		$option_ar[$i * $floor] = $i * $floor;
	}
	return $option_ar;
}


$search_data = array();
$order_by = array("0"=>Localizer::translate("-Order by-"),
                  "highest"=> Localizer::translate("Highest Price"),
                  "lowest"=>Localizer::translate("Lowest Price"),
                  "newest"=>Localizer::translate("Newest Listing"),
                  "oldest"=>Localizer::translate("Oldest Listing"),
                  "suburb"=>Localizer::translate("Suburb"),
                  "state"=>Localizer::translate("State"));

$agent_order_by = array("0"=>Localizer::translate("-Order by-"),
                  "notcomplete" => "Not Complete",
                  "switch" => "Switch",
                  "passed-in" => "Passed In",
                  "offer" => "Offer",
                  "active" => "Wait Activation",
                  "sold" =>" Sold",
                  "highest"=> Localizer::translate("Highest Price"),
                  "lowest"=>Localizer::translate("Lowest Price"),
                  "newest"=>Localizer::translate("Newest Listing"),
                  "oldest"=>Localizer::translate("Oldest Listing"),
                  "suburb"=>Localizer::translate("Suburb"),
                  "state"=>Localizer::translate("State"));
$agent_auction_order_by = array("0"=>Localizer::translate("-Order by-"),
                  "notcomplete" => "Not Complete",
                  "switch" => "Switch",
                  "offer" => "Offer",
                  "active" => "Wait Activation",
                  "highest"=> Localizer::translate("Highest Price"),
                  "lowest"=>Localizer::translate("Lowest Price"),
                  "newest"=>Localizer::translate("Newest Listing"),
                  "oldest"=>Localizer::translate("Oldest Listing"),
                  "suburb"=>Localizer::translate("Suburb"),
                  "state"=>Localizer::translate("State"));
$watchlist_order_by = array("0"=>Localizer::translate("-Order by-"),
                  "switch" => "Switch",
                  "sold" =>" Sold",
                  "highest"=> Localizer::translate("Highest Price"),
                  "lowest"=>Localizer::translate("Lowest Price"),
                  "newest"=>Localizer::translate("Newest Listing"),
                  "oldest"=>Localizer::translate("Oldest Listing"),
                  "suburb"=>Localizer::translate("Suburb"),
                  "state"=>Localizer::translate("State"));

$bids_order_by = array("0"=>Localizer::translate("-Order by-"),
                  "switch" => "Switch",
                  "sold" =>" Sold",
                  "highest"=> Localizer::translate("Highest Price"),
                  "lowest"=>Localizer::translate("Lowest Price"),
                  "newest"=>Localizer::translate("Newest Listing"),
                  "oldest"=>Localizer::translate("Oldest Listing"),
                  "suburb"=>Localizer::translate("Suburb"),
                  "state"=>Localizer::translate("State"));

$banner_order_by = array("0" =>Localizer::translate("-Order by-"),
                         "name" => "Name",
                         "newest"=>Localizer::translate("Newest Listing"),
                         "oldest"=>Localizer::translate("Oldest Listing")

                         );
$search_data['region'] = R_getOptions(COUNTRY_DEFAULT,array(0 => Localizer::translate('Any')));
$search_data['state'] = R_getOptions((COUNTRY_DEFAULT > 0 ? COUNTRY_DEFAULT : -1 ),array(0 => Localizer::translate('Any')));
$search_data['country'] = R_getOptions(0,array(0 => Localizer::translate('Any')));

$property_kind = 0;

if (($ar = getPost('search')) && isset($ar['property_kind'])) {
	$property_kind = $ar['property_kind'];
} else if (getParam('property_kind')) {
	$property_kind = getParam('property_kind');
}
if ($property_kind == 1) {
	$search_data['property_type'] =  array(0 => Localizer::translate('Any'))  + PEO_getOptions('property_type_commercial') ;
} else if ($property_kind == 2) {
	$search_data['property_type'] =  array(0 => Localizer::translate('Any'))  + PEO_getOptions('property_type');
} else {
	$search_data['property_type'] =  array(0 => Localizer::translate('Any'))  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial') ;
}



//$search_data['property_type_commercial'] = PEO_getOptions('property_type_commercial',array(0 => Localizer::translate('Any')));
$search_data['bedroom'] = PEO_getOptions('bedrooms',array(0 => Localizer::translate('Any')));
$search_data['parking'] = PEO_getParking(array(-1 => Localizer::translate('Any')));

//$search_data['land_size'] = PEO_getOptions('land_size',array(0 => Localizer::translate('Any')));
$search_data['bathroom'] = PEO_getOptions('bathrooms',array(0 => Localizer::translate('Any')));
$search_data['unit'] = PEO_getOptions('unit',array(0 => Localizer::translate('Any')));
$search_data['land_size'] = optionsArea(Localizer::translate('Any'));
$search_data['livability_rating'] = getRatingOptions('livability_rating',array(0 => Localizer::translate('Any')));
$search_data['green_rating'] = getRatingOptions('green_rating',array(0 => Localizer::translate('Any')));

$search_data['car_spaces'] = PEO_getOptions('car_spaces',array(0 => Localizer::translate('Any')));
$search_data['car_port'] = PEO_getOptions('garage_carport',array(0 => Localizer::translate('Any')));

$search_data['min_price'] = optionsPriceMin(Localizer::translate('Any'));
$search_data['max_price'] = optionsPriceMax(Localizer::translate('Any'));

$search_data['rating'] = optionsRating(Localizer::translate('Any'));
$search_data['order_by'] = $order_by;
$search_data['agent_order_by'] = $agent_order_by;
$search_data['agent_auction_order_by'] = $agent_auction_order_by;
$search_data['bids_order_by'] = $bids_order_by;
$search_data['watchlist_order_by'] = $watchlist_order_by;
$search_data['banner_order_by'] = $banner_order_by;

$search_data['kinds'] = PEO_getKind(array(0 => Localizer::translate('Any')));

$smarty->assign('search_data',$search_data);

//
//print_r($_REQUEST);
//print_r($_SERVER['REQUEST_URI']);
//die();
//ini_set('display_errors', 1);
if($_SERVER['REQUEST_URI'] == '/view-search-advance.html&rs=1'){
    $params_search = $_REQUEST['search'];
    $seo_url = ''; $hasOnlyRegion = true;
    if(is_array($params_search) && count($params_search) > 0){
        foreach($params_search as $key => $val){
            if(!empty($val) || $val > 0 ){
                if($key != 'region'){
                //$seo_url .= ''.$key.'-'.trim(strtolower($val)).'/';
                    $hasOnlyRegion = false;
                }
            }
        }
        $region = $params_search['region'];
        if(!empty($region) && $hasOnlyRegion){
            header("Location: ".ROOTURL.'/property-for-sale-'.trim(strtolower($region)).'/'.$seo_url);
            die();
        }

    }
}
if($_SERVER['REQUEST_URI'] == '/?module=property&action=search-auction'){
    $params_search = $_REQUEST['search'];
    $seo_url = ''; $hasOnlySuburb = true;
    if(is_array($params_search) && count($params_search) > 0){
        foreach($params_search as $key => $val){
            if( !empty($val) || $val > 0 ){
                if($key != 'suburb' && $key != 'country'){
                //$seo_url .= ''.$key.'-'.trim(strtolower($val)).'/';
                    $hasOnlySuburb = false;
                }
            }
        }
        $region = $params_search['suburb'];
        if(!empty($region) && $hasOnlySuburb){
            header("Location: ".ROOTURL.'/property-for-sale-'.trim(strtolower($region)).'/'.$seo_url);
            die();
        }

    }
}
?>