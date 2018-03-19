<?php
include_once 'calendar.class.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
    $log_cls = new Email_log();
}
if (!isset($calendar_cls) || !($calendar_cls instanceof Calendar)) {
    $calendar_cls = new Calendar();
}
function Calendar_createTemp()
{
    $temp = '';
    if ($_SESSION['agent']['id'] > 0) {
        $temp = encrypt($_SESSION['agent']['id']);
    } else {
        $temp = encrypt($_SESSION['Admin']['ID']);
    }
    if (!isset($temp)) {
        $temp = encrypt('123456789');
    }
    return trim($temp);
}

function Calendar_update($property_id = 0, $temp = '')
{
    global $calendar_cls;
    if ($property_id > 0 && strlen($temp) > 0) {
        $calendar_cls->update(array('property_id' => $property_id, 'temp' => ''), "temp ='$temp'");
    }
}

function Calendar_deleteTempRows($temp = '')
{
    global $calendar_cls;
    if (strlen($temp) > 0) {
        $calendar_cls->delete("temp = '$temp'");
    }
}

function Calendar_getList($property_id = 0, $temp = '')
{
    global $calendar_cls, $config_cls;
    $rs = '';
    $wh_str = '';
    if ($property_id > 0) {
        $wh_str = 'property_id = ' . $property_id;
    } else if (strlen($temp) > 0) {
        $wh_str = "temp ='$temp'";
    }
    if (strlen($wh_str) == 0)
        return $rs;
    $rows = $calendar_cls->getRows($wh_str . ' ORDER BY begin ASC');
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $dt = new DateTime($row['begin']);
            $rows[$key]['begin_date'] = $dt->format($config_cls->getKey('general_date_format'));
            $rows[$key]['begin_time'] = $dt->format('H:i:s');
            $dt = new DateTime($row['end']);
            $rows[$key]['end_date'] = $dt->format($config_cls->getKey('general_date_format'));
            $rows[$key]['end_time'] = $dt->format('H:i:s');
        }
    }
    return $rows;
}

function Calendar_createPopup($property_id = 0, $open_for_inspection = false, $mode = 'list')
{
    global $calendar_cls, $config_cls, $smarty;
    $item_str = '';
    if ($property_id > 0 && $open_for_inspection == true) {
        $rows = $calendar_cls->getRows('property_id = ' . $property_id);
        if (is_array($rows) && count($rows) > 0) {
            $i = 0;
            foreach ($rows as $key => $row) {
                $i++;
                $dt = new DateTime($row['begin']);
                $rows[$key]['begin_date'] = $dt->format($config_cls->getKey('general_date_format'));
                $rows[$key]['begin_time'] = $dt->format('H:i:s');
                $dt = new DateTime($row['end']);
                $rows[$key]['end_date'] = $dt->format($config_cls->getKey('general_date_format'));
                $rows[$key]['end_time'] = $dt->format('H:i:s');
            }
            $smarty->assign('mode', $mode);
            $smarty->assign('ROOTURL', ROOTURL);
            $smarty->assign('action', getParam('action'));
            $smarty->assign('calendar_rows', $rows);
            $item_str = $smarty->fetch(ROOTPATH . '/modules/calendar/templates/calendar.view.grid.tpl');
        }
    }
    //Begin Contact Info
    $dataContact = array();
    $agent_vendor = PE_getAgent('', $property_id);
    $dataContact['agent_id_from'] = $_SESSION['agent']['id'];
    $dataContact['name'] = $_SESSION['agent']['firstname'] . ' ' . $_SESSION['agent']['lastname'];
    $dataContact['email'] = $_SESSION['agent']['email_address'];
    $dataContact['telephone'] = $_SESSION['agent']['telephone'];
    $dataContact['agent_id_to'] = $agent_vendor['agent_id'];
    $dataContact['email_to'] = $agent_vendor['email_address'];
    foreach ($dataContact as $key => $data) {
        $dataContact[$key] = str_replace("'", '', $data);
    }
    if (A_isLogin()) {
        $click = 'showContact(\'' . $dataContact['agent_id_from'] . '\',\'' . $dataContact['name'] . '\',\'' . $dataContact['email'] . '\',\'' . $dataContact['telephone'] . '\',\'' . $dataContact['agent_id_to'] . '\',\'' . $dataContact['email_to'] . '\',\'' . $property_id . '\')';
    } else {
        $click = 'showLoginPopup()';
    }
    $str = '<a href="javascript:void(0)" onclick= "' . $click . '">' . Localizer::translate("contact vendor") . '</a>';
    if ($open_for_inspection == true && strlen($item_str) > 0) {
        $smarty->assign('calendar_items', $item_str);
        $smarty->assign('note_time_id', $property_id);
        $str = '<a href="javascript:void(0)" onclick="showNoteTimePopup(\'note_time_' . $property_id . '\')">Yes</a>' . $smarty->fetch(ROOTPATH . '/modules/calendar/templates/calendar.popup.tpl');
    }
    return $str;
}

