<?php
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

if (!($check instanceof CheckingForm)) {
	$check = new CheckingForm();
}

if (!isset($media_cls) or !($media_cls instanceof Medias)) {
	$media_cls = new Medias();
}

if (!isset($document_cls) or !($document_cls instanceof Documents)) {
	$document_cls = new Documents();
}


$property_id = isset($_POST['property_id']) ? $_POST['property_id'] : (isset($_GET['property_id']) ? $_GET['property_id'] : 0);
$property_id = (int) preg_replace('#[^0-9]#','', $property_id);
$action = (isset($_POST['action']) and strlen($_POST['action']) > 0 ) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '') ;

$module = 'property';

switch ($action) {
	case 'add';
	case 'edit':
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
		//if ($id <=0 ) return;
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit-detail';
		}
		
		$message = '';
		$form_action = '?module=property&action='.$action.'&property_id='.$property_id.'&token='.$token;
		
		$action_ar = explode('-', $action);
		$bar_data = array('detail' => array('link' => '?module=property&action=edit-detail&property_id='.$property_id.'&token='.$token,'title' => 'Property detail') ,
					'media' => array('link' => '?module=property&action=edit-media&property_id='.$property_id.'&token='.$token,'title' => 'Photo & Video'),
					'document' => array('link' => '?module=property&action=edit-document&property_id='.$property_id.'&token='.$token,'title' => 'Legal document'),
					'rating' => array('link' => '?module=property&action=edit-rating&property_id='.$property_id.'&token='.$token,'title' => 'Ratings'),
					'term' => array('link' => '?module=property&action=edit-term&property_id='.$property_id.'&token='.$token,'title' => 'Auction terms'),
					'option' => array('link' => '?module=property&action=edit-option&property_id='.$property_id.'&token='.$token,'title' => 'Options'));
					
		$title_ar = array('detail' => 'Property detail',
					'media' => 'Media',
					'document' => 'Document',
					'rating' => 'Rating',
					'term' => 'Term',
					'option' => 'Option');			
		
		$limit_click_ar = array();
		if ($property_id > 0) {
			$row = $property_cls->getRow('property_id = '.$property_id);
			if (is_array($row) and count($row) > 0) {
				
				$bar_data['comment'] = array('link' => '?module=property&action=edit-comment&property_id='.$property_id.'&token='.$token,'title' => 'Comments');
				$bar_data['note'] = array('link' => '?module=property&action=edit-note&property_id='.$property_id.'&token='.$token,'title' => 'Notes');
				
				$title_ar['comment'] = 'Comments';
				$title_ar['note'] = 'Notes';
				
				foreach ($title_ar as $key => $val) {
					array_push($limit_click_ar,$key);
				}
				
			}
		}
					
		include_once 'inc/admin.property.'.$action_ar[1].'.php';
		$smarty->assign('prev',PE_navAdminLink('prev', $property_id));
		$smarty->assign('next',PE_navAdminLink('next', $property_id));
		$smarty->assign('bar_data', $bar_data);			
		$smarty->assign('action_ar', $action_ar);
		$smarty->assign('form_action', $form_action);
		$smarty->assign('message',$message);
		$smarty->assign('property_id',$property_id);
		$smarty->assign('title',$title_ar[$action_ar[1]]);
		$smarty->assign('limit_click_ar',$limit_click_ar);
	break;
	default:
	break;
}
$smarty->assign('property_id',$property_id);
$smarty->assign('action', $action);
?>