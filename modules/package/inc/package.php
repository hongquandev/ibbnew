<?php
ini_set('display_errors', 0);
include_once 'package.class.php';
include_once 'package_basic.class.php';
include_once 'package_banner.class.php';
include_once 'package_property.class.php';
include_once 'package_property_group.class.php';
include_once 'package_property_group_option.class.php';
include_once 'package_property_option.class.php';
include_once 'package_select_options.class.php';
if (!isset($package_cls) || !($package_cls instanceof Package)) {
    $package_cls = new Package();
}
if (!isset($package_basic_cls) || !($package_basic_cls instanceof Package_basic)) {
    $package_basic_cls = new Package_basic();
}
if (!isset($package_banner_cls) || !($package_banner_cls instanceof Package_banner)) {
    $package_banner_cls = new Package_banner();
}
if (!isset($package_property_cls) || !($package_property_cls instanceof Package_property)) {
    $package_property_cls = new Package_property();
}
if (!isset($package_property_group_cls) || !($package_property_group_cls instanceof Package_property_group)) {
    $package_property_group_cls = new Package_property_group();
}
if (!isset($package_property_option_cls) || !($package_property_option_cls instanceof Package_property_option)) {
    $package_property_option_cls = new Package_property_option();
}
if (!isset($package_property_group_option_cls) || !($package_property_group_option_cls instanceof Package_property_group_option)) {
    $package_property_group_option_cls = new Package_property_group_option();
}
if (!isset($package_option_cls) || !($package_option_cls instanceof Package_select_option)) {
    $package_option_cls = new Package_select_option();
}
/**
 * @ function : PA_getPackageByPropertyId
 * @ argument :
 * @ output :
 **/
