<?php
include_once ROOTPATH.'/modules/report/inc/page_log.class.php';
include_once ROOTPATH.'/modules/report/inc/page_log_time.class.php';
include_once ROOTPATH.'/modules/report/inc/property_log.class.php';
include_once ROOTPATH.'/modules/report/inc/banner_log.class.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';

Menu_incView(@$_SERVER['REDIRECT_URL']);
// Var
$page_collection = array('home' => 'Home Page' ,
    'property_view-search-advance' => 'Search Advance Page',
    'property_search-auction' => 'Search Advance Auction Page',
    'property_search-sale' => 'Search Advance Sale Page',
    'property_search-partner' => 'Search Advance Partner Page',
    'property_view-search' => 'View Search Advance Page',
    'property_view-auction-list' => 'View Auction List Page',
    'property_view-sale-list' => 'View Sale List Page',
    'property_view-passedin-list' => 'View Passed In List Page',
    'property_view-tv-show' => 'View The Block List Page',
    'property_view-auction-detail' => 'View Auction Detail Page',
    'property_view-sale-detail' => 'View Sale Detail Page',
    'property_view-forthcoming-detail' => 'View Forthcoming Detail Page',
    'agent_register-vendor' => 'Register Vendor Page',
    'agent_register-buyer' => 'Register Buyer Page',
    'agent_register-partner' => 'Register Partner Page',
    'agent_view-property-vendor' => 'Edit Existing Property',
    'agent_view-property-buyer' => 'List Property',
    'agent_view-auction' => 'Manage Auction Terms',
    'agent_view-auction-vendor' => 'Manage Auction Terms',
    'agent_edit-notification' => 'Notification Page',
    'agent_list-partner' => 'List Partner Page',
    'agent_add-info' => 'Add information');

if (!isset($page_log_cls) || !($page_log_cls instanceof Page_Log)) {
	$page_log_cls = new Page_Log();
}

if (!isset($page_log_time_cls) || !($page_log_time_cls instanceof Page_Log_Time)) {
	$page_log_time_cls = new Page_Log_Time();
}

if (!isset($property_log_cls) || !($property_log_cls instanceof Property_Log)) {
	$property_log_cls = new Property_Log();
}

if (!isset($banner_log_cls) || !($banner_log_cls instanceof Banner_Log)) {
	$banner_log_cls = new Banner_Log();
}

if (!isset($cms_cls) or !($cms_cls instanceof Cms)) {
	$cms_cls = new Cms();
}
/**
Report Page
**/
function Report_pageAdd($key) {
	global $page_log_cls, $page_log_time_cls, $page_collection,$menu_cls;

    $uri = $_SERVER["REQUEST_URI"];
    if(strlen($uri) > 0 )
    {
        $uri_ar = explode("/",$uri);
        $uri_ar = array_filter($uri_ar,'strlen');
        $uri = implode('/',$uri_ar);
        $uri_ar = explode('.html',$uri);
        $uri = $uri_ar[0].'.html';
        if($uri == '.html'){
            $uri = 'home';
        }
        $menu_row = $menu_cls->getCRow(array('menu_id','title','url','views')," url LIKE '%".addslashes($uri)."%'");
        if(count($menu_row)> 0 and is_array($menu_row))
        {
            //print_r_pre($menu_row);
            $menu_cls->update(array('views' => (int)$menu_row['views']+ 1),'menu_id = '.$menu_row['menu_id']);
        }
    }

    if (isset($page_collection[$key])) {
        $title = $page_collection[$key];
		$_row = $page_log_cls->getRow("SELECT page_log_id FROM ".$page_log_cls->getTable()." WHERE `key` = '".$key."'", true);

		if (!is_array($_row) || count($_row) == 0) {
			$page_log_cls->insert(array('key' => $key, 'title' => $title));
			$_id = $page_log_cls->insertId();

		} else {
			$_id = $_row['page_log_id'];
		}

		if ($_id > 0) {
			$time = date('Y-m-d');
			$wh_str = 'page_log_id = '.$_id." AND create_at = '".$time."'";
			$_row = $page_log_time_cls->getRow('SELECT view FROM '.$page_log_time_cls->getTable().' WHERE '.$wh_str, true);
			if (is_array($_row) && count($_row) > 0) {
				$_row['view'] = array('fnc' => 'view+1');
				$page_log_time_cls->update($_row,$wh_str);
			} else {
				$page_log_time_cls->insert(array('create_at' => $time, 'view' => 1,'page_log_id'=>$_id));
			}
		}
    }
}

