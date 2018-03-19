<?php
ini_set('display_errors',0);
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once 'inc/package.php';

$message = '';
$module = getParam('module');
$package_id = (int)restrictArgs(getParam('package_id',0));
$action = getParam('action','view-basic');
$token = getParam('token');
$action_ar = explode('-', $action);

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch (@$action_ar[1]) {
	case 'basic':
	case 'property':
	case 'banner':
    case 'register':
		
		$perm_tmp_ar = array('view' => 'return "view";',
							 'edit' => 'return "edit";',
							 'save' => 'return ($package_id == 0 ? "add" :"edit");',
							 'active' => 'return "edit";',
							 'delete' => 'return "delete";');
							 
		if ($perm_ar[$act = eval($perm_tmp_ar[@$action_ar[0]])] == 0) {
			$session_cls->setMessage($perm_msg_ar[$act]);
			redirect('/admin/?module=package&action=view-deny&token='.$token);
		}			
		
		$link_ar = array('module' => 'package', 
						 'action' => 'save-'.$action_ar[1], 
						 'token' => $token);
						 
		$form_action = '?'.http_build_query($link_ar);

		$title_ar = array('basic' => 'Basic package',
						  /*'property' => 'Property package',*/
						  'banner' => 'Banner package',
                          'register' => 'Agent Register package');
		
		$bar_data = array();
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				$link_ar_ = $link_ar;
				$link_ar_['action'] = 'view-'.$key;
				$bar_data[$key] = array('link' => '?'.http_build_query($link_ar_), 'title' => $title);		
			}
		}
					
		include_once 'inc/admin.'.$module.'.'.$action_ar[1].'.php';
		$smarty->assign(array('bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'title' => $title_ar[$action_ar[1]],
							  'limit_click_ar' => $limit_click_ar));
	    break;
    case 'property_new':
        $link_ar = array('module' => 'package',
						 'action' => 'save-'.$action_ar[1],
						 'token' => $token);

		$form_action = '?'.http_build_query($link_ar);

        //get all group active
        $groups = $package_property_group_cls->getRows('is_active = 1 AND is_extra_group = 0 ORDER BY `order` ASC');
        $title_ar = array();
        foreach ($groups as $group){
            $title_ar[$group['group_id']] = $group['name'];
        }

		$bar_data = array();
        $bar_data['general'] = array('ref' => "#package_info_tabs_general",
                                     'title' => 'General');
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				//get all options
                $options = $package_property_option_cls->getRows('SELECT *
                                                                  FROM '.$package_property_option_cls->getTable().'
                                                                  WHERE group_id = '.$key.'
                                                                  ORDER BY `order` ASC',true);
                foreach ($options as $k=>$optionRow){
                    if (in_array($optionRow['type'],array('select','multiselect'))){
                        $childOptions = $package_option_cls->getRows('option_id = '.$optionRow['option_id'].' ORDER BY `order` ASC');
                        $list = $optionRow['type'] == 'select'?array(''=>'-Select-'):array();
                        if (is_array($childOptions) and count ($childOptions)){
                            foreach ($childOptions as $option){
                                $list[$option['entity_id']] = $option['label'];
                            }
                        }
                        $options[$k]['list'] = $list;
                    }
                }
                $link_ar_ = $link_ar;
				$link_ar_['action'] = 'view-'.$key;
				$bar_data[$key] = array('ref' => "#package_info_tabs_{$key}",
                                        'title' => $title,
                                        'options' =>$options);
			}
		}

        $options_type = getOptionsType();

        include_once 'inc/admin.'.$module.'.property_new.php';
        $smarty->assign(array('bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
                              'options_type'=> $options_type));
        break;
    case 'group':
        $link_ar = array('module' => 'package',
						 'action' => 'save-'.$action_ar[1],
						 'token' => $token);

		$form_action = '?'.http_build_query($link_ar);

        $title_ar = array('group_general' => 'General Information',
						  'group_option' => 'Manage Options');

		$bar_data = array();
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				$link_ar_ = $link_ar;
				$link_ar_['action'] = 'view-'.$key;
				$bar_data[$key] = array('ref' => "#group_info_tabs_{$key}", 'title' => $title);
			}
		}

        $options_type = getOptionsType();

        include_once 'inc/admin.'.$module.'.group.php';
        $smarty->assign(array('bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
                              'options_type'=> $options_type));
        break;
    case 'manage_group':
        $smarty->assign(array('title' => 'Packages List'));
        break;
	case 'view-deny':
	
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}


$options_yes_no = array(1 => 'Yes', 0 => 'No');
$auction_sale_ar = PEO_getAuctionSale();
//$options_property_type = array($auction_sale_ar['private_sale'] => 'Private Sale', $auction_sale_ar['auction'] => 'Auction');
$options_property_type = PEO_getOptions('auction_sale');
$options_doc = DOC_getList();

$smarty->assign(array('package_id' => $package_id,
					  'action' => $action,
					  'message' => $message,
					  'options_yes_no' => $options_yes_no,
					  'options_property_type' => $options_property_type,
					  'options_doc' => $options_doc,
                      'token'=>$token));
?>