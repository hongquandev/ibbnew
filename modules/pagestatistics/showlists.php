<?php

header('Content-type:text/javascript;charset=UTF-8');
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
require_once  '../../includes/functions.php';

$smarty = new Smarty;

if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}


if ($_SESSION['language'] == 'vn') {
    include 'lang/pagestatistics.vn.lang.php';
} else {
    include 'lang/pagestatistics.en.lang.php';
}

include_once ROOTPATH . '/modules/cms/inc/cms.php';

$start = $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'];
$limit = $_REQUEST['limit'] == 0 ? 25 : $_REQUEST['limit'];
$sortby = $_REQUEST['sort'] == '' ? 'ID' : $_REQUEST['sort'];
$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'];


$search_query = $cms_cls->escape(isset($_REQUEST['search_query']) ? $_REQUEST['search_query'] : '');
$search_where = '';
if (strlen($search_query) > 0) {
    $search_where = "WHERE (cms_page.title LIKE '%" . $search_query . "%'
														OR cms_page.page_id ='" . $search_query . "')";
}

$rows = $cms_cls->getRows('SELECT SQL_CALC_FOUND_ROWS cms_page.*
										FROM ' . $cms_cls->getTable() . ' 
											 ' . $search_where . '
												ORDER BY page_id ' . $dir . '
													LIMIT ' . $start . ',' . $limit, true);

$totalCount = $cms_cls->getFoundRows();

$retArray = array();

if (is_array($rows) and count($rows) > 0) {

    foreach ($rows as $row) {

        $row['search'] = "<a href=\"#\" onclick=\"wow('../modules/pagestatistics/popup.php?ID={$row['page_id']}',350,500);\" style=\"color:#0000FF; text-decoration:none\" >Search </a>";

        $retArray[] = $row;
    }
}
// $data = json_encode($retArray);

$arrJS = array("totalCount" => $totalCount, "topics" => $retArray);

echo json_encode($arrJS);
?> 