function PA_getPackageByPropertyId_old($property_id = 0)
{
    global $package_cls, $property_cls;
    $row = $property_cls->getRow('SELECT pk.*
                                      FROM ' . $property_cls->getTable() . ' AS pro,
                                            ' . $package_cls->getTable() . ' AS pk
                                      WHERE pro.property_id = ' . $property_id . '
                                            AND pro.package_id = pk.package_id', true);
    if (is_array($row) && count($row) > 0) {
        return $row;
    }
    return array();
}

function PA_getPackageByPropertyId_bk($property_id = 0)
{
    global $package_property_cls,
           $property_cls,
           $package_property_group_option_cls,
           $package_property_option_cls,
           $package_property_group_cls;
    $optionIsActive = PA_getAllOptionActive(1);
    //render query to get option
    $options = array();
    foreach ($optionIsActive as $row) {
        if (strlen($row['code'])) {
            $options[] = '(SELECT po.value
                        FROM ' . $package_property_group_option_cls->getTable() . ' AS po
                        WHERE po.option_id = ' . $row['option_id'] . ' AND po.package_id = pk.package_id) AS ' . $row['code'];
        }
    }
    $row = $property_cls->getRow('SELECT pk.*,
                                      ' . implode(',', $options) . '
                                      FROM ' . $property_cls->getTable() . ' AS pro,
                                           ' . $package_property_cls->getTable() . ' AS pk
                                      WHERE pro.property_id = ' . $property_id . '
                                            AND pro.package_id = pk.package_id', true);
    if (is_array($row) && count($row) > 0) {
        return $row;
    }
    return array();
}

function PA_getPackageByPropertyId($property_id = 0)
{
    global $package_property_cls,
           $property_cls,
           $package_property_group_option_cls,
           $package_property_option_cls,
           $package_property_group_cls,
           $property_package_payment_cls;
    $optionIsActive = PA_getAllOptionActive(1);
    //render query to get option
    $options = array();
    foreach ($optionIsActive as $row) {
        if (strlen($row['code'])) {
            $options[] = '(SELECT po.value
                            FROM ' . $package_property_group_option_cls->getTable() . ' AS po
                            WHERE po.option_id = ' . $row['option_id'] . ' AND po.package_id = pk.package_id) AS ' . $row['code'];
        }
    }
    $row = $property_cls->getRow('SELECT pk.package_id,
                                          ' . implode(',', $options) . '
                                          FROM ' . $property_package_payment_cls->getTable() . ' AS pk
                                          WHERE pk.property_id = ' . $property_id . '
                                                AND `group_id` = (SELECT `group_id` FROM `' . $package_property_group_cls->getTable() . '` WHERE `name` = "bidRhino Packages")
                                                AND 1 ', true);
    //print_r($property_cls->sql);
    //print_r($row);die('123');
    if (is_array($row) && count($row) > 0) {
        return $row;
    }
    return array();
}

function PA_getAllOptionActive($has_system = 0)
{
    global $package_property_option_cls, $package_property_group_cls;
    $cond = $has_system ? '' : ' AND o.is_system = 0';
    $rows = $package_property_group_cls->getRows('SELECT o.code, o.option_id, g.group_id, o.is_system
                                                      FROM ' . $package_property_group_cls->getTable() . ' AS g
                                                      LEFT JOIN ' . $package_property_option_cls->getTable() . ' AS o
                                                      ON o.group_id = g.group_id AND o.is_active = 1 AND g.is_active = 1
                                                      ' . $cond, true);
    if (is_array($rows) and count($rows) > 0) {
        return $rows;
    }
    return null;
}

/**
 * @ function : PA_canUploadImage
 * @ argument : property_id
 * @ output :
 **/
function PA_canUploadImage_old($property_id = 0)
{
    $row = PA_getPackageByPropertyId($property_id);
    if (is_array($row) && count($row) > 0 && ($row['photo_num'] == 'all' || (int)$row['photo_num'] > 0)) {
        return true;
    }
    return false;
}

function PA_canUploadImage($property_id = 0)
{
    $row = PA_getPackageByPropertyId($property_id);
    if (is_array($row) && count($row) > 0 &&
        isset($row['photo_upload']) && (int)$row['photo_upload'] > 0
    ) {
        return true;
    }
    return false;
}

/**
 * @ function : PA_canUploadVideo
 * @ argument : property_id
 * @ output :
 **/
function PA_canUploadVideo_old($property_id = 0)
{
    $row = PA_getPackageByPropertyId($property_id);
    if (is_array($row) && count($row) > 0 && ($row['video_num'] == 'all' || (int)$row['video_num'] > 0)) {
        return true;
    }
    return false;
}

function PA_canUploadVideo($property_id = 0)
{
    $row = PA_getPackageByPropertyId($property_id);
    if (is_array($row) && count($row) > 0 &&
        isset($row['video_upload']) && (int)$row['video_upload'] > 0
    ) {
        return true;
    }
    return false;
}

/**
 * @ function : PA_getPackage
 * @ argument : package_id
 * @ output :
 **/
function PA_getPackage_old($package_id)
{
    global $package_cls;
    $row = $package_cls->getRow('package_id = ' . $package_id);
    if (is_array($row) && count($row) > 0) {
        return $row['title'];
    }
    return null;
}

function PA_getPackageDetail($package_id)
{
    global $package_property_cls,
           $package_property_group_option_cls;
    $optionIsActive = PA_getAllOptionActive(1);
    //render query to get option
    $options = array();
    foreach ($optionIsActive as $row) {
        if (strlen($row['code'])) {
            $code = $row['code'];
            if ($row['is_system']) {
                $code = $row['code'] . '_' . $row['group_id'];
            }
            $options[] = '(SELECT po.value
                        FROM ' . $package_property_group_option_cls->getTable() . ' AS po
                        WHERE po.option_id = ' . $row['option_id'] . ' AND po.package_id = pk.package_id) AS ' . $code;
        }
    }
    $row = $package_property_cls->getRow('SELECT pk.*,
                                      ' . implode(',', $options) . '
                                      FROM ' . $package_property_cls->getTable() . ' AS pk
                                      WHERE pk.package_id = ' . $package_id, true);
    if (is_array($row) && count($row) > 0) {
        return $row;
    }
    return null;
}

function PA_getPackage($package_id)
{
    $row = PA_getPackageDetail($package_id);
    if (is_array($row) && count($row) > 0) {
        return $row['name'];
    }
    return null;
}

/**
 * @ function : PA_getPackageOfID
 * @ argument : property_id
 * @ output :
 **/
function PA_getPackageOfID($property_id)
{
    /*global $package_cls, $property_cls;
    $row = $property_cls->getRow('SELECT pk.document_ids
                                  FROM '.$property_cls->getTable().' AS pro,
                                        '.$package_cls->getTable().' AS pk
                                  WHERE pro.property_id = '.$property_id.'
                                        AND pro.package_id = pk.package_id',true);

    if (is_array($row) and count($row)> 0){
        return $row;
    }
    return array();*/
    $document_id_str = PA_getDocumentIds($property_id);
    return array('document_ids' => implode(',', $document_id_str));
    /*$package_rows = PA_getPackageByPropertyId($property_id);
    if(is_array($package_rows) && count($package_rows) > 0){
        foreach($package_rows as $row){

        }
    }*/
}

/**
 * @ function :
 * @ argument :
 * @ output :
 **/
function PA_getGridAdmin($type)
{
    global $package_cls, $token;
    $rows = $package_cls->getRows("package_type = '$type'");
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as &$row) {
            $row['auction_type'] = PA_getAuctionType($row['property_type'], $row['for_agent']);
            $row['link_status'] = '?module=package&action=active-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_edit'] = '?module=package&action=edit-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_delete'] = '?module=package&action=delete-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
        }
    }
    return $rows;
}

