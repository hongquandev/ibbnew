<?php
ini_set('display_errors', 0);
include_once ROOTPATH . '/utils/ajax-upload/server/php.php';
$message = array();
function isXMLFileValid($xmlFilename, $version = '1.0', $encoding = 'utf-8')
{
    $xmlContent = file_get_contents($xmlFilename);
    return isXMLContentValid($xmlContent, $version, $encoding);
}

function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
{
    if (trim($xmlContent) == '') {
        return false;
    }
    libxml_use_internal_errors(true);
    $doc = new DOMDocument($version, $encoding);
    $doc->loadXML($xmlContent);
    $errors = libxml_get_errors();
    libxml_clear_errors();
    return empty($errors);
}

function XmlPropertyData($file)
{
    global $agent_cls, $company_cls;
    $message = array();
    $xml = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);
    $xml_ar = json_decode(json_encode((array)$xml), 1);
    //print_r($xml_ar); return true;
    foreach ($xml_ar as $key => $val) {
        switch ($key) {
            /*commercial |
             land |
             rental |
             holidayRental |
             residential |
             rural*/
            case 'commercial':
            case 'land':
            case 'rental':
                //case 'holidayRental':
            case 'residential':
            case 'rural':
                if (is_array($val) && count($val) > 0) {
                    $listing = array();
                    if (empty($val[0]) || !empty($val['uniqueID'])) {
                        $listing[0] = $val;
                    } else {
                        $listing = $val;
                    }
                    foreach ($listing as $_key => $property) {
                        if (is_array($property) && count($property) > 0) {
                            //print_r($property); continue;
                            $result = array('isValid' => true, 'message');
                            $attr_value = $property;
                            $uniqueID = $attr_value['uniqueID'];
                            $agentID = $attr_value['agentID'];
                            $clientID = $attr_value['clientID'];
                            try {
                                $status = $attr_value['@attributes']['status'];
                                /*status ( current | withdrawn | sold | offmarket | leased | deleted*/
                                if (!in_array($status, array('current'))) {
                                    // Change Status Property
                                    $changeProperty_result = ChangePropertyStatusReaxml($status, $uniqueID, $agentID);
                                    $message[] = '- Processing change property REA uniqueID#' . $uniqueID . ': ' . $changeProperty_result['message'] . '';
                                    continue;
                                }
                                $property_data = array();
                                $property_data['uniqueID'] = $uniqueID;
                                $property_data['agentID'] = $agentID;
                                /*AGENT - VENDOR*/
                                $vendorDetails = $attr_value['listingAgent'];
                                $agent_email = $vendorDetails['email'];
                                //if (in_array($key, array('rental'))) {
                                if (!empty($agent_email)) {
                                    $property_data['agent_users_main'][] = $vendorDetails;
                                } else {
                                    $vendorDetails = $attr_value['vendorDetails'];
                                    $listingAgent = $attr_value['listingAgent'];
                                    $agent_email = $vendorDetails['email'];
                                    if (empty($agent_email)) {
                                        if (empty($listingAgent['email'])) {
                                            foreach ($listingAgent as $listingAgent_key => $agent_ar) {
                                                if (is_array($agent_ar)) {
                                                    if (/*empty($agent_ar['agentID']) || empty($agent_ar['@attributes']['id']) ||*/
                                                        $listingAgent_key == 0
                                                    ) {
                                                        $property_data['agency'] = $agent_ar;
                                                        $agent_email = $agent_ar['email'];
                                                        $property_data['agent_users_main'][] = $agent_ar;
                                                    } else {
                                                        $property_data['agent_users'][] = $agent_ar;
                                                    }
                                                }
                                            }
                                        } else {
                                            $agent_email = $listingAgent['email'];
                                        }
                                    }
                                }
                                //$agent_email = 'a';
                                //print_r($agent_email);die();
                                if (!empty($agent_email)) {
                                    $vendor_row = $agent_cls->getRow('parent_id != 0 AND email_address = "' . $agent_email . '"');
                                    if (!empty($vendor_row) && is_array($vendor_row) && count($vendor_row) > 0) {
                                        $agent_row = $agent_cls->getRow('agent_id = ' . $vendor_row['parent_id']);
                                        $property_data['vendor_email'] = $agent_email;
                                        $property_data['vendor_id'] = $vendor_row['agent_id'];
                                    } else {
                                        $agent_row = $agent_cls->getRow('parent_id = 0 AND email_address = "' . $agent_email . '"');
                                        if (!empty($agent_row) && is_array($agent_row) && count($agent_row) > 0) {
                                        } else {
                                            /*$agent_row = array();
                                            $agent_email_l = explode('@',$agent_email);
                                            if(!empty($agent_email_l[1])){
                                                $agent_row = $agent_cls->getRow('parent_id = 0 AND email_address LIKE "%@' . $agent_email_l[1] . '"');
                                                if (!empty($agent_row) && is_array($agent_row) && count($agent_row) > 0) {
                                                    $property_data['agent_users'] =  $property_data['agent_users_main'];
                                                }
                                            }*/
                                            $agent_row = $agent_cls->getRow('SELECT ag.* FROM `agent` AS ag INNER JOIN `agent_company` AS ac ON ag.agent_id = ac.agent_id AND ac.clientID = "' . $clientID . '"', true);
                                            if (!empty($agent_row) && is_array($agent_row) && count($agent_row) > 0) {
                                                $property_data['agent_users'] = $property_data['agent_users_main'];
                                            }
                                        }
                                        //print_r($agent_cls->sql);die();
                                        //$agent_row = $agent_cls->getRow('email_address = "' . $agent_email . '"');
                                    }
                                }
                                //print_r($agent_row);die();
                                if (!empty($agent_row) && is_array($agent_row) && count($agent_row) > 0) {
                                    $property_data['agent_id'] = $agent_row['agent_id'];
                                    $property_data['agent_email'] = $agent_row['email_address'];
                                    //echo 'Adding property for Bidrhino Agent: ' . A_getFullName($agent_row['agent_id']) . ', ' . $agent_email . '';
                                } else {
                                    $result['isValid'] = false;
                                    $result['message'] = 'Not find Agent with email ' . $agent_email . ' in Bidrhino system.';
                                }
                                /*-------Set property Data-------*/
                                $property_data['reaxml_type'] = $key;
                                /*Auction Type*/
                                $auction_sales_options = PEO_getOptions('auction_sale');
                                $auction_sale_key = $key == 'rental' ? 'Rental Auction' : 'Property Auction';
                                $property_data['auction_sale'] = array_search($auction_sale_key, $auction_sales_options);
                                /*Property Kind*/
                                $kind_ar = PEO_getKind();
                                $property_data['kind'] = array_search('Residential', $kind_ar);
                                /*Property Type*/
                                $type_ar = $property_data['kind'] == 2 ? PEO_getOptions('property_type') : PEO_getOptions('property_type_commercial');
                                $category_name = $attr_value['category']['@attributes']['name'];
                                if (array_search('category_name', $type_ar)) {
                                    $property_data['type'] = array_search('category_name', $type_ar);
                                } else {
                                    $property_data['type'] = array_search('Other', $type_ar) ? array_search('Other', $type_ar) : key(array_slice($type_ar, -1, 1, TRUE));
                                }
                                /*Address*/
                                if (!empty($attr_value['address']['subNumber'])) {
                                    $property_data['address'] = $attr_value['address']['subNumber'] . '/' . $attr_value['address']['streetNumber'] . ' ' . $attr_value['address']['street'];
                                } else {
                                    $property_data['address'] = $attr_value['address']['streetNumber'] . ' ' . $attr_value['address']['street'];
                                }
                                /*Suburb*/
                                $property_data['suburb'] = $attr_value['address']['suburb'];
                                /*Post code*/
                                $property_data['postcode'] = $attr_value['address']['postcode'];
                                /*State*/
                                $property_data['state'] = $attr_value['address']['state'];
                                /*Country*/
                                $property_data['country'] = 1; //Australia
                                /*Parking*/
                                $property_data['parking'] = 0;
                                /*Price*/
                                $property_data['price'] = $attr_value['price'];
                                if (!empty($attr_value['rent'])) {
                                    $property_data['period'] = 60;
                                    if (!empty($attr_value['rent']["@attributes"]['period'])) {
                                        $period = $attr_value['rent']["@attributes"]['period'];
                                        if (in_array($period, array('week', 'weekly'))) {
                                            $property_data['period'] = 60;
                                        }
                                        if (in_array($period, array('month', 'monthly'))) {
                                            $property_data['period'] = 61;
                                        }
                                    }
                                    $property_data['price'] = $attr_value['rent'];
                                }
                                /*price View*/
                                $property_data['price_view'] = $attr_value['priceView'];
                                /*Bedrooms*/
                                $property_data['bedrooms'] = $attr_value['features']['bedrooms'];
                                /*Bathrooms*/
                                $property_data['bathrooms'] = $attr_value['features']['bathrooms'];
                                /*Land size & Unit*/
                                $property_data['land_size_number'] = $attr_value['landDetails']['area'];
                                $property_data['unit'] = 27;
                                $property_data['frontage'] = $attr_value['landDetails']['frontage'];
                                /*cartport*/
                                $property_data['car_space'] = $attr_value['features']['garages'];
                                /*cartspace*/
                                $property_data['car_port'] = $attr_value['features']['carports'];
                                /*Property description*/
                                $property_data['description'] = $attr_value['description'];
                                /*underoffer*/
                                if (strtolower($attr_value['underOffer']['@attributes']['value']) == 'no') {
                                    $property_data['underoffer'] = 0;
                                }
                                if (strtolower($attr_value['underOffer']['@attributes']['value']) == 'yes') {
                                    $property_data['underoffer'] = 1;
                                }
                                /*MEDIA*/
                                if (is_array($attr_value['images']) && count($attr_value['images']) > 0) {
                                    foreach ($attr_value['images']['img'] as $img_ar) {
                                        if (!empty($img_ar['@attributes']['url']) && filter_var($img_ar['@attributes']['url'], FILTER_VALIDATE_URL) !== FALSE) {
                                            $property_data['images'][] = $img_ar['@attributes']['url'];
                                        }
                                    }
                                }
                                if (is_array($attr_value['objects']) && count($attr_value['objects']) > 0) {
                                    foreach ($attr_value['objects'] as $key_object => $objects) {
                                        foreach ($objects as $key_object_number => $objects_value) {
                                            if (!empty($objects_value['@attributes']['url']) && filter_var($objects_value['@attributes']['url'], FILTER_VALIDATE_URL) !== FALSE) {
                                                $property_data['objects'][$key_object][] = $objects_value['@attributes']['url'];
                                            }
                                        }
                                    }
                                }
                                //print_r($attr_value);
                                //print_r($property_data);die();
                                if ($result['isValid']) {
                                    $addProperty_result = AddPropertyInSystem($property_data);
                                    if ($addProperty_result['property_id'] > 0) {
                                        $message[] = '- Processing success property REA uniqueID#' . $uniqueID . ': ';
                                        //$message[] = '' . implode("\r\n + ", $addProperty_result['message']) . '';
                                    } else {
                                        $message[] = '- Processing property REA uniqueID#' . $uniqueID . ':';
                                        //$message[] = '' . implode("\r\n + ", $addProperty_result['message']) . '';
                                        //print_r($addProperty_result['message']);
                                    }
                                    $message[] = $addProperty_result['message'];
                                } else {
                                    $message[] = '- Processing property REA uniqueID#' . $uniqueID . ': ' . $result['message'] . '';
                                }
                            } catch (Exception $er) {
                                $message[] = '- Can not processing property REA uniqueID#' . $uniqueID . '';
                                $message[] = $er->getMessage();
                            }
                        }
                    }
                }
                break;
            default:
                break;
        }
    }
    return $message;
}

