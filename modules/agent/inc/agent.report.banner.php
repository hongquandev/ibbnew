<?php

include_once ROOTPATH.'/modules/report/inc/report.php';
include_once ROOTPATH.'/modules/general/inc/bids.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';

if(!isPost()){
    $banner_id = getParam('id', 0);
    //BEGIN DETAIL BANNER
    $auction_sale_ar = PEO_getAuctionSale();
    $sql = 'SELECT SQL_CALC_FOUND_ROWS a.*, b.*, sum(c.click) as click
            FROM '.$banner_cls->getTable().' AS a
            LEFT JOIN '.$banner_cls->getTable('banner_log').' AS c ON a.banner_id = c.banner_id
            LEFT JOIN '.$region_cls->getTable().' as b ON a.state = b.region_id
            WHERE a.banner_id = '.$banner_id.'
            ';
    $row = $banner_cls->getRow($sql,true);
    $result = array();
    $type_ar = array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial');
    if (is_array($row) and count($row) > 0) {
        $dt = new DateTime($row['creation_time']);
        $dt2 = new DateTime($row['date_from']);
        $dt3 = new DateTime($row['date_to']);
        $row['creation_time']= $dt->format($config_cls->getKey('general_date_format'));
        $row['date_from'] = $dt2->format($config_cls->getKey('general_date_format'));
        $row['date_to'] = $dt3->format($config_cls->getKey('general_date_format'));
        $row['type'] = $type_ar[$row['type']];
        $row['banner_file'] = str_replace('%20', '%2520', $row['banner_file']);
        $row['description'] = strlen($row['description']) > 100 ? safecontent($row['description'], 100). '...' : $row['description'];
        $page_ar = Menu_getTitleArById(explode(',', $row['page_id']));
        $row['page_list'] = is_array($page_ar) && count($page_ar) > 0 ? $page_ar : array(0 => 'None');
        $result['info'] = $row;
    }
    $smarty->assign(array('banner' => $result,'banner_id' => $banner_id));
    // END DETAIL BANNER
}