function PA_getAuctionType($property_type, $for_agent = 0)
{
    $option = PEO_getOptionById($property_type);
    $title = $option['title'];
    if ($option['code'] == 'auction') {
        $title = $for_agent ? $option['title'] : 'Auction Live';
    }
    return $title;
}

function PA_getAuctionTypeId($property_type, $for_agent = 0)
{
    $auction_sale_ar = PEO_getAuctionSale();
    $id = $property_type;
    if ($property_type == $auction_sale_ar['auction']) {
        $id = $for_agent ? $auction_sale_ar['auction'] : Property::OPTION_AUCTION_LIVE;
    }
    return $id;
}

/**
 * @ function : PABasic_getInfo
 * @ argument :
 * @ output : array
 * ---------------
 * Package Basic
 **/
function PABasic_getInfo()
{
    global $package_basic_cls;
    $row = $package_basic_cls->getRow('1');
    return $row;
}

/**
 * @ function : PA_getPrice
 * @ argument :
 * @ output :
 **/
function PA_getPrice_old($package_id = 0)
{
    global $package_cls;
    $row = $package_cls->getRow('package_id = ' . $package_id);
    if (is_array($row) && count($row) > 0) {
        return $row['price'];
    }
    return 0;
}

function PA_getPrice_byPackId($package_id = 0)
{
    global $package_property_group_cls;
    $row = PA_getPackageDetail($package_id);
    $total = 0;
    //get all group
    $group = $package_property_group_cls->getRows('is_active = 1');
    if (is_array($row) && count($row) > 0) {
        foreach ($group as $rowGroup) {
            $price = 0;
            if (strlen($row['special_price_' . $rowGroup['group_id']])) {
                $now = new DateTime(date('Y-m-d H:i:s'));
                if (strlen($row['special_price_from_' . $rowGroup['group_id']]) && strlen($row['special_price_to_' . $rowGroup['group_id']])) {
                    $from = new DateTime($row['special_price_from_' . $rowGroup['group_id']]);
                    $to = new DateTime($row['special_price_to_' . $rowGroup['group_id']] . ' 23:59:59');
                    $price = ($now >= $from and $now <= $to) ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
                } elseif (strlen($row['special_price_from_' . $rowGroup['group_id']])) {
                    $from = new DateTime($row['special_price_from_' . $rowGroup['group_id']]);
                    $price = $now >= $from ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
                } elseif (strlen($row['special_price_to_' . $rowGroup['group_id']])) {
                    $to = new DateTime($row['special_price_to_' . $rowGroup['group_id']] . ' 23:59:59');
                    $price = $now <= $to ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
                } else {
                    $price = $row['special_price_' . $rowGroup['group_id']];
                }
            } else {
                $price = $row['price_' . $rowGroup['group_id']];
            }
            $total += $price;
        }
        return $total;
    }
    return 0;
}

function PA_getPrice_byGroupPack($group_id = 0, $package_id = 0)
{
    $row = PA_getPackageDetail($package_id);
    $rowGroup = array('group_id' => $group_id);
    if (is_array($row) && count($row) > 0) {
        if (!empty($row['special_price_' . $rowGroup['group_id']])) {
            $now = new DateTime(date('Y-m-d H:i:s'));
            if (!empty($row['special_price_from_' . $rowGroup['group_id']]) && !empty($row['special_price_to_' . $rowGroup['group_id']])) {
                $from = new DateTime($row['special_price_from_' . $rowGroup['group_id']]);
                $to = new DateTime($row['special_price_to_' . $rowGroup['group_id']] . ' 23:59:59');
                $price = ($now >= $from and $now <= $to) ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
            } elseif (!empty($row['special_price_from_' . $rowGroup['group_id']])) {
                $from = new DateTime($row['special_price_from_' . $rowGroup['group_id']]);
                $price = $now >= $from ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
            } elseif (!empty($row['special_price_to_' . $rowGroup['group_id']])) {
                $to = new DateTime($row['special_price_to_' . $rowGroup['group_id']] . ' 23:59:59');
                $price = $now <= $to ? $row['special_price_' . $rowGroup['group_id']] : $row['price_' . $rowGroup['group_id']];
            } else {
                $price = $row['special_price_' . $rowGroup['group_id']];
            }
        } else {
            $price = $row['price_' . $rowGroup['group_id']];
        }
        return $price;
    }
    return 0;
}

