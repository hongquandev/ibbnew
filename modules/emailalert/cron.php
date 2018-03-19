<?php

/* include_once ROOTPATH.'/modules/emailalert/cron.emailalert.daily.php';*/

//$arr_sch = EA_getSchedule();
/* $date = array('Daily'=>1,'Weekly'=>7,'Monthly'=>30);
 foreach ($date as $key=>$_d){
     $wh_ar[] = " IF(schedule = ".$arr_sch[$key]." AND DATEDIFF('".date('Y-m-d H:i:s')."', last_cron) > ".$_d.",1,0) = 1";
 }
 if (count($wh_ar)> 0){
     $wh_str = implode($wh_ar,' OR ');
 }
 $cron = $email_cls->getRows($wh_str);*/

/* $schedule_cron = (int)$config_cls->getKey('notification_schedule_cron'); // Loop Cron with minute/hour
 $schedule_cron = isset($schedule_cron) ? $schedule_cron : 0 ;
 $schedule_sec = round($schedule_cron*60/2);
 $dt = new DateTime(date('Y-m-d H:i:s'));

 $begin_time = date("H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') - $schedule_sec));
 $end_time = date("H:i:s", mktime($dt->format('H'), $dt->format('i') , $dt->format('s') + $schedule_sec));*/

/*$schedule_ar =  EA_getSchedule();
$cron = $email_cls->getRows("abort = 0 AND allows = 1 ");
if (is_array($cron) and count($cron) > 0){
    foreach ($cron as $row){
        if (EA_reSearch($row,$message,$row['agent_id'],$schedule_ar['Daily'])){
            $email_cls->update(array('content'=>$row['content'],
                                     'last_cron'=>date('Y-m-d H:i:s')
                                    ),
                                     'email_id ='.$row['email_id']);

        }
    }
}*/

?>