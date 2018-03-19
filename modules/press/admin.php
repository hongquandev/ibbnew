<?php
include_once ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once 'inc/press.php';


if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

$message = '';
$module = getParam('module');
$action = getParam('action');
$_action = explode('-',$action);

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
	case 'add-category':
    case 'edit-category':
    case 'add-article':
    case 'edit-article':
		include_once 'inc/admin.press.'.$_action[1].'.form.php';
        $form_action = ($_action[0] == 'add')?'?module=press&action=add-'.$_action[1]:'?module=press&action=edit-'.$_action[1].'&id='.$_GET['id'];
        $form_action .= '&token='.$token;
        break;
    case 'deny':
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
if ($_action[1] == 'category'){
    $bar[] = array('title'=>'List Category','url'=>'?module=press&action=list-category&token='.$token,'key'=>'list');
}else{
    $bar[] = array('title'=>'List Press Post','url'=>'?module=press&action=list-article&token='.$token,'key'=>'list');
}
$bar[] = array('title'=>'Add New Category','url'=>'?module=press&action=add-category&token='.$token,'key'=>'add-category');
$bar[] = array('title'=>'Add New Press Post','url'=>'?module=press&action=add-article&token='.$token,'key'=>'add-article');
if (strlen(trim($message)) == 0) {
    $message = $session_cls->getMessage();
}
$smarty->assign(array('form_action'=>$form_action,
                     'token'=>$token,
                     'action'=>$action,
                     'action_arr'=>$_action,
                     'bar'=>$bar,
                     'message'=>$message));
?>