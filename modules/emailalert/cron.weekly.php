<?php

include_once ROOTPATH . '/modules/emailalert/inc/emailalert.php';
$key = 'Weekly';
$schedule_ar = EA_getSchedule();
$cron = $email_cls->getRows('schedule = ' . $schedule_ar[$key] . ' AND allows = 1 ');
if (is_array($cron) and count($cron) > 0) {
    foreach ($cron as $row) {
        if (EA_reSearch($row, $message, $row['agent_id'], $schedule_ar[$key])) {
        }
        $email_cls->update(array('content' => addslashes($row['content']),
                'last_cron' => date('Y-m-d H:i:s')
            ),
            'email_id =' . $row['email_id']);
    }
} else {
}

?>