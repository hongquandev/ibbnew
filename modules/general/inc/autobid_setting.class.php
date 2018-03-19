<?php
class Autobid_setting extends Model{
	const HAVE_MULTI_SETTING = true;
	
	public function __construct(){
		parent::__construct();
		$this->id = array('agent_id', 'property_id');
		$this->table = 'autobid_setting';
		$this->fields = array('agent_id' => 0,
							  'property_id' => 0,
							  'money_step' => 0.00,
							  'money_max' => 0.00,
							  'accept' => 0,
							  'received' => 0
							  );
		
		$this->fields_valid['agent_id'] = array('label' => 'Agent id', 
												'fnc' => array('isBigger' => 0),
												'fnc_msg' => array('isBigger' => 'is required.'));	
																		  
		$this->fields_valid['property_id'] = array('label' => 'Property id', 
													'fnc' => array('isBigger' => 0),
													'fnc_msg' => array('isBigger' => 'is required.'));					  
														
		$this->fields_valid['money_step'] = array('label' => 'Money step', 
													'fnc' => array('isBigger' => 0),
													'fnc_msg' => array('isBigger' => 'is required.'));					  
														
		$this->fields_valid['money_max'] = array('label' => 'Money max', 
												'fnc' => array('isBigger' => 0),
												'fnc_msg' => array('isBigger' => 'is required.'));					  
														
		$this->fields_valid['accept'] = array('label' => 'Accept', 
												'fnc' => array('isInt' => null));					  
														
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
	@ param : array(agent_id, property_id, money_step, money_max, accept)
	@ output : if true return true
			   else return msg	
	**/
	
	public function add($data = array()) {
		try {
			if (!$this->isValid($data)) {
				throw new Exception(implode("<br/>",$this->getErrorsValid()));
			}
			
			if (self::HAVE_MULTI_SETTING) {//ALLOW HAVING ALOT OF SETTINGS
				if ($this->isExist($data['agent_id'], $data['property_id'])) {
					$this->update(array('money_step' => $data['money_step'], 
										'money_max' => $data['money_max'],
										'accept' => $data['accept']), 
										'agent_id = '.$data['agent_id'].' AND property_id = '.$data['property_id']);
				} else {
					$this->insert($data);
				}
			} else {//ONLY ALLOW ONE SETTING
				$row = $this->getRow('agent_id = '.$data['agent_id']);
				if (is_array($row) && count($row) > 0) {
					$this->update(array('money_step' => $data['money_step'], 
										'money_max' => $data['money_max'],
										'accept' => $data['accept'],
										'property_id' => $data['property_id']), 
										'agent_id = '.$data['agent_id']);
				
				} else {
					$this->insert($data);
				}
			}
			
			if ($this->hasError()) {
				throw new Exception('There was an error when inserting/updating data on the Auto Bid function');
			}
		} catch (Exception $e) {
			return $e->getMessage();	
		}
		
		return true;
	}
	
	/**
	@ function : setReceived
	@ param : array
	@ output : void
	**/
	
	public function setReceived($args = array('agent_id' => 0, 'property_id' => 0, 'received' => 0)) {
		$this->update(array('received' => $args['received']), 'agent_id = '.$args['agent_id'].' AND property_id = '.$args['property_id']);
	}
	
	/**
	@ function : getReceived
	@ param : array
	@ output : void
	
	**/
	
	public function getReceived($args = array('agent_id' => 0, 'property_id' => 0)) {
		$row = $this->getRow('agent_id = '.$args['agent_id'].' AND property_id = '.$args['property_id']);
		if (is_array($row) && count($row) > 0) {
			return $row['received'];
		}
		return 0;
	}
}
?>