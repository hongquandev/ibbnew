<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
$smarty->assign('options_state',R_getOptions(COUNTRY_DEFAULT));
if (isSubmit()) {
	$message = configPostDefault();
}

 
?>