// BEGIN REPORT BANNER
    $id = restrictArgs(getParam('id',0));
		if ($id > 0) {
            $form_action = '/?module=agent&action=view-report-banner-detail&id='.$id;
            $data = array();$wh_str = '';
            $type = array('clicks' => 'Click(s)', 'views'=>'View(s)');
            $filter_year = getParam('year','');
            $filter_month = getParam('month','');
            $report_type = getParam('type','monthly');
            $format_key  = 'Y';
            switch ($report_type){
                case 'monthly':
                    $filter_month = '';
                    if($filter_year == ''){$filter_year = date('Y');}
                    $wh_str = "AND DATE_FORMAT(b.created_at,'%Y') = '".$filter_year."' GROUP BY DATE_FORMAT(b.created_at,'%Y-%m') ASC";
                    $group = "DATE_FORMAT(b.created_at,'%m') as time ";
                    $format_key  = 'm';
                    $select_click = 'SUM(b.click)';
                    $select_view = 'SUM(b.view)';
                    break;
                case 'yearly':
                    $filter_month = '';
                    $select_click = 'SUM(b.click)';
                    $select_view = 'SUM(b.view)';
                    $wh_str = "GROUP BY DATE_FORMAT(b.created_at,'%Y') ASC";
                    if($filter_year != '')
                    {
                        //$wh_str = "AND DATE_FORMAT(b.created_at,'%Y') = '".$filter_year."' GROUP BY DATE_FORMAT(b.created_at,'%Y') ASC";
                    }
                    $group = "DATE_FORMAT(b.created_at,'%Y') as time ";
                    $format_key  = 'Y';
                    break;
                case 'daily':
                    $select_click = 'b.click';
                    $select_view = ' b.view';
                    if($filter_year == ''){
                        $filter_year = date('Y');
                    }
                    $filter_month = getParam('month',date('m'));
                    if(strlen($filter_month) < 2){
                        $filter_month = '0'.$filter_month;
                    }
                    $wh_str = "  AND DATE_FORMAT(b.created_at,'%Y') = '".$filter_year."' AND DATE_FORMAT(b.created_at,'%m') = '".$filter_month."' ";
                    $group = "   DATE_FORMAT(b.created_at,'%d') as time ";
                    $format_key  = 'd';
                    break;
            }
            // REPORT
                $rows = $banner_cls->getRows('SELECT '.$select_click.' as clicks, '.$select_view.' as views,'.$group.'
                                                FROM '.$banner_log_cls->getTable().' AS b
                                                WHERE b.banner_id = '.$id.'
											    '.$wh_str
                    .' ORDER BY b.created_at DESC'
                    ,true);
                //print_r($banner_cls->sql);
                //print_r_pre($rows);
                if(is_array($rows) and count($rows) > 0)
                {
                    foreach($rows as $key_ => $row)
                    {
                        //$time = new DateTime($row['time']);
                        //$month = (int)$time->format($format_key);
                        $time = (int)$row['time'];
                        if(!isset($data['clicks'][$time])){
                            $data['clicks'][$time] = 0;
                        }
                        $data['clicks'][$time] = (int)$data['clicks'][$time] + (int)$row['clicks'];
                        if(!isset($data['views'][$time])){
                            $data['views'][$time] = 0;
                        }
                        $data['views'][$time] = (int)$data['views'][$time] + (int)$row['views'];
                    }
                }
            $data_report = array();
            $loop_start = 0;
            $loop_end = 0;
            $day_str = '';
            switch ($report_type){
                case 'monthly':
                    $loop_start = 1;
                    $loop_end = 12;
                    break;
                case 'yearly':
                    $options_year = Banner_options_year($id);
                    $loop_start = reset($options_year);
                    $loop_end = end($options_year);
                    break;
                case 'daily':
                    $loop_start = 1;
                    $loop_end = 30;
                    break;
            }
            for($i = $loop_start ; $i<= $loop_end ; $i++){
                if(!isset($data['clicks'][$i])){
                    $data_report['clicks'][$i] = 0 ;
                }else{
                    $data_report['clicks'][$i] = $data['clicks'][$i];
                }
                if(!isset($data['views'][$i])){
                    $data_report['views'][$i] = 0 ;
                }else{
                    $data_report['views'][$i] = $data['views'][$i];
                }
                $day_str .= '<th scope="col">'.$i.'</th>';
            }

            $smarty->assign('day_str',$day_str);
            $smarty->assign('data',$data_report);
            $smarty->assign('type',$type);
            $filter_month = ($filter_month != '')? ' - '.$filter_month:'';
            $title = ucfirst($report_type). ' Report : '.$filter_year.' '.$filter_month;
            $smarty->assign('title_chart',$title);
            if(isPost())
            {
                //die(json_encode($data_report));
                $html =  $smarty->fetch(ROOTPATH.'/modules/agent/templates/agent.report.banner.chart.tpl');
                $result = array('html' => $html);
                die(json_encode($result));
            }else{
                $smarty->assign('action',getParam('action'));
                $smarty->assign('options_year_banner_def',date('Y'));
                $smarty->assign('options_year_banner',Banner_options_year($id));
                $smarty->assign('options_month_banner',Banner_options_month($id));
                $smarty->assign('options_type_def','monthly');
                $smarty->assign('options_type',array('yearly' => ' Yearly','monthly' => 'Monthly' , 'daily' => 'Daily'));
            }


        }
//END REPORT BANNER
function Banner_options_year($id){
    global $banner_cls,$banner_log_cls;
    $data = array();
    $wh_str = "GROUP BY DATE_FORMAT(b.created_at,'%Y') ASC";
    $group = "DATE_FORMAT(b.created_at,'%Y') as year ";
    $rows = $banner_cls->getRows('SELECT '.$group.'
                                            FROM '.$banner_log_cls->getTable().' AS b
                                            WHERE 1
                                            AND b.banner_id = '.$id.'
                                            '.$wh_str
            .' ORDER BY b.created_at ASC'
        ,true);
    if(count($rows)> 0 and is_array($rows))
    {
        foreach($rows as $key => $row )
        {
            $data[$row['year']] = $row['year'];
        }
    }
    return $data;
}
function Banner_options_month($id){
    global $config_cls,$banner_cls,$banner_log_cls;
    $data = array();
    /*for($i = 1; $i <= 12 ; $i++){
        $data[$i] = date( 'F', mktime(0, 0, 0, $i) );
    }*/
    $wh_str = " GROUP BY DATE_FORMAT(b.created_at,'%Y-%m') ASC";
    $group = "DATE_FORMAT(b.created_at,'%m') as time ";
    $rows = $banner_cls->getRows('SELECT '.$group.'
                                            FROM '.$banner_log_cls->getTable().' AS b
                                            WHERE 1
                                            AND b.banner_id = '.$id.'
                                            '.$wh_str
            .' ORDER BY b.created_at ASC'
        ,true);
    if(count($rows)> 0 and is_array($rows))
    {
        foreach($rows as $key => $row )
        {
            $data[(int)$row['time']] = date( 'F', mktime(0, 0, 0, (int)$row['time']) );
        }
    }
    return $data;
}
?>