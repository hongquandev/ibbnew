<?php

$p = (int)restrictArgs(getQuery('p',1));
$p = $p <= 0 ? 1 : $p;
$len = 20;

//prepare category
$cats = $cat_cls->getRows("active = 1 AND allow LIKE '%".$_SESSION['Admin']['role_id']."%' ORDER BY position");
if (is_array($cats) and count($cats)> 0){
    foreach ($cats as $cat){
        $items = $help_cls->getRows("SELECT SQL_CALC_FOUND_ROWS *
                                     FROM ".$help_cls->getTable()."
                                     WHERE active = 1
                                           AND allow LIKE '%".$_SESSION['Admin']['role_id']."%'
                                           AND catID = ".$cat['catID'].'
                                     LIMIT '.(($p-1)*$len).','.$len,true);
        $cat['items'] = $items;
        $arr[] = $cat;
    }

  /*  $arr[0]['active'] = 'class="active"';
    $arr[0]['show'] = 'style="display:block;"';*/
   /* $smarty->assign('showCategory','style="display:none;"');
/*    $smarty->assign('question_data',$items);*/
    /*$smarty->assign('found',1);*/
}

if ($_POST['submit'] == '1'){
        $query = $_POST['search'];
        if ($query != ''){
            $keys = explode(' ',$query);
            $search_str = '';
            if (count($keys) > 0){
                foreach ($keys as $key){
                    $str = " h.question LIKE '%".$key."%'
                          OR h.answer LIKE '%".$key."%'";
                    $search_str .= ($search_str == '')?$str:' OR '.$str;
                }
            }
        }
        $search_str = $search_str != ''? ' AND ('.$search_str.')':'';

        $rows = $help_cls->getRows('SELECT SQL_CALC_FOUND_ROWS h.*, c.title, c.active, c.allow
							      FROM '.$help_cls->getTable().' AS h
							      LEFT JOIN '.$cat_cls->getTable(). " AS c
							      ON h.catID = c.catID
                                  WHERE h.active = 1
                                        AND c.active = 1
                                        AND h.allow LIKE '%".$_SESSION['Admin']['role_id']."%'
                                        AND c.allow LIKE '%".$_SESSION['Admin']['role_id']."%' "
							      . $search_str.'
							      ORDER BY h.position
							      LIMIT '.(($p-1)*$len).','.$len,true);

        if (is_array($rows) and count($rows)){
            foreach ($rows as $row){
                $row['intro'] = strip_tags(safecontent(strip_tags($row['answer']),300).'...');
                $search_data[] = $row;
            }
            $smarty->assign('found',1);
        }else{
            $smarty->assign('found',0);
        }
        $smarty->assign('search_key',$_POST['search']);
        $smarty->assign('hideCategory','style="display:none;"');
        $smarty->assign('search_data',$search_data);

}

$pag_cls->setTotal($help_cls->getFoundRows())
		->setPerPage($len)
		->setCurPage($p)
	    ->setLenPage(10)
	    ->setUrl('admin/?module=help_center&action='.$action.'&token='.$token)
		->setLayout('link_simple');
$smarty->assign('pag_str',$pag_cls->layout());
$smarty->assign('cat_data',$arr);


?>