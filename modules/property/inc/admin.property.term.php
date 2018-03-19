<?php
//ini_set('display_errors', 1);
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
$data_ar = array();
$auction_terms = AT_getTerms();
if (is_array($auction_terms) and count($auction_terms) > 0) {
    foreach ($auction_terms as $key => $row) {
        switch ($auction_terms[$key]['type']) {
            case 'text':
                $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => '');
                break;
            case 'checkbox':
                $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => 0);
                break;
            case 'select':
                if (PE_isAuction($property_id, 'ebiddar') && in_array($auction_terms[$key]['code'], array('deposit_required', 'settlement_period', 'contract_and_deposit_timeframe'))) {
                    unset($auction_terms[$key]);
                } else {
                    $def_child_id = 0;
                    $auction_terms[$key]['is_validate_zero'] = "validate-number-gtzero";
                    $auction_terms[$key]['options'] = AT_getOptions($key, 1, 'ASC', PEO_getCodeAuctionSale($property_id));
                    foreach ($auction_terms[$key]['options'] as $index => $value) {
                        if ($index === 0) {
                            $auction_terms[$key]['is_validate_zero'] = "";
                            break;
                        };
                    }
                    $childs = AT_getChildIds($key);
                    if (is_array($childs) and count($childs) > 0) {
                        $def_child_id = $childs[0];
                    }
                    $data_ar[$key] = array('id' => $def_child_id, 'parent_id' => $key, 'value' => 0);
                }
                break;
        }
    }
}
$isBlock = PE_isTheBlock($property_id);
$ofAgent = PE_isTheBlock($property_id, 'agent');
$isAuction = PE_isNormalAuction($property_id) ? 1 : 0;
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {//FOR POST
    $_data = array();
    if (isset($_POST['fields']['term'])) {
        foreach ($_POST['fields']['term'] as $key => $val) {
            //$key is auction_term_id, we must hold $key with $type in ('text','checkbox')
            //but have to change to child of $key with select
            $type = AT_getType($key);
            $code = AT_getCodeById($key);
            switch ($type) {
                case 'text':
                    $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => $val);
                    $_data[$code] = $val;
                    break;
                case 'checkbox':
                    $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => 1);
                    $_data[$code] = $val;
                    break;
                case 'select':
                    $child_id = AT_getChildId($val, $key);
                    $data_ar[$key] = array('id' => $child_id, 'parent_id' => $key, 'value' => $val);
                    $_data[$code] = $val;
                    break;
            }
            //ADD NEW MANUAL
            if($val == 'new'){
                // save aution_terms
                $new_value = $_POST["new_fields"][$code];
                $new_value_real = preg_replace("/[^0-9]/","",$new_value);
                if(!empty($new_value) && !empty($new_value_real)){
                    $aut_data = array('title'=> $new_value,'value' => $new_value_real ,
                        'auction_term_parent_id' => $key ,'type'=> 'text','order' => 10,'active' => 1);
                    $auction_term_cls->insert($aut_data);
                    $aut_value_id = $auction_term_cls->insertId();
                    if(!empty($aut_value_id)){
                        $data_ar[$key]['value'] = $aut_data['value'];
                        $auction_terms[$key]['options'] = AT_getOptions($key, 1, 'ASC', PEO_getCodeAuctionSale($_SESSION['property']['id']));
                    }
                }
            }
            if($val == 'new-schedule'){
                //SAVE FILE
                ini_set('max_input_time', 300);
                ini_set('max_execution_time', 300);
                $path = ROOTPATH . '/store/uploads/files_schedule';
                $url_path = '/store/uploads/files_schedule';
                createFolder($path, 1);
                //BEGIN SETTING FOR UPLOADER
                // list of valid extensions, ex. array()
                $allowedExtensions = array('pdf', 'png', 'jpg', "jpeg", "bmp");
                // max file size in bytes
                $sizeLimit = 10 * 1024 * 1024 * 1024;
                $isCheckSetting = false;
                $files = $result = array();
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, $isCheckSetting);
                if (is_array($_FILES) && count($_FILES) > 0) {
                    foreach ($_FILES as $_key => $file) {
                        $uploader->addFileToUpload($file);
                        $result[$_key] = $uploader->handleUpload($path . '/');
                        if ($result[$_key]['success']) {
                            $files[$_key] = $url_path . '/' . $result[$_key]['filename'];
                        }
                    }
                    if(!empty($files['schedule'])){
                        $data_ar[$key]['value'] = $files['schedule'];
                    }
                }
                $file_delete_ar = $_POST['files_deleted'];
                if (is_array($file_delete_ar) && count($file_delete_ar) > 0) {
                    foreach ($file_delete_ar as $file => $_val) {
                        if ($_val == 'deleted') {
                            $data_ar[$key]['value'] = 1;
                        }
                    }
                }
            }
        }
        $error = false;
        if (!$error) { //print_r($data_ar['end_time']['value']);
            $start_time = getPost('start_time');
            $end_time = getPost('end_time');
            if (strlen(trim($start_time)) == 0) {
                $start_time = '5000-05-05 00:00:00';
            }
            if (strlen(trim($end_time)) == 0) {
                $end_time = '5000-06-06 00:00:00';
            }
            $end_time = $isBlock || ($ofAgent && $isAuction) ? '5000-01-01 00:00:00' : $end_time;
            if ($end_time < date('Y-m-d H:i:s')) {
                $error = true;
                $message = 'End time must be larger than current time.';
            }
            if ($end_time < $start_time) {
                $error = true;
                $message = "Start time can't more than End time ";
            }
            if (!isValidDateTime($end_time)) {
                $error = true;
                $message = "End time is invalid.";
            }
            if (isset($_data['auction_start_price']) && isset($_data['reserve']) && $_data['auction_start_price'] > $_data['reserve']) {
                $error = true;
                $message = '"Auction start price" must be less than "Reserve price"';
            }
            if (isset($_data['initial_auction_increments']) && isset($_data['reserve']) && $_data['reserve'] > 0 && $_data['initial_auction_increments'] > $_data['reserve']) {
                $error = true;
                $message = '"Initial auction increments" must be less than "Reserve price"';
            }
        }
        if (!$error) {
            foreach ($data_ar as $key => $info) {
                //we do not search by "property_id and auction_term_parent_id" NOT by "property_id and auction_term_id"
                $_code = AT_getCodeById((int)$info['parent_id']);
                if ($_code == 'auction_date' && strlen($info['value']) > 8) {
                    $info['value'] = AT_date2db($info['value']);
                }
                $row = $property_term_cls->getRow('property_id = ' . $property_id . ' AND auction_term_parent_id = ' . (int)$info['parent_id']);
                if ($property_term_cls->hasError()) {
                } else if (is_array($row) and count($row) > 0) {
                    // Quan: check change Data when submit
                    $term_row = $property_term_cls->getRow('property_id=' . $property_id);
                    $changed_data = false;
                    if (is_array($data) && count($data) > 0) {
                        foreach ($data as $key => $val) {
                            if (isset($term_row[$key])) {
                                if ($data[$key] != $term_row[$key]) {
                                    $changed_data = true;
                                    break;
                                }
                            }
                        }
                    }
                    if ($changed_data)
                        $property_cls->update(array('last_update_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
                    //end
                    $data = array('value' => $info['value']);
                    $property_term_cls->update($data, 'property_id = ' . $property_id . ' AND auction_term_parent_id = ' . (int)$info['parent_id']);
                } else {
                    $data = array('property_id' => (int)$property_id,
                        'auction_term_id' => (int)$info['id'],
                        'auction_term_parent_id' => (int)$info['parent_id'],
                        'value' => $info['value']);
                    $property_term_cls->insert($data);
                }
            }
            /*
            $data['end_time'] = $_POST['time']['year'].'-'.$_POST['time']['month'].'-'.$_POST['time']['day'].' '.
                $_POST['time']['hour'].':'.$_POST['time']['minute'].':'.$_POST['time']['second'];
            */
            if (isset($end_time) && $end_time != '') {
                $data['end_time'] = $end_time;
            } else {
                $data['end_time'] = date('Y-m-d H:i:s');
            }
            if (isset($start_time) && $start_time != '') {
                $data['start_time'] = $start_time;
            } else {
                $data['start_time'] = date('Y-m-d H:i:s');
            }
            /*$property_cls->update(array('end_time' => $data['end_time']),'property_id = '.$property_id);
            $property_cls->update(array('start_time'=>$data['start_time']),'property_id = '.$property_id);*/
            $detail_data = array();
            $detail_data['end_time'] = $data['end_time'];
            $detail_data['start_time'] = $data['start_time'];
            if ($property_cls->isAdminCreated($property_id)) {
                $detail_data['pay_status'] = Property::PAY_COMPLETE;
                $detail_data['agent_active'] = 1;
                $detail_data['posted_to_live_time'] = date('Y-m-d H:i:s');
            }
            //AUCTION RUN IN HOUR
            $selection_day = getPost('selection_day');
            $selection_hour = getPost('selection_hour');
            $selection_minute = getPost('selection_minute');
            $selection_second = getPost('selection_second');
            $add_seconds = (((int)$selection_day * 24 + (int)$selection_hour) * 60 + (int)$selection_minute) * 60 + (int)$selection_second;
            if ($add_seconds > 0) {
                if($detail_data['start_time'] == '5000-05-05 00:00:00'){
                    $detail_data['start_time'] = date('Y-m-d H:i:s');
                }
                if ($detail_data['start_time'] < date('Y-m-d H:i:s')) {
                    $st = new DateTime(date('Y-m-d H:i:s'));
                } else {
                    $st = new DateTime($detail_data['start_time']);
                }
                $end_time_ch = date('Y-m-d H:i:s', mktime($st->format('H'), $st->format('i'), (int)$st->format('s') + (int)$add_seconds, $st->format('m'), $st->format('d'), $st->format('Y')));
                if ($end_time_ch > $detail_data['start_time']) {
                    $detail_data['end_time'] = $end_time_ch;
                }
            }
            $detail_data['release_time'] = getPost('release_time');
            $property_cls->update($detail_data, 'property_id = ' . $property_id);
            if (is_array($row) and count($row) > 0) {
                // Write Logs
                $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
                    'Action' => 'UPDATE',
                    'Detail' => "UPDATE PROPERTY TERM ID :" . $property_id,
                    'UserID' => $_SESSION['Admin']['EmailAddress'],
                    'IPAddress' => $_SERVER['REMOTE_ADDR']
                ));
            } else {
                // Write Logs
                $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
                    'Action' => 'INSERT',
                    'Detail' => "ADD PROPERTY TERM ID :" . $property_id,
                    'UserID' => $_SESSION['Admin']['EmailAddress'],
                    'IPAddress' => $_SERVER['REMOTE_ADDR']
                ));
            }
            //FOR AUCTION PROPERTY
            PE_updateHasAuctionTerm($property_id);
            if ($error || $property_term_cls->hasError()) {
                $message = 'Error during processing.';
            } else {
                $message = 'Added / Edited successful.';
                if ($_POST['next'] == 1) {
                    //redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-option&property_id='.$property_id.'&token='.$token);
                    redirect(ROOTURL . '/admin/?module=' . $module . '&action=list&token=' . $token);
                }
            }
        }
    }
}
//
$form_data = array();
$row = $property_cls->getRow('property_id = ' . $property_id);
$is_auction = (PE_isAuction($property_id)) ? 'true' : 'false';
//$form_data['end_time'] = $form_data['start_time'] = '';
if (is_array($row) && count($row) > 0) {
    //extractDateTime($row['end_time'],$form_data);
    //$form_data['end_time'] = $row['end_time'];
    //$form_data['start_time'] = $row['start_time'];
    $readonly = '';
    if ($is_auction == 'true' && $row['pay_status'] == Property::PAY_COMPLETE) {
        $st_time = new DateTime($row['start_time']);
        $now = new DateTime(date('Y-m-d H:i:s'));
        $readonly = ($st_time < $now || Property_datediff(date('Y-m-d H:i:s'), $row['start_time'])) ? 'readonly="readonly"' : '';
    }
    $form_data = $row;
}
if ($form_data['end_time'] == '0000-00-00 00:00:00' || $form_data['end_time'] >= '5000-06-06 00:00:00') {
    $form_data['end_time'] = '';
}
if ($form_data['start_time'] == '0000-00-00 00:00:00' || $form_data['start_time'] >= '5000-05-05 00:00:00') {
    $form_data['start_time'] = '';
}
if ($row['release_time'] == '0000-00-00 00:00:00') {
    $form_data['release_time'] = '';
}