function AddAgentUser($agent_user, $parent_id, $parent_email)
{
    global $config_cls, $agent_cls;
    if (!empty($agent_user['email'])) {
        $pw = "b1dr1n0";
        $agent_row = $agent_cls->getRow('email_address ="' . $agent_user['email'] . '"');
        $user_inc = 0;
        if (!empty($agent_row) && is_array($agent_row) && count($agent_row) > 0) {
            $message = ' + ' . $parent_email . ': Agent User ' . $agent_user['email'] . ' is exited;';
            return $message;
            //$user_inc++;
            //$pw .= $user_inc;
        }
        $user_data = array();
        $user_data['parent_id'] = $parent_id;
        $user_data['email_address'] = $agent_user['email'];
        $user_data['firstname'] = $agent_user['name'];
        $user_data['fullname'] = $agent_user['name'];
        $user_data['creation_time'] = date('Y-m-d H:i:s');
        $user_data['type_id'] = 7;
        $user_data['mobilephone'] = $agent_user['telephone'];
        $user_data['is_active'] = 1;

        $user_data['notify_email'] = 1;
        $user_data['notify_email_bid'] = 1;
        $user_data['notify_sms'] = 1;
        $user_data['notify_turnon_sms'] = 1;
        $confirm = encrypt($user_data['email_address']);
        $user_data['confirm'] = $confirm;
        //$pass_length = (int)$config_cls->getKey('general_customer_password_length');
        //$pw = strrand($pass_length > 0 ? $pass_length : 6);
        $user_data['password'] = encrypt($pw);
        $agent_cls->insert($user_data);
        //sendmail confirm
        $username = $user_data['firstname'] . ' ' . $user_data['lastname'] != '' ? 'member'
            : $user_data['firstname'] . ' ' . $user_data['lastname'];
        include_once ROOTPATH . '/modules/shorturl/inc/short_url.class.php';
        if (!isset($shortUrl_cls) || !($shortUrl_cls instanceof ShortUrl)) {
            $shortUrl_cls = new ShortUrl();
        }
        $url = ROOTURL . $shortUrl_cls->addShortUrl('/?module=agent&action=confirm&key=' . $confirm);
        $msg_active = 'Click link below to active your account :<a href="' . $url . '">' . $url . '</a>';
        $params_email = array('to' => array($user_data['email_address'], $parent_email, $config_cls->getKey('general_contact1_name')));
        $variables = array('[username]' => $username, '[email]' => $user_data['email_address'], '[password]' => $pw,
            '[link_active]' => $url,
            '[msg_active]' => $msg_active,
            '[key]' => $confirm,
            '[ROOTURL]' => ROOTURL);
        sendNotificationByEventKey('user_finished_account', $params_email, $variables);
        $message = ' + ' . $parent_email . ': Added Agent User ' . $user_data['email_address'];
        return $message;
    }
    return 'Email address is not valid';
}