function Calendar_createButton($property_id = 0, $open_for_inspection = false, $mode = 'list')
{
    global $calendar_cls, $config_cls, $smarty;
    $item_str = '';
    if ($property_id > 0 && $open_for_inspection == true) {
        $rows = $calendar_cls->getRows('property_id = ' . $property_id);
        if (is_array($rows) && count($rows) > 0) {
            $i = 0;
            foreach ($rows as $key => $row) {
                $i++;
                $dt = new DateTime($row['begin']);
                $rows[$key]['begin_date'] = $dt->format($config_cls->getKey('general_date_format'));
                $rows[$key]['begin_time'] = $dt->format('H:i:s');
                $dt = new DateTime($row['end']);
                $rows[$key]['end_date'] = $dt->format($config_cls->getKey('general_date_format'));
                $rows[$key]['end_time'] = $dt->format('H:i:s');
            }
            $smarty->assign('mode', $mode);
            $smarty->assign('ROOTURL', ROOTURL);
            $smarty->assign('action', getParam('action'));
            $smarty->assign('calendar_rows', $rows);
            $item_str = $smarty->fetch(ROOTPATH . '/modules/calendar/templates/calendar.view.grid.tpl');
        }
    }
    //Begin Contact Info
    $dataContact = array();
    $agent_vendor = PE_getAgent('', $property_id);
    $dataContact['agent_id_from'] = $_SESSION['agent']['id'];
    $dataContact['name'] = $_SESSION['agent']['firstname'] . ' ' . $_SESSION['agent']['lastname'];
    $dataContact['email'] = $_SESSION['agent']['email_address'];
    $dataContact['telephone'] = $_SESSION['agent']['telephone'];
    $dataContact['agent_id_to'] = $agent_vendor['agent_id'];
    $dataContact['email_to'] = $agent_vendor['email_address'];
    foreach ($dataContact as $key => $data) {
        $dataContact[$key] = str_replace("'", '', $data);
    }
    if (A_isLogin()) {
        $click = 'showContact(\'' . $dataContact['agent_id_from'] . '\',\'' . $dataContact['name'] . '\',\'' . $dataContact['email'] . '\',\'' . $dataContact['telephone'] . '\',\'' . $dataContact['agent_id_to'] . '\',\'' . $dataContact['email_to'] . '\',\'' . $property_id . '\')';
    } else {
        $click = 'showLoginPopup()';
    }
    //$str = '<input type="button" class="btn-open-for-inspection f-left" onclick="'.$click.'" />';
    $str = '<button class="btn-pv1 btn-pv-inspect" title="Inspect" onclick="' . $click . '"></button>';
    if ($open_for_inspection == true && strlen($item_str) > 0) {
        $smarty->assign('calendar_items', $item_str);
        $smarty->assign('note_time_id', $property_id);
        $str = '<button class="btn-pv1 btn-pv-inspect" title="Inspect" onclick="showNoteTimePopup(\'note_time_' . $property_id . '\')" ></button>' . $smarty->fetch(ROOTPATH . '/modules/calendar/templates/calendar.popup.tpl');
    }
    return $str;
}

/**
 **/
function Calendar_hasRow($property_id = 0)
{
    global $calendar_cls;
    $ok = false;
    if ($property_id > 0) {
        $row = $calendar_cls->getRow('property_id = ' . $property_id);
        if (is_array($row) && count($row) > 0) {
            $ok = true;
        }
    }
    return $ok;
}

function sendMailNotifyInspectTime($data)
{
    include_once ROOTPATH . '/modules/banner/inc/banner.php';
    if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
        $banner_cls = new Banner();
    }
    global $property_cls, $smarty, $config_cls;
    $vendor = PE_getAgent('', $data['property_id']);
    if (count($vendor) > 0 and is_array($vendor)) {
        $lkB = getBannerByPropertyId($data['property_id']);
        $email_to = $vendor['email_address'];
        $subject = $config_cls->getKey('email_inspecttime_prompt_msg_subject');
        $subject = str_replace(array('[ID]', '[ROOTURL]'), array($data['property_id'], ROOTURL), $subject);
        $content = $config_cls->getKey('email_inspecttime_prompt_msg');
        $vendor_name = $vendor['firstname'] . ' ' . $vendor['lastname'];
        $address = PE_getAddressProperty($data['property_id']);
        $content = str_replace(array('[ID]', '[ROOTURL]', '[address]', '[agent_name]'), array($data['property_id'], ROOTURL, $address, $vendor_name), $content);
        $email_from = '';
        if ($vendor['notify_email'] == 0) {
            return true;
        }
        include_once ROOTPATH . '/modules/general/inc/email_log.class.php';
        if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
            $log_cls = new Email_log();
        }
        //sendSMSByKey($email_to,'inspecttime_prompt',$data['property_id']);
        $log_cls->createLog('calendar_notify');
        if (sendEmail_func($email_from, $email_to, $content, $subject, $lkB) == 'send') {
            return true;
        } else {
            return false;
        }
    }
}

?>