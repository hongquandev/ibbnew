<?php
include_once ROOTPATH . '/modules/cms/inc/cms.php';
include_once ROOTPATH . '/modules/menu/inc/menu.php';
include_once ROOTPATH . '/modules/banner/inc/banner.php';
include_once ROOTPATH . '/modules/systemlog/inc/systemlog.php';
include ROOTPATH . '/modules/contentfaq/inc/contentfaq.php';
$page_url = 'landing-page.html';
/*$row = $cms_cls->getRow('SELECT cms.*, menu.menu_id
							FROM ' . $cms_cls->getTable() . ' AS cms
							INNER JOIN ' . $menu_cls->getTable() . ' AS menu ON cms.parent_id = menu.menu_id
							WHERE menu.url = \'' . $cms_cls->escape($page_url) . '\'', true);*/
$row = $cms_cls->getRow('SELECT cms.*
							FROM ' . $cms_cls->getTable() . ' AS cms
							WHERE cms.title = \'Landing-Page-Home\'', true);
$page_id = 0;
if (count($row) > 0 and is_array($row)) {
    $page_id = $row['page_id'];
    $smarty->assign('page_id', $page_id);
    $smarty->assign('row', $row);
    $smarty->assign('content', $row['content']);
    // begin FAQ
    if (isset($row['alias_title']) and $row['alias_title'] != '') {
        $faq_rows = $contentfaq_cls->getRows(' active = 1 AND content_id IN (' . $row['alias_title'] . ') ORDER BY content_id ASC  ');
        if (count($faq_rows) > 0 and is_array($faq_rows)) {
            $smarty->assign('faq_rows', $faq_rows);
        }
    }
}
/*HOMEPAGE SLIDE*/
include_once ROOTPATH . '/modules/homepage_slides/inc/homepage_slides.class.php';
$slide_rows = $slide_cls->getRows("SELECT homeslides.* FROM {$slide_cls->getTable()} AS homeslides WHERE active = 1 ORDER BY homeslides.position ASC ",true);
if(is_array($slide_rows) && count($slide_rows) > 0){
    foreach($slide_rows as $key => $row){
        $slide_rows[$key]['image'] = ROOTURL.$row['image'];
    }
}
$smarty->assign('slide_rows', $slide_rows);
?>