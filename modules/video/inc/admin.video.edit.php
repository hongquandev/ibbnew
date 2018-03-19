<?php
include_once 'video.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
$form_data = $video_cls->getFields();
$form_data[$video_cls->id] = $video_id;
if (isSubmit()) {

	try {
	
		$data = $form_data;
		foreach ($data as $key => $val) {
			if (isset($_POST[$key])) {
				$data[$key] = $video_cls->escape($_POST[$key]);
			} else {
				unset($data[$key]);
			}
		}
		
		$form_data = $data;
		
		if (strlen(trim($data['video_name'])) == 0) {
			throw new Exception('Video name is invalid!');
		}
		
		//print_r($_FILES);
		//die();
		
		mkdir(ROOTPATH."/store/uploads/video/", 0777);
		chmod(ROOTPATH."/store/uploads/video/", 0777);
		$data['is_embed'] = isset($data['is_embed']) ? 1 : 0;
		$data['video_content'] = scanContent($data['video_content']);
		if ($data['is_embed'] == 1) {
			$data['video_file'] = scanContent($data['video_file']);
		} else {
			$name = $_FILES['file_video_name']['name'];
			if (strlen($_FILES['file_video_name']['type']) == 0 && $video_id > 0) {
				unset($data['video_file']);			
			} else {
				// mime_type of video
				/*				
				case "mpeg":
				case "mpg":
				case "mpe"
					return "video/mpeg";
				case "mp3":
					return "audio/mpeg3";
				case "wav":
					return "audio/wav";
				case "aiff":
				case "aif":
					return "audio/aiff";
				case "avi":
					return "video/msvideo";
				case "wmv":
					return "video/x-ms-wmv";
				case "mov":
					return "video/quicktime";				
				*/	
				$mimeAr = array('video/mpeg', 'audio/mpeg3', 'audio/wav', 'video/x-ms-wmv', 'video/quicktime');
				if (in_array($_FILES['file_video_name']['type'], $mimeAr)) {
					if ($_FILES['file_video_name']['size'] > 10 * 1024 * 1024 * 1024) {
						throw new Exception('Allowed max size is 10M');
					}	
					if (move_uploaded_file ($_FILES['file_video_name']['tmp_name'], ROOTPATH."/store/uploads/video/".$name)) {
						$data['video_file'] = "/store/uploads/video/".$name;
					}
				} else {
					throw new Exception('Extentions allowed (mpeg, wmv, wmv, mov)');
				}
			}			
		}
		
		if ($form_data[$video_cls->id] > 0) {//update
			$video_cls->update($data, $video_cls->id.' = '.$form_data[$video_cls->id]);
		} else {//new
			$video_cls->insert($data);
			$video_id = $video_cls->insertId();
		}
		
		if ($video_cls->hasError()) {
			throw new Exception($video_cls->getError());
		} else {
			$form_action = '?module='.$module.'&action='.$action.'&video_id='.$video_id.'&token='.$token;
			$message = $form_data[$video_cls->id] > 0 ? 'Edited successful.' : 'Added successful.';
			$session_cls->setMessage($message);
		}
		
	} catch (Exception $e) {
		$session_cls->setMessage($e->getMessage());
		if ($data['video_id'] > 0) {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&id='.$data['video_id'].'&token='.$token);
		} else {
			redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
		}
	}	

	if ($_POST['next'] == 1) {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=edit&token='.$token);
	} else {
		redirect(ROOTURL.'/admin/?module='.$module.'&action=lists&token='.$token);
	}
} else {
	$row = $video_cls->getRow('video_id = '.(int)$video_id);
	
	if ($video_cls->hasError()) {
		$message = $video_cls->getError();
	} else if (is_array($row) and count($row) > 0) {
		//set form data 
		foreach ($form_data as $key => $val) {
			if (isset($row[$key])) {
				$form_data[$key] = $row[$key];
			}
		}
	} 
}
$smarty->assign(array('row' => $form_data));
?>