<?php 
$module = 'users';
if ($_SESSION['language'] == 'vn') {
	include 'lang/'.$module.'.vn.lang.php';
}else{
	include 'lang/'.$module.'.en.lang.php';
}


include_once ROOTPATH.'/includes/checkingform.class.php';
include_once 'inc/users.register.class.php';
include_once 'inc/users.php';

if(!isset($check)){
	$check = new CheckingForm();
}
$check->arr = array('title');


$act = isset($_GET['action'])?$_GET['action']:'';
$step = isset($_GET['step'])?$_GET['step']:1;
if(((int)$step)<0 or (int)$step>5){
	$step = 1;
}

$form_datas = array('id'=>0,'title'=>'','uri'=>'','order'=>0,'parent_id'=>0,'active'=>0);
$form_action = '?module='.$module;
$form_datas['id'] = isset($_GET['id'])?$_GET['id']:0;
$message = '';



$usersRegister = new UsersRegister();
switch($act){
	case 'register':
		$smarty->assign('step',$step);
		switch($step){
			case '1':
			break;
			case '2':
			break;
			case '3':
			break;
			case '4':
			break;
			case '5':
			break;
		}
	break;
	default:
	break;
}

$smarty->assign('action',$act);
$smarty->assign('module',$module);
/*
$smarty->assign('message',$message);
$smarty->assign('form_action',$form_action);
$smarty->assign('form_datas',$form_datas);
*/
?>