function AddPropertyInSystem($property_data = array())
{
    global $media_cls, $property_media_cls, $property_cls, $package_property_cls, $property_package_payment_cls;
    $result = array('property_id' => 0, 'message' => array());
    if (is_array($property_data) && count($property_data) > 0) {
        // PROPERTY
        $bedrooms_options = array('0' => '0') + PEO_getOptions('bedrooms');
        $bedrooms = $property_data['bedrooms'];
        $property_data['bedroom'] = key(array_slice($bedrooms_options, -1, 1, TRUE));
        if (array_search($bedrooms, $bedrooms_options)) {
            $property_data['bedroom'] = array_search($bedrooms, $bedrooms_options);
        }
        $bathrooms_options = array('0' => '0') + PEO_getOptions('bathrooms');
        $bathrooms = $property_data['bathrooms'];
        $property_data['bathroom'] = key(array_slice($bathrooms_options, -1, 1, TRUE));
        if (array_search($bathrooms, $bathrooms_options)) {
            $property_data['bathroom'] = array_search($bathrooms, $bathrooms_options);
        }
        $data['land_size_number'] = $property_data['land_size_number'];
        $data['unit'] = $property_data['unit'];
        if (isset($data['unit']) && strlen($data['unit'])) {
            $rowo = $property_cls->getRow('SELECT * FROM ' . $property_cls->getTable('property_entity_option') . ' WHERE property_entity_option_id = ' . $data['unit'], true);
            if ($data['land_size_number'] > 0) {
                $property_data['land_size'] = $data['land_size_number'] . ' ' . $rowo['title'];
            } else {
                $property_data['land_size'] = '';
            }
        }
        $car_spaces = PEO_getOptions('car_spaces', array('0' => '0'));
        $car_space = $property_data['car_space'];
        $property_data['car_space'] = key(array_slice($car_spaces, -1, 1, TRUE));
        if (array_search($car_space, $car_spaces)) {
            $property_data['car_space'] = array_search($car_space, $car_spaces);
        }
        $car_ports = PEO_getOptions('garage_carport', array('0' => '0'));
        $car_port = $property_data['car_port'];
        $property_data['car_port'] = key(array_slice($car_ports, -1, 1, TRUE));
        if (array_search($car_port, $car_ports)) {
            $property_data['car_port'] = array_search($car_port, $car_ports);
        }
        $state_options = R_getOptions(COUNTRY_DEFAULT);
        /*act, nsw, nt, qld, sa, tas, vic or wa*/
        $state_options_ar = array(
            'act' => 'Australian Capital Territory',
            'nsw' => 'New South Wales',
            'nt' => 'Northern Territory',
            'qld' => 'Queensland',
            'sa' => 'South Australia',
            'tas' => 'Tasmania',
            'vic' => 'Victoria',
            'wa' => 'Western Australia',
        );
        $property_data['state'] = array_search($state_options_ar[strtolower($property_data['state'])], $state_options);
        $property_data['agent_active'] = 1;
        $property_data['active'] = 1;
        $property_data['pay_status'] = Property::PAY_COMPLETE;
        //
        $property_data['buynow_price'] = $property_data['price'];
        $property_data['advertised_price_from'] = $property_data['price'];
        $property_data['start_time'] = "5000-05-05 00:00:00";
        $property_data['end_time'] = "5000-06-06 00:00:00";
        try {
            // CHECK VALID PROPERTY
            if (!isValidPropertyInSystem($property_data)) {
                $result['message'][] = 'Property uniqueID#' . $property_data['uniqueID'] . ' is not valid';
                return $result;
            }
            // ADD AGENT USER
            if (!empty($property_data['agent_users']) && count($property_data['agent_users']) > 0) {
                $agent_id = $property_data['agent_id'];
                foreach ($property_data['agent_users'] as $agent_user) {
                    $result['message'][] = AddAgentUser($agent_user, $agent_id, $property_data['agent_email']);
                }
            }
            // AGENT MANAGEMENT
            if (!empty($property_data['vendor_id'])) {
                $property_data['agent_manager'] = $property_data['vendor_id'];
            }
            $row_property = $property_cls->getRow('uniqueID = "' . $property_data['uniqueID'] . '" AND agentID="' . $property_data['agentID'] . '"');
            //print_r($row_property);
            if (is_array($row_property) && count($row_property) > 0) {
                unset($property_data['agent_active']);
                unset($property_data['active']);
                unset($property_data['pay_status']);
                $property_id = $row_property['property_id'];
                //print_r($property_data);
                $property_cls->update($property_data, 'property_id=' . $row_property['property_id']);
                if ($property_cls->hasError()) {
                    $result['message'][] = 'Error update with property ID#' . $property_id;
                    $result['message'][] = $property_cls->getError();
                } else {
                    $result['message'][] = 'updated successful with property ID#' . $property_id;
                }
            } else {
                $property_cls->insert($property_data);
                $property_id = $property_cls->insertId();
                if (!$property_cls->hasError() && $property_id > 0) {
                    $result['message'][] = 'added successful with property ID#' . $property_id;
                    //$property_id = $property_cls->insertId();
                    //SET PAYMENT STORE
                    // ADD PACKAGE
                    $rows_ppg = $package_property_cls->getRows('1');
                    if (is_array($rows_ppg) && count($rows_ppg) > 0) {
                        foreach ($rows_ppg as $row_ppg) {
                            $ppp_data = array();
                            if ($property_data['reaxml_type'] == 'rental' && $row_ppg['name'] == 'Rental') {
                                $ppp_data['package_id'] = $row_ppg['package_id'];
                            }
                            if ($property_data['reaxml_type'] != 'rental' && $row_ppg['name'] == 'Black') {
                                $ppp_data['package_id'] = $row_ppg['package_id'];
                            }
                            if (!empty($ppp_data['package_id'])) {
                                $property_cls->update(array('package_id' => $ppp_data['package_id']), 'property_id = ' . $property_id);
                                $ppp_data['group_id'] = 20;
                                $ppp_data['property_id'] = $property_id;
                                $ppp_data['option_id'] = 0;
                                $ppp_data['pay_status'] = 2;
                                $ppp_data['payment_id'] = 0;
                                $property_package_payment_cls->insert($ppp_data);
                                $ppp_data['group_id'] = 21;
                                $property_package_payment_cls->insert($ppp_data);
                                break;
                            }
                        }
                    }
                    // ADD MEDIA
                    if (is_array($property_data['images']) && count($property_data['images']) > 0) {
                        foreach ($property_data['images'] as $url) {
                            $file_result = download_file($url);
                            if ($file_result['success']) {
                                $datas = array('file_name' => $file_result['url'], 'type' => 'photo', 'active' => 1);
                                $media_cls->insert($datas);
                                if (!$media_cls->hasError()) {
                                    $media_id = $media_cls->insertId();
                                    $datas = array('property_id' => $property_id, 'media_id' => $media_id);
                                    $property_media_cls->insert($datas);
                                }
                            }
                        }
                    }
                    // ADD TERM
                    $result['property_id'] = $property_id;
                    // SEND MAIL
                    //__paymentAlert($property_id, 0);
                } else {
                    $result['message'][] = 'Error Insert with property ID#' . $property_id;
                    $result['message'][] = $property_cls->getError();
                    //$result['message'][] = $property_cls->sql;
                }
            }
            /*UPDATE SLUG*/
            $result['message'][] = $property_data;
            updateSlugProperty($property_id);
            return $result;
        } catch (Exception $er) {
            $result['message'][] = $er->getMessage();
            $result['message'][] = $property_cls->sql;
        }
    }
    return $result;
}

