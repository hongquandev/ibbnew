<?php
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/configuration.php';

$module = getParam('module');
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
$action_ar = explode('-', $action);
switch ($action) {
	case 'edit-general':
	case 'edit-notification':
	case 'edit-facebook':
	case 'edit-twitter':
	case 'edit-youtube':
	case 'edit-sms':
	case 'edit-email':
	case 'edit-payment':
	case 'edit-google':
    case 'edit-register':
	case 'edit-calendar':
	case 'edit-captcha':
    case 'edit-rules':
	case 'edit-endtime':
    case 'edit-bid':
    case 'edit-agent':
    case 'edit-theblock':
	case 'edit-termdoc':
    case 'edit-press':
	case 'edit-mediaserver':
	case 'edit-api':
    case 'edit-howtosell':
    case 'edit-howitwork':
		if ($perm_ar[$action_ar[0]] == 0) {
			$session_cls->setMessage($perm_msg_ar[$action_ar[0]]);
			redirect('/admin/?module='.$module.'&action=view-deny&token='.$token);
		}	
		
		$title_ar = array('general' => 'General',
						  'notification' => 'Notification Schedule',
						  'facebook' => 'Facebook Connect Options',
						  'twitter' => 'Twitter Connect Options',
						  'youtube' => 'Youtube Options',
						  'sms' => 'Short Message Service',
						  'email' => 'Email & SMS Templates',
						  'calendar' => 'Calendar Template',
						  'payment' => 'Payment Methods',
						  'google' => 'Google Settings',
						  'captcha' => 'Captcha Settings',
                          'endtime' => 'Property time Settings',
                          'register' => 'Register Message',
                          'bid' => 'Bid Settings',
                          'rules' => 'iBB Auction Rules Message',
                          'agent' => 'Agent Auction Settings',
                          'theblock' => 'The Block Settings',
						  'termdoc' => 'Term Settings',
                          'press' => 'Press Settings',
						  'mediaserver' => 'Media Server Settings',
						  'api' => 'Api Settings',
                          'howtosell' => 'How to sell',
                          'howitwork' => 'How it works');
						  
		$bar_data = array();
		
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				$bar_data[$key] = array('link' => '?module='.$module.'&action=edit-'.$key.'&token='.$token, 'title' => $title);			
			}
		}				  		
		$limit_click_ar = array();
		
		$filterFnc = null;
		
		include_once 'inc/admin.'.$module.'.'.$action_ar[1].'.php';
		
		$form_data = array();
		$rows = $config_cls->getRows();
		if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $row) {
                if (in_array($row['key'],array('restrict_area','theblock_show_type_properties'))){
                    $row['value'] = explode(',',$row['value']);
                }
                $form_data[$row['key']] = $row['value'];

			}
		}
		
		// CHANGE VALUE$form_data.endtime-enable
		filterAction($form_data, $filterFnc);
        $options_type_properties = array('sold'=>'Sold',
                                         'passed_in'=>'Passed In',
                                         'live'=>'Live Auction',
                                         'forthcoming'=>'Forthcoming Auction');
        $smarty->assign('end_time',$form_data['endtime-enable']);
        $smarty->assign('status_notification_schedule',$form_data['status_notification_schedule']);
        $smarty->assign(array('form_data' => $form_data,
							  'bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'title' => $title_ar[$action_ar[1]],
							  'limit_click_ar' => $limit_click_ar,
                              'options_type_property'=>$options_type_properties));
	break;
	case 'view-deny':
	break;
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		} else {
			redirect('/admin/?module='.$module.'&action=edit-general&token='.$token);
		}
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$options_yes_no = array(1 => 'Yes', 0 => 'No');
$options_lock_unlock = array(1 => 'Lock', 0 => 'Unlock');

$smarty->assign(array('message' => $message,
					  'options_yes_no' => $options_yes_no,
                      'options_lock_unlock'=>$options_lock_unlock));


function configPostDefault() {
	global $config_cls;
	$message = '';
	if (isset($_POST['fields']) && is_array($_POST['fields'])) {
		foreach ($_POST['fields'] as $key => $val) {
			$key = $config_cls->escape($key);
            if (is_array($_POST['fields'][$key])){
                $val = implode(',',$_POST['fields'][$key]);
            }else{
                $val = $config_cls->escape($val);
            }			
			
			$row = $config_cls->getRow("`key` = '".$key."'");
			if (is_array($row) && count($row) > 0) {// UPDATE
				$config_cls->update(array('value' => $val),"`key` = '".$key."'");
				$message = 'Updated successful.';
			} else {// NEW
				$config_cls->insert(array('key' => $key, 'value' => $val));
				$message = 'Added successful.';
			}
		}
	}
	createConfigXml();
	return $message;
}

function filterAction(&$params, $fnc) {
	if ($fnc != null) {
		$fnc($params);
	}
}
?>
