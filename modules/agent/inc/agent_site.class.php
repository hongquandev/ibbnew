<?php
class Agent_site extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_site';

		$this->id = 'site_id';
		
		$this->fields = array('agent_id' => 0,
							  'site_id' =>0,
                              'name'=>'',
                              'type'=>'',
                              'logo'=>'',
                              'background_logo'=>''
							);

	}
}