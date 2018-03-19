<?php
include_once ROOTPATH.'/admin/functions.php';
include_once 'inc/help_center.php';
include_once ROOTPATH.'/includes/pagging.class.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$message = '';
$module = getParam('module');
$action = getParam('action');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));

$perm_tmp_ar = array('add' => 'add', 'edit' => 'edit', 'manager' => 'edit');

if (strlen($act = @$perm_tmp_ar[$action]) > 0) {
	if ($perm_ar[$act] == 0) {
		$session_cls->setMessage($perm_msg_ar[$act]);
		redirect('/admin/?module='.$module.'&action=deny&token='.$token);
	}
}
switch ($action) {
	case 'add-center':
    case 'edit-center':
    case 'add-cat':
    case 'edit-cat':
        $_action = explode('-',$action);
		include_once 'inc/admin.help_'.$_action[1].'.form.php';
        $form_action = ($_action[0] == 'add')?'?module=help_center&action=add-'.$_action[1]:'?module=help_center&action=edit-'.$_action[1].'&id='.$_GET['id'];
        $form_action .= '&token='.$token;
        break;
    case 'deny':
        break;
    case 'popup':
        include_once 'inc/admin.help.popup.php';
        $form_action = '?module=help_center&action=popup&token='.$token;
        break;
    default:
		if ($perm_ar['view'] == 0) {
			$session_cls->setMessage($perm_msg_ar['view']);
			redirect('/admin/?module='.$module.'&action=deny&token='.$token);
		}
        $catID = getParam('catID','');
        $smarty->assign('catID',$catID);
	break;
}
if (in_array($action,array('add-center','edit-center'))){
    $bar[] = array('title'=>'List Help Question','url'=>'?module=help_center&action=list-center&token='.$token,'key'=>'list');
}else{
    $bar[] = array('title'=>'List Help Category','url'=>'?module=help_center&action=list-cat&token='.$token,'key'=>'list');
}
$bar[] = array('title'=>'Add New Category','url'=>'?module=help_center&action=add-cat&token='.$token,'key'=>'add-cat');
$bar[] = array('title'=>'Add New Question','url'=>'?module=help_center&action=add-center&token='.$token,'key'=>'add-question');
$smarty->assign(array('form_action'=>$form_action,
                     'token'=>$token,
                     'action'=>$action,
                     'bar'=>$bar,
                     'list'=>$bar[0]['url']));
?>