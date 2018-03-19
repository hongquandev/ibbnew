<?php
include_once ROOTPATH . '/modules/configuration/inc/configuration.php';
$form_data = $property_cls->getFields();
$form_data[$property_cls->id] = $_SESSION['property']['id'];
//get count down
$row = $property_cls->getCRow(array('set_count'), 'property_id = ' . $_SESSION['property']['id']);
if (is_array($row) and count($row) > 0) {
    $form_data['set_count'] = $row['set_count'];
}
$auction_sale_ar = PEO_getAuctionSale();
//default auction_sale
if (isset($auction_sale_ar['auction'])) {
    $form_data['auction_sale'] = $auction_sale_ar['auction'];
} else {
    $form_data['auction_sale'] = $auction_sale_ar['ebidda30'];
}
$smarty->assign('error', $config_cls->getKey('restrict_property'));
$restrict_area = $config_cls->getKey('restrict_area');
$smarty->assign('restrict_area', $restrict_area);
$readonly = array();
if (isSubmit()) {
    foreach ($form_data as $key => $value) {
        if (isset($_POST['fields'][$key])) {
            $data[$key] = addslashes($_POST['fields'][$key]);
        }
    }
    $data['agent_id'] = $_SESSION['agent']['id'];
    if ($data['price'] == '') $data['price'] = 0;
    $data['auction_sale'] = !(isset($_POST['fields']['auction_sale'])) ? $auction_sale_ar['auction'] : $_POST['fields']['auction_sale'];
    $data['price_on_application'] = (isset($_POST['fields']['price_on_application']) && (int)$data['price'] == 0) ? 1 : 0;
    $data['land_size_number'] = $_POST['fields']['land_size_number'];
    $data['unit'] = $_POST['fields']['unit'];
    if (isset($data['unit']) && strlen($data['unit'])) {
        $rowo = $property_cls->getRow('SELECT * FROM ' . $property_cls->getTable('property_entity_option') . '
                                   WHERE property_entity_option_id = ' . $data['unit'], true);
        if ($data['land_size_number'] > 0) {
            $data['land_size'] = $data['land_size_number'] . ' ' . $rowo['title'];
        } else {
            $data['land_size'] = '';
        }
    }
    $is_auction = PE_isAuction($_SESSION['property']['id']);
    foreach (array('open_for_inspection', 'open_time', 'auction_blog', 'contact_by_bidder') as $key) {
        $data[$key] = isset($data[$key]) ? 1 : 0;
    }
    //$data['package_id'] = 0;
    //if ($_SESSION['agent']['type'] != 'agent'){
    /*$package_ar = getPost('package_id');
    if (is_array($package_ar)) {
        $data['package_id'] = $package_ar[0];
    }*/
    //}else{
    //$data['package_id'] = $package['package_id'];
    //}
    //fnc => array('fnc_name' => fnc_arg)
    //$property_cls->addValid(array('field' => 'land_size_number', 'label' => 'Land size number', 'fnc' => array('isInt' => null)));
    //$property_cls->addValid(array('field' => 'price', 'label' => 'Price', 'fnc' => array('isInt' => null,'isBigger' => 0)));
    $isValid_fields = false;
    try {
        $checkFields_ar = PE_isValidPriceBeforeLiveAndEnding($form_data[$property_cls->id], $_SESSION['agent']['type']);
        if ($_SESSION['agent']['type'] != 'theblock') {
            $data_before = $property_cls->getCRow(array('price'), "property_id='" . $form_data[$property_cls->id] . "'");
            if (count($data_before) > 0) {
                foreach ($checkFields_ar as $key => $val) {
                    if ($val and isset($data[$key]) and $data[$key] != $data_before[$key]) {
                        $isValid_fields = true;
                        throw new Exception('You can\'t edit ' . str_replace('_', ' ', $key));
                        break;
                    }
                }
            }
        }
    } catch (Exception $e) {
        $message_ = $e->getMessage();
    }
    /*
    if ($data['auction_sale'] == $auction_sale_ar['private_sale'] || $_SESSION['agent']['type'] == 'theblock'
        || ($_SESSION['agent']['type'] == 'agent' && $data['auction_sale'] == $auction_sale_ar['auction'])
    ) {//private sale OR the block
        if ((int)$data['price'] <= 0 AND $data['price_on_application'] == 0) {
            $isValid_fields = true;
            throw new Exception('Please fill Price or POA (Price on application)');
            //$message_ = 'Please fill Price or POA (Price on application)';
        }
    } else {
        if ($data['price'] <= 0 OR $data['price'] == '') {
            $isValid_fields = true;
            $message_ = 'Please fill reserve price';
        }
        if ($data['auction_sale'] == $auction_sale_ar['ebidda30'] && ($data['buynow_price'] <= 0 OR $data['buynow_price'] == '')) {
            $isValid_fields = true;
            $message_ = 'Please fill Buy Now price';
        }
    }*/
    if ($data['advertised_price_from'] > 0 && $data['advertised_price_to'] > 0 && $data['advertised_price_from'] >= $data['advertised_price_to'] ) {
        $isValid_fields = true;
        $message_ = 'Please fill Advertised From price less than Advertised To price ';
    }
    if ($property_cls->isValid($data) AND !$isValid_fields) {
        $data['suburb'] = trim($data['suburb']);
        try {
            $region_ar = array_map('trim', array($data['suburb'], $data['state'], $data['postcode']));
            if ($property_cls->invalidRegion(implode(' ', $region_ar))) {
                throw new Exception('Wrong suburb/postcode or state!');
            }
            /*$region = R_getItemFromCondition('region_id = '.$data['state']);
            if (is_array($region) && count($region)> 0 && in_array($region['code'],array('NT','WA','TAS','QLD'))){
                $msg = $config_cls->getKey('restrict_property');
                throw new Exception($msg);
            }*/
            if ($_SESSION['agent']['type'] != 'agent') {
                if (in_array($data['state'], explode(',', $restrict_area))) {
                    $msg = $config_cls->getKey('restrict_property');
                    throw new Exception($msg);
                }
            }
            if ($data['land_size_number'] > 0) {
                $data['land_size'] = $data['land_size_number'] . ' ' . $property_entity_option_cls->getItem($data['unit'], 'title');
            } else {
                $data['land_size'] = '';
            }
            $data['description'] = scanContent($data['description']);
            /*if ($_SESSION['agent']['type'] != 'agent'){*/
            /*if ($data['auction_sale'] != $auction_sale_ar['private_sale']) {
                $row = $package_cls->getRow('package_id = '.$data['package_id'].' AND property_type != '.$auction_sale_ar['private_sale']);
                if (!is_array($row) || count($row) == 0) {
                    $row = $package_cls->getRow('property_type = '.$auction_sale_ar['auction'].' ORDER BY `order` ASC');
                    if (is_array($row) && count($row) > 0) {
                        $data['package_id'] = $row['package_id'];
                    }
                }
                if ((int)$data['package_id'] == 0) {
                    throw new Exception('Please select the package for this property.');
                }
            } else {
                $row = $package_cls->getRow('property_type = '.$auction_sale_ar['private_sale']);
                if ((int)$data['package_id'] == 0 && is_array($row) && count($row) > 0) {
                    $data['package_id'] = $row['package_id'];
                }
            }*/
            //}
            if ($_SESSION['agent']['type'] == 'agent') {
                $data['show_agent_logo'] = 1;
            }
            /*UPDATE SET COUNT*/
            /*if (($_SESSION['agent']['type'] == 'theblock' || ($_SESSION['agent']['type'] == 'agent' && $data['auction_sale'] == $auction_sale_ar['auction'])) && $form_data['set_count'] == '') {
                $data['set_count'] = 'Waiting for Auctioneer';
                $data['lock_bid'] = 1;
            }*/
            if ($_SESSION['agent']['type'] == 'agent' && $data['auction_sale'] != $auction_sale_ar['auction'] && $form_data['set_count'] != '') {
                $data['set_count'] = '';
                $data['lock_bid'] = 0;
            }
            if ($form_data[$property_cls->id] > 0) { //UPDATE a propertye
                $data['last_update_time'] = date('Y-m-d H:i:s');
                /*if ($data['auction_sale'] != $auction_sale_ar['private_sale']) {
                    $start_price = PT_getValueByCode($form_data[$property_cls->id], 'auction_start_price');
                    if (!isset($start_price)) {
                        $start_price = 0;
                    }
                    if (!(in_array($_SESSION['agent']['type'], array('theblock', 'agent')))) {
                        if ($data['price'] <= $start_price) {
                            throw new Exception('Price is less than start price.');
                        }
                    }
                }*/
                $disableFields = PE_getDisableFieldsPaid(PE_getPayStatus($form_data[$property_cls->id]));
                foreach ($disableFields as $field) {
                    if (isset($data[$field])) {
                        unset($data[$field]);
                    }
                }
                //SAVE BANK DETAILS
                $data['bank_info'] = getParam('fields')['bank_info'];
                if (is_array($data['bank_info']) && count($data['bank_info']) > 0) {
                    $data['bank_info'] = serialize($data['bank_info']);
                }
                // UPDATE PROPERTY
                //print_r($data);die();
                $property_cls->update($data, $property_cls->id . ' = ' . $form_data[$property_cls->id]);
                //MOVE STEP
                /*if (in_array($data['auction_sale'], array($auction_sale_ar['auction'], $auction_sale_ar['ebidda30'], $auction_sale_ar['ebiddar']))) {
                    $row = $property_term_cls->getRow(' property_id = ' . $form_data[$property_cls->id] . ' AND auction_term_id = ' . AT_getIdByCode('reserve'));
                    if (is_array($row) and count($row) > 0) { //update term
                        $property_term_cls->update(array('value' => $data['price']), 'property_id = ' . $form_data[$property_cls->id] . '
                                                                                       AND auction_term_id = ' . AT_getIdByCode('reserve'));
                    }
                }*/
                updateSlugProperty($form_data[$property_cls->id]);
            }
            // UPDATE NOTIFICATION TO ANDROID
            //push(0, array('type_msg' => 'update-property'));
            if (!PE_isAuction($_SESSION['property']['id']) and $_SESSION['property']['id'] > 0) {
                $property_cls->update(array('stop_bid' => 0,
                    'start_time' => '0000-00-00 00:00:00',
                    'end_time' => '0000-00-00 00:00:00'), 'property_id = ' . $_SESSION['property']['id']);
                $property_term_cls->delete('property_id = ' . $_SESSION['property']['id']);
                $bid_cls->delete('property_id = ' . $_SESSION['property']['id']);
            }
            if ($property_cls->hasError()) {
                throw new Exception('Error');
            } else {
                $pay_status = PE_getPayStatus($_SESSION['property']['id']);
                $track = (int)getPost('track');
                if ($track == 1) { // Update
                    $_SESSION['property']['step'] = $step;
                    $message = 'Saved successfully.';
                    $property_cls->update(array('step' => $step), 'property_id = ' . $_SESSION['property']['id']);

                } else {
                    redirect(ROOTURL . '?module=' . $module . '&action=register&step=' . ($step + 1));
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    } else {
        $message = implode("<br/>", $property_cls->getErrorsValid());
        if ($isValid_fields) {
            $message = $message_;
        }
    }
    if (strlen($message) > 0) {
        //GET DATA TO SHOW BACK FORM
        $form_data = $data;
    }
}
if ((int)$_SESSION['property']['id'] <= 0) {
    $mode = 'add-property';
} else {
    $mode = 'update-property';
    //begin for updating
    //NH EDIT FOR ACC PARENT THE BLOCK, AGENT AUCTION
    if ($_SESSION['agent']['type'] == 'theblock' || $_SESSION['agent']['type'] == 'agent') {
        $row = $property_cls->getRow('property_id = ' . $_SESSION['property']['id'] . '
                                                  AND (IF(ISNULL(agent_manager)
                                                          OR agent_manager = 0
                                                          OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' WHERE agent_id = ' . $_SESSION['agent']['id'] . ') = 0
                                                          ,agent_id = ' . $_SESSION['agent']['id'] . '
                                                          , agent_manager = ' . $_SESSION['agent']['id'] . ')
                                                       OR (SELECT parent_id FROM ' . $agent_cls->getTable() . ' AS a
                                                        WHERE a.agent_id = ' . $property_cls->getTable() . '.agent_id ) = ' . $_SESSION['agent']['id'] .
            ')');
    } else {
        $row = $property_cls->getRow('property_id = ' . $_SESSION['property']['id'] . ' AND agent_id = ' . $_SESSION['agent']['id']);
    }
    // Begin vaild price
    $is_auction = PE_isAuction((int)$_SESSION['property']['id']);
    $checkFields_ar = PE_isValidPriceBeforeLiveAndEnding((int)$_SESSION['property']['id'], $_SESSION['agent']['type']);
    {
        if (is_array($checkFields_ar) and count($checkFields_ar) > 0) {
            foreach ($checkFields_ar as $key => $val) {
                if ($val) {
                    $readonly[$key] = 'disabled="disabled" readonly="readonly"';
                }
            }
        }
    }
    $disableFields = PE_getDisableFieldsPaid($row['pay_status']);
    //Update Form data
    if ($property_cls->hasError()) {
        $message = $property_cls->getError();
    } elseif (is_array($row) and count($row)) {
        $form_data = $row;
        $land_size = explode(' ', $form_data['land_size']);
        if (is_array($land_size) && count($land_size) > 1) {
            $form_data['land_size_number'] = $land_size[0];
            $form_data['unit'] = $property_entity_option_cls->getItemByField('title', $land_size[1], 'property_entity_option_id');
        }
        if ($form_data['price'] == 0) {
            $form_data['show_price'] = '';
        } else {
            $form_data['price'] = number_format($form_data['price'], 0, '', '');
            $form_data['show_price'] = showPrice($form_data['price']);
        }
        if ($form_data['buynow_price'] == 0) {
            $form_data['show_buynow_price'] = '';
        } else {
            $form_data['buynow_price'] = number_format($form_data['buynow_price'], 0, '', '');
            $form_data['show_buynow_price'] = showPrice($form_data['buynow_price']);
        }
        if ($form_data['price_on_application'] == 0) {
            $form_data['show_price_on_application'] = '';
        } else {
            $form_data['price_on_application'] = number_format($form_data['price_on_application'], 0, '', '');
            $form_data['show_price_on_application'] = showPrice($form_data['price_on_application']);
        }
        if ($form_data['advertised_price_from'] == 0) {
            $form_data['show_advertised_price_from'] = '';
        } else {
            $form_data['advertised_price_from'] = number_format($form_data['advertised_price_from'], 0, '', '');
            $form_data['show_advertised_price_from'] = showPrice($form_data['advertised_price_from']);
        }
        if ($form_data['advertised_price_to'] == 0) {
            $form_data['show_advertised_price_to'] = '';
        } else {
            $form_data['advertised_price_to'] = number_format($form_data['advertised_price_to'], 0, '', '');
            $form_data['show_advertised_price_to'] = showPrice($form_data['advertised_price_to']);
        }
        $option = PEO_getOptionById($form_data['auction_sale']);
        $form_data['auction_sale_code'] = $option['code'];
    }
}
//end
$form_data['date_to_lock_before_live'] = $config_cls->getKey('date_to_lock_before_live');
$form_data['tooltip_price'] = $config_cls->getKey('date_to_lock_before_live_des');
$form_data['country'] = (int)$form_data['country'] > 0 ? $form_data['country'] : $config_cls->getKey('general_country_default');
$type_ar = $form_data['kind'] == 2 ? PEO_getOptions('property_type') : PEO_getOptions('property_type_commercial');
if ((int)$form_data['auction_sale'] > 0) {
} else {
    $form_data['auction_sale'] = $auction_sale_ar['ebidda30'];
}
$form_data['bank_info'] = unserialize($form_data['bank_info']);
$smarty->assign(array(
    'property_types' => $type_ar,
    'property_kinds' => PEO_getKind(),
    'price_ranges' => PEO_getOptions('price_range'),
    'bedrooms' => array('0' => '0') + PEO_getOptions('bedrooms'),
    'bathrooms' => array('0' => '0') + PEO_getOptions('bathrooms'),
    'parkings' => PEO_getParking(),
    'land_sizes' => PEO_getOptions('land_size'),
    'car_spaces' => PEO_getOptions('car_spaces'),
    'car_ports' => PEO_getOptions('garage_carport', array('0' => 'None')),
    'mode' => $mode,
    'unit' => PEO_getOptions('unit'),
    'states' => R_getOptions(COUNTRY_DEFAULT, array(0 => 'Select...')),
    'countries' => R_getOptionsStep2(),
    'form_data' => formUnescapes($form_data),
    'is_paid' => PE_getPayStatus($_SESSION['property']['id']),
    'readonly' => $readonly,
    /*'package_tpl' => PK_getPackageTpl($_SESSION['property']['id'],0,$form_data['auction_sale']),*/
    'isBlock' => $_SESSION['agent']['type'] == 'theblock' ? 1 : 0,
    'auction_sale_ar' => PEO_getAuctionSale(),
    'period_options' => PEO_getOptions('period'),
    'disableFields' => $disableFields));
$smarty->assign('auction_sales', PEO_getOptions('auction_sale', array(), $_SESSION['agent']['type'] == 'agent' ? 1 : 0));
?>