<?php
include 'partner.php';
	$form_data = $partner_cls->getFields();
	$form_data[$partner_cls->id] = $partner_id;	
	
//$module = 'agent';		

if (isset($_SESSION['new_agent']['id']) ) {
	$agent_id = $_SESSION['new_agent']['id'];
} else {
	$agent_id = 0;
}
if (isset($_GET['id'])) {
	$ax_id = $_GET['id'];
} else {
	$ax_id = '';
}

if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
    $row = $partner_cls->getRow('agent_id='.$_SESSION['new_agent']['id']);
    if (is_array($row) && count($row) > 0 ) {
        foreach ($form_data as $key=>$val) {
              if (isset($row[$key])) {
                   $form_data[$key] = $row[$key];
              }
        }
    }
}else{
    foreach ($form_data as $key=>$val) {
        if (isset($_SESSION['new_agent']['partner'][$key])) {
            $form_data[$key] = $_SESSION['new_agent']['partner'][$key];
        }
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

        if ($data['postal_country'] == 1){
                $data['postal_other_state'] = '';
        }else{
                $data['postal_state'] = '';
        }

        $error = false;
        if (!$error){
            if($data['postal_country'] == 1) {
                if ($agent_cls->invalidRegion(trim($data['postal_suburb']).' '.trim($data['postal_state']).' '.trim($data['postal_postcode']))) {
                       $error = true;
                       $message = 'Wrong suburb/postcode or state postal!';
                }
		    }
        }


        if ($_SESSION['new_agent']['partner']){
            $data['agent_id'] = $_SESSION['new_agent']['id'];
            $data['partner_id'] = $_SESSION['new_agent']['partner']['partner_id'];
        }
        if(!empty($_FILES['image_file']['name'])){
            $name = substr($_FILES['image_file']['name'],0,strrpos($_FILES['image_file']['name'],'.'));
            $ext = end(explode('.',$_FILES['image_file']['name']));
            $path_pre = ROOTPATH.'/store/uploads/banner/images/partner/';
			$sizeLimit = 2 * 1024 * 1024;
			$allowedType = array('image/jpeg', 'image/jpg','image/png', 'image/gif', 'image/x-png');
            if (!in_array($_FILES['image_file']['type'], $allowedType)) {
                $error = true;
                $message = 'File type is invalid !';
            }
            if ($_FILES['image_file']['size'] > $sizeLimit){
                $error = true;
                $message = 'File is large !';
            }
            if (!$error){
                $file_name = date('YmdHis').'_'.formatFilename($name).'.'.$ext;
                if (move_uploaded_file($_FILES['image_file']['tmp_name'],$path_pre.$file_name)){
                       list($width, $height) = getimagesize($path_pre.$file_name);
                        if ($width == $height){
                            $new_width = $new_height = 154;
                        }elseif ($width > $height){//max:185px
                            $new_width = 185;
                            $new_height = $height * (185/$width);
                        }else{
                            $new_height = 154;
                            $new_width = $height * (154/$height);
                        }
                        resizeImage($path_pre.$file_name,$new_width,$new_height);
                        $data['partner_logo'] = $file_name;
                        if (strlen($_SESSION['agent_id']['partner']['partner_logo']) > 0){
                            @unlink($path_pre.$_SESSION['agent_id']['partner']['partner_logo']);
                        }                       
                }else{
                    $error = true;
                    $message = 'Error Upload !';
                }
            }
        }


		
        if (!$error){
            $form_data = $data;

		
        if (isset($_SESSION['new_agent']) and $_SESSION['new_agent']['id'] > 0){
            $agent = $agent_cls->getRow('agent_id = '.$_SESSION['new_agent']['id']);
            $row = $partner_cls->getRow('agent_id = '.$_SESSION['new_agent']['id']);
            if (is_array($row) and count($row)> 0){
                if ($data['partner_logo'] == '') unset($data['partner_logo']);
                $partner_cls->update($data,$partner_cls->id.'='.$data['partner_id']);
            }else{
                if (is_array($agent) and count($agent)> 0){
                    $data['agent_id'] = $_SESSION['new_agent']['id'];
                    $partner_cls->insert($data);
                }
            }

        }
        $_SESSION['new_agent']['partner'] = $data;
        $_SESSION['new_agent']['step'] = $_SESSION['new_agent']['step'] < $step + 1?$step + 1:$_SESSION['new_agent']['step'];
        redirect(ROOTURL.'?module='.$module.'&action='.$action.'&step='.($step+1));
       	 }
	}
} // END SERVER REQUEST POST

if (!((int)$form_data['postal_country'] > 0)) {
	$form_data['postal_country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign('options_state',R_getOptions(($form_data['postal_country'] > 0 ? $form_data['postal_country'] : -1 ),array(0=>'Select...')));
$smarty->assign('options_country',R_getOptions());
$smarty->assign('form_data',formUnescapes($form_data));

//$smarty->assign('form_data',$form_data);

?>


