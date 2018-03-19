<?php
class Card_type extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		
		$this->table = 'card_type';
		
		$this->id = 'card_id';
		
		$this->fields = array('card_id'=>0,
							'code'=>'',
							'name'=>'',
							'order'=>0,
							'active'=>0);
	}
}