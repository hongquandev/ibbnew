<?php
	include_once 'faq.php';
	if (!isset($faq_cls) or !($faq_cls instanceof Faq)) {
		$faq_cls = new Faq();
	}
	
		$id = $_GET['id'] ? $_GET['id'] : '';
		$arr = array();
		if (isset($id)) {
			$row = $faq_cls->getRow('SELECT * FROM '.$faq_cls->getTable().' WHERE faq_id ='.$id.'', true);
			
			foreach($rows as $row) {
				
			}
		}
	
		$smarty->assign('row', $row);
?>