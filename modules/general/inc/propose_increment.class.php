<?php
class Propose_increment extends Model {
	public function __construct(){
		parent::__construct();
		$this->table = 'propose_increment';
		$this->id = array('from_id', 'to_id', 'property_id');
		$this->fields = array('from_id' => 0,
							'property_id' => 0,
							'amount' => 0.0,
							'type_approved' => 0);
		/**
		is_approved : 0 = Require, 1 = Accept, 2 = Refuse, 3 = Finish (will remove)
		**/					
	}
}
