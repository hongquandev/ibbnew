<?php
include_once ROOTPATH.'/modules/faq/inc/faq.php';
include_once ROOTPATH.'/modules/contentfaq/inc/contentfaq.php';

if (!isset($faq_cls) or !($faq_cls instanceof Faq)) {
	$faq_cls = new Faq();
}

if (!isset($contentfaq_cls) or !($contentfaq_cls instanceof ContentFaq)) {
	$contentfaq_cls = new ContentFaq();
}

$action = $_GET['action'] ? $_GET['action'] : '';
$rows = '';
if (isset($action) && $action == 'faq') {

 $smarty->assign('top_menu',Menu());
 
 $smarty->assign('top_menu2',Menu2());
 
}
else{
    Report_pageRemove(Report_parseUrl());
    //redirect(ROOTURL.'/notfound.html');
	redirect('/notfound.html');
}

$smarty->assign('cms_faq', $cms_faq);
$smarty->assign('cms_row', $cms_row);
$smarty->assign('total', $total);
$smarty->assign('action', $action);
$smarty->assign('ROOTPATH',ROOTPATH);

?>