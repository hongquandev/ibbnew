<?php


include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/general/inc/documents.class.php';
include_once ROOTPATH.'/modules/general/inc/options.php';

include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/note/inc/note.php';

include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once 'inc/property.php';
include_once 'inc/admin.property.php';
include_once ROOTPATH.'/modules/general/inc/medias.class.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/notification/notification.php';

ini_set('display_errors', 0);
if (!isset($check) or !($check instanceof CheckingForm)) {
	$check = new CheckingForm();
}

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
	$media_cls = new Medias();
}

if (!isset($document_cls) or !($document_cls instanceof Documents)) {
	$document_cls = new Documents();
}

if (!isset($package_cls) or !($package_cls instanceof Package)) {
		$package_cls = new Package();
}

$message = '';
$module = 'property';
$property_id = (int)restrictArgs(getParam('property_id',0));
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action) {
	case 'add';
	case 'edit':
    case 'edit-package':
	case 'edit-detail':
	case 'edit-media':
	case 'edit-document':
	case 'edit-rating':
	case 'edit-term':
	case 'edit-option':
	case 'edit-comment':
	case 'delete-comment':
	case 'active-comment':
	case 'inactive-comment':
	case 'edit-note':
	case 'delete-note':
	case 'active-note':
	case 'inactive-note':
    case 'edit-provideremail':
    case 'edit-generatepdf':
        //limitPermision($token,$action);
		//if ($id <=0 ) return;
		if ($action == 'add') {
			//$action = 'edit-detail';
            $action = 'edit-package';
		}
        if ($action == 'edit'){
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
		$title_ar = array('package' => 'Property Package',
                    'detail' => 'Property detail',
					'media' => 'Photo & Video',
					'document' => 'Legal document',
					'rating' => 'Ratings',
					'term' => 'Auction terms',
                    'provideremail' => 'Service Provider Email',
                    'generatepdf' => 'Generate PDF & Email to Printer',
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
                if($action == 'edit-generatepdf' && $row['active'] == 1 && $row['agent_active'] == 1) {
                    redirect('/admin/index.php?action=generatePDF&property_id='.$property_id);
                }

                if (!PK_isBindProperty($property_id) && $action != 'edit-package') {
					$session_cls->setMessage('Please select the package for this property.');
					redirect(ROOTURL.'/admin/?module=property&action=edit-package&property_id='.$property_id.'&token='.$token);
				}
                if (isset($row['auction_sale']) && in_array($row['auction_sale'],$sales) && $row['agent_id'] > 0){
                    foreach ($title_ar as $key => $val) {
                        array_push($limit_click_ar,$key);
                    }
                }else{
                    array_push($limit_click_ar,'detail');
                    array_push($limit_click_ar,'package');
                    array_push($limit_click_ar,'provideremail');
                }
                //if ($row['auction_sale'] == $sales['ebiddar']){
                    //hide rating
                    unset($bar_data['rating']);
                    if ($action == 'edit-rating'){
                        redirect(ROOTURL.'/admin/?module=property&action=edit-term&property_id='.$property_id.'&token='.$token);
                    }
                //}
                if (in_array($row['auction_sale'],array($sales['auction'],$sales['ebiddar'],$sales['ebidda30'], $sales['bid2stay']))) {
                    $bar_data['term'] = array('link'=>'?module=property&action=edit-term&property_id='.$property_id.'&token='.$token,'title' => 'Auction terms');
                    $title_ar['term'] = 'Term';
                } else {
                    if ($action == 'edit-term') {
                        redirect(ROOTURL.'/admin/?module=property&action=edit&property_id='.$property_id.'&token='.$token);
                    }
                }
				$bar_data['comment'] = array('link' => '?module=property&action=edit-comment&property_id='.$property_id.'&token='.$token,'title' => 'Comments');
				$bar_data['note'] = array('link' => '?module=property&action=edit-note&property_id='.$property_id.'&token='.$token,'title' => 'Notes');
                //$bar_data['provideremail'] = array('link' => '?module=property&action=edit-provideremail&property_id='.$property_id.'&token='.$token,'title' => 'Service Provider Email');
				
				$title_ar['comment'] = 'Comments';
				$title_ar['note'] = 'Notes';
                //$title_ar['provideremail'] = 'Service Provider Email';

                //$session_cls->unsetMessage();
                if (in_array($action, array('edit-document', 'edit-rating', 'edit-term'))) {
                    //VIDEO AND PHOTO
                    /*$media = $property_cls->getRow('SELECT pk.*
                                              FROM '.$property_cls->getTable().' AS p, '.$package_cls->getTable().' AS pk
                                              WHERE p.package_id = pk.package_id AND p.property_id = '.$property_id,true);*/
                    /*$photo_ar = PM_getPhoto($property_id);
                    if ($media['photo_num'] != 'all' && $media['photo_num'] < count(@$photo_ar['photo'])) {
                        $session_cls->setMessage('Please delete some your images.');
                        redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }

                    // RESTRICT FOR VIDEO
                    $video_ar = $config_cls->getKey('youtube_enable') == 1 ? PM_getYT($property_id) :PM_getVideo($property_id);
                    if ($media['video_num'] != 'all' && $media['video_num'] < count(@$video_ar['video'])) {
                        $session_cls->setMessage('Please delete some your videos.');
                        redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }*/

                    $media = PA_getPackageByPropertyId($property_id);
                    // RESTRICT FOR PHOTO
                    $photo_ar = PM_getPhoto($property_id);
                    if ($media['photo_upload'] < count(@$photo_ar['photo'])) {
                        //$session_cls->setMessage('Please delete some your images.');
                        //redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }

                    // RESTRICT FOR VIDEO
                    $video_ar = $config_cls->getKey('youtube_enable') == 1 ? PM_getYT($property_id) :PM_getVideo($property_id);
                    if ($media['video_upload'] < count(@$video_ar['video'])) {
                        //$session_cls->setMessage('Please delete some your videos.');
                        //redirect(ROOTURL.'/admin/?module=property&action=edit-media&property_id='.$property_id.'&token='.$token);
                    }
                }
			}
		}

		// BEGIN SHOW/HIDE AUCTION COMBO
		$left_json_ar = array($sales['auction'] => $title_ar, $sales['private_sale'] => $title_ar);
		unset($left_json_ar[$sales['private_sale']]['term']);	
		// END	
               
		include_once 'inc/admin.property.'.$action_ar[1].'.php';
		$smarty->assign(array('prev' => PE_navAdminLink('prev', $property_id),
							  'next' => PE_navAdminLink('next', $property_id),
							  'bar_data' => $bar_data,
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'title' => $title_ar[$action_ar[1]],
							  'limit_click_ar' => $limit_click_ar,
							  'private_sale' => $sales['private_sale'],
							  'auction' => $sales['auction'],
							  'left_json' => json_encode(@$left_json_ar)));
	break;

    case 'reaxml_import_products':
        include_once 'inc/admin.property.reaxml_import_products.php';
        break;

	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

$session_msg = $session_cls->getMessage();

if (strlen($session_msg)) {
	$message = $session_msg;
}
$smarty->assign(array('message' => $message,
					  'property_id' => $property_id,
					  'ROOTPATH' =>	ROOTPATH,
					  'action' => $action));

?>