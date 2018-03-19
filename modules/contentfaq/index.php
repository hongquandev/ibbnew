<?php
include_once ROOTPATH.'/modules/contentfaq/inc/contentfaq.php';
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/general/inc/ftp.php';

$action = getParam('action','');
switch ($action){
    case 'faq':
        $query = addslashes(getPost('query'));
        if (strlen(trim($query)) >0) {
            $sql = 'SELECT faq.* FROM ' . $contentfaq_cls->getTable() . ' AS faq
                WHERE active = 1 AND (faq.question LIKE "%'.$query.'%" OR faq.answer LIKE "%'.$query.'%" )
                ORDER BY position ASC';
            $smarty->assign('resultsTitle','<h2 style="border-bottom: 1px solid #D2D2D2; padding: 0px 0px;" id="resultsTitle">Results for: <span id="search-query">'.$query.'</span></h2>');
            $smarty->assign('query',$query);
            $smarty->assign('isSearchResult',1);
        } else {
            $smarty->assign('isSearchResult',0);
            $sql = 'SELECT * FROM ' . $contentfaq_cls->getTable() . ' WHERE active = 1 ORDER BY position ASC';
        }
        $rows = $contentfaq_cls->getRows($sql, true);
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $k => &$row) {
                $row['answer'] = preg_replace_callback('/<img(.*?)>/', 'imgToLightBoxFormat', $row['answer']);
            }
        }
        $smarty->assign('rows', $rows);
        break;
    case 'collapse':
        break;
    default:
        Report_pageRemove(Report_parseUrl());
        //redirect(ROOTURL.'/notfound.html');
		redirect('/notfound.html');
    break;
}
$browserMobile = detectBrowserMobile();
$smarty->assign('browserMobile',$browserMobile);
$smarty->assign('action', $action);
$smarty->assign('ROOTPATH',ROOTPATH); 
?>