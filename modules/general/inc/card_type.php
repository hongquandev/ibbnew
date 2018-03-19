<?php
//begin card type
include_once 'card_type.class.php';
$card_type_cls = new Card_type();

function getCardType(){
	global $card_type_cls;
	$options = array(''=>'Select...');
	$rows = $card_type_cls->getRows('SELECT code, name FROM '.$card_type_cls->getTable().' WHERE active > 0 ORDER BY `order` ASC', true);
	if ($card_type_cls->hasError()) {
		$message = $card_type_cls->getError();
	} else {
		if (is_array($rows) and count($rows) > 0) {
			foreach($rows as $key => $row) {
				$options[$row['code']] = $row['name'];		
			}
		}
	}
	return $options;
}
//end

?>