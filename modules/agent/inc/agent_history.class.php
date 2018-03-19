<?php
class Agent_history extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'agent_history';
		$this->id = 'agent_history_id';
		$this->fields = array('agent_history_id' => 0,
						'agent_id' => 0,
						'property_id' => 0,
						'property_step' => 0);
	}
	
	/**
	$where_str = 'agent_id = ? AND property_id = ?';
	*/
	public function getHistory($where_str){
		$row = $this->getRow($where_str);
		if (is_array($row) and count($row)>0) {
			return $row;
		}
		return array();
	}
	
	/**
	$where_str = 'agent_id = ? AND property_id = ?';
	*/
	public function updateHistory($data = array() ,$where_str = ''){
		if (strlen(trim($where_str)) > 0) {
			$row = $this->getHistory($where_str);
			if (is_array($row) and count($row) > 0) {
				$this->update($data,$where_str);
			} else {
				$this->insert($data);
			}
		}
	}
	
	public function getStep($property_id, $agent_id) {
		$row = $this->getRow('agent_id = '.(int)$agent_id.' AND property_id = '.(int)$property_id);
		if (is_array($row) && count($row) > 0) {
			$step = (int)$row['property_step'];
			return  in_array($step,range(1,8)) ? $step : 1 ;
		}
		return 1;
	}
}
?>