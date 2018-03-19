<?php
class Auction_terms extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'auction_terms';
		$this->id = 'auction_term_id';
		$this->fields = array('auction_term_id' => 0,
							'title' => '',
							'code' => '',
							'value' => '',
							'auction_term_parent_id' => 0,
							'type' => 'text',
							'order' => 0,
							'active' => 1,
                            'condition'=>'');
	}
	
	
}
?>