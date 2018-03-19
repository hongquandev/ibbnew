<?php
if (!isset($check)) {
	$check = new CheckingForm();
}
$check->arr = array();

$form_data = array();
$form_data['lawyer'] = $agent_lawyer_cls->getFields();
$form_data['contact'] = $agent_contact_cls->getFields();
$id = $_SESSION['new_agent']['id'];


if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
	$data['lawyer'] = $form_data['lawyer'];
    if (isset($_SESSION['new_agent']['lawyer'])){
        $data['lawyer']['agent_lawyer_id'] = $_SESSION['new_agent']['lawyer']['agent_lawyer_id'];
        $data['lawyer']['agent_id'] = $_SESSION['new_agent']['lawyer']['agent_id'];
    }
    if (isset($_SESSION['new_agent']['contact'])){
        $data['contact']['agent_contact_id'] = $_SESSION['new_agent']['contact']['agent_contact_id'];
        $data['contact']['agent_id'] = $_SESSION['new_agent']['contact']['agent_id'];
    }
    $_POST['lawyer']['email'] = strtolower($_POST['lawyer']['email']);
    $_POST['contact']['email'] = strtolower($_POST['contact']['email']);
	foreach ($data['lawyer'] as $key => $val) {
		if (isset($_POST['lawyer'][$key])) {
			$data['lawyer'][$key] = $agent_lawyer_cls->escape($_POST['lawyer'][$key]);
		}
	}
	
	$data['contact'] = $form_data['contact'];
	foreach ($data['contact'] as $key => $val) {
		if (isset($_POST['contact'][$key])) {
			$data['contact'][$key] = $agent_contact_cls->escape($_POST['contact'][$key]);
		}
	}
	
	
	//$data['lawyer']['agent_id'] = $data['contact']['agent_id'] = $_SESSION['new_agent']['id'];

    if ($_POST['lawyer']['state'] > 0 && $_POST['lawyer']['country'] == 1) {
		$data['lawyer']['other_state'] = '';
	}

	if ($_POST['lawyer']['other_state'] != '' && $_POST['lawyer']['country'] > 1) {
		$data['lawyer']['state'] = '';
    }

	//begin valid
	$error = false;
	if ( ($data['lawyer']['state']*$data['lawyer']['country']*$data['contact']['state']*$data['contact']['country']) == 0) {
		/*
			$error = true;
			$check->showRed();
			$message = "The form is not complete. <A href='#here' name='here' onclick=\"msgAlert();\">Click here</A> to view the missing fields.";
		*/
		
	} else if (!$check->checkEmail($data['lawyer']['email']) or !$check->checkEmail($data['contact']['email'])) {
		$error = true;
		if (!$check->checkEmail($data['lawyer']['email'])) {
			$data['lawyer']['email'] = '';
		}
		
		if (!$check->checkEmail($data['contact']['email'])) {
			$data['contact']['email'] = '';
		}
		$message = 'Email invalid!';
	}

    if (!$error) {
		if ($data['lawyer']['country'] == 1 && $data['lawyer']['suburb'] != '' && $data['lawyer']['state'] != '' && $data['lawyer']['postcode'] != '' ) {
			if ($agent_cls->invalidRegion(trim($data['lawyer']['suburb']).' '.trim($data['lawyer']['state']).' '.trim($data['lawyer']['postcode']))) {
				$error = true;
				$message = "Wrong suburb/postcode or state!";
			}
		}		
	}
    if (!$error) {
		if ($data['contact']['country'] == 1) {
			if ($agent_cls->invalidRegion(trim($data['contact']['suburb']).' '.trim($data['contact']['state']).' '.trim($data['contact']['postcode']))) {
				$error = true;
				$message = "Wrong suburb/postcode or state!";
			}
		}	
	}
	//end valid
	



	if ($error) {
		$form_data['lawyer'] = $data['lawyer'];
		$form_data['contact'] = $data['contact'];
	} else {

        //BEGIN LAWYER
        $agent = $agent_cls->getRow('agent_id = '.$_SESSION['new_agent']['id']);
		if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){//update
            $row = $agent_lawyer_cls->getRow('agent_lawyer_id = '.(int)$data['lawyer']['agent_lawyer_id']);
            if (is_array($row) and count($row) > 0) {//update
			    $agent_lawyer_cls->update($data['lawyer'],'agent_lawyer_id = '.$data['lawyer']['agent_lawyer_id']);
            }else{
                if (is_array($agent) and count($agent) > 0){
                    $data['lawyer']['agent_id'] = $_SESSION['new_agent']['id'];
                    $agent_lawyer_cls->insert($data['lawyer']);
                }
            }
        }
        //DON'T SAVE AGENT INFORMATION AT THIS STEP:Nhung
        $_SESSION['new_agent']['lawyer'] = $data['lawyer'];
		//END
		
		//BEGIN CONTACT
		if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){//update
            $row = $agent_contact_cls->getRow('agent_contact_id = '.(int)$data['contact']['agent_contact_id']);
            if (is_array($row) and count($row) > 0) {//update
			    $agent_contact_cls->update($data['contact'],'agent_contact_id = '.$data['contact']['agent_contact_id']);
            }else{
                if (is_array($agent) and count($agent) > 0){
                    $data['contact']['agent_id'] = $_SESSION['new_agent']['id'];
                    $agent_contact_cls->insert($data['contact']);
                }
            }
        }
        //DON'T SAVE AGENT INFORMATION AT THIS STEP:Nhung
        $_SESSION['new_agent']['contact'] = $data['contact'];
		//END
		
		/*if ($agent_lawyer_cls->hasError() or $agent_contact_cls->hasError()) {
			$message = 'Error when inserting/updating data.';
			$form_data = $data;
		} else {
			$_SESSION['new_agent']['step'] = $step + 2;
			$message = 'The information has been inserted/updated.';
			redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.$_SESSION['new_agent']['step']);
		}	*/
        $step = $step + 1;
        $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step']< $step?$step:$_SESSION['new_agent']['step'];
        $message = 'The information has been inserted/updated.';
		redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.$step);
	}
} 


