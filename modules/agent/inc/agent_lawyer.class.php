<?php
class Agent_lawyer extends Model {
	public function __construct() {
		parent::__construct();
		$this->id = 'agent_lawyer_id';
		$this->table = 'agent_lawyer';
		$this->fields = array('agent_lawyer_id' => 0,
							'name' => '',
							'company' => '',
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
	
	public function isExist($agent_id = 0) {
		$row = $this->getRow('agent_id = '.$agent_id );
		if (is_array($row) && count($row) > 0 && strlen(trim($row['name'])) > 0) {
			return true;
		}
		return false;
	}

    public  function getKey($field = 'agent_lawyer_id',$wh = ''){
        $row = $this->getRow($wh);
		if (is_array($row) && count($row) > 0 && strlen(trim($row['name'])) > 0) {
			return $row[$field];
		}
		return null;
    }
}
?>