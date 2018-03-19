<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'partner.php';
include_once 'company.php';


//FOR PERSONAL SITE
$form_data['personal'] = $agent_cls->getFields();
$keysPer_arr= array();
$row = $agent_cls->getRow('SELECT a.*,l.logo
				FROM ' . $agent_cls->getTable() . ' AS a
				LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS l
				ON l.agent_id = a.agent_id
				WHERE a.agent_id = ' . $_SESSION['agent']['id'], true);

foreach ($row as $key => $val) {
    if(isset($form_data['personal'][$key])){
    }else{
        $keysPer_arr[] = $key;
    }
    $form_data['personal'][$key] = $val;
}

$row = $agent_site_cls->getRow('agent_id = '.$_SESSION['agent']['id']." AND type = 'agent'");
if (is_array($row) and count($row)> 0){
    $form_data['personal']['site'] = $row['name'];
    $form_data['personal']['site_id'] = $row['site_id'];
    $keysPer_arr[] = 'site';
    $keysPer_arr[] = 'site_id';
}else{
    $form_data['personal']['site'] = '';$form_data['personal']['site_id'] = '';
}

if ($_SESSION['agent']['type'] == 'partner'){
    $form_data['partner'] = $partner_cls->getFields();
    $row = $partner_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
    foreach ($form_data['partner'] as $key=>$val){
        if (strlen($row[$key]) > 0){
            $form_data['partner'][$key] = $row[$key];
        }
    }
}
if ($_SESSION['agent']['type'] == 'agent' || $_SESSION['agent']['type'] == 'theblock'){
    $form_data['company'] = $company_cls->getFields();
    $row = $company_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
    foreach ($form_data['company'] as $key=>$val){
        if (strlen($row[$key]) > 0){
            $form_data['company'][$key] = $row[$key];
        }
    }
}

//UPDATE INFORMATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = false;
    //$form_data = array();
    //$form_data['personal'] = $agent_cls->getFields();
    $type = array('field'=>'personal','partner'=>'partner','company'=>'company');
    foreach ($type as $k=>$t){
        if (isset($_POST[$k]) && isset($form_data[$t])) {
            foreach ($form_data[$t] as $key => $val) {
                if (isset($_POST[$k][$key])) {
                    $form_data[$t][$key] = $_POST[$k][$key];
                } else {
                    if ($key != 'logo' and $key != 'site'){
                        unset($form_data[$t][$key]);
                    }
                }
            }
        }
    }
    if (!$error) {
		if(isset($form_data['personal']) && $form_data['personal']['country'] == 1) {
		    if ($agent_cls->invalidRegion(trim($form_data['personal']['suburb']).' '.trim($form_data['personal']['state']).' '.trim($form_data['personal']['postcode']))) {
                    $error = true;
			        $message = 'Wrong suburb/postcode or state!';
		    }
		}
    }
    if (!$error){
        if (isset($form_data['personal']) && isset($form_data['personal']['email_address'])) {
            $row = $agent_cls->getRow("email_address = '".$form_data['personal']['email_address']."' AND agent_id != ".$_SESSION['agent']['id']);
			if (is_array($row) and count($row) > 0){
                $error = true;
                $message = 'Email existed!';
		    }
        }
    }
    if (!$error){
        if (isset($form_data['partner'])){
            if ($form_data['personal']['website_partner'] != '' && !isValidURL($form_data['personal']['website_partner'])){
                $error = true;
                $message = 'Invalid format website';
            }
            if($form_data['partner']['postal_country'] == 1) {
                if ($agent_cls->invalidRegion(trim($form_data['partner']['postal_suburb']).' '.trim($form_data['partner']['postal_state']).' '.trim($form_data['partner']['postal_postcode']))) {
                       $error = true;
                       $message = 'Wrong suburb/postcode or state postal!';
                }
		    }
        }
    }
	//unset($personal['creation_time'],$personal['type_id'],$personal['ip_address'],$personal['password']);
    $form_data['personal']['update_time'] = date('Y-m-d H:i:s');

    if ($form_data['personal']['country'] == 1) {
		$form_data['personal']['other_state'] = '';
    }else{
		$form_data['personal']['state'] = '';
    }

    if (isset($form_data['partner']) && isset($form_data['partner']['postal_country'])){
        if ($form_data['partner']['postal_country'] == 1){
            $form_data['partner']['postal_other_state'] = '';
        }else{
            $form_data['partner']['postal_state'] = '';
        }
    }

     if (isset($form_data['company']) && isset($form_data['company']['country'])){
        if ($form_data['company']['country'] == 1){
            $form_data['company']['other_state'] = '';
        }else{
            $form_data['company']['state'] = '';
        }
		
		$form_data['company']['description'] = scanContent($form_data['company']['description']);
    }
     // For contact Vendor
    $cont_vendor = $_POST['field']['allow_vendor_contact'];
    $cont_vendor = isset($cont_vendor) ? 1 : 0 ;
    $form_data['personal']['allow_vendor_contact'] = $cont_vendor;


    if (!$error){
        $agent_cls->update($form_data['personal'],'agent_id='.$_SESSION['agent']['id']);
        if ($_SESSION['agent']['type'] == 'partner'){
            $row = $partner_cls->getCRow(array('agent_id'),'agent_id = '.$_SESSION['agent']['id']);
            if (is_array($row) and count($row) > 0){
                $partner_cls->update($form_data['partner'],'agent_id = '.$_SESSION['agent']['id']);
            }else{
                $form_data['partner']['agent_id'] = $_SESSION['agent']['id'];
                $partner_cls->insert($form_data['partner']);
            }

        }
        if (in_array($_SESSION['agent']['type'],array('agent','theblock'))){
            $row = $company_cls->getCRow(array('agent_id'),'agent_id = '.$_SESSION['agent']['id']);
            if (is_array($row) and count($row) > 0){
                $company_cls->update($form_data['company'],'agent_id = '.$_SESSION['agent']['id']);
            }else{
                $form_data['company']['agent_id'] = $_SESSION['agent']['id'];
                $company_cls->insert($form_data['company']);
            }
        }
        if ($agent_cls->hasError()) {
            $message = $agent_cls->getError();
        }else{
            $_SESSION['agent']['firstname'] = $form_data['personal']['firstname'];
            $_SESSION['agent']['lastname'] = $form_data['personal']['lastname'];
            $fullname = $_SESSION['agent']['firstname'].' '.$_SESSION['agent']['lastname'];
            $fullname = strlen($fullname) > 55 ? safecontent($fullname,55).'...' : $fullname;
            $_SESSION['agent']['full_name'] = $fullname;
            if ($form_data['personal']['email_address'] != ''){
                $_SESSION['agent']['email_address'] = $form_data['personal']['email_address'];
            }
            $message = 'Updated successfully !';
        }


        //insert or update logo: NHUNG
        if (isset($_SESSION['block']) && strlen($_SESSION['block'][$_SESSION['agent']['id']]['logo']) > 0) {
            $row = $agent_logo_cls->getRow('agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($row) and count($row) > 0) {
                @unlink(ROOTPATH.$row['logo']);
                $agent_logo_cls->update(array('logo' => $_SESSION['block'][$_SESSION['agent']['id']]['logo']),
                                        'agent_id = ' . $_SESSION['agent']['id']);
            } else {
                $agent_logo_cls->insert(array('agent_id' => $_SESSION['agent']['id'],
                                             'logo' => $_SESSION['block'][$_SESSION['agent']['id']]['logo']));
            }
            $form_data['personal']['logo'] = $_SESSION['block'][$_SESSION['agent']['id']]['logo'];
            unset($_SESSION['block'][$_SESSION['agent']['id']]);

        }

        if ($form_data['personal']['site'] != ''){
            $check = Agent_checkExitsSite($_SESSION['agent']['id'],'agent');
            if (Agent_checkValidSite($form_data['personal']['site'],$check,$message)){
                if ( $check > 0){
                    $agent_site_cls->update(array('name'=>$form_data['personal']['site']),'site_id = '.$check);
                }else{
                    $agent_site_cls->insert(array('name'=>$form_data['personal']['site'],
                                                  'agent_id'=>$_SESSION['agent']['id'],
                                                  'type'=>'agent'));
                }
            }else{
                $smarty->assign('error',1);
            }
        }
    }
}


if (isset($form_data['personal']) && (int)$form_data['personal']['country'] == 0) {
	$form_data['personal']['country'] = COUNTRY_DEFAULT;
}
if (isset($form_data['partner']) && (int)$form_data['partner']['postal_country'] == 0) {
    $form_data['partner']['postal_country'] = COUNTRY_DEFAULT;
}
if (isset($form_data['company']) && (int)$form_data['company']['country'] == 0) {
    $form_data['company']['country'] = COUNTRY_DEFAULT;
}

$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('options_state',R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array('0'=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('subState', subRegion());
$smarty->assign('options_method',AO_getOptions('contact_method'));
$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('description',$config_cls->getKey('description_site_agent'))
?>