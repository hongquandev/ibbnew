<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/agent/inc/partner.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

global $agent_cls;
if ($_SESSION['agent']['type'] == 'agent'){
    redirect(ROOTURL.'?module=agent&action=view-dashboard');
}
//get data

    $form_data['personal'] = $agent_row = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
    $form_data['contact'] = $agent_contact_cls->getFields();

    $agent_contact_row = $agent_contact_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
    if (is_array($agent_contact_row) and count($agent_contact_row) > 0){
        $form_data['contact'] = $agent_contact_row;
    }

    $form_data['credit'] = $agent_creditcard_cls->getFields();
    $form_data['credit'] = $agent_credit_row = $agent_creditcard_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
    $form_data['partner'] = $partner_cls->getFields();
    $partner_row = $partner_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
    if (is_array($partner_row) and count($partner_row) > 0){
         $form_data['partner'] = $partner_row;
    }

    if (is_array($agent_credit_row) && count($agent_credit_row)>0 ){
        $dt = new DateTime($form_data['credit']['expiration_date']);
        $form_data['credit']['expiration_year'] = $dt->format('Y');
        $form_data['credit']['expiration_month'] = $dt->format('m');
    } else{
        $form_data['credit']['expiration_year'] = '0';
	    $form_data['credit']['expiration_month'] = '0';
    }

    if ($_SESSION['agent']['type'] == 'partner'){
        $check_partner = true;
    }else{
        $check_partner = false;
    }
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = false;
        //valid Region
       if (!$error) {
		   if ($_POST['personal']['country'] == 1) {
				if ($agent_cls->invalidRegion(trim($_POST['personal']['suburb']).' '.trim($_POST['personal']['state']).' '.trim($_POST['personal']['postcode']))) {
						$error = true;
						$message = 'Wrong suburb/postcode or state!';
						$smarty->assign('form_data',$form_data);
				}
			}	
	   }
       if (!$check_partner){
            if (!$error) {
				if ($_POST['contact']['country'] == 1) {	
					if ($agent_cls->invalidRegion(trim($_POST['contact']['suburb']).' '.trim($_POST['contact']['state']).' '.trim($_POST['contact']['postcode']))) {
							$error = true;
							$message = 'Wrong suburb/postcode or state!';
							$smarty->assign('form_data',$form_data);
					}
				}	
            }
       }

        //valid Email
       if (!$error) {
            if ($agent_cls->hasEmail($_POST['personal']['email_address']) && $_POST['personal']['email_address'] != $form_data['personal']['email_address'] ) {//edit
                    $error = true;
                    $message = 'Email existed!';
					$smarty->assign('form_data',$form_data);
            }
       }
		
       if (!$error){
            //GET DATA
            $type = array('personal','contact','partner'/*,'lawyer','credit'*/);
            foreach ($type as $_t){

                /* if (isset($_POST[$_t])){
                     foreach ($_POST[$_t] as $key => $val) {
                        if (isset($_POST[$_t][$key])) {
                            $form_data[$_t][$key] = $val;
                        }else{
                            unset($form_data[$_t][$key]);
                        }
                     }
                 }*/

                 if (isset($_POST[$_t])){
                     foreach ($form_data[$_t] as $key => $val) {
                        if (isset($_POST[$_t][$key])) {
                            $form_data[$_t][$key] = $agent_cls->escape($_POST[$_t][$key]);
                        }else{
                            unset($form_data[$_t][$key]);
                        }
                     }
                 }
				 
				 /*if (is_array($form_data[$_t]) && count($form_data[$_t]) > 0) {
				 	foreach ($form_data[$_t] as $key => $val) {
                        if (isset($_POST[$_t][$key])) {
                            $form_data[$_t][$key] = $_POST[$_t][$key];
                        } else {
                             unset($form_data[$_t][$key]);
                        }
					}
				 } */
            }
			
			
           /* $form_data['partner']['contact_references'] = isset($_POST['partner']['contact_references'])?1:0;
            $form_data['partner']['debit_card'] = isset($_POST['partner']['debit_card'])?1:0;*/



			if ($form_data['personal']['country'] == 1){
                $form_data['personal']['other_state'] = '';
            }else{
                $form_data['personal']['state'] = 0;
            }

            if ($form_data['contact']['country'] == 1){
                $form_data['contact']['other_state'] = '';
            }else{
                $form_data['contact']['state'] = 0;
            }
            //END

            //UPDATE OR INSERT DATA
            if (is_array($agent_row) && count($agent_row) > 0) {
                $agent_cls->update($form_data['personal'],'agent_id = '.$_SESSION['agent']['id']);
			} else {
                $form_data['personal']['agent_id'] = $_SESSION['agent']['id'];
				$agent_cls->insert($form_data['personal']);
			}
            if (is_array($agent_contact_row) && count($agent_contact_row) > 0) {
               $agent_contact_cls->update($form_data['contact'],'agent_id = '.$_SESSION['agent']['id']);
            } else {
               $form_data['contact']['agent_id'] = $_SESSION['agent']['id'];
               $agent_contact_cls->insert($form_data['contact']);
            }
            if ($check_partner){
                if (is_array($partner_row) && count($partner_row) > 0) {
                    $partner_cls->update($form_data['partner'],'agent_id = '.$_SESSION['agent']['id']);
                } else {
                    $form_data['partner']['agent_id'] = $_SESSION['agent']['id'];
                    $partner_cls->insert($form_data['partner']);
                }
            }

            if ($agent_cls->hasError() || $agent_contact_cls->hasError() || $partner_cls->hasError()){
                $message = 'Error !';
            }else{
                $message = 'Updated successful !';
                $_SESSION['agent']['email_address'] = $form_data['personal']['email_address'];
                if (isset($_SESSION['item_number'])){
                    $_SESSION['full_info'] = true;
                    $link_ar = array('module' => 'property',
								     'action' => 'view-auction-detail', 
								     'id' => $_SESSION['item_number']);
                    redirect(shortUrl($link_ar));
                }else{
                    redirect(ROOTURL.'/?module=agent&action=view-dashboard');
                }
            }
	   }
}
if (!((int)$form_data['personal']['country'] > 0)) {
	$form_data['personal']['country'] = $config_cls->getKey('general_country_default');
}
if (!((int)$form_data['contact']['country'] > 0)) {
	$form_data['contact']['country'] = $config_cls->getKey('general_country_default');
}
$smarty->assign('options_state',R_getOptions(1,array(0=>'Select...')));


$smarty->assign('options_country',R_getOptions());
$smarty->assign('options_year',ACC_getOptionsYear(date('Y')+10));
$smarty->assign('options_month',ACC_getOptionsMonth());
$smarty->assign('options_card_type',CT_getOptions());
$smarty->assign('form_data',$form_data);
$smarty->assign('subState', subRegion());
$smarty->assign('agent_id',$_SESSION['agent']['id']);
$smarty->assign('message', $message);
$smarty->assign('options_question',AO_getOptions('security_question'));

?>