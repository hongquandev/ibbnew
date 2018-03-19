<?php
class Agent_Logo extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_logo';

		$this->id = 'logo_id';

		$this->fields = array('logo_id' => 0,
							'agent_id' => 0,
							'logo' => ''
							);
	}
}