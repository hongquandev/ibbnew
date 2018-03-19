<?php
class Agent_Company extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_company';
		$this->id = 'company_id';

		$this->fields = array('company_id' => 0,
							'agent_id' => 0,
							'company_name' => '',
							'address' => '',
							'suburb' => '',
							'state' => 0,
							'other_state' => '',
							'other_country' => '',
							'postcode' => '',
							'country' => 0,
							'telephone' => '',
							'abn' => '',
							'email_address' => '',
							'website'=>'',
                            'description'=>'',
                            'logo'=>'',
							'clientID' => ''
							);
	}
}