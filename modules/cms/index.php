<?php
include_once ROOTPATH.'/modules/cms/inc/cms.php';
include_once ROOTPATH.'/modules/menu/inc/menu.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';

$uri = getParam('uri', '');
$action = getParam('action', '');

//NH edit
if (strlen($uri) > 0) {
	$uri .= '.html';
    $today = getdate();
	$date = date('Y-m-d');

    $currentDate = implode('-', array($today["year"], $today["mon"], $today["mday"], $today["hours"], $today["minutes"], $today["seconds"]));

    $row = $cms_cls->getRow('SELECT cms.*, menu.menu_id
							FROM '.$cms_cls->getTable().' AS cms
							INNER JOIN '.$menu_cls->getTable().' AS menu ON cms.parent_id = menu.menu_id
							WHERE menu.url = \''.$cms_cls->escape($uri).'\'', true);
    $id = 0;
	if (is_array($row) && count($row) > 0) {
		$id = $row['menu_id'];
		//$site_title .= ' / '.$row['title'];
        $language = $_SESSION['language_current'];
        if($language == 'cn'){
            $row['title'] = $row['title_chinese'];
            $row['content'] = $row['content_chinese'];
        }
        $site_meta_key = $row['title'];
        $site_meta_description =  strip_tags($row['content']);

		// Infographic
        $infographic_row = $infographic_cls->getRows('page_id = '.(int)$row['page_id'] . " AND icon_on <> '' AND icon_off <> '' AND title <> '' AND content <> '' ");
        //print_r_pre($infographic_row);die();
        if(is_array($infographic_row) && count($infographic_row) > 0) {
            $smarty->assign(array('infographic_data' => $infographic_row));   
        } else {
            $infographic_row = array();
            for($i=1;$i<=15;$i++) {
                $arr = array('step'=> $i);
                array_push($infographic_row, $arr);
            }
            $smarty->assign(array('infographic_data' => $infographic_row));   
        }
        $smarty->assign('row', $row);
		// Show banner
		$showBanner = 'SELECT position, banner_id, url, banner_file, page_id 
						FROM '.$banner_cls->getTable().'
						WHERE status = 1 AND display = 1 AND agent_status = 1 AND pay_status = 2
							AND date_from <= "'.$date.'" AND "'.$date.'" <= date_to
							AND page_id LIKE "%'.$id.'%" 
							OR page_id LIKE "%,0,%" AND status = 1 AND agent_status = 1 AND display = 1
							AND pay_status = 2 AND date_from <= "'.$date.'" AND "'.$date.'" <= date_to
						ORDER BY position ASC, RAND()';
						
		$kq = strpos($showBanner, $id);
		if ($kq !== false) {
			$handle2 = $banner_cls->getRows($showBanner, true);
			$arr = array();
			$numRow = $banner_cls->getFoundRows();
			foreach ($handle2 as $rowbanner) {
				$arr[] = array('file' => $rowbanner['banner_file'], 'url' => $rowbanner['url'], 'banner_id' => $rowbanner['banner_id']);
				$data2['views'] = array('fnc' => 'views+1');
				$wh_strsr = 'banner_id = '.$rowbanner['banner_id'].' AND status = 1 AND agent_status = 1 AND display = 1 AND pay_status = 2
									AND DATE(Now()) <= DATE(date_to)';
				$banner_cls->update($data2,$wh_strsr);
				//echo $banner_cls->sql;
			}
		}
		$smarty->assign('rowbanner', $arr);
		$smarty->assign('pages_id', $_GET['pages_id']);		
    } else {
		$file = parseRedirectUrl($_SERVER['REQUEST_URI']);
		if (is_file(ROOTPATH.$file)) {
			include ROOTPATH.$file;
		} else {
			//redirect(ROOTURL.'/notfound.html');
			redirect('/notfound.html');
			$smarty->assign('row', "error");
		}
    }
}else{

}
if(getParam('module','') == ''){
    $action = 'view-landing-page';
}

global $landingPage;
if (isset($landingPage) && $landingPage){
    $action = 'landing';
}

if($action == 'view-landing-page'){
    include_once 'inc/cms.landing-page.php';
}
if ($action == 'counter-banner') {
    include_once ROOTPATH.'/modules/report/inc/report.php';
	Report_bannerAdd(getParam('id'),'click');
}

if (!isset($action) OR $action == 'notfound' ) {
    $smarty->assign('error', 'error');
}
/*HOMEPAGE*/
$smarty->assign('cms_row', $cms_row);
$smarty->assign('action', $action);
$smarty->assign('ROOTPATH', ROOTPATH);
?>