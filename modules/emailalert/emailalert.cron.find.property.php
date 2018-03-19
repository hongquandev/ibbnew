<?php
/*
	Author  : StevenDuc
	Skype   : stevenduc21
	Company : Global OutSource Solution
 
*/
	//Include File Init();
	include_once '../../configs/config.inc.php';
	include_once '../../includes/functions.php';
	include_once ROOTPATH.'/modules/emailalert/inc/emailalert.php';



	$arr_sch = EA_getSchedule();

    $date = array('Daily'=>1,'Weekly'=>7,'Monthly'=>30);
    foreach ($date as $key=>$_d){
        $wh_ar[] = " IF(schedule = '.$arr_sch($key).' AND DATEDIFF('".date('Y-m-d H:i:s')."', last_cron) > ".$_d.",1,0) = 1";
    }
    if (count($wh_ar)> 0){
        $wh_str = implode($wh_ar,' OR ');
    }
    $cron = $email_cls->getRow($wh_str);
    if (is_array($cron) and count($cron) > 0){
        foreach ($cron as $row){
            if (EA_reSearch($row,$message,$row['agent_id'])){
              $email_alert->update(array('content'=>$row['content'],'last_cron'=>date('Y-m-d H:i:s')),'email_id ='.$row['email_id']);
            }
        }
    }

	
?>