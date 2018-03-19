<?php
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';
include_once ROOTPATH.'/modules/package/inc/package.php';

_listPackage();
$form_data = $property_cls->getFields();
$form_data[$property_cls->id] = $property_id;
if ($property_id > 0){
    $form_data = $property_cls->getRow('property_id = '.$property_id);
}
$form_data['is_pay'] = (isset($form_data['pay_status']) && $form_data['pay_status'] == Property::PAY_COMPLETE)?1:0;
$form_data['package_price'] = (isset($form_data['package_id']) && $form_data['package_id'] > 0)?
                              PA_getPrice($form_data['package_id']):0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST)) {
        $data = $form_data;
        /*if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
            foreach ($form_data as $key => $val) {
                if (isset($_POST['fields'][$key])) {
                    $data[$key] = $property_cls->escape($_POST['fields'][$key]);
                } else {
                    unset($data[$key]);
                }
            }
        }*/
        /*PACKAGE*/
        if($property_id >0){
            $property_package_payment_cls->delete('property_id = ' . $property_id . ' AND pay_status !=' . Property::PAY_COMPLETE .' AND payment_id = 0');
        }
        $packages = $_POST['package'];
        if(is_array($packages) && count($packages) > 0){
            foreach($packages as $group_id => $package){
                if(is_array($package) && count($package) > 0){
                    foreach($package as $_packageId => $val){
                        if($packageId == 0) { $packageId = $_packageId; }
                        $package_payment_data = array();
                        $package_payment_data['group_id'] = $group_id;
                        $package_payment_data['package_id'] = $_packageId;
                        $package_payment_data['pay_status'] = 0;
                        $package_payment_data['option_id'] = 0;
                        $package_payment_data['property_id'] = $property_id;
                        $package_payment_data_package[] = $package_payment_data;
                        if($property_id > 0){
                            $package_payment_data['property_id'] = $property_id;
                            $property_package_payment_cls->insert($package_payment_data);
                        }
                    }
                }
            }
        }
        $data['package_id'] = $packageId;
        $extra_options = $_POST['extra_options'];
        if(is_array($extra_options) && count($extra_options) > 0){
            foreach($extra_options as $group_id => $options){
                foreach($options as $option_id => $price){
                    $package_payment_data = array();
                    $package_payment_data['group_id'] = $group_id;
                    $package_payment_data['package_id'] = 0;
                    $package_payment_data['pay_status'] = 0;
                    $package_payment_data['option_id'] = $option_id;
                    $package_payment_data_extra_options[] = $package_payment_data;
                    if($property_id > 0){
                        $package_payment_data['property_id'] = $property_id;
                        $property_package_payment_cls->insert($package_payment_data);
                    }
                }
            }
        }
        /*END PACKAGE*/
        //$switch = false;
        if ($form_data[$property_cls->id] > 0) { //edit
            $pro_row = $property_cls->getRow('property_id=' . $form_data[$property_cls->id]);
            $changed_data = false;
            foreach ($data as $key => $val){
                if (isset($pro_row[$key])) {
                    if ($data[$key] != $pro_row[$key]) {
                        $changed_data = true;
                        //break;
                    }
                    /*if ($data[$key] != $pro_row[$key] && $key == 'package_id') {
                        $switch = true;
                    }*/
                }
            }
            if ($changed_data) {
                $data['last_update_time'] = date('Y-m-d H:i:s');
            }
            //end

            /*if ($switch) {
                include_once ROOTPATH . '/modules/payment/inc/payment.php';
                $payment_store_cls->update(array('is_change' => 1), 'property_id = ' . (int)$form_data[$property_cls->id]);
                Property_transition_pending($form_data[$property_cls->id]);
            }*/

            if ($pro_row['pay_status'] != Property::PAY_COMPLETE){
                $property_cls->update($data, $property_cls->id . '=' . $form_data[$property_cls->id]);
                $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
                                            'Action' => 'UPDATE',
                                            'Detail' => "UPDATE PROPERTY ID :" . $property_id,
                                            'UserID' => $_SESSION['Admin']['EmailAddress'],
                                            'IPAddress' => $_SERVER['REMOTE_ADDR']
                                       ));
            }
        } else { //insert
            $data['admin_created'] = 1;
            $data['creation_date'] = date('Y-m-d H:i:s');
            $data['creation_datetime'] = date('Y-m-d H:i:s');
            $temp = Calendar_createTemp();
            $row_notify = $notification_cls->getRow("temp_id='" . $temp . "'");
            if (count($row_notify) > 0 and is_array($row_notify)) {
                $data['notify_inspect_time'] = $row_notify['notify_value'];
                $notification_cls->delete("temp_id='" . $temp . "'");
            }
            $property_cls->insert($data);
            $property_id = $property_cls->insertId();
            /*Save Package*/
            foreach($package_payment_data_package as $package_data){
                $package_data['property_id'] = $property_id;
                $property_package_payment_cls->insert($package_data);
            }
            foreach($package_payment_data_extra_options as $package_data){
                $package_data['property_id'] = $property_id;
                $property_package_payment_cls->insert($package_data);
            }
            /*END*/
            Calendar_update($property_id, $temp);
            // Write Logs
            $systemlog_cls->insert(array('Updated' => date("Y-m-d H:i:s"),
                                        'Action' => 'INSERT',
                                        'Detail' => "ADD NEW PROPERTY ID :" . $property_id,
                                        'UserID' => $_SESSION['Admin']['EmailAddress'],
                                        'IPAddress' => $_SERVER['REMOTE_ADDR']
                                   ));

        }
        // UPDATE NOTIFICATION TO ANDROID
		push(0, array('type_msg' => 'update-property'));

        $form_data = $data;
        extractDateTime($form_data['end_time'], $form_data);
        if ($property_cls->hasError()) {
            $message = $property_cls->getError();
            $form_data['is_pay'] = (isset($form_data['pay_status']) && $form_data['pay_status'] == Property::PAY_COMPLETE)?1:0;
            $form_data['package_price'] = (isset($form_data['package_id']) && $form_data['package_id'] > 0)?
                                          PA_getPrice($form_data['package_id']):0;
        } else {
            $message = $form_data[$property_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
            redirect(ROOTURLS . '/admin/?module=' . $module . '&action=edit-detail&property_id=' . $property_id . '&token=' . $token);
        }
    }
}
/* FORM PACKAGE*/
$payment_packages = array();
$disable_ar = array();
if ($property_id > 0) {
    $rows = $property_package_payment_cls->getRows('property_id = ' . $property_id );
    if (is_array($rows) && count($rows) > 0) {
        foreach ($rows as $row) {
            if($row['group_id'] > 0){
                if($row['package_id'] > 0){
                    $payment_packages['package'][$row['group_id']][$row['package_id']] = $row['pay_status'] ;
                    $disable_ar[$row['group_id']]  = "";
                    if($row['pay_status'] == Property::PAY_COMPLETE){
                        $disable_ar[$row['group_id']]  = "disabled='disabled'";
                    }
                }
                if($row['option_id'] > 0){
                    $payment_packages['extra_options'][$row['group_id']][$row['option_id']] = $row['pay_status'];
                }
            }
        }
    }
    $smarty->assign(array('payment_packages' => $payment_packages,
        'property_id' => $property_id,
        'disable_ar' => $disable_ar,
        'pay_complete' => Property::PAY_COMPLETE));
}
//END
$smarty->assign('form_data',formUnescapes($form_data));

?>