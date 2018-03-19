<?php
include_once 'press.category.class.php';
include_once 'press.article.class.php';

if (!isset($press_cat_cls) || !($press_cat_cls instanceof Press_cat)) {
	$press_cat_cls = new Press_cat();
}
if (!isset($press_article_cls) || !($press_article_cls instanceof Press_article)) {
	$press_article_cls = new Press_article();
}

function Press_getCategory($def = array(),$active = false){
    global $press_cat_cls;
    $options = $def != null?$def:array();
    $wh_str = $active?'active = 1':'1';
    $rows = $press_cat_cls->getRows('SELECT cat_id, title
                                     FROM '.$press_cat_cls->getTable().'
                                     WHERE '.$wh_str.'
                                     ORDER BY position ASC',true);
    foreach ($rows as $row){
        $options[$row['cat_id']] = $row['title'];
    }
    return $options;
}

function Press_getFullInfoCategory($active = false){
    global $press_cat_cls;
    $options = array();
    $wh_str = $active?'active = 1':'1';
    $rows = $press_cat_cls->getRows('SELECT cat_id, title, `key`
                                     FROM '.$press_cat_cls->getTable().'
                                     WHERE '.$wh_str.'
                                     ORDER BY position ASC',true);


    if (is_array($rows) and count($rows) > 0){
           $options = $rows;
    }
    return $options;
}

function Press_getIDFromKey($key){
    global $press_cat_cls;

    $row = $press_cat_cls->getCRow(array('cat_id'),"`key` = '{$key}'");
    if (is_array($row) and count($row) > 0){
        return $row['cat_id'];
    }
    return 0;
}
function Press_SEO($press_id){
    if ($press_id == 0) return;
    global $press_article_cls,$press_cat_cls;
    $row = $press_article_cls->getRow('SELECT pa.title,
                                              pc.title AS cat_title,
                                              pc.key
                                       FROM '.$press_article_cls->getTable().' AS pa
                                       LEFT JOIN '.$press_cat_cls->getTable().' AS pc
                                       ON pa.cat_id = pc.cat_id
                                       WHERE press_id = '.$press_id,true);
    if (is_array($row) and count($row) > 0){
        $url = $row['key'].'/'.formatFilename($row['title']);
        //SAVE URL
        $rows = $press_article_cls->getRow("SELECT seo_url
                                            FROM ".$press_article_cls->getTable()."
                                            WHERE seo_url LIKE '{$url}%' AND press_id != ".$press_id.'
                                            ORDER BY seo_url DESC',true);
        if (is_array($rows) and count($rows)> 0){
            $last_url = $rows[0]['seo_url'];
            $cut_str = substr($last_url,strlen($url),strlen($last_url) - strlen($url));
            if (is_numeric($cut_str) || $cut_str == ''){
                $new_number = (int)$cut_str + 1;
                $url .= '-'.$new_number;
            }
        }
        $press_article_cls->update(array('seo_url'=>$url),'press_id = '.$press_id);
        return $url;
    }
}

function Press_SEOCategory($cat_id,$cat_title){
    if ($cat_id == 0) return false;
    global $press_cat_cls;
    $url = formatFilename($cat_title);

    //SAVE KEY
    $rows = $press_cat_cls->getRow("SELECT `key`
                                    FROM ".$press_cat_cls->getTable()."
                                    WHERE `key` LIKE '{$url}%' AND cat_id != ".$cat_id.'
                                    ORDER BY `key` DESC',true);
    if (is_array($rows) and count($rows)> 0){
            $last_url = $rows[0]['key'];
            $cut_str = substr($last_url,strlen($url),strlen($last_url) - strlen($url));
            if (is_numeric($cut_str) || $cut_str == ''){
                $new_number = (int)$cut_str + 1;
                $url .= '-'.$new_number;
            }
    }
    $press_cat_cls->update(array('key'=>$url),'cat_id = '.$cat_id);
    if ($press_cat_cls->hasError()){
        return false;
    }
    return true;
}

function Press_getImageFromHTML($html){
    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    $tags = $doc->getElementsByTagName('img');
    $img_arr = array();
    foreach ($tags as $tag) {
         $img_arr[]  = str_replace('..',ROOTURL,$tag->getAttribute('src'));
    }
    return $img_arr;
}

function Press_reformatContent($html){
    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    $tags = $doc->getElementsByTagName('img');
    foreach ($tags as $tag) {
        if (preg_match('/^\.\.(.*)/',$tag->getAttribute('src'))){
            $ori_link = str_replace('..','',$tag->getAttribute('src'));
            $html = str_replace($tag->getAttribute('src'),ROOTURL.$ori_link,$html);
        }
    }
    return $html;
}

function Press_getList($wh_str = '',$word = 1000,$allow_paging = false,$len = 5,$p = 1,$url_part = ''){
    global $press_article_cls,$press_cat_cls,$smarty,$pag_cls,$config_cls;

    $rows = $press_article_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pa.title,
                                                    pa.seo_url,
                                                    pa.content,
                                                    pa.show_date,
                                                    pa.tag,
                                                    pc.title as cat_name,
                                                    pc.key

                                              FROM ' . $press_article_cls->getTable() . ' AS pa
                                              LEFT JOIN ' . $press_cat_cls->getTable() . " AS pc
                                              ON pa.cat_id = pc.cat_id
                                              WHERE pa.show_date <= '" . date('Y-m-d H:i:s') . "'
                                              AND pa.active = 1
                                              {$wh_str}
                                              ORDER BY pa.show_date DESC"
                                        . ' LIMIT ' . ($p - 1) * $len . ',' . $len, true);
    if ($allow_paging){
        $total_row = $press_article_cls->getFoundRows();
        $pag_cls->setTotal($total_row)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(5)
                ->setUrl('/press' . $url_part)
                ->setLayout('link_simple');
        $smarty->assign('pag_str', $pag_cls->layout());
    }

    $entries = array();
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $row) {
            $image = Press_getImageFromHTML($row['content']);
            $row['photo'] = $image != null ? $image[0] : '';
            $row['url'] = ROOTURL . '/press/' . $row['seo_url'] . '.html';
            $date = new DateTime($row['show_date']);
            $row['show_date'] = $date->format($config_cls->getKey('general_date_format'));
            $row['content'] = safecontent(strip_tags($row['content'],'<p>'), $word);
            $row['tag'] = explode(',', $row['tag']);
            $entries[] = $row;
        }
        //$smarty->assign('entries', $entries);
    }
    return $entries;
}

?>
