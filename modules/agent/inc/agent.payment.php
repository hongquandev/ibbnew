<?php
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';
include_once ROOTPATH.'/modules/package/inc/package.php';
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH.'/modules/property/inc/property.php';

if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}

$agent_id = $_SESSION['agent']['parent_id'] == 0?$_SESSION['agent']['id']:$_SESSION['agent']['parent_id'];

/*$rows = $payment_store_cls->getRows('SELECT p.creation_time,
                                            p.package_id,
                                            p.amount,
                                            ap.date_from,
                                            ap.date_to
                                     FROM '.$payment_store_cls->getTable().' AS p
                                     LEFT JOIN '.$agent_payment_cls->getTable().' AS ap
                                     ON ap.store_id = p.id
                                     WHERE p.agent_id = '.$agent_id.'
                                     AND p.property_id = 0 AND p.banner_id = 0
                                     AND is_paid = 1',true);*/



//PAYMENT
$rows = $payment_store_cls->getRows('SELECT ap.package_id,
                                            ap.date_from,
                                            ap.date_to,
                                            ap.store_id,
                                            ap.creation_date
                                     FROM '.$agent_payment_cls->getTable().' AS ap
                                     WHERE ap.agent_id = '.$agent_id,true);
if (is_array($rows) and count($rows) > 0){
    foreach ($rows as $row){
        if ($row['store_id'] == 0){//free package
            if ($row['creation_date'] != '' || $row['creation_date'] != '0000-00-00 00:00:00' ){
                $dt = new DateTime($row['creation_date']);
                $row['time'] = $dt->format($config_cls->getKey('general_date_format'));
            }
            $row['value'] = showPrice_cent(0);
        }else{
            $store = $payment_store_cls->getCRow(array('amount','creation_time'),' id = '.$row['store_id']);
            $dt = new DateTime($store['creation_time']);
            $row['time'] = $dt->format($config_cls->getKey('general_date_format'));
            $row['value'] = showPrice_cent($store['amount']);
        }
        $package_info = PA_getPackage($row['package_id']);
        $dt1 = new DateTime($row['date_from']);
        $dt2 = new DateTime($row['date_to']);
        $row['description'] = $package_info.' ('.$dt1->format($config_cls->getKey('general_date_format')).' - '.$dt2->format($config_cls->getKey('general_date_format')).')';
        $data[] = $row;
    }
}
$smarty->assign('invoice',$data);

$array = array('title'=>array('name'=>'Package'),
               'expire'=>array('name'=>'Expire Date','fnc'=>'date'),
               'photo_num'=>array('name'=>'Photo upload'),
               'video_num'=>array('name'=>'Video upload'),
               'account_num'=>array('name'=>'No. of sub account(s)','fnc'=>'num'),
               'document_ids'=>array('name'=>'Document upload','fnc'=>'doc'),
               'can_comment'=>array('name'=>'Blog','fnc'=>'check'));
$package = $package_cls->getRow('SELECT p.*,
                                        (SELECT ap.date_to
                                         FROM '.$agent_payment_cls->getTable().' AS ap
                                         WHERE ap.agent_id = '.$agent_id."
                                         AND ap.date_from <= '".date('Y-m-d H:i:s')."' AND ap.date_to >= '".date('Y-m-d H:i:s')."'
                                         ) AS expire
                                 FROM ".$package_cls->getTable().' AS p
                                 WHERE p.package_id = (SELECT ap.package_id
                                                       FROM '.$agent_payment_cls->getTable().' AS ap
                                                       WHERE ap.agent_id = '.$agent_id."
                                                       AND ap.date_from <= '".date('Y-m-d H:i:s')."' AND ap.date_to >= '".date('Y-m-d H:i:s')."'
                                                       )"
                                ,true);
$data = array();
if (is_array($package) and count($package) > 0){
    foreach ($array as $k=>$arr){
        switch ($arr['fnc']){
            case 'date':
                $dt = new DateTime($package[$k]);
                $data[$arr['name']] = $dt->format($config_cls->getKey('general_date_format'));
                break;
            case 'check':
                $data[$arr['name']] = $package[$k] == 1?'<span class="icon check"></span>':'<span class="icon uncheck"></span>';
                break;
            case 'doc':
                if ($package[$k] != 'all'){
                    $doc_arr = DOC_getList();
                    $value_arr = explode(',',$package[$k]);
                    foreach ($value_arr as $item){
                        $data[$arr['name']] .= $doc_arr[$item].'<br />';
                    }
                }else{
                    $data[$arr['name']] = $package[$k];
                }
                break;
            case 'num':
                $data[$arr['name']] = strlen($package[$k]) > 0?(int)$package[$k]:'unlimited';
                break;
            default:
                $data[$arr['name']] = $package[$k];
                break;
        }

    }
    $smarty->assign('package_current',$data);
}
if (isSubmit()) {
    $package_id = (int)$_POST['package_id'][0] > 0?(int)$_POST['package_id'][0]:$package['package_id'];
    $package_arr = PK_getPackage($package_id);
    $time = (int)$_POST['time'][0] > 0?(int)$_POST['time'][0]:1;

    if ($_SESSION['agent']['id'] > 0) {
        if ($package_arr['price'] == 0){
             $payment_arr = $agent_payment_cls->getRow("SELECT agent_id, date_to
                                                        FROM ".$agent_payment_cls->getTable()."
                                                        WHERE payment_id
                                                                    IN (
                                                                    SELECT MAX(payment_id)
                                                                    FROM ".$agent_payment_cls->getTable()."
                                                                    GROUP BY agent_id
                                                                    )
                                                              AND agent_id = {$_SESSION['agent']['id']}",true);
             $current_date = new DateTime(date('Y-m-d'));
             if (is_array($payment_arr) and count($payment_arr) > 0){
                  $last_date = new DateTime($payment_arr['date_to']);
             }else{
                  $last_date = new DateTime('0000-00-00');
             }
             $date_from = $current_date < $last_date ? date('Y-m-d H:i:s', strtotime($payment_arr['date_to']))
                           : date('Y-m-d H:i:s');
             $agent_payment_cls->insert(array('store_id' => 0,
                                              'creation_date'=>date('Y-m-d H:i:s'),
                                              'package_id' => $package_id,
                                              'agent_id' => $_SESSION['agent']['id'],
                                              'date_from' => $date_from,
                                              'date_to' => date('Y-m-d H:i:s', strtotime($date_from." +{$time} month"))));
             $message = 'Your payment is successful !';
             $smarty->assign('message',$message);
        }else{
             $item_number = $payment_store_cls->_insert(array('package_id'=>$package_id,
                                             'package_price'=>$package_arr['price'],
                                             'agent_id'=>$_SESSION['agent']['id'],
                                             'amount'=>$package_arr['price'] * $time));
             redirect(ROOTURL.'?module=payment&action=option&type=agent&item_id='.$item_number);
        }

	} else{
        redirect(ROOTURL);
    }
}
//prepare Payment
$form_datas = $package;
$smarty->assign('form_datas',$form_datas);
$smarty->assign('package_tpl',PK_getPackageRegisterTpl());
$package_time = array('1'=>count($package) == 0?'Current month':'Next month',
                      '3'=>'Next 3 months',
                      '12'=>'Next 12 months');
$smarty->assign('package_time',$package_time);



?>