/**
 *
 * @ method : __paymentAlert
 **/
function __paymentAlert($property_id = 0, $payment_id = 0)
{
    try {
        global $config_cls, $smarty, $property_cls;
        $from = $config_cls->getKey('general_contact_email');
        $to = array($config_cls->getKey('general_alert_post_email'));
        $msg = 'The property ID#{property_id} has just been posted to bidRhino.com';
        $data = array('contact_email' => $from);
        /* User Information */
        $agent_data = PE_getAgent(0, $property_id);
        $to[] = $agent_data['email_address'];
        $to[] = $config_cls->getKey('general_contact1_name');
        $to[] = 'test@bidrhino.com';
        $data['agent'] = $agent_data;
        $data['agent']['name'] = $agent_data['firstname'] . ' ' . $agent_data['lastname'];
        $data['agent']['address'] = $agent_data['street'] . ' ' . implode(' ', array($agent_data['suburb'], $agent_data['state_code'], $agent_data['other_state'], $agent_data['postcode'], $agent_data['country_name']));
        /* Package Information*/
        include_once ROOTPATH . '/modules/package/inc/package.php';
        $property_data = $property_cls->getRow('property_id = ' . $property_id);
        $data['property'] = $property_data;
        $data['property']['is_pay'] = (isset($property_data['pay_status']) && $property_data['pay_status'] == Property::PAY_COMPLETE) ? 1 : 0;
        $data['property']['full_address'] = PE_getAddressProperty($property_id);
        $data['property']['pro_kind'] = PEO_getKindName($property_data['kind']);
        $data['property']['package_price'] = showPrice(PA_getPrice(0, $property_id, $payment_id));
        $data['property']['package_id'] = $property_data['package_id'];
        $smarty->assign('data', $data);
        $package = __listPackageByPropertyId($property_id, $payment_id);
        $smarty->assign('packageData', $package);
        $message = $smarty->fetch(ROOTPATH . '/modules/payment/templates/emailtemplate.property.success_reaxml.tpl');
        $subject = str_replace('{property_id}', $property_id, $msg);
        sendEmail_func($from, $to, $message, $subject);
        /*when a service is purchased ( by anyone, buyer/vendor or Agent)*/
        //$params['property_id'] = $property_id;
        //$params['email_content'] = $message;
        //sendNotificationByEventKey('system_service_purchased', $params);
        /*when a property is posted to bidRhino (to be reviewed)*/
        //sendNotificationByEventKey('system_property_posted', $params);
    } catch (Exception $er) {
        $handle = fopen("php://stdout", "w");
        fwrite($handle, $er->getMessage());
        //print_r($er->getMessage());
        fclose($handle);
    }
}

