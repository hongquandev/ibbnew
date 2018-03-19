<?php
include_once ROOTPATH.'/includes/pagging.class.php';
include_once 'inc/press.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

//$message = '';
$action = getParam('action');
$action_arr = explode('-',$action);


switch ($action) {
	case 'view-detail':
        $url = getParam('url');
        $row = $press_article_cls->getRow('SELECT pa.title,
                                                  pa.seo_url,
                                                  pa.content,
                                                  pa.show_date,
                                                  pa.tag,
                                                  pc.title as cat_name,
                                                  pc.`key`
                                              FROM '.$press_article_cls->getTable().' AS pa
                                              LEFT JOIN '.$press_cat_cls->getTable()." AS pc
                                              ON pa.cat_id = pc.cat_id
                                              WHERE pa.show_date <= '".date('Y-m-d H:i:s')."'
                                              AND pa.active = 1
                                              AND pa.seo_url = '{$url}'",true);
        if (is_array($row) and count($row) > 0){
            $date = new DateTime($row['show_date']);
            $row['content'] = Press_reformatContent($row['content']);
            $row['show_date'] = $date->format($config_cls->getKey('general_date_format'));
            $row['url'] = ROOTURL.'/press/'.$row['seo_url'].'.html';
            $row['tag'] = explode(',',$row['tag']);
            $image = Press_getImageFromHTML($row['content']);
            $meta_photo = $image != null ? $image[0] : ROOTURL.'/modules/general/templates/images/ibb-logo.png';
            $site_meta_description = strip_tags($row['content']);
            $smarty->assign('entry',$row);
        }else{
            //redirect(ROOTURL.'/notfound.html');
			redirect('/notfound.html');
        }
        break;
    case 'news':
        break;
    default:
        $cat_key = getParam('cat','');
        $tag_key = utf8_decode(urldecode(getParam('tag','')));
        $p = (int)restrictArgs(getQuery('p',0));
		$p = $p <= 0 ? 1 : $p;
        $len = (int)getPost('len',$config_cls->getKey('press_num_post'));
        $wh_arr = array();


        //LIST BY CATEGORY
        $url_part = '';
        if (strlen($cat_key) > 0){
            $url_part = '/'.$cat_key;
            $catID = Press_getIDFromKey($cat_key);
            $wh_arr[] = $catID > 0?'pc.cat_id = '.$catID:1;
            $smarty->assign('catID',$catID);
        }

        //LIST BY TAG
        if (strlen($tag_key) > 0){
            $url_part = '/tags/'.$tag_key;
            $wh_arr[] = " FIND_IN_SET('{$tag_key}', tag )";
        }
        $wh_str = count($wh_arr)> 0?' AND '.implode(' AND ',$wh_arr):'';
        $entries = Press_getList($wh_str,1000,true,$len,$p,$url_part);
        $smarty->assign('entries',$entries);
	    break;
}

//GET CATEGORY
$options_category = Press_getFullInfoCategory(true);
$smarty->assign('options_category',$options_category);

//GET RECENT POST
$rows = Press_getList('',
                      200,
                      false,
                      (int)$config_cls->getKey('press_num_recent'));
$smarty->assign('recent',$rows);


$smarty->assign('action',$action);

?>