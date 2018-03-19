<?php
include_once 'auction_terms.class.php';
$auction_term_cls = new Auction_terms();

function getAuctionTerms(){
	global $auction_term_cls;
	$terms = array();
	$rows = $auction_term_cls->getRows('1 ORDER BY `order` ASC');
	if(is_array($rows) and count($rows)>0){
		foreach($rows as $row){
			$terms[$row['auction_term_id']] = $row;
		}
	}
	return $terms;
}
?>