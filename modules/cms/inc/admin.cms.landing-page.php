<?php
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
include ROOTPATH.'/modules/contentfaq/inc/contentfaq.php';
$page_url = 'landing-page.html';
$form_data = $cms_cls->getFields();
$row = $cms_cls->getRow('SELECT cms.*, menu.menu_id
							FROM '.$cms_cls->getTable().' AS cms
							INNER JOIN '.$menu_cls->getTable().' AS menu ON cms.parent_id = menu.menu_id
							WHERE menu.url = \''.$cms_cls->escape($page_url).'\'', true);
$page_id = 0;
if(count($row) > 0 and is_array($row) )
{
    $page_id = $row['page_id'];
}
$form_data[$cms_cls->id] = $page_id;
if (isSubmit()) {
    try {
        $data = $form_data;
        foreach ($data as $key => $val) {
            if (isset($_POST[$key])) {
                $data[$key] = $tab_cls->escape($_POST[$key]);
            } else {
                unset($data[$key]);
            }
        }
        $form_data = $data;
        $chk_ar = $_POST['chk'];
        $chk_ar_ = array();
        if(isset($chk_ar) and count($chk_ar) > 0 )
        {
            foreach($chk_ar as $key => $chk){
                $chk_ar_[] = $chk;
            }
        }
        $chk_st = implode(',',$chk_ar_);
        $data['alias_title'] = $chk_st;
        if (strlen(trim($data['title'])) == 0) {
            throw new Exception('Title is invalid!');
        }

        if ($form_data[$cms_cls->id] > 0) {//update
            $data['update_time'] = date('Y-m-d H:i:s');
            $cms_cls->update($data, $cms_cls->id.' = '.$form_data[$cms_cls->id]);
        } else {//new
            $data['creation_time'] = date('Y-m-d H:i:s');
            $cms_cls->insert($data);
            $page_id = $cms_cls->insertId();
        }

        if ($cms_cls->hasError()) {
            throw new Exception($cms_cls->getError());
        } else {
            $form_action = '?module='.$module.'&action='.$action.'&page_id='.$page_id.'&token='.$token;
            $message = $form_data[$cms_cls->id] > 0 ? 'Edited successful.' : 'Edited successful.';
            $session_cls->setMessage($message);
        }
    } catch (Exception $e) {
        $session_cls->setMessage($e->getMessage());
    }

}
//
{
    $row = $cms_cls->getRow('page_id = '.(int)$page_id);
    if ($cms_cls->hasError()) {
        $message = $cms_cls->getError();
    } else if (is_array($row) and count($row) > 0) {
        //set form data
        foreach ($form_data as $key => $val) {
            if (isset($row[$key])) {
                $form_data[$key] = $row[$key];
            }
        }
        //print_r(explode(',',$row['alias_title']));
        $smarty->assign('chk_ar',explode(',',$row['alias_title']));
    }
}

// begin FAQ
$faq_rows = $contentfaq_cls->getRows(' active = 1 ORDER BY content_id ASC  ');
if(count($faq_rows) > 0 and is_array($faq_rows)){
    $smarty->assign('faq_rows',$faq_rows);
}

$type = $page_id > 0 ? 'edit' : 'add';
$smarty->assign('type',$type);
$smarty->assign(array('row' => $form_data));
?>