//BEGIN LAWYER
if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0 and isset($_SESSION['new_agent']['lawyer'])){
    $row = $agent_lawyer_cls->getRow('agent_id = '.(int)$_SESSION['new_agent']['id']);
    if ($agent_lawyer_cls->hasError()) {
        $message = '';
    } else if (is_array($row) and count($row) > 0) {
        foreach ($form_data['lawyer'] as $key => $val) {
            if (isset($row[$key])) {
                $form_data['lawyer'][$key] = $row[$key];
            }
        }
    }
}else{
    if (isset($_SESSION['new_agent']['lawyer'])){
         foreach ($_SESSION['new_agent']['lawyer'] as $key=>$val) {
           if (isset($_SESSION['new_agent']['lawyer'][$key])) {
                $form_data['lawyer'][$key] = $_SESSION['new_agent']['lawyer'][$key];
           }
        }
    }
   
}
/*print_r($_SESSION);*/
//BEGIN CONTACT
if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0 and isset($_SESSION['new_agent']['contact'])){
    $row = $agent_contact_cls->getRow('agent_id = '.(int)$_SESSION['new_agent']['id']);
    if ($agent_contact_cls->hasError()) {
        $message = '';
    } else if (is_array($row) and count($row) > 0) {
        foreach ($form_data['contact'] as $key => $val) {
            if (isset($row[$key])) {
                $form_data['contact'][$key] = $row[$key];
            }
        }
    }
}else{


     if(isset($_SESSION['new_agent']['contact']))
         foreach ($_SESSION['new_agent']['contact'] as $key=>$val) {
            if (isset($_SESSION['new_agent']['contact'][$key])) {
              $form_data['contact'][$key] = $_SESSION['new_agent']['contact'][$key];
            }
         }
    else{
        // FOr auto update contact info
        //$row = $agent_cls->getRow('agent_id = '.(int)$_SESSION['new_agent']['id']);
        $row = $_SESSION['new_agent']['agent'];
        if(count($row) > 0 and is_array($row))
        {
            if($row['auto_update_contact'] == 1)
            {
                // Auto add information into contact fields
                foreach($row as $key=>$val)
                {
                    $form_data['contact'][$key] = $val;
                }
                $form_data['contact']['name'] = $row['firstname'].' '.$row['lastname'];
                $form_data['contact']['address'] = $row['street'];
                $form_data['contact']['email'] = $row['email_address'];
            }
        }
    }
}





if ((int)$form_data['lawyer']['country'] == 0) {
	$form_data['lawyer']['country'] = COUNTRY_DEFAULT;
}

if ((int)$form_data['contact']['country'] == 0) {
	$form_data['contact']['country'] = COUNTRY_DEFAULT;
}



$smarty->assign('options_state',R_getOptions(($form_data['contact']['country'] > 0 ? $form_data['contact']['country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('subState', subRegion());
$smarty->assign('form_data',formUnescapes($form_data));

?>