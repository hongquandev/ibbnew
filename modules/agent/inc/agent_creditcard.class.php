<?php
class Agent_creditcard extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_creditcard';
		
		$this->id = 'agent_creditcard_id';
		
		$this->fields = array('agent_creditcard_id' => 0,
							'card_type' => '',
							'card_name' => '',
							'card_number' => '',
							'expiration_date' => '0000-00-00 00:00:00',
							'agent_id' => 0);
	}
}