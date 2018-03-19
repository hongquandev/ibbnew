<?php
include_once 'partner.php';
include_once 'agent.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';

//FOR PERSONAL SITE
$row = $agent_cls->getRow('SELECT a.*
                           FROM ' . $agent_cls->getTable() . ' AS a
                           WHERE a.agent_id = ' . $_SESSION['agent']['id'], true);

$form_data = $agent_cls->getFields();
foreach ($form_data as $key => $val) {
    if (isset($row[$key])) {
        $form_data[$key] = $row[$key];
    }
}

//UPDATE INFORMATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = false;
    if (isset($_POST['field']) && count($_POST['field']) > 0){
        foreach ($_POST['field'] as $k=>$value){
            $form_data[$k] = $personal[$k] = $agent_cls->escape($value);
        }
    }

    if (!$error){
        if (isset($_POST['field']['email_address'])) {
            $row = $agent_cls->getRow("email_address = '".$form_data['email_address']."' AND agent_id != ".$_SESSION['agent']['id']);
			if (is_array($row) and count($row) > 0){
                $error = true;
                $message = 'Email existed!';
		    }
        }
    }

    $personal['update_time'] = date('Y-m-d H:i:s');
	$personal['description'] = scanContent($personal['description']);
    if (!$error){
        $agent_cls->update($personal,'agent_id='.$_SESSION['agent']['id']);

        if ($agent_cls->hasError()) {
            $message = $agent_cls->getError();
        }else{
            $_SESSION['agent']['email_address'] = $form_data['email_address'];
            $message = 'Updated successfully !';
        }
    }
}

$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('options_state',R_getOptions(COUNTRY_DEFAULT,array(0=>'Select')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('options_method',AO_getOptions('contact_method'));
$smarty->assign('options_question',AO_getOptions('security_question'));
$smarty->assign('country_default',COUNTRY_DEFAULT)
?>