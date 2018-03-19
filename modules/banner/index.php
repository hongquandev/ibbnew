<?php
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';

include_once ROOTPATH.'/modules/general/inc/ftp.php';
include_once ROOTPATH.'/modules/general/inc/media.php';

// Check Security
if(!isset($_SESSION['agent']['id'])) {
	redirect(ROOTURL);
} else {
	$row = $agent_cls->getRow('agent_id = '.(int)$_SESSION['agent']['id']);
	if($row['type_id'] != 3) {	
		redirect(ROOTURL);
	} 			
}

$form_action = '';
$id = (int)getParam('id', 0);
$action = getParam('action');
$module = 'banner';
//print_r($_POST);print_r($_GET);die();

// End Check Security
switch ($action) {
	default:
		Report_pageRemove(Report_parseUrl());
		//redirect(ROOTURL.'/notfound.html');
		redirect('/notfound.html');
	break;
	// action My Banner in Dashboad 
	case 'my-banner':
		// Check Security
		if (isset($_SESSION['agent']['id'])) {
			$row = $agent_cls->getRow('agent_id = '.(int)$_SESSION['agent']['id']);
			if($row['type_id'] == 3) {	
				include_once ROOTPATH.'/modules/banner/inc/banner.my-banner.php';	
			} else {
				//redirect(ROOTURL);
			}			
		} else {
			redirect(ROOTURL);
		}
		// End Check Security
	break;
	case 'agent-active':
		if (isset($id) && $id > 0) {
			$bannersql = $banner_cls->getRow('banner_id ='.$id);
			if ($bannersql['agent_status'] == 1) {
				$banner_cls->update(array('agent_status' => 0), 'banner_id = '.$id);
			} else {
				$banner_cls->update(array('agent_status' => 1), 'banner_id = '.$id);
			}
			redirect(ROOTURL.'?module=banner&action=my-banner');
		}
	break;
	case 'edit-advertising':  
		$form_action = '?module=banner&action=edit-advertising';
		if(!isset($_SESSION['agent']['id'])) {
			redirect(ROOTURL);
		} else {
			$row = $agent_cls->getRow('agent_id = '.(int)$_SESSION['agent']['id']);
			if($row['type_id'] == 3) {	
				$nBanner = $banner_cls->getRow('banner_id ='.(int)$id);
				if (count($nBanner) > 0 ) {
					if ($nBanner['check_all_page'] == 1 && $nBanner['pay_status'] != 2) {
						// msg_alert('Please contacts admin complete payment!',ROOTURL.'/?module=banner&action=my-banner');
						redirect(ROOTURL);						
					}
				}
				
				if ($id > 0 && !B_checkErrorAgent((int)$_SESSION['agent']['id'])) {
					redirect(ROOTURL.'?module=agent&action=view-dashboard');
				} else {
					include'inc/banner.edit.php';
				}
			} else {
				redirect(ROOTURL);
			}
		}	
	break;	
}

// Check Form Action;
$smarty->assign(array('module' => $module,
				'form_action' => $form_action,
				'property_types' => array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial'),
				'action' => $action,
				'countries' => R_getOptions(),
				'states' => R_getOptions($config_cls->getKey('general_country_default')),
				'areas' => CMS_getArea(),
				'id' => $id,
				'ROOTPATH' => ROOTPATH,
				'message' => $session_cls->getMessage()));
?>