function isValidPropertyInSystem($property_data = array())
{
    //print_r($property_data);
    if (is_array($property_data) && count($property_data) > 0) {
        $valid_fieds = array('agent_id', 'auction_sale', 'kind', 'type', 'address', 'suburb', 'postcode', 'state', 'country');
        $isValid = true;
        foreach ($valid_fieds as $field) {
            $isValid = $isValid && !empty($property_data[$field]) && (strlen(trim($property_data[$field])) > 0);
        }
        return $isValid;
    }
    return false;
}

function __changeReaStatusAction($property_id = 0, $new_status)
{
    global $property_cls;
    if ($property_id > 0 && !empty($new_status)) {
        $current_status = PE_getPropertyStatusREA_xml($property_id);
        $current_status = str_replace(' ', '-', $current_status);
        if ($new_status == 'sold' || $new_status == 'leased') {
            $property_cls->update(array('confirm_sold' => 1, 'stop_bid' => 1, 'scan' => 0, 'sold_time' => date('Y-m-d H:i:s')), 'property_id=' . $property_id);
        }
        if ($new_status == 'underoffer') {
            $pro_data = array('underoffer' => 1, 'confirm_sold' => 0, 'stop_bid' => 0, 'sold_time' => '0000-00-00 00:00:00');
            $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
        } else {
            $pro_data = array('underoffer' => 0);
            $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
        }
        if ($new_status == 'offmarket') {
            $pro_data = array('active' => 0);
            $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
        }
        if ($new_status == 'withdrawn') {
            $pro_data = array('withdrawn' => 1, 'active' => 0);
            $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
        } else {
            $pro_data = array('withdrawn' => 0);
            $property_cls->update($pro_data, 'property_id = ' . $property_id . '');
        }
        /*Sold or leased needs to change to current or under offer, withdrawn or offmarket*/
        if ($current_status == 'sold' || $current_status == 'leased') {
        }
        if ($current_status == 'current') {
        }
        $result = "Change status $new_status successful!";
        return $result;
    }
    return false;
}