if ((PE_isAuction($property_id, 'ebiddar') || PE_isAuction($property_id, 'ebidda30')) && $form_data['end_time'] == '5000-01-01 00:00:00') {
    $form_data['end_time'] = '';
}
$form_action = '?module=' . $module . '&action=edit-term&property_id=' . $property_id . '&token=' . $token;
$property_terms = PT_getTermsKeyParentId($property_id);
if (!strlen($property_terms[(int)AT_getIdByCode('reserve')])) {
    $property_terms[(int)AT_getIdByCode('reserve')] = $row['price'];
}
$price['reserve'] = showPrice($property_terms[(int)AT_getIdByCode('reserve')]);
$price['auction_start_price'] = showPrice($property_terms[(int)AT_getIdByCode('auction_start_price')]);
//$cur_date =  date("m/d/Y", mktime(0, 0, 0, date('m'), date('d')+14, date('Y')));
// Set Auction Run In Hours
$day_options = array(0 => '0 Day');
$hour_options = array(0 => '0 Hour');
$minute_options = array(0 => '0 Minute');
$second_options = array(0 => '0 Second');
for ($i = 1; $i <= 30; $i++) {
    $day_options[$i] = $i . ($i >= 2 ? ' Days' : ' Day');
}
for ($i = 1; $i <= 23; $i++) {
    $hour_options[$i] = $i . ($i >= 2 ? ' Hours' : ' Hour');
}
for ($i = 1; $i <= 59; $i++) {
    $minute_options[$i] = $i . ($i >= 2 ? ' Minutes' : ' Minute');
}
for ($i = 1; $i <= 59; $i++) {
    $second_options[$i] = $i . ($i >= 2 ? ' Seconds' : ' Second');
}
//print_r($price);
//$smarty->assign('cur_date',$cur_date);
$smarty->assign('is_auction', $is_auction);
$smarty->assign('readonly', $readonly);
$smarty->assign('auction_terms', $auction_terms);
$smarty->assign('property_terms', formUnescapes($property_terms));
$smarty->assign('form_data', $form_data);
$smarty->assign('price', $price);
$smarty->assign('isBlock', $isBlock ? 1 : 0);
$smarty->assign('ofAgent', $ofAgent ? 1 : 0);
$smarty->assign('isAuction', $isAuction);
$smarty->assign(array('day_options' => $day_options,
    'hour_options' => $hour_options,
    'minute_options' => $minute_options,
    'second_options' => $second_options));
?>