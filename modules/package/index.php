<?php
//ini_set('display_errors',1);
include_once 'inc/package.php';

//$message = '';
$action = getParam('action');
$action_arr = explode('-',$action);
$message = '';

switch ($action) {
    case 'list':
        if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
           redirect(ROOTURL.'/?module=package');
        }else{
           redirect(ROOTURL.'/?module=agent&action=login');
        }
        break;
    case 'next':
        /**/
        $packageId = 0;
        $property_id = getParam('property_id',0);
        if($property_id >0){
            $property_package_payment_cls->delete('property_id = ' . $property_id . ' AND pay_status !=' . Property::PAY_COMPLETE .' AND payment_id = 0');
        }
        $packages = $_POST['package'];
        unset($_SESSION['packages']);
        if(is_array($packages) && count($packages) > 0){
            foreach($packages as $group_id => $package){
                if(is_array($package) && count($package) > 0){
                    foreach($package as $_packageId => $val){
                        $_SESSION['packages']['package'][$group_id] = $_packageId;
                        if($packageId == 0) { $packageId = $_packageId; }
                        if($property_id > 0){
                            $package_payment_data = array();
                            $package_payment_data['group_id'] = $group_id;
                            $package_payment_data['package_id'] = $_packageId;
                            $package_payment_data['pay_status'] = 0;
                            $package_payment_data['option_id'] = 0;
                            $package_payment_data['property_id'] = $property_id;
                            $property_package_payment_cls->insert($package_payment_data);
                        }
                    }
                }
            }
        }
        $extra_options = $_POST['extra_options'];
        if(is_array($extra_options) && count($extra_options) > 0){
            foreach($extra_options as $group_id => $options){
                foreach($options as $option_id => $price){
                    $_SESSION['packages']['extra_options'][$group_id][] = $option_id;
                    if($property_id > 0){
                        $package_payment_data = array();
                        $package_payment_data['group_id'] = $group_id;
                        $package_payment_data['package_id'] = 0;
                        $package_payment_data['pay_status'] = 0;
                        $package_payment_data['option_id'] = $option_id;
                        $package_payment_data['property_id'] = $property_id;
                        $property_package_payment_cls->insert($package_payment_data);
                    }
                }
            }
        }
        $pay_status = 0 ;
        if($property_id  > 0){
            $property_row = $property_cls->getCRow(array('pay_status'),'property_id = '.$property_id);
            if (is_array($property_row) and count($property_row) > 0) {
                $pay_status = $property_row['pay_status'] ;
            }
            if($pay_status == Property::PAY_COMPLETE ){
                redirect(ROOTURL.'/?module=payment&action=option&type=extra-options&item_id='.$property_id);
                break;
            }
        }
        if ($packageId != 0){
            $encryptPackageId = new_encrypt($packageId);
            if (isset($_SESSION['agent']) and $_SESSION['agent']['id'] > 0) {
                if($property_id > 0){
                    $property_cls->update(array('package_id' => $packageId),'property_id = '.$property_id);
                    redirect(ROOTURL.'/?module=property&action=register&step=1&id='.$property_id.'&pid='.$encryptPackageId);
                }else{
                    redirect(ROOTURL.'/?module=property&action=register&pid='.$encryptPackageId);
                }
            }else{
                redirect(ROOTURL.'/index.php?module=agent&action=register-vendor&pid='.$encryptPackageId);
            }
        }else{
            $session_cls->setMessage('Please choose package.');
            if($property_id > 0)
                redirect(ROOTURL.'/?module=package');
            else
                redirect(ROOTURL.'/?module=package&property_id='.$property_id);
        }
        break;
    default:
        $property_id = getParam('property_id', 0);
        $payment_packages = array();
        $disable_ar = array();
        if ($property_id > 0) {
            //$property_package_payment_cls->delete('property_id = ' . $property_id . ' AND pay_status !=' . Property::PAY_COMPLETE .' AND payment_id = 0');
            //$rows = $property_package_payment_cls->getRows('property_id = ' . $property_id . ' AND pay_status =' . Property::PAY_COMPLETE);
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
        //get all package is in active
        _listPackage();
        break;
}
$message = $session_cls->getMessage();
$session_cls->setMessage('');

$smarty->assign('message',$message);
$smarty->assign('action',$action);
?>