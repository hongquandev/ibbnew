<?php
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
	$config_cls = new Config();
}

include_once ROOTPATH.'/includes/smarty/Smarty.class.php';
$mobileFolder = '/';
$mobileBrowser = detectBrowserMobile(); 
if (!isset($smarty) || !($smarty instanceof Smarty)) { 
    //BEGIN SMARTY
    $smarty = new Smarty;
    if ($mobileBrowser){
        $mobileFolder = '/mobile/';
        $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
    }else{
        $smarty->compile_dir = ROOTPATH.'/templates_c/';
        $mobileFolder = '/';
    } 
}
$data = array();
switch($action) {
    case 'howtosell' :
        $data['step1'] = ($config_cls->getKey('how_to_sell_1'));
        $data['step2'] = ($config_cls->getKey('how_to_sell_2'));
        $data['step3'] = ($config_cls->getKey('how_to_sell_3'));
        $data['step4'] = ($config_cls->getKey('how_to_sell_4'));
        $data['step5'] = ($config_cls->getKey('how_to_sell_5'));
        $data['step6'] = ($config_cls->getKey('how_to_sell_6'));
    break;
    case 'howitwork' :
        $data['step1'] = ($config_cls->getKey('how_it_work_1'));
        $data['step2'] = ($config_cls->getKey('how_it_work_2'));
        $data['step3'] = ($config_cls->getKey('how_it_work_3'));
        $data['step4'] = ($config_cls->getKey('how_it_work_4'));
        $data['step5'] = ($config_cls->getKey('how_it_work_5'));
        $data['step6'] = ($config_cls->getKey('how_it_work_6'));
    break;
}
$smarty->assign('data', $data);
?>