<?php
ini_set('display_errors', 0);
include_once ROOTPATH . '/modules/calendar/inc/calendar.php';
if (!isset($calendar_cls) || !($calendar_cls instanceof Calendar)) {
    $calendar_cls = new Calendar();
}
if (!isset($property_cls) || !($property_cls instanceof Property)) {
    $property_cls = new Property();
}

if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
$now = date('Y-m-d H:i:s');
$rows = $calendar_cls->getRows('is_max_end_time = 1 AND daily_scan = 0 AND allow_weekly = 0 ');
if (count($rows) > 0 and is_array($rows)) {
    foreach ($rows as $key => $row) {
        if ($row['end'] < $now) {
            $mail = sendMailNotifyInspectTime($row);
            if ($mail) {
                $calendar_cls->update(array('daily_scan' => 1, 'last_time_daily' => $now, 'allow_weekly' => 1), 'calendar_id = ' . $row['calendar_id']);
            }

        }
        $calendar_cls->update(array('last_time_daily' => $now), 'calendar_id = ' . $row['calendar_id']);
    }
} else {

}