function PA_getPrice($package_id = 0, $property_id = 0, $payment_id = 0)
{
    global $property_package_payment_cls, $package_property_option_cls;
    $total = 0;
    if ($property_id > 0) {
        if ($payment_id > 0) {
            $query = 'property_id = ' . $property_id . ' AND pay_status = ' . Property::PAY_COMPLETE . ' AND payment_id = ' . $payment_id;
        } else {
            $query = 'property_id = ' . $property_id . ' AND pay_status != ' . Property::PAY_COMPLETE . ' AND payment_id = 0';
        }
        $packages = $property_package_payment_cls->getRows($query);
        if (is_array($packages) && count($packages) > 0) {
            foreach ($packages as $data) {
                if ($data['group_id'] > 0 && $data['package_id'] > 0) {
                    $total += (float)PA_getPrice_byGroupPack($data['group_id'], $data['package_id']);
                }
                if ($data['option_id'] > 0) {
                    $row = $package_property_option_cls->getRow('option_id = ' . $data['option_id'] . ' AND group_id = ' . $data['group_id']);
                    if ((float)$row['price'] > 0) {
                        $total += (float)$row['price'];
                    }
                }
            }
        }
        return $total;
    } else {
        return PA_getPrice_byPackId($package_id);
    }
}

/**
 * @ function : PABasic_getPrice
 * @ argument :
 * @ output :
 **/
function PABasic_getPrice($args = array('home', 'focus', 'bid', 'make_an_offer', 'banner_notification_email'))
{
    global $package_basic_cls;
    $row = $package_basic_cls->getRow('1');
    $price = 0;
    if (is_array($row) && count($row) > 0 && count($args) > 0) {
        foreach ($args as $val) {
            $price += $row[$val];
        }
    }
    return $price;
}

/**
 * @ function : PABanner_getPrices
 * @ argument :
 * @ output :
 **/
function PABanner_getPrices($args = array('property_type_id' => 0, 'area' => 0, /*'position' => 0, */
    'page_id_ar' => array(), 'country_id' => 0, 'state_id' => 0, 'days' => 1))
{
    $price = 0;
    if (is_array($args['page_id_ar']) && count($args['page_id_ar']) > 0) {
        /*
        $args_temp = $args;
        foreach ($args['page_id_ar'] as $page_id) {
            $page_id = (int)$page_id;
            $args_ = $args_temp;
            //unset($args_['page_id_ar']);
            $args_['page_id'] = $page_id;
            $price += PABanner_getPrice($args_);
        }
        */
        $price = count($args['page_id_ar']) * PABanner_getPrice($args);
    }
    return $price;
}

/**
 * @ function : PABanner_getPrice
 * @ argument :
 * @ output :
 **/
function PABanner_getPrice($args = array('property_type_id' => 0, 'area' => 0, /*'position' => 0, */
    'page_id' => 0, 'country_id' => 0, 'state_id' => 0, 'days' => 1))
{
    global $package_banner_cls;
    $wh_ar = array();
    if (is_array($args) && count($args) > 0) {
        if ($args['property_type_id'] > 0) {
            $wh_ar[] = '(property_type_id = ' . $args['property_type_id'] . ')';
        }
        if ($args['area'] > 0) {
            $wh_ar[] = 'area = ' . $args['area'];
        }
        //if ($args['position'] > 0 && $args['area'] != 1) {// RIGHT IGNORE
        //$wh_ar[] = 'position = '.$args['position'];
        //}
        //if ($args['page_id'] > 0) {
        //$wh_ar[] = 'page_id = '.$args['page_id'];
        //}
        //if ($args['country_id'] > 0) {
        $wh_ar[] = 'country_id = ' . $args['country_id'];
        //}
        if ($args['state_id'] > 0) {
            $wh_ar[] = 'state_id = ' . $args['state_id'];
        }
    }
    $wh_ar[] = ' active = 1';
    $wh_str = 1;
    if (count($wh_ar) > 0) {
        $wh_str = implode(' AND ', $wh_ar);
    }
    $row = $package_banner_cls->getRow($wh_str);
    if (is_array($row) && count($row) > 0) {
        return $args['days'] * $row['price'];
    }
    return 0;
}

/**
 * @ function :
 * @ argument :
 * @ output :
 **/
function PABanner_getGridAdmin()
{
    global $package_banner_cls, $token;
    $rows = $package_banner_cls->getRows();
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as &$row) {
            $row['link_status'] = '?module=package&action=active-banner&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_edit'] = '?module=package&action=edit-banner&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_delete'] = '?module=package&action=delete-banner&package_id=' . $row['package_id'] . '&token=' . $token;
        }
    }
    return $rows;
}

