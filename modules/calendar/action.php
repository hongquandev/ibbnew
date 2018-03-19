<?php
session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/modules/configuration/inc/config.class.php';
include 'inc/calendar.php';
include_once ROOTPATH.'/modules/general/inc/ics.class.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
if (!isset($property_cls) || !($property_cls instanceof Property)) {
    $property_cls = new Property();
}

if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}
define('SITE_TITLE',$config_cls->getKey('site_title'));
$smarty->assign('site_title_config',$config_cls->getKey('site_title'));

if (!isset($ics_cls) || !($ics_cls instanceof ICS)) {
	$ics_cls = new ICS();
}

if (!isset($notification_cls) || !($notification_cls instanceof Notification)) {
	$notification_cls = new Notification();
}


//BEGIN SMARTY
include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
$smarty = new Smarty; 
if(detectBrowserMobile()){ 
    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
}else{
    $smarty->compile_dir = ROOTPATH.'/templates_c/';
}
$smarty->assign('ROOTURL', ROOTURL);
//END

$action = getParam('action');

switch ($action) {
    case 'notify-time':
        $property_id = restrictArgs(getParam('property_id',0));
        $notify = getParam('notify_inspect_time',0);
        $data = array('notify_inspect_time' => $notify);
        if($property_id > 0 )
        {
            $property_cls->update($data,'property_id = '.$property_id);
            if($property_cls->hasError()){
                $message['result'] = false;
                $message['msg'] = $property_cls->getError();
            }else{
                $message['result'] = true;
                $message['msg']  = 'Updated Successfully.';
            }
        }
        else{
            $data = array();
            $temp = Calendar_createTemp();
            $data['temp_id'] =  $temp;
            $data['notify_value'] = $notify;
            $row = $notification_cls->getRow("temp_id = '$temp'");
            if(count($row) > 0 and is_array($row)){
                $notification_cls->update($data,"temp_id='$temp'");
            }
            else{
                $notification_cls->insert($data);
                if($notification_cls->hasError())
                {
                    $message['result'] = false;
                    $message['msg'] = $property_cls->getError();
                }
                else{
                    $message['result'] = true;
                    $message['msg']  = 'Updated Successfully.';
                }
            }
            
        }
        die(json_encode($message));
    break;
    case 'load-calendar':
        $property_id = restrictArgs(getParam('property_id',0));
        $smarty->assign('property_id',$property_id);
        if($property_id > 0)
        {
            $row = $property_cls->getRow('property_id = '.$property_id);
            if(count($row) > 0 and is_array($row))
            {
                $notify = array('inspect_time' => $row['notify_inspect_time']);
                $smarty->assign('notify',$notify);
            }
        }
        else
        {
            $temp = Calendar_createTemp();
            $row = $notification_cls->getRow("temp_id = '$temp'");
            if(count($row) > 0 and is_array($row)){
                $notify = array('inspect_time' => $row['notify_value']);
                $smarty->assign('notify',$notify);
            }
        }

        $result['data'] = $smarty->fetch(ROOTPATH.'/modules/calendar/templates/calendar.form.tpl');
        die(($result['data']));
	case 'save-calendar':
		$property_id = restrictArgs(getParam('property_id',0));
		$calendar_id = restrictArgs(getParam('calendar_id',0));
		$begin = getParam('begin');
		$end = getParam('end');
		
		$result = array();
		$error = false;
		$msg = '';
		
		$temp = Calendar_createTemp();

		if (!isValidDateTime($begin) || !isValidDateTime($end)) {
			$error = true;
		}

        // Max end time
        $is_max_end_time = 0;
        $rows = $calendar_cls->getRows('property_id = '.$property_id);
        if(count($rows) > 0 and is_array($rows))
        {
            $temp_ar = array('0000-00-00 00:00:00');
            foreach($rows as $key => $row )
            {
                if($row['calendar_id'] != $calendar_id)
                $temp_ar[$row['end']] = $row['end'];
            }
            $max_end_time = max($temp_ar);
            if($end >= $max_end_time)
            {
                $is_max_end_time = 1;
                $calendar_cls->update(array('is_max_end_time' => 0),'property_id = '.$property_id);
            }
            else
            {
                $is_max_end_time = 0 ;
            }
        }
        else
        {
            $is_max_end_time = 1;
        }
        // End
        $data_ar = array('begin' => $begin,
                         'end' => $end,
                         'property_id' => $property_id,
                         'temp' => $temp,
                         'is_max_end_time' => $is_max_end_time,
                         'change_time' => date('Y-m-d H:i:s'));
        if($is_max_end_time == 1 AND $end > date('Y-m-d H:i:s') )
        {
            $data_ar['daily_scan'] = 0;
            $data_ar['allow_weekly'] = 0;
        }
		if (!$error) {
			if ($calendar_id > 0) {//edit
				$calendar_cls->update($data_ar,'calendar_id = '.$calendar_id);
			} else {//add
				$calendar_cls->insert($data_ar);
			}
		}
		
		$smarty->assign('rows',Calendar_getList($property_id,$temp));
		$result['data'] = $smarty->fetch(ROOTPATH.'/modules/calendar/templates/calendar.form.grid.tpl');
		//print_r($result['data']);
		die($result['data']);
	break;
	case 'list-calendar':
		$property_id = restrictArgs(getParam('property_id',0));
        $temp = Calendar_createTemp();
		$smarty->assign('rows',Calendar_getList($property_id,$temp));
		$result['data'] = $smarty->fetch(ROOTPATH.'/modules/calendar/templates/calendar.form.grid.tpl');
		die($result['data']);
	break;
	
	case 'delete-calendar':
		$calendar_id = restrictArgs(getParam('calendar_id',0));
		$property_id = 0;
		
		$result = array('data' => '');
		if ($calendar_id > 0) {
			$row = $calendar_cls->getRow('calendar_id = '.$calendar_id);
			if (is_array($row) && count($row) > 0) {
				$property_id = $row['property_id'];
			}
			$calendar_cls->delete('calendar_id = '.$calendar_id);
		}
		
		if ($property_id > 0) {
			$smarty->assign('rows',Calendar_getList($property_id));

		}else{
            $temp = Calendar_createTemp();
            $smarty->assign('rows',Calendar_getList($property_id,$temp));
        }
        $result['data'] = $smarty->fetch(ROOTPATH.'/modules/calendar/templates/calendar.form.grid.tpl');
		die($result['data']);
	break;
	
	case 'edit-calendar':
		$calendar_id = restrictArgs(getParam('calendar_id',0));
		$result = array();
		if ($calendar_id > 0) {
			$row = $calendar_cls->getRow('calendar_id = '.$calendar_id);
			if (is_array($row) && count($row) > 0) {
				$result['data'] = $row;
			}
		}
		die(_response($result));
	break;
	/*
	case 'export-calendar':
		$calendar_id = restrictArgs(getParam('calendar_id',0));
		if ($calendar_id > 0) {
			$row = $calendar_cls->getRow('calendar_id = '.$calendar_id);
			if (is_array($row) && count($row) > 0) {
			
				header('Content-Type: text/calendar; charset=utf-8');
				header('Content-Description: File Transfer');
				header('Content-Disposition: attachment; filename='.basename($row['file_name']));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');

				
				header('Content-Disposition: attachment; filename="'.$row['calendar_id'].'_calendar.ics"; ');				
				ob_clean();
				flush();
				$data = array('dtstart' => preg_replace('/[-:]/','',str_replace(' ','T',$row['begin'])).'Z',
							'dtend' => preg_replace('/[-:]/','',str_replace(' ','T',$row['end'])).'Z',
							'title' => $config_cls->getKey('calendar_description'),
							'description' => $config_cls->getKey('calendar_summary'),
							'location' => $config_cls->getKey('calendar_location'));
				echo $ics_cls->getLayout($data);
				exit();
			}
		}
	break;
	*/
}

?>