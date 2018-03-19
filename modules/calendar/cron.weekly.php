<?php
include_once ROOTPATH.'/modules/calendar/inc/calendar.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
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
    $rows = $calendar_cls->getRows('allow_weekly = 1');
    if(count($rows) > 0 and is_array($rows))
    {
        foreach($rows as $key => $row)
        {
            $pro_row = $property_cls->getCRow(array('notify_inspect_time'),'property_id = '.$row['property_id']);
            if(count($pro_row) > 0 AND is_array($pro_row))
            {
                if($pro_row['notify_inspect_time'] == 1)
                {
                    if($row['end'] < $now)
                    {
                        $mail = sendMailNotifyInspectTime($row);
                        if($mail)
                        {
                            $calendar_cls->update(array('last_time_weekly' => $now), 'calendar_id = '.$row['calendar_id']);
                        }
                    }
                }
            }

        }
    }
    else{

    }
