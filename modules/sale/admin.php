<?php
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';

$message = '';
$module = 'sale';
$id = (int)restrictArgs(getParam('id',0));
$action = getParam('action');
$token = getParam('token');

if ($action == 'list') {
	$action = 'list-property';
}

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'add';
	case 'edit':
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit-detail';
		}
		
		// BEGIN FOR PERMISSION		
		$action_ar = explode('-', $action);
		
		if (in_array($action_ar[0], array('edit', 'active', 'inactive'))) {
			if ($property_id == 0 && $perm_ar['add'] == 0) {
				$session_cls->setMessage($perm_msg_ar['add']);
				redirect('/admin/?module=property&action=list&token='.$token);
			} else if ($perm_ar['edit'] == 0) {
				$session_cls->setMessage($perm_msg_ar['edit']);
				redirect('/admin/?module=property&action=list&token='.$token);
			}
			
		} else if ($action_ar[0] == 'delete' && $perm_ar['delete'] == 0) {
			$session_cls->setMessage($perm_msg_ar['delete']);
			redirect('/admin/?module=property&action=list&token='.$token);
		} else if ($perm_ar['view'] == 0) {
			redirect('/admin/');
		}
		
		// END
		
		$form_action = '?module=property&action='.$action.'&property_id='.$property_id.'&token='.$token;
		
		$action_ar = explode('-', $action);
		$title_ar = array('detail' => 'Property detail',
					'media' => 'Photo & Video',
					'document' => 'Legal document',
					'rating' => 'Ratings',
					'term' => 'Auction terms',
					/*'option' => 'Options'*/);
		$bar_data = array();
		
		if (is_array($title_ar) && count($title_ar) > 0) {
			foreach ($title_ar as $key => $title) {
				$host = in_array($key, array('media','document')) ? ROOTURLS : ROOTURL;
				$bar_data[$key] = array('link' => $host.'/admin/?module=property&action=edit-'.$key.'&property_id='.$property_id.'&token='.$token, 'title' => $title);
			}
		}		
					
		
		$limit_click_ar = array();
        $auction_sale = $_POST['fields']['auction_sale'];
		$sales = PEO_getAuctionSale();

		if ($property_id > 0) {
			$row = $property_cls->getRow('property_id = '.$property_id);
			if (is_array($row) and count($row) > 0) {
                if ($row['auction_sale'] == $sales['auction']) {
                    $bar_data['term'] = array('link'=>'?module=property&action=edit-term&property_id='.$property_id.'&token='.$token,'title' => 'Auction terms');
                    $title_ar['term'] = 'Term';
                } else {
                    if ($action == 'edit-term') {
                        redirect(ROOTURL.'/admin/?module=property&action=edit&property_id='.$property_id.'&token='.$token);
                    }
                }
				$bar_data['comment'] = array('link' => '?module=property&action=edit-comment&property_id='.$property_id.'&token='.$token,'title' => 'Comments');
				$bar_data['note'] = array('link' => '?module=property&action=edit-note&property_id='.$property_id.'&token='.$token,'title' => 'Notes');
				
				$title_ar['comment'] = 'Comments';
				$title_ar['note'] = 'Notes';

				foreach ($title_ar as $key => $val) {
					array_push($limit_click_ar,$key);
				}
                //$session_cls->unsetMessage();
                if (in_array($action, array('edit-document', 'edit-rating', 'edit-term'))) {
                    //VIDEO AND PHOTO
                    /*$media = $property_cls->getRow('SELECT pk.*
                                              FROM '.$property_cls->getTable().' AS p, '.$package_cls->getTable().' AS pk
                                              WHERE p.package_id = pk.package_id AND p.property_id = '.$property_id,true);*/
                    $media = PA_getPackageByPropertyId($property_id);
                    // RESTRICT FOR PHOTO
                    $photo_ar = PM_getPhoto($property_id);
                    if ((int)$media['photo_upload'] < count(@$photo_ar['photo'])) {
                        $session_cls->setMessage('Please delete some your images.');
                        redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }

                    // RESTRICT FOR VIDEO
                    $video_ar = $config_cls->getKey('youtube_enable') == 1 ? PM_getYT($property_id) :PM_getVideo($property_id);
                    if ((int)$media['video_upload'] < count(@$video_ar['video'])) {
                        $session_cls->setMessage('Please delete some your videos.');
                        redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }
                }
			}
		}


                
		include_once 'inc/admin.property.'.$action_ar[1].'.php';
		$smarty->assign(array('bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'title' => $title_ar[$action_ar[1]]));
	break;
	
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('message' => $message,
				'id' => $id,
				'ROOTPATH' =>	ROOTPATH,
				'action' => $action,
				'type_label' => $action == 'list-property' ? 'Property' : 'Banner',
				'type' => str_replace('list-', '', $action),
				'title' => eregi('property',$action) ? 'Property' : 'Banner'));

?>