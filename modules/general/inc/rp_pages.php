<?php
include_once ROOTPATH.'/modules/menu/inc/menu.php';
$data = array();
$category = array();
$rows = $menu_cls->getCRows(array('title', 'level', 'views'), 'AND active = 1
								AND (
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('header').',%\' OR
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('footer').',%\' OR
									url = \'home\'
									)
								AND views >= 0
								ORDER BY views DESC
								LIMIT 0,20
								');
//print_r_pre($rows);
if (is_array($rows) && count($rows) > 0) {
	foreach ($rows as $row) {
		$level_ar = unserialize($row['level']);
		$title = ucwords(strtolower(implode(' > ', $level_ar)));
		
		$data[] = array('name' => $title , 'data' => (int)$row['views']);
        $category[] = $title;
	}
}
?>
<script type="text/javascript" >
var dataPage = <?php echo json_encode($data) ?>;
var categoriesPage = [<?php echo $category;?>]
</script>
     