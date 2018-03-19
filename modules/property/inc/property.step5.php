<?php
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
$data_ar = array();
$step = (int)getParam('step', 0);
//BEGIN CHECK PROPERTY TYPE
$auction_sale_ar = PEO_getAuctionSale();
$property_row = $row = $property_cls->getRow('property_id = ' . $_SESSION['property']['id']);
$isAuction = PE_isNormalAuction($_SESSION['property']['id']);
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
                if ((PE_isAuction($_SESSION['property']['id'], 'ebiddar') || PE_isAuction($_SESSION['property']['id'], 'bid2stay')) && in_array($auction_terms[$key]['code'], array('deposit_required', 'settlement_period', 'contract_and_deposit_timeframe'))) {
                    unset($auction_terms[$key]);
                } else {
                    $def_child_id = 0;
                    $auction_terms[$key]['options'] = AT_getOptions($key, 1, 'ASC', PEO_getCodeAuctionSale($_SESSION['property']['id']));
                    // begin not valid number zero if value options = 0;
                    $auction_terms[$key]['is_valid_zero'] = 'validate-number-gtzero';
                    foreach ($auction_terms[$key]['options'] as $key_ => $val) {
                        if ($key_ == 0) {
                            $auction_terms[$key]['is_valid_zero'] = '';
                            break;
                        }
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
if (isSubmit()) {//FOR POST
    $data = getPost('fields');
    if (isset($data['term']) && is_array($data['term']) && count($data['term']) > 0) {
        $data_ex_ar = array();
        foreach ($data['term'] as $key => $val) {
            //$key is auction_term_id, we must hold $key with $type in ('text','checkbox')
            //but have to change to child of $key with select
            $type = AT_getType($key);
            //BEGIN CODE
            $code = AT_getCodeById($key);
            if (in_array($code, array('auction_start_price', 'reserve', 'initial_auction_increments'))) {
                $data_ex_ar[$code] = array('value' => (int)$val, 'title' => $auction_terms[$key]['title']);
            }
            //END
            //$test_ar['reserve'] = $_POST['fields']['term'][AT_getIdByCode('reserve')];
            switch ($type) {
                case 'text':
                    $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => $val);
                    /*$code = AT_getCodeById($key);
                    if ($code != 'reserve'){
					    $data_ar[$key] = array('id' => $key , 'parent_id' => $key,'value' => $val);
                    }*/
                    break;
                case 'checkbox':
                    $data_ar[$key] = array('id' => $key, 'parent_id' => $key, 'value' => 1);
                    break;
                case 'select':
                    $child_id = AT_getChildId($val, $key);
                    $data_ar[$key] = array('id' => $child_id, 'parent_id' => $key, 'value' => $val);
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
        $property_term_cls->addValid(array('field' => 'start_time', 'label' => 'Start time', 'fnc' => array('isDateTime' => null)));
        $property_term_cls->addValid(array('field' => 'end_time', 'label' => 'End time',
            'fnc' => array('isDateTime' => null, 'isBigger' => array(date('Y-m-d H:i:s'), 'string')),
            'fnc_msg' => array('isBigger' => 'End time must be after the present time.')));

        try {
            $no_auction = false;
            /*Can we make the auction non mandatory, so if an auction time is not set
            by vendor/agent, then the property lists as a sale but with only offer/buy now functions…
            and in auction space on listing it is just listed as TBA*/
            $start_time = getPost('start_time');
            $end_time = getPost('end_time');
            if (strlen(trim($start_time)) == 0) {
                $start_time = '5000-05-05 00:00:00';
                $no_auction = true;
            }
            if (strlen(trim($end_time)) == 0) {
                $end_time = '5000-06-06 00:00:00';
                $no_auction = ($no_auction AND true);
            }
            if(!$no_auction){
                if (!$_SESSION['agent']['type'] == 'theblock' && !($_SESSION['agent']['type'] == 'agent' && $isAuction) && $data_ex_ar['reserve']['value'] <= 0) {
                    $property_term_cls->addValid(array('field' => 'auction_start_price', 'label' => $data_ex_ar['auction_start_price']['title'],
                        'fnc' => array('isBigger' => 0, 'isSmaller' => array($data_ex_ar['reserve']['value'], 'int')),
                        'fnc_msg' => array('isSmaller' => $data_ex_ar['auction_start_price']['title'] . ' must be less than ' . $data_ex_ar['reserve']['title'])));
                }
                $property_term_cls->addValid(array('field' => 'reserve', 'label' => $data_ex_ar['reserve']['title'],
                    'fnc' => array('isBigger' => array($data_ex_ar['initial_auction_increments']['value'], 'int')),
                    'fnc_msg' => array('isBigger' => $data_ex_ar['initial_auction_increments']['title'] . ' can\'t be affter ' . $data_ex_ar['reserve']['title'])));
                $property_term_cls->addValid(array('field' => 'reserve', 'label' => $data_ex_ar['reserve']['title'],
                    'fnc' => array('isBigger' => 0),
                    'fnc_msg' => array('isBigger' => $data_ex_ar['reserve']['title'] . ' must be larger than 0.')));
                $property_term_cls->addValid(array('field' => 'auction_start_price', 'label' => $data_ex_ar['auction_start_price']['title'],
                    'fnc' => array('isBigger' => 0),
                    'fnc_msg' => array('isBigger' => $data_ex_ar['auction_start_price']['title'] . ' must be larger than 0.')));
            }
            if (!$property_term_cls->isValid(array('start_time' => $start_time,
                'end_time' => $end_time,
                'auction_start_price' => $data_ex_ar['auction_start_price']['value']
            ))) {
                throw new Exception(implode("<br/>", $property_term_cls->getErrorsValid()));
            }
            $checkFields_ar = PE_isValidPriceBeforeLiveAndEnding((int)$_SESSION['property']['id'], $_SESSION['agent']['type']);
            $data_before = $property_cls->getCRow(array('price', 'start_time', 'end_time'), "property_id='" . (int)$_SESSION['property']['id'] . "'");
            $property_terms = PT_getTermsKeyParentId((int)$_SESSION['property']['id']);
            $data_before['start_price'] = $property_terms[(int)AT_getIdByCode('auction_start_price')];
            $data_ch = array('price' => $data['term'][(int)AT_getIdByCode('reserve')], 'start_price' => $data['term'][(int)AT_getIdByCode('auction_start_price')], 'start_time' => $start_time,
                'end_time' => $end_time);
            if (count($data_before) > 0) {
                foreach ($checkFields_ar as $key => $val) {
                    if ($val and (isset($data_ch[$key]) and $data_ch[$key] != '') and $data_ch[$key] != $data_before[$key]) {
                        $isValid_fields = true;
                        throw new Exception('You can\'t edit ' . str_replace('_', ' ', $key));
                        break;
                    }
                }
            }
            foreach ($data_ar as $key => $info) {
                //we do not search by "property_id and auction_term_parent_id" NOT by "property_id and auction_term_id"
                $_code = AT_getCodeById((int)$info['parent_id']);
                if ($_code == 'auction_date' && strlen($info['value']) > 8) {
                    $info['value'] = AT_date2db($info['value']);
                }
                $row = $property_term_cls->getRow('property_id = ' . (int)$_SESSION['property']['id'] . ' AND auction_term_parent_id = ' . (int)$info['parent_id']);
                if ($property_term_cls->hasError()) {
                } else if (is_array($row) and count($row) > 0) {
                    $data = array('value' => $info['value']);
                    // Quan: check change Data when submit
                    $term_row = $property_term_cls->getRow('property_id=' . (int)$_SESSION['property']['id']);
                    $changed_data = false;
                    foreach ($data as $key => $val) {
                        if (isset($term_row[$key])) {
                            if ($data[$key] != $term_row[$key]) {
                                $changed_data = true;
                                break;
                            }
                        }
                    }
                    if ($changed_data)
                        $property_cls->update(array('last_update_time' => date('Y-m-d H:i:s')), 'property_id=' . (int)$_SESSION['property']['id']);
                    //end
                    $property_term_cls->update($data, 'property_id = ' . (int)$_SESSION['property']['id'] . ' AND auction_term_parent_id = ' . (int)$info['parent_id']);
                } else {
                    $data = array('property_id' => (int)$_SESSION['property']['id'],
                        'auction_term_id' => (int)$info['id'],
                        'auction_term_parent_id' => (int)$info['parent_id'],
                        'value' => $info['value']);
                    $property_term_cls->insert($data);
                }
            }
            $_data = array('start_time' => $start_time,
                'end_time' => $_SESSION['agent']['type'] == 'theblock' || ($_SESSION['agent']['type'] == 'agent' && $isAuction) ? '5000-01-01' : $end_time,
                'date_to_reg_bid' => getPost('date_to_reg_bid'));
            //RESET STOP BID WHEN END_TIME > CURRENT TIME
            if ($_data['end_time'] > date('Y-m-d H:i:s')) {
                $_data['stop_bid'] = 0;
                //die ('stop_bid');
            }
            //AUCTION RUN IN HOUR
            $selection_day = getPost('selection_day');
            $selection_hour = getPost('selection_hour');
            $selection_minute = getPost('selection_minute');
            $selection_second = getPost('selection_second');
            $add_seconds = (((int)$selection_day * 24 + (int)$selection_hour) * 60 + (int)$selection_minute) * 60 + (int)$selection_second;
            if ($add_seconds > 0) {
                if($_data['start_time'] == '5000-05-05 00:00:00'){
                    $_data['start_time'] = date('Y-m-d H:i:s');
                }
                if ($_data['start_time'] < date('Y-m-d H:i:s')) {
                    $st = new DateTime(date('Y-m-d H:i:s'));
                } else {
                    $st = new DateTime($_data['start_time']);
                }
                $end_time_ch = date('Y-m-d H:i:s', mktime($st->format('H'), $st->format('i'), (int)$st->format('s') + (int)$add_seconds, $st->format('m'), $st->format('d'), $st->format('Y')));
                if ($end_time_ch > $_data['start_time']) {
                    $_data['end_time'] = $end_time_ch;
                }
            }
            /*RELEASE TIME*/
            $_data['release_time'] = getPost('release_time');
            $property_cls->update($_data, 'property_id = ' . $_SESSION['property']['id']);
            //FOR AUCTION PROPERTY
            PE_updateHasAuctionTerm((int)$_SESSION['property']['id']);
            // UPDATE NOTIFICATION TO ANDROID
            //push(0, array('type_msg' => 'update-property'));
            if ($property_term_cls->hasError()) {
                throw new Exception('There is error when processing data.');
            } else {
                $_SESSION['property']['step'] = $step;
                $track = (int)getPost('track', 0);
                if ($track == 1) {
                    $message = 'Saved successful.';
                    $property_cls->update(array('step' => $step), 'property_id = ' . $_SESSION['property']['id']);
                } else {
                    redirect(ROOTURL . '?module=' . $module . '&action=register&step=' . ($step + 1));
                }
            }
        } catch (Exception $e) {
            $form_data = $_POST;
            $message = $e->getMessage();
        }
    }
}
/*FORM DATA*/
$property_data = $row = $property_cls->getRow('property_id = ' . $_SESSION['property']['id']);
if (is_array($row) && count($row) > 0) {
    if (Validate::isDateTime(array($row['end_time']))) {
        $form_data['end_time'] = $row['end_time'];
        if ($row['end_time'] >= '5000-06-06 00:00:00') {
            $form_data['end_time'] = '';
        }
    }
    if (Validate::isDateTime(array($row['start_time']))) {
        $form_data['start_time'] = $row['start_time'];
        if ($row['start_time'] == '5000-05-05 00:00:00') {
            $form_data['start_time'] = '';
        }
    }
    if ($row['date_to_reg_bid'] != '0000-00-00') {
        $form_data['date_to_reg_bid'] = $row['date_to_reg_bid'];
    }
    if ((PE_isAuction($_SESSION['property']['id'], 'ebiddar') || PE_isAuction($_SESSION['property']['id'], 'ebidda30') || PE_isAuction($_SESSION['property']['id'], 'bid2stay')) && $row['end_time'] == '5000-01-01 00:00:00') {
        $form_data['end_time'] = '';
    }
    if (Validate::isDateTime(array($row['release_time']))) {
        $form_data['release_time'] = $row['release_time'];
    }
}
$form_data['tooltip_des_date_lock'] = $config_cls->getKey('date_to_lock_before_live_des');
$is_auction = PE_isAuction((int)$_SESSION['property']['id']);
// Check valid end_time, start_time,start_price
$date_to_lock_before_live = $config_cls->getKey('date_to_lock_before_live');
$date_to_lock_before_ending = $config_cls->getKey('date_to_lock_before_ending');
$readonly = array();
$checkFields_ar = PE_isValidPriceBeforeLiveAndEnding((int)$_SESSION['property']['id'], $_SESSION['agent']['type']);
if (is_array($checkFields_ar) and count($checkFields_ar) > 0) {
    foreach ($checkFields_ar as $key => $val) {
        if ($val) {
            $readonly[$key] = 'readonly="readonly"';
        }
    }
}
$price = array();
$property_terms = isset($data['term']) ? $data['term'] : PT_getTermsKeyParentId((int)$_SESSION['property']['id']);
if(count($property_terms) == 0){
    $property_terms[(int)AT_getIdByCode('deposit_required')] = "10";
    $property_terms[(int)AT_getIdByCode('settlement_period')] = "60";
}
//print_r($property_terms);
/*if (!strlen($property_terms[(int)AT_getIdByCode('reserve')])) {
    $property_terms[(int)AT_getIdByCode('reserve')] = $row['price'];
}*/
$price['reserve'] = showPrice($property_terms[(int)AT_getIdByCode('reserve')]);
$price['auction_start_price'] = showPrice($property_terms[(int)AT_getIdByCode('auction_start_price')]);
if(empty($property_terms[(int)AT_getIdByCode('deposit_payment')])){
    if(!empty($property_row['buynow_price'])){
        $price['deposit_payment'] = showPrice((float)$property_row['buynow_price'] * 0.1);
    }elseif(!empty($property_row['price'])){
        $price['deposit_payment'] = showPrice((float)$property_row['price'] * 0.1);
    }else{
        $price['deposit_payment'] = showPrice(0);
        $property_terms[(int)AT_getIdByCode('deposit_payment')] = 0;
    }
}else{
    $price['deposit_payment'] =  showPrice($property_terms[(int)AT_getIdByCode('deposit_payment')]);
}
/*
 * 25. new - all rental auctions should reach the listed reserve on the first bid… can we force this?  i.e. do not list an auction start price for rentals, just list the reserve price field, and auto populate the auction start price with reserve price-$5?
 * minus$5 auto set for auction start price is set for all property postings, is for rental only, not sales properties
 * */
$auction_sale_options = PEO_getOptions('auction_sale', array(), $_SESSION['agent']['type'] == 'agent' ? 1 : 0);
$auction_type = 'rental_auction';
if (strlen(trim($auction_type)) > 0 && $property_data['auction_sale'] > 0) {
    if (strtolower(trim(str_replace(' ', '_', $auction_sale_options[$property_data['auction_sale']]))) == strtolower(trim(str_replace(' ', '_', $auction_type)))) {
        /*$property_terms[(int)AT_getIdByCode('auction_start_price')] = floatval($property_terms[(int)AT_getIdByCode('reserve')]) - 5;
        $readonly['start_price'] = 'readonly="readonly"';*/
    }
}
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
$smarty->assign(array('is_auction' =>
    $is_auction, 'readonly' => $readonly,
    'auction_terms' => $auction_terms,
    'price' => $price,
    'property_terms' => $property_terms,
    'form_data' => $form_data,
    'isBlock' => $_SESSION['agent']['type'] == 'theblock' ? 1 : 0,
    'isAgent' => $_SESSION['agent']['type'] == 'agent' ? 1 : 0,
    'isAuction' => $isAuction ? 1 : 0,
    'day_options' => $day_options,
    'hour_options' => $hour_options,
    'minute_options' => $minute_options,
    'second_options' => $second_options
));