function Report_pageRemove($key) {
    global $page_log_cls, $page_log_time_cls, $page_collection;
    if (isset($page_collection[$key])) {
        $title = $page_collection[$key];
        $_id = 0;
        $_row = $page_log_cls->getRow("SELECT page_log_id FROM ".$page_log_cls->getTable()." WHERE `key` = '".$key."'", true);
        if (!is_array($_row) || count($_row) == 0) {
             // not found
        } else {
            $_id = $_row['page_log_id'];
            $page_log_cls->delete('page_log_id='.$_id);
            if($page_log_cls->hasError())
            {

            }
        }
        if ($_id > 0) {
            $page_log_time_cls->delete('page_log_id = ' .$_id);
            if($page_log_time_cls->hasError()){

            }
        }

    }
}


/**
Report Property
**/
function Report_propertyAdd($property_id = 0) {
	global $property_log_cls;
	if ($property_id > 0) {
		$time = date('Y-m-d');
		$wh_str = 'property_id = '.(int)$property_id." AND created_at = '".$time."'";
		$row = $property_log_cls->getRow('SELECT view FROM '.$property_log_cls->getTable().' WHERE '.$wh_str, true);
		if (is_array($row) && count($row) > 0) {
			$property_log_cls->update(array('view' => (int)$row['view']+1),$wh_str);
		} else {
			$property_log_cls->insert(array('property_id' => $property_id,'created_at' => $time,'view' => 1));
		}
	}
}

/**
Report Banner Add
**/
include_once ROOTPATH.'/modules/banner/inc/banner.php';

function Report_bannerAdd($banner_id = 0, $type = '',$is_redirect = true) {
	global $banner_log_cls, $banner_cls;
	if ($banner_id > 0) {
		$time = date('Y-m-d');
		$data = array();
		$wh_str = 'banner_id = '.(int)$banner_id." AND created_at = '".$time."'";
		switch ($type) {
			case 'click':
				$data['click'] = array('fnc' => 'click+1');	
			break;
			case 'view':
				$data['view'] = array('fnc' => 'view+1');
			break;
			
			
		}
		$row = $banner_log_cls->getRow('SELECT banner_log_id FROM '.$banner_log_cls->getTable().' WHERE '.$wh_str, true);
		if (count($data) > 0) {
			if (is_array($row) && count($row) > 0) {
				$banner_log_cls->update($data,$wh_str);
				$rows = $banner_cls->getRow('banner_id = '.(int)$banner_id);
				if (count($rows) > 0) {
                    if($is_redirect){
                        redirect($rows['url']);
                    }
				}
			} else {
				$data = array('banner_id' => $banner_id, 'created_at' => $time, $type => 1);
				$banner_log_cls->insert($data);
				$rows = $banner_cls->getRow('banner_id = '.$banner_id);
				if (count($rows) > 0) {
                    if($is_redirect){
                        redirect($rows['url']);
                    }
				}
			}
		}
	}
}

/**
Report Banner Get
**/
function Report_bannerInfo($banner_id = 0, $type = '') {
	global $banner_log_cls;
	$rs = 0;
	if ($banner_id > 0) {
		if (in_array($type,array('click','view'))) {
			$row = $banner_log_cls->getRow('SELECT SUM('.$type.') AS num FROM '.$banner_log_cls->getTable()." WHERE banner_id = ".$banner_id,true);
			if (is_array($row) && count($row) > 0) {
				return $row['num'];
			}
		}
	}
	return $rs;
}


