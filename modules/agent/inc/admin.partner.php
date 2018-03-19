<?php
include_once 'partner.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';

//$partner_id = (int)restrictArgs(getParam('partner_id', 0));
	
if (isset($_GET['agent_id'])) {
	$agent_id = $_GET['agent_id'];
} else {
	$agent_id = '';
}

$form_data = $partner_cls->getFields();

$rows = $partner_cls->getRow('agent_id ='.$agent_id);
if (count($rows) > 0) {
	$form_data[$partner_cls->id] = $rows['partner_id'];		
} else {
	$form_data[$partner_cls->id] = '';
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

        $error = false;
		$now = time();
		$rand = rand(5,100000000000000000);
		
        //getImage
        if(!empty($_FILES['image_file']['name'])){

            include_once ROOTPATH.'/modules/banner/configImg-partner.php';
            $file = $_FILES['image_file'];
            $file_name = $file['name'];
            $ext = strtolower(substr(strrchr($file_name, "."), 1));
               if($validation_type == 1) {
                    $file_info = getimagesize($_FILES['image_file']['tmp_name']);
                    if(empty($file_info)){
                        $error = true;
                        $message = "The uploaded file doesn't seem to be an image.";
                    }else{
						// Check Width And Height Image With Upload
						if ($file_info[0] > 185 || $file_info[1] > 154) {
							$error = true;
							$message = 'Width or height image max size 185, 154!';
							//$row = $data;
							//$smarty->assign('row',$row);
							$sql = $partner_cls->getRow('agent_id='.(int)$agent_id);
							if (isset($sql['partner_id']) and (int)$sql['partner_id'] > 0) { 
								$smarty->assign('ckImageAdmin', 'ckImageAdmin');	
							} else {
								$row = $data;
								$smarty->assign('row',$row);
							}
							
						} // End CHeck
						
						
                        $file_mime = $file_info['mime'];
                         if($ext == 'jpc' || $ext == 'jpx' || $ext == 'jb2'){
                             $extension = $ext;
                         }
                         else{
                             $extension = ($mime[$file_mime] == 'jpeg') ? 'jpg' : $mime[$file_mime];
                         }

                         if(!$extension){
                            $extension = '';
                            $file_name = str_replace('.', '', $file_name);
                         }
                    }
               }else if($validation_type == 2){
                  if(!in_array($ext, $image_extensions_allowed)){
                    $exts = implode(', ',$image_extensions_allowed);
                    $error = true;
                    $message = "You must upload a file with one of the following extensions: ".$exts;
                  }
                  $extension = $ext;
               }

           if(!$error){
               $new_file_name = strtolower($file_name);
			   //$new_file_name = preg_replace('/[^0-9,a-z,A-Z]/', '', file_name);
               //$new_file_name = str_replace(' ', '-', $new_file_name);
			   
			   $new_file_name = str_replace('%2520','-', stripslashes($new_file_name));
			   $new_file_name = str_replace(' ', '-', stripslashes($new_file_name));
			   
               $new_file_name = substr($new_file_name, 0, -strlen($ext));
               $new_file_name .= $extension;
               //$move_file = move_uploaded_file($file['tmp_name'], $upload_image_to_folder.$new_file_name);
			   $move_file = move_uploaded_file($file['tmp_name'], $upload_image_to_folder.$now.$rand.$new_file_name);
               if($move_file){
                     //$done = 'The image has been uploaded.';
                    $data['partner_logo'] = $now.$rand.$new_file_name;	
               }
           }else{
                @unlink($file['tmp_name']);
           }
        }else{//edit
				// $row = $partner_cls->getRow('agent_id ='.$agent_id);
             	 //$data['partner_logo'] = $now.$rand.$new_file_name;

        }
       
		$rowImage = $banner_cls->getRow('SELECT * FROM '.$partner_cls->getTable().' WHERE partner_logo ="'.$new_file_name.'"', true);	
		if (count($rowImage) > 0 && is_array($rowImage) > 0) {
			$error = true;
			$message = 'Partner Logo Name Exsiting!';
			$row = $data;
			$smarty->assign('row',$row);
			$smarty->assign('ckImageAdmin', 'ckImageAdmin');			
		}
		
        if (!$error){
			
			$data['contact_references'] = isset($_POST['contact_references'])?1:0;
			$data['debit_card'] = isset($_POST['debit_card'])?1:0;

			$sql = $partner_cls->getRow('agent_id='.(int)$agent_id);
				
			// Required Image Not Null;
			if (isset($sql['partner_id']) and (int)$sql['partner_id'] > 0) { 
				
				$data['agent_id'] = $agent_id;
				if ($new_file_name == '') { 
					$data['partner_logo'] = $sql['partner_logo'];
				} else {
					// remove Image Image Present And Update Image New
					@unlink(ROOTPATH.'/store/uploads/banner/images/partner/'.$row['partner_logo']);
					@unlink(ROOTPATH.'/store/uploads/banner/images/partner/thumbs/'.$row['partner_logo']);
					
					$data['partner_logo'] = $now.$rand.$new_file_name;
				}

				$row = $partner_cls->getRow('partner_id='.$sql['partner_id']);
				
			
				
				$partner_cls->update($data,$partner_cls->id.'='.$sql['partner_id']);
				
					if (!$partner_cls->hasError()) {
						
						$message = 'Updated successful !';
						$row = $data;
						$smarty->assign('row',$row);
						$smarty->assign('ckImageAdmin', 'ckImageAdmin');
					}	
            		
				//echo $partner_cls->sql;
			} // END if (isset($sql['partner_id']) and (int)$sql['partner_id'] > 0) {
			else {
				$data['agent_id'] = $agent_id;
				$data['partner_logo'] = $now.$rand.$new_file_name;
				$partner_cls->insert($data);
				
					if (!$partner_cls->hasError()) {
						$message = 'Inserted successful !';
						$row = $data;
						$smarty->assign('row',$row);
						$smarty->assign('ckImageAdmin', 'ckImageAdmin');
						unset($row);
						
					}	   
				}				
       	 } 
	}
} // END SERVER REQUEST POST


?>



