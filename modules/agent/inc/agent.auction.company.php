<?php
include_once 'company.php';
include_once 'agent.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

$form_data = $company_cls->getFields();
$row = $company_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
if (is_array($row) and count($row) > 0) {
    $form_data = $row;
}
//UPDATE INFORMATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = false;
    $data = array();
    if (isset($_POST) && count($_POST) > 0){
        foreach ($form_data as $key=>$val){
            if (isset($_POST[$key])){
                $form_data[$key] = $data[$key] = $company_cls->escape($_POST[$key]);
            }
        }
    }

    if ($data['country'] == 1) {
        $data['other_state'] = '';
    } else {
        $data['state'] = '';
    }

    if (!$error){
        if ($data['country'] == 1 && $agent_cls->invalidRegion(implode(' ', array_map('trim', array($data['suburb'], $data['state'], $data['postcode']))))) {
            $error = true;
            $message = 'Wrong suburb/postcode or state!';
        }
    }

    if (!$error){
        //insert or update banner
        if (isset($_SESSION['auction']) && strlen($_SESSION['auction'][$_SESSION['agent']['id']]['logo']) > 0) {
            if (is_file($form_data['logo'])){
                @unlink(ROOTPATH.$form_data['logo']);
            }
            $data['logo'] = $form_data['logo'] = $_SESSION['auction'][$_SESSION['agent']['id']]['logo'];
            unset($_SESSION['auction'][$_SESSION['agent']['id']]);
        }
        $data['website'] = str_replace(array('http://','https://'),array('',''),$data['website']);

        if(!empty($row['agent_id']) && $row['agent_id'] > 0){
            $company_cls->update($data,'agent_id='.$_SESSION['agent']['id']);
        }else{
            $data['agent_id'] = $_SESSION['agent']['id'];
            $company_cls->insert($data);
        }

        if ($company_cls->hasError()) {
            $message = $company_cls->getError();
        }else{
            $message = 'Updated successfully !';
        }
    }
}

$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('options_state',R_getOptions(COUNTRY_DEFAULT,array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('country_default',COUNTRY_DEFAULT)
?>