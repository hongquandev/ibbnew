<?php
class Agent_Payment extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_payment';

		$this->id = 'payment_id';

		$this->fields = array('payment_id' => 0,
							'agent_id' => 0,
							'package_id' => 0,
							'date_from' => '0000-00-00 00:00:00',
                            'date_to'=>'0000-00-00 00:00:00',
                            'store_id'=>0,
                            'creation_date'=>'0000-00-00 00:00:00'
							);
	}
}