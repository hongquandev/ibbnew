<?php
class Agent_option extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		
		$this->table = 'agent_option';
		
		$this->id = 'agent_option_id';
		
		$this->fields = array('agent_option_id'=>0,
							'title'=>'',
							'code'=>'',
							'order'=>0,
							'parent_id'=>0,
							'active'=>1);
	}
}
?>