<?php
class Agent_contact extends Model {
	public function __construct() {
		parent::__construct();
		$this->id = 'agent_contact_id';
		$this->table = 'agent_contact';
		$this->fields = array('agent_contact_id' => 0,
						'name' => '',
						'address' => '',
						'suburb' => '',
						'state' => 0,
						'other_state' => '',
						'other_country' => '',
						'postcode' => '',
						'country' => 0,
						'telephone' => '',
						'mobilephone' => '',
						'email' => '',
						'agent_id' => 0);
	}
}
?>