function ChangePropertyStatusReaxml($status, $uniqueID, $agentID)
{
    global $property_cls;
    $result = array('message' => "Can not change $status| $uniqueID| $agentID ");
    if (!empty($status) && !empty($uniqueID) && !empty($agentID)) {
        $row_property = $property_cls->getRow('uniqueID = "' . $uniqueID . '" AND agentID="' . $agentID . '"');
        if (is_array($row_property) && count($row_property) > 0) {
            $property_id = $row_property['property_id'];
            $result['message'] = __changeReaStatusAction($property_id, $status);
        }
    }
    return $result;
}

function download_file($url)
{
    $result = array('success' => true, 'url' => '');
    if (empty($url)) {
        $result['success'] = false;
    }
    $path_ar = parse_url($url);
    //$path = str_replace("{$path_ar['scheme']}://{$path_ar['host']}", ROOTPATH . "/store/uploads/mediaREA", $url);
    $path = ROOTPATH . "/store/uploads/mediaREA/" . basename($url);
    $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    $path = str_replace('//', DIRECTORY_SEPARATOR, $path);
    $path = str_replace("\\\\", DIRECTORY_SEPARATOR, $path);
    if (@mkdir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    $newfilename = $path;
    $file = fopen($url, "rb");
    if ($file) {
        $newfile = fopen($newfilename, "wb+");
        if ($newfile) {
            while (!feof($file)) {
                fwrite($newfile, fread($file, 1024 * 8), 1024 * 8);
            }
            $result['url'] = "/store/uploads/mediaREA/" . basename($url);
        } else {
            $result['success'] = false;
        }
        if ($newfile) {
            fclose($newfile);
        }
    } else {
        $result['success'] = false;
    }
    if ($file) {
        fclose($file);
    }
    return $result;
}