function PK_getPackageRegisterTpl($layout = 'list')
{
    global $package_cls, $smarty;
    $rs = '';
    $rows = $package_cls->getRows('package_type = \'register\'  AND active = 1 ORDER BY `order` ASC');
    $array = array('title' => array('name' => 'Package'),
        'photo_num' => array('name' => 'Photo upload'),
        'video_num' => array('name' => 'Video upload'),
        'account_num' => array('name' => 'No. of sub account(s)', 'fnc' => 'num'),
        'document_ids' => array('name' => 'Document upload', 'fnc' => 'doc'),
        'can_comment' => array('name' => 'Blog', 'fnc' => 'check'));
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            $row['price'] = $row['price'] > 0 ? '$' . number_format($row['price'], 0, ',', '') : 'Free';
            foreach ($row as $k => $val) {
                switch ($array[$k]['fnc']) {
                    case 'check':
                        $row[$k] = $row[$k] == 1 ? '<span class="icon check"></span>' : '<span class="icon uncheck"></span>';
                        break;
                    case 'doc':
                        if ($row[$k] != 'all') {
                            $doc_arr = DOC_getList();
                            $value_arr = explode(',', $row[$k]);
                            $row[$k] = '';
                            foreach ($value_arr as $item) {
                                $row[$k] .= $doc_arr[$item] . '<br />';
                            }
                        }
                        break;
                    case 'num':
                        $row[$k] = strlen($row[$k]) > 0 ? (int)$row[$k] : 'unlimited';
                        break;
                    default:
                        break;
                }
            }
            $data[] = $row;
        }
        $smarty->assign('package_data', $data);
        $smarty->assign('layout', $layout);
        $rs = $smarty->fetch(ROOTPATH . '/modules/package/templates/package.register.tpl');
    }
    return $rs;
}

function PK_getPackage($package_id)
{
    global $package_cls;
    $row = $package_cls->getRow('package_id = ' . $package_id);
    if (is_array($row) and count($row) > 0) {
        return $row;
    }
    return null;
}

function getOptionsType()
{
    $options_type = array('' => '-Select Type-',
        'text' => 'Text Field',
        'textarea' => 'Text Area',
        'date' => 'Date',
        'boolean' => ' Yes/No',
        'multiselect' => 'Multi Select',
        'select' => 'Drop down',
        'price' => 'Price');
    return $options_type;
}

function PPN_hasOption($package_id = 0, $option_id = 0)
{
    global $package_property_group_option_cls;
    $row = $package_property_group_option_cls->getRow('package_id = ' . $package_id . ' AND option_id = ' . $option_id);
    if (is_array($row) and count($row) > 0) {
        return $row['entity_id'];
    }
    return 0;
}

function PPN_getGridAdmin($type)
{
    global $package_cls, $token;
    $rows = $package_cls->getRows("package_type = '$type'");
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as &$row) {
            $row['auction_type'] = PA_getAuctionType($row['property_type'], $row['for_agent']);
            $row['link_status'] = '?module=package&action=active-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_edit'] = '?module=package&action=edit-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
            $row['link_delete'] = '?module=package&action=delete-' . $type . '&package_id=' . $row['package_id'] . '&token=' . $token;
        }
    }
    return $rows;
}

function adjustBrightness($hex, $steps)
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));
    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    // Get decimal values
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    return '#' . $r_hex . $g_hex . $b_hex;
}

function PPN_getGradientCss($color)
{
    $lighterColor = adjustBrightness($color, 40);
    return 'background-color: ' . $color . ';
                background: -moz-linear-gradient(' . $color . ', ' . $lighterColor . ');
                background: -webkit-linear-gradient(' . $color . ', ' . $lighterColor . ');
                background: -o-linear-gradient(' . $color . ', ' . $lighterColor . ');
                background: -moz-linear-gradient(' . $color . ', ' . $lighterColor . ');
                background: linear-gradient(' . $color . ', ' . $lighterColor . ');
                filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr=\'' . $color . '\', endColorstr=\'' . $lighterColor . '\',GradientType=0 )!important /* IE6-9 */;';
}

function PA_getDocumentIds($property_id = 0)
{
    global $document_cls;
    $documentIds = array();
    $row = PA_getPackageByPropertyId($property_id);
    $document_rows = $document_cls->getRows();
    if (is_array($document_rows) && count($row) > 0) {
        foreach ($document_rows as $document) {
            if (isset($row[$document['key']]) && $row[$document['key']]) {
                $documentIds[] = $document['document_id'];
            }
        }
    }
    return $documentIds;
}

