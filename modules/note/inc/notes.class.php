<?php
class Notes extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'notes';
		$this->id = 'note_id';
		$this->fields = array('note_id' => 0,
						'content' => '',
						'time' => '0000-00-00 00:00:00',
						'entity_id_to' => 0,/*property_id, agent_id*/
						'entity_id_from' => 0,/*agent_id, user_id*/
						'type' => 'customer2property',
						'active' => 0);
	}
}