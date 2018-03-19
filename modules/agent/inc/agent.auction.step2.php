<?php
include 'company.php';
$form_data = $company_cls->getFields();
$form_data[$company_cls->id] = $company_id;
	
//$module = 'agent';		

if (isset($_SESSION['new_agent']['id']) ) {
	$agent_id = $_SESSION['new_agent']['id'];
} else {
	$agent_id = 0;
}

if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
    $row = $company_cls->getRow('agent_id='.$_SESSION['new_agent']['id']);
    if (is_array($row) && count($row) > 0 ) {
        foreach ($form_data as $key=>$val) {
              if (isset($row[$key])) {
                   $form_data[$key] = $row[$key];
              }
        }
    }
}else{
    foreach ($form_data as $key=>$val) {
        if (isset($_SESSION['new_agent']['company'][$key])) {
            $form_data[$key] = $_SESSION['new_agent']['company'][$key];
        }
        $form_data['email_address'] = $_SESSION['new_agent']['agent']['email_address'];
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($_POST)) {
		$data = $form_data;
		foreach ($data as $key => $val) {
			if (isset($_POST[$key])) {
					$data[$key] = $partner_cls->escape($_POST[$key]);
			} else {
				unset($data[$key]);
			}
		} // End Foreach Data

        if ($data['country'] == 1){
                $data['other_state'] = '';
        }else{
                $data['state'] = '';
        }

        $error = false;
        if (!$error){
            if($data['country'] == 1) {
                if ($agent_cls->invalidRegion(trim($data['suburb']).' '.trim($data['state']).' '.trim($data['postcode']))) {
                       $error = true;
                       $message = 'Wrong suburb/postcode or state postal!';
                }
		    }
        }


        if ($_SESSION['new_agent']['company']){
            $data['agent_id'] = $_SESSION['new_agent']['id'];
            $data['company_id'] = $_SESSION['new_agent']['company']['company_id'];
        }

		
        if (!$error){
            $form_data = $data;

		
        if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
            $agent = $agent_cls->getRow('agent_id = '.$_SESSION['new_agent']['id']);
            $row = $company_cls->getRow('agent_id = '.$_SESSION['new_agent']['id']);
            if (is_array($row) and count($row)> 0){
                $company_cls->update($data,$company_cls->id.'='.$data['company_id']);
            }else{
                if (is_array($agent) and count($agent)> 0){
                    $data['agent_id'] = $_SESSION['new_agent']['id'];
                    $company_cls->insert($data);
                }
            }

        }
        $_SESSION['new_agent']['company'] = $data;
        $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step'] < $step + 1?$step + 1:$_SESSION['new_agent']['step'];
        redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.($step+1));
       	 }
	}
} // END SERVER REQUEST POST

if (!((int)$form_data['country'] > 0)) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign('options_state',R_getOptions(($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('form_data',formUnescapes($form_data));

//$smarty->assign('form_data',$form_data);

?>


