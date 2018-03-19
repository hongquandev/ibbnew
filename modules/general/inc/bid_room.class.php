<?php
class Bid_room extends Model{
	const PLAY_MULTI_ROOM = true;
	
	public function __construct(){
		parent::__construct();
		$this->id = array('agent_id', 'property_id');
		$this->table = 'bid_room';
		$this->fields = array('agent_id' => 0,
							  'property_id' => 0,
							  'time_joined' => '0000-00-00 00:00:00',
							  'ignore' => 0
							  );
							  
		$this->fields_valid = array('agent_id' => array('label' => 'Agent id', 
														'fnc' => array('isBigger' => 0),
														'fnc_msg' => array('isBigger' => 'is required.')),
														
								   'property_id' => array('label' => 'Property id', 
														 'fnc' => array('isBigger' => 0),
														 'fnc_msg' => array('isBigger' => 'is required.')),	
																										
								   'time_joined' => array('label' => 'Time joined', 
														 'fnc' => array('isDateTime' => null),
														 'fnc_msg' => array('isDateTime' => 'is required.')));	
														
	}
	
	/**
	@ function : isExist
	@ param : agent_id, property_id
	@ output : bool
	**/
	
	public function isExist($agent_id = 0, $property_id = 0) {
		$row = $this->getRow('agent_id = '.$agent_id.' AND property_id = '.$property_id);
		if (is_array($row) && count($row) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	@ function : add
	@ param : array(agent_id, property_id)
	@ output : mixed
			if true then true
			else msg
	**/
	
	public function add($data = array()) {
		try {
			$agent_id = $data['agent_id'];
			$property_id = $data['property_id'];
			
			if (self::PLAY_MULTI_ROOM) {//CAN PLAY ON MANY ROOMS
				if ($this->isExist($agent_id, $property_id)) {
					$this->update(array('time_joined' => date('Y-m-d H:i:s')), 
										'agent_id = '.$agent_id .' AND property_id = '.$property_id);
				} else {
					$this->insert(array('agent_id' => $agent_id, 
										'property_id' => $property_id, 
										'time_joined' => date('Y-m-d H:i:s')));
				}
			} else {//ONLY PLAY ON ONE ROOM
				$row = $this->getRow('agent_id = '.$agent_id);
				if (is_array($row) && count($row) > 0) {
					$this->update(array('property_id' => $property_id,
										'time_joined' => date('Y-m-d H:i:s')), 
										'agent_id = '.$agent_id);
				} else {
					$this->insert(array('agent_id' => $agent_id, 
										'property_id' => $property_id, 
										'time_joined' => date('Y-m-d H:i:s')));
				}
			}
			
			if ($this->hasError()) {
				throw new Exception('There was an error when inserting/updating data on the Auto Bid function.');
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return true;
	}
	
	/**
	@ function : del
	@ param : agent_id, property_id
	@ output : mixed
			if true then true
			else msg
	**/
	
	public function del($agent_id = 0, $property_id = 0) {
		try {
			if (self::PLAY_MULTI_ROOM) {
				if (!$this->isValid(array('agent_id' => $agent_id, 'property_id' => $property_id))) {
					throw new Exception("<br/>".$this->getErrorsValid());
				}
				$this->delete('agent_id = '.$agent_id.' AND property_id = '.$property_id);	
			} else {
				if (!$this->isValid(array('agent_id' => $agent_id))) {
					throw new Exception("<br/>".$this->getErrorsValid());
				}
				$this->delete('agent_id = '.$agent_id);
			}
			
			if ($this->hasError()) {
				throw new Exception('There was an error when inserting/updating data on the Auto Bid function .');
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return true;
	}
	
	/**
	@ function : getNext
	@ param : agent_id, property_id
	@ output : int
	------
	Have many more 1 people in each room
	**/
	 
	public function getNext($agent_id = 0, $property_id = 0) {
		$rows = $this->getRows('property_id = '.$property_id.' ORDER BY time_joined ASC');
		
		if (is_array($rows) && count($rows) > 1) {
			$member_ar = array();
			foreach ($rows as $row) {
				array_push($member_ar, $row['agent_id']);
			}
			$order = array_search($agent_id, $member_ar);
			
			if ($order >= (count($member_ar) - 1)) {
				return $member_ar[0];
			} else {
				return $member_ar[$order + 1];
			}
		}
		return 0;
	}
	
	/**
	@ function : getSeatAll
	@ param : property_id
	@ output : array
	**/
	
	public function getSeatAll($property_id = 0) {
		$rows = $this->getRows('property_id = '.$property_id.' ORDER BY time_joined ASC');
		
		if (is_array($rows) && count($rows) > 1) {
			$member_ar = array();
			foreach ($rows as $row) {
				array_push($member_ar, $row['agent_id']);
			}
			return $member_ar;
		}
		return array();
	}
	
}
?>