function _listPackageExtraOptions()
{
    global $package_property_cls,
           $package_property_group_option_cls,
           $package_property_option_cls,
           $package_property_group_cls,
           $smarty;
    $data = $package_property_cls->getRows("SELECT
                                                       g.name AS group_name,
                                                       g.group_id,
                                                       g.is_extra_group,
                                                       o.name AS option_name,
                                                       o.type,
                                                       o.code,
                                                       o.option_id,
                                                       o.has_unit,
                                                       o.unit,
                                                       o.price,
                                                       o.description
                                        FROM " . $package_property_option_cls->getTable() . ' AS o
                                        LEFT JOIN ' . $package_property_group_cls->getTable() . ' AS g
                                        ON g.group_id = o.group_id AND g.is_active = 1
                                        WHERE o.is_active = 1 AND g.is_extra_group = 1
                                        ORDER BY o.order ASC', true);
    $packageData = array();
    if (is_array($data) and count($data) > 0) {
        foreach ($data as $package) {
            if ($package['group_id'] > 0) {
                if (!isset($packageData[$package['group_id']])) {
                    $packageData[$package['group_id']] = array('data' => array(),
                        'options' => array(),
                        'is_extra_group' => $package['is_extra_group'],
                        'packages' => array());
                }
                $packageData[$package['group_id']]['data'] = array('name' => $package['group_name']);
            }
            if (!in_array($package['code'], array('price', 'special_price', 'special_price_from', 'special_price_to'))) {
                if (!isset($packageData[$package['group_id']]['options'][$package['option_id']])) {
                    $packageData[$package['group_id']]['options'][$package['option_id']] = array('name' => $package['option_name'],
                        'code' => $package['code'],
                        'type' => $package['type'],
                        'price' => $package['price'],
                        'description' => $package['description'],
                        'price_formatted' => showPrice_cent($package['price'])
                    );
                }
            }
        }
    }
    return $packageData;
}

function _listPackage()
{
    global $package_property_cls,
           $package_property_group_option_cls,
           $package_property_option_cls,
           $package_property_group_cls,
           $smarty;
    $data = $package_property_cls->getRows("SELECT p.*,
                                                       g.name AS group_name,
                                                       g.group_id,
                                                       g.is_extra_group,
                                                       o.name AS option_name,
                                                       o.type,
                                                       o.code,
                                                       o.option_id,
                                                       o.has_unit,
                                                       o.unit,
                                                       o.price,
                                                       o.description,
                                                       po.value
                                        FROM " . $package_property_cls->getTable() . ' AS p
                                        LEFT JOIN ' . $package_property_group_option_cls->getTable() . ' AS po
                                        ON po.package_id = p.package_id
                                        LEFT JOIN ' . $package_property_option_cls->getTable() . ' AS o
                                        ON o.option_id = po.option_id
                                        LEFT JOIN ' . $package_property_group_cls->getTable() . ' AS g
                                        ON g.group_id = o.group_id
                                        WHERE p.is_active = 1 AND o.is_active = 1 AND g.is_active = 1 AND g.is_extra_group = 0
                                        ORDER BY p.order ASC, g.order ASC, o.order ASC', true);
    $packageData = array();
    $onlyPackageData = array();
    $systemOptions = array();
    if (is_array($data) and count($data) > 0) {
        $tmp = array();
        foreach ($data as $package) {
            if ($package['group_id'] > 0) {
                if (!isset($packageData[$package['group_id']])) {
                    $packageData[$package['group_id']] = array('data' => array(),
                        'options' => array(),
                        'is_extra_group' => $package['is_extra_group'],
                        'packages' => array());
                }
                $packageData[$package['group_id']]['data'] = array('name' => $package['group_name']);
            }
            if ($package['package_id'] > 0) {
                if (!isset($onlyPackageData[$package['package_id']])) {
                    $onlyPackageData[$package['package_id']] = array('name' => $package['name'],
                        'color' => $package['color'],
                        'gradient' => PPN_getGradientCss($package['color']),
                        'total' => 0);
                }
            }
            //$onlyPackageData[$package['package_id']]['total'] +=
            if (!in_array($package['code'], array('price', 'special_price', 'special_price_from', 'special_price_to'))) {
                if (!isset($packageData[$package['group_id']]['options'][$package['option_id']])) {
                    $packageData[$package['group_id']]['options'][$package['option_id']] = array('name' => $package['option_name'],
                        'code' => $package['code'],
                        'type' => $package['type'],
                        'price' => $package['price'],
                        'description' => $package['description'],
                        'price_formatted' => showPrice_cent($package['price'])
                    );
                }
                //format
                switch ($package['type']) {
                    case 'boolean':
                        $value = '<span class="option-' . $package['value'] . '"></span>';
                        break;
                    case 'price':
                        $value = strlen($package['value']) ? showPrice_cent($package['value']) : '-';
                        break;
                    case 'select':
                    case 'multiselect':
                        $valueAr = explode(',', $package['value']);
                        $list = PPO_getOptionsFromCode($package['code']);
                        $listAr = array();
                        foreach ($valueAr as $v) {
                            if (isset($list[$v])) {
                                $listAr[] = $list[$v];
                            }
                        }
                        $value = implode('<br />', $listAr);
                        if ($package['type'] == 'select' && $package['has_unit']) {
                            $value .= ' ' . $package['unit'];
                        }
                        break;
                    default:
                        $value = $package['value'];
                        if ($package['has_unit']) {
                            $value .= ' ' . $package['unit'];
                        }
                        break;
                }
                $packageData[$package['group_id']]['options'][$package['option_id']]['packages'][$package['package_id']] = $value;
            } else {
                $systemOptions[$package['group_id']][$package['code']] = $package['option_id'];
                if (in_array($package['code'], array('price', 'special_price'))) {
                    if (!isset($packageData[$package['group_id']]['price'][$package['option_id']])) {
                        $packageData[$package['group_id']]['price'][$package['option_id']] = array('name' => $package['option_name'],
                            'code' => $package['code'],
                            'type' => $package['type']
                        );
                    }
                    $packageData[$package['group_id']]['price'][$package['option_id']]['packages'][$package['package_id']] = strlen($package['value']) ? showPrice_cent($package['value']) : '--';
                }
                $tmp[$package['group_id']][$package['package_id']][$package['code']] = $package['value'];
            }
        }
        //sum price package
        foreach ($tmp as $group_id => $package) {
            foreach ($package as $package_id => $pk) {
                $price = 0;
                if (strlen($pk['special_price'])) {
                    $now = new DateTime(date('Y-m-d H:i:s'));
                    if (strlen($pk['special_price_from']) && strlen($pk['special_price_to'])) {
                        $from = new DateTime($pk['special_price_from']);
                        $to = new DateTime(date('Y-m-d', strtotime($pk['special_price_to'])) . ' 23:59:59');
                        $price = ($now >= $from and $now <= $to) ? $pk['special_price'] : $pk['price'];
                    } elseif (strlen($pk['special_price_from'])) {
                        $from = new DateTime($pk['special_price_from']);
                        $price = $now >= $from ? $pk['special_price'] : $pk['price'];
                    } elseif (strlen($pk['special_price_to'])) {
                        $to = new DateTime(date('Y-m-d', strtotime($pk['special_price_to'])) . ' 23:59:59');
                        $price = $now <= $to ? $pk['special_price'] : $pk['price'];
                    } else {
                        $price = $pk['special_price'];
                    }
                } else {
                    $price = $pk['price'];
                }
                if ($price === $pk['price']) {
                    if (strlen(trim($systemOptions[$group_id]['special_price'])) > 0)
                        $packageData[$group_id]['price'][$systemOptions[$group_id]['special_price']]['packages'][$package_id] = '--';
                }
                $onlyPackageData[$package_id]['group'][$group_id]['total'] += $price;
                $onlyPackageData[$package_id]['group'][$group_id]['format_total'] = showPrice_cent($onlyPackageData[$package_id]['group'][$group_id]['total']);
                $onlyPackageData[$package_id]['total'] += $price;
                $onlyPackageData[$package_id]['format_total'] = showPrice_cent($onlyPackageData[$package_id]['total']);
            }
        }
    }
    //print_r($packageData);
    //print_r($onlyPackageData);
    $extra_options = _listPackageExtraOptions();
    $smarty->assign('data', $packageData + $extra_options);
    $smarty->assign('package', $onlyPackageData);
    $smarty->assign('totalPackage', count($onlyPackageData));
    $smarty->assign('next_action', ROOTURL . '/?module=package&action=next');
}

function PA_isUniqueCode($option = array())
{
    global $package_property_option_cls;
    if (isset($option['is_system']) && $option['is_system'] == 1 && isset($option['group_id'])) {
        $row = $package_property_option_cls->getRow('code = \'' . $option['code'] . '\' AND group_id = ' . $option['group_id']);
    } else {
        $row = $package_property_option_cls->getRow('code = \'' . $option['code'] . '\'');
    }
    if (is_array($row) and count($row) > 0) {
        if (isset($option['option_id']) && $row['option_id'] == $option['option_id']) {
            return true;
        }
        return false;
    }
    return true;
}

function __listPackageByPropertyId($property_id = 0, $payment_id = 0)
{
    global $package_property_cls,
           $package_property_group_option_cls,
           $package_property_option_cls,
           $package_property_group_cls,
           $property_package_payment_cls,
           $smarty;
    $packages_group = array();
    try {
        if ($property_id > 0) {
            if ($payment_id > 0) {
                $query = 'property_id = ' . $property_id . ' AND pay_status =' . Property::PAY_COMPLETE . ' AND payment_id = ' . $payment_id;
            } else {
                $query = 'property_id = ' . $property_id . ' AND pay_status =' . Property::PAY_COMPLETE . '';
            }
            $datas = $property_package_payment_cls->getRows($query);
            if (is_array($datas) && count($datas) > 0) {
                foreach ($datas as $data) {
                    if ($data['group_id'] > 0) {
                        $group_data = $package_property_group_cls->getRow('group_id = ' . $data['group_id']);
                        $packages_group[$data['group_id']]['name'] = $group_data['name'];
                        if ($data['package_id'] > 0) {
                            $packages_group[$data['group_id']]['price'] = PA_getPrice_byGroupPack($data['group_id'], $data['package_id']);
                            $packages_group[$data['group_id']]['price_formatted'] = showPrice_cent($packages_group[$data['group_id']]['price']);
                            $data_package = $package_property_cls->getRows("SELECT p.*,
                                                                   g.name AS group_name,
                                                                   g.group_id,
                                                                   o.name AS option_name,
                                                                   o.type,
                                                                   o.code,
                                                                   o.option_id,
                                                                   o.has_unit,
                                                                   o.unit,
                                                                   o.description,
                                                                   po.value
                                                    FROM " . $package_property_cls->getTable() . ' AS p
                                                    LEFT JOIN ' . $package_property_group_option_cls->getTable() . ' AS po
                                                    ON po.package_id = p.package_id
                                                    LEFT JOIN ' . $package_property_option_cls->getTable() . ' AS o
                                                    ON o.option_id = po.option_id
                                                    LEFT JOIN ' . $package_property_group_cls->getTable() . ' AS g
                                                    ON g.group_id = o.group_id
                                                    WHERE p.is_active = 1 AND o.is_active = 1
                                                    AND g.is_active = 1
                                                    AND p.package_id = \'' . $data['package_id'] . '\'
                                                    AND g.group_id = \'' . $data['group_id'] . '\'
                                                    ORDER BY p.order ASC, g.order ASC, o.order ASC', true);
                            if (is_array($data_package) && count($data_package) > 0) {
                                foreach ($data_package as $package) {
                                    $packages_group[$data['group_id']]['package_name'] = $package['name'];
                                    if (!in_array($package['code'], array('price', 'special_price', 'special_price_from', 'special_price_to'))) {
                                        //format
                                        switch ($package['type']) {
                                            case 'boolean':
                                                $value = $package['value'] ? 'Yes' : 'No';
                                                break;
                                            case 'price':
                                                $value = strlen($package['value']) ? showPrice_cent($package['value']) : '-';
                                                break;
                                            case 'select':
                                            case 'multiselect':
                                                $value = $package['value'];
                                                break;
                                            default:
                                                $value = $package['value'];
                                                if ($package['has_unit']) {
                                                    $value .= $package['unit'];
                                                }
                                                break;
                                        }
                                        $packages_group[$data['group_id']]['options'][] = array('name' => $package['option_name'],
                                            'code' => $package['code'],
                                            'type' => $package['type'],
                                            'value' => $value,
                                            'value_html' => $package['option_name'] . ': ' . $value,
                                            'price' => '',
                                            'price_formatted' => ''
                                        );
                                    }
                                }
                            }
                        }
                        if ($data['option_id'] > 0) {
                            $data_option = $package_property_option_cls->getRow('option_id = ' . $data['option_id']);
                            $packages_group[$data['group_id']]['options'][] = array('name' => $data_option['name'],
                                'code' => $data_option['code'],
                                'type' => $data_option['type'],
                                'description' => $data_option['description'],
                                'price' => $data_option['price'],
                                'value_html' => $data_option['name'] . ': ' . showPrice_cent($data_option['price']),
                                'price_formatted' => showPrice_cent($data_option['price'])
                            );
                            if (!isset($packages_group[$data['group_id']]['price'])) {
                                $packages_group[$data['group_id']]['price'] = 0;
                            }
                            $packages_group[$data['group_id']]['price'] += $data_option['price'];
                            $packages_group[$data['group_id']]['price_formatted'] = showPrice_cent($packages_group[$data['group_id']]['price']);
                        }
                    }
                }
            }
        }
    } catch (Exception $er) {
        //print_r($er->getMessage());
    }
    return $packages_group;
}

function PPO_getOptionsFromCode($code = '')
{
    global $package_property_option_cls, $package_option_cls;
    $list = $package_option_cls->getRows('SELECT *
                                      FROM ' . $package_option_cls->getTable() . ' AS l
                                      LEFT JOIN ' . $package_property_option_cls->getTable() . ' AS o
                                      ON o.option_id = l.option_id
                                      WHERE o.code = \'' . $code . '\'', true);
    $listAr = array();
    if (is_array($list) and count($list) > 0) {
        foreach ($list as $info) {
            $listAr[$info['entity_id']] = $info['label'];
        }
    }
    return $listAr;
}

function PA_hasPackage($property_id = 0)
{
    global $package_property_group_cls, $property_package_payment_cls, $package_property_option_cls;
    $check = false;
    if ($property_id > 0) {
        $query = 'property_id = ' . $property_id . ' ';
        $packages = $property_package_payment_cls->getRows($query);
        if (is_array($packages) && count($packages) > 0) {
            $check = true;
        }
    }
    return $check;
}

function PA_NewPackageFromId($property_id = 0, $new_property_id)
{
    global $property_package_payment_cls;
    if ($property_id > 0 && $new_property_id > 0) {
        $query = 'property_id = ' . $property_id . ' ';
        $packages = $property_package_payment_cls->getRows($query);
        if (is_array($packages) && count($packages) > 0) {
            foreach ($packages as $row) {
                $row['property_id'] = $new_property_id;
                $property_package_payment_cls->insert($row);
            }
        }
    }
}

?>