function Report_bannerOptions() {
	global $banner_log_cls;
	$rs = array();
	$row = $banner_log_cls->getRow('SELECT MIN(YEAR(created_at)) AS y_min, MAX(YEAR(created_at)) AS y_max
						FROM '.$banner_log_cls->getTable().'
						LIMIT 1',true);
					
	if (is_array($row) && count($row) > 0 && (int)$row['y_min'] > 0) {
		if ($row['y_min'] == $row['y_max']) {
			$rs[$row['y_min']] = $row['y_min'];
		} else {
			for ($i = $row['y_min']; $i <= $row['y_max']; $i++) {
				$rs[$i] = $i;
			}
		}
	} else {
		$rs[date('Y')] = date('Y');
	}					
	
	return $rs;
}
/**
Report parse url
**/
function Report_parseUrl() {
	global $page_collection,$cms_cls, $menu_cls;
	$key = '';

    if (strlen($_SERVER['QUERY_STRING']) > 0) {
		parse_str($_SERVER['QUERY_STRING'], $output);

		if ($output['module'] == 'cms') {
            if(isset($output['menu']) AND isset($output['page']))
            {
                $row = $cms_cls->getRow('SELECT cms.page_id, menu.title, cms.title_frontend FROM '.$cms_cls->getTable().' AS cms
                                 LEFT JOIN '.$menu_cls->getTable()." AS menu
                                 ON menu.menu_id = cms.parent_id
                                 WHERE menu.alias = '".restrictArgs($output['menu'],'[^0-9a-zA-Z\-]')."' AND cms.alias_title = '".restrictArgs($output['page'],'[^0-9a-zA-Z\-]')."'",true);
                if (is_array($row) && count($row) > 0) {
                    $key = $output['module'].'_'.$row['page_id'];
                    $page_collection[$key] = $row['title'].' » '.$row['title_frontend'];
                }
            }
		}
		else {
			$output['module'] = restrictArgs(@$output['module'],'[^0-9a-zA-Z-_]');
			$output['action'] = restrictArgs(@$output['action'],'[^0-9a-zA-Z-_]');
            $row = $cms_cls->getRow('SELECT title_frontend FROM '.$cms_cls->getTable()." WHERE action = '%".$output['action']."%' OR action = '".$output['module']."%'", true);
			$key = $output['module'].'_'.$output['action'];
			if (!isset($page_collection[$key])){
                if (is_array($row) and count($row) > 0){
                    $page_collection[$key] = $row['title_frontend'];
                }else{
                    $page_collection[$key] = strtoupper($output['module']).' >> '.$output['action'];
                }                
            }
		}
	} else {
		$key = 'home';
	}
	
	return $key;
}


/**
Report parse url for porperty
**/
function Report_parseUrl4Property() {
	if (strlen($_SERVER['QUERY_STRING']) > 0) {
		parse_str($_SERVER['QUERY_STRING'], $output);
		if ($output['module'] == 'property' && in_array($output['action'],array('view-sale-detail','view-auction-detail','view-forthcoming-detail')) && $output['id'] > 0) {
			return $output['id'];
		}
	}
	return 0;
}

function Report_optionsTime($schedule) {
	global $property_cls;
	$year = date('Y');
	$month = date('m');
	
	$option_month_str = '<option value="">All</option>';
	for ($i = $year; $i <= date('Y'); $i++) {
		for ($j = 1; $j <= 12; $j++ ) {
			$_j = substr('00'.$j,-2);
			$selected = ($i.'-'.$_j)==($schedule) ? 'selected' : '';
			$option_month_str .= '<option value="'.$i.'-'.$_j.'" '.$selected.'>'.$i.'-'.$_j.'</option>';
		}
	}
	return $option_month_str;
	//END
}

//drop down list for popup
function Report_optionsYear($year,$agent_id){
    global $property_cls;
    //get Agent
    $rows = $property_cls->getRows('SELECT creation_date FROM '.$property_cls->getTable().' WHERE agent_id ='.$agent_id.' GROUP BY DATE_FORMAT(creation_date,\'%Y\')', true);

    $option_year = '<option value="">All</option>';
    if (is_array($rows) && count($rows)>0){
        foreach ($rows as $row){
            $dt = new DateTime($row['creation_date']);
            if (strlen($row['creation_date']) != 0){
                $_year = substr($row['creation_date'],0,4);
                $selected = ($_year == $year)? 'selected': '';
                $option_year .= '<option value="'.$_year.'" '.$selected.' >'.$_year.'</option>';
            }            
        }
    }
    return $option_year;
}


function toMonth($month){
    if ($month < 10) return '0'.$month;
    return $month;
}


function Report_optionsMonthForBid($id,$year,$schedule){
    global $bid_cls,$property_log_cls;
    $option_month_str = '<option value="'.$year.'">All</option>';
    $rows_bid = $bid_cls->getRows("SELECT bid.time
                              FROM ".$bid_cls->getTable()." AS bid
                              WHERE bid.property_id = ".intval($id)
                              . " AND DATE_FORMAT(bid.time,'%Y') = '".$year."' GROUP BY DATE_FORMAT( bid.time, '%Y-%m' )",true);
    $rows_view = $property_log_cls->getRows('SELECT pro_log.created_at
							FROM '.$property_log_cls->getTable()." AS pro_log
							WHERE pro_log.property_id = ".$id
                            ." AND DATE_FORMAT(pro_log.created_at,'%Y') = '".$year."' GROUP BY DATE_FORMAT( pro_log.created_at, '%Y-%m' )",true);
    $row_month = array();
    foreach ($rows_bid as $row){
        $dt = new DateTime($row['time']);
        $row_month[] = $dt->format('m');
    }
    foreach ($rows_view as $row){
        $dt = new DateTime($row['created_at']);
        $row_month[] = $dt->format('m');
    }
    //for($i = 1;$i<=12;$i++) {$month[$i] = 0;}
    $month = array();
    foreach($row_month as $row){
        $month[(int)$row]++;
    }
    for ($i = 1;$i<=12;$i++){
        if ($month[$i] > 0) {
        $selected = ($year.'-'.toMonth($i)) == ($schedule) ?'selected':'';
        $option_month_str .= '<option value="'.$year.'-'.toMonth($i).'" '.$selected.'>'.$year.'-'.toMonth($i).'</option>';
        }
    }
    return $option_month_str;

}

function Report_optionsMonthForView($id,$year,$schedule){
    global $property_log_cls;
    $option_month_str = '<option value="'.$year.'">All</option>';
    $rows = $property_log_cls->getRows('SELECT pro_log.created_at
							FROM '.$property_log_cls->getTable()." AS pro_log
							WHERE pro_log.property_id = ".$id
                            ." AND DATE_FORMAT(pro_log.created_at,'%Y') = '".$year."' GROUP BY DATE_FORMAT( pro_log.created_at, '%Y-%m' )",true);

    foreach ($rows as $row){
        $dt = new DateTime($row['created_at']);
        $month = $dt->format('m');
        $selected = ($year.'-'.$month) == ($schedule) ?'selected':'';
        $option_month_str .= '<option value="'.$year.'-'.$month.'" '.$selected.'>'.$year.'-'.$month.'</option>';
    }
    return $option_month_str;

}

//end
//action_collection

	
//$config_cls->getKey('general_date_format')	
function beginWeek($format) {
	global $config_cls;
	$cur_month = date('m');
	
	$mktime = mktime(0, 0, 0, date('m'), date('d') - date('w'), date('Y'));
	$begin_week = date($format, $mktime);
	
	if (date('m',$mktime) != $cur_month) {
		$begin_week = date($format, mktime(0, 0, 0, date('m'), 1, date('Y')));
	}
	return $begin_week;
}

function endWeek($format) {
	global $config_cls;
	$cur_month = date('m');
	
	$mktime = mktime(0, 0, 0, date('m'), date('d') + 6 - date('w'), date('Y'));
	
	$end_week = date($format, mktime(0, 0, 0, date('m'), date('d') + 6 - date('w'), date('Y')));
	if (date('m',$mktime) != $cur_month) {
		$end_week = date($format, mktime(0, 0, 0, date('m')+1, 0, date('Y')));
	}
	return $end_week;
}

function beginMonth($format) {
	global $config_cls;
	$begin_month = date($format, mktime(0, 0, 0, date('m'), 1, date('Y')));
	return $begin_month;
}

function endMonth($format) {
	global $config_cls;
	$end_month = date($format, mktime(0, 0, 0, date('m')+1, 0, date('Y')));
	return $end_month;
}	

/*
$ymd ~ Y-m-d or Y-m
*/
function firstDayOfMonth($ymd) {
	return 1;
}

/*
$ymd ~ Y-m-d or Y-m
*/

function lastDayOfMonth($ymd) {
	$dt = new DateTime($ymd);
	$y = $dt->format('Y');
	
	switch ($dt->format('m')) {
		case '1':
		case '3':
		case '5':
		case '7':
		case '8':
		case '10':
		case '12':
			return 31;
		break;
		case '2':
			if ($y % 4 !=0 || $y % 400 != 0) {
				return 29;
			} else {
				return 28;
			}
		break;
		default:
			return 30;
		break;
	}
}

function R_reportCountry(){
    include_once ROOTPATH.'/modules/general/inc/regions.php';
    $option_country_ar = R_getOptions(0);
    $option_country_str = '';
    if (is_array($option_country_ar) & count($option_country_ar) > 0) {
        foreach ($option_country_ar as $key=>$val) {
            $selected = $key==COUNTRY_DEFAULT? 'selected' : '';
            $option_country_str .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
        }
    }
    return $option_country_str;
}

function R_reportState(){
    include_once ROOTPATH.'/modules/general/inc/regions.php';
    $selected  = '';
    $option_state_ar = R_getOptions(1);
    $option_state_str = '';
    if (is_array($option_state_ar) & count($option_state_ar) > 0) {
        foreach ($option_state_ar as $key=>$val) {
            $option_state_str .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
        }
	}
	return $option_state_str;
}
?>