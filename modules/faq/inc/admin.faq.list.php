<?php
	include_once 'faq.php';
	if (!isset($faq_cls) or !($faq_cls instanceof Faq)) {
		$faq_cls = new Faq();
	}
	
	$rows = $faq_cls->getRows('SELECT * FROM '.$faq_cls->getTable().'', true);
	$faq_row = array();
	foreach($rows as $row) {
	
		faq_row[] = $row;			
	}
	
?>