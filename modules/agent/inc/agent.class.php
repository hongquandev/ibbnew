<?php
class Agent extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'agent';
		
		$this->id = 'agent_id';

        $this->fields = array('agent_id' => 0,
            'firstname' => '',
            'lastname' => '',
            'fullname' => '',
            'titlename' => '',
            'street' => '',
            'suburb' => '',
            'state' => 0,
            'other_state' => '',
            'other_country' => '',
            'postcode' => '',
            'country' => 0,
            'telephone' => '',
            'mobilephone' => '',
            'email_address' => '',
            'license_number' => '',
            'allow_vendor_contact' => 0,
            'allow_lawyer' => 0,
            'allow_alert' => 0,
            'preferred_contact_method' => 0,
            'password' => '',
            'security_question' => 0,
            'security_answer' => '',
            'notify_email' => 0,
            'notify_email_bid' => 0,
            'notify_sms' => 0,
            'notify_turnon_sms' => 0,
            'is_active' => 0,
            'creation_time' => '0000-00-00 00:00:00',
            'update_time' => '0000-00-00 00:00:00',
            'auction_step' => 0.00,
            'maximum_bid' => 0.00,
            'type_id' => 0,
            'ip_address' => '127.0.0.1',
            'confirm' => '',
            'subscribe' => 0,
            'provider_id' => '',
            'allow_twitter' => 0,
            'allow_facebook' => 0,
            'auto_update_contact' => 0,
            'parent_id' => 0,
            'general_contact_partner' => '',
            'website_partner' => '',
            'package_id' => 0,
            'pay_status' => 0,
            'instance' => "",
        );
							
		$this->fields_valid = array('firstname' => array('label' => 'First name', 'fnc' => array('isRequire' => null)),
									//'lastname' => array('label' => 'Last name', 'fnc' => array('isRequire' => null)),
									'fullname' => array('label' => 'Full name', 'fnc' => array('isRequire' => null)),
									'titlename' => array('label' => 'Title name', 'fnc' => array('isRequire' => null)),
									'street' => array('label' => 'Address', 'fnc' => array('isRequire' => null)),
									'suburb' => array('label' => 'Suburb', 'fnc' => array('isRequire' => null)),
									'state' => array('label' => 'State', 
													 'fnc' => array('isInt' => null, 'isBigger' => array(0))),
									//'postcode' => array('label' => 'Postcode', 'fnc' => array('isPostcode' => null)),
									'country' => array('label' => 'Country', 
													   'fnc' => array('isInt' => null, 'isBigger' => array(0))),
									/*'telephone' => array('label' => 'Telephone',
														 'fnc' => array('isNumber' => null, 'isEqualLen' => array(10)))*/);
		
	}
	
	/**
	@ function : hasEmail
	@ param : email
	@ output : bool
	*/
	
	public function hasEmail($email = '') {
//		$this->sql = 'SELECT agent_id FROM '.$this->getTable()." WHERE email_address = '".$this->escape($email)."'";
//		$val = $this->db->GetOne($this->sql);
   /*     if ($this->hasError()) {
			return false;
		} elseif ((int)$val > 0) {
			return true;
		} else {
			return false;
		}*/
        $row = $this->getRow(" email_address = '".$this->escape($email)."'");
        if (is_array($row) and count($row)> 0){
            return true;
        }else return false;

	}
	
	/*
	@ function : isvalidRegion
	@ param : region
	@ output : bool
	*/
	
    public function invalidRegion($region) {
        $region = strtoupper($region);

        $this->sql = "SELECT *
					FROM ". $this->getTable('code')." AS c
					WHERE CONCAT(UCASE(suburb),' ',(SELECT reg_1.region_id
					FROM ".$this->getTable('regions')." AS reg_1
					WHERE reg_1.code = c.state), ' ',pcode) LIKE '%". $region . "%'";
					
        $row = $this->getRow($this->sql, true);
        if ($this->hasError()) {

        } else if (is_array($row) and count($row)) {
           return false;
        }
		
        return true;
    }
	
	/*
	@ function : getFullname
	@ param : agent_id
	@ output : string
	*/
	
	public function getFullname($agent_id = 0) {
		$row = $this->getRow('SELECT agt.firstname,
									 agt.lastname
							  FROM '.$this->getTable().' AS agt 
							  WHERE agt.agent_id = '.$agent_id,true);
		if (is_array($row) && count($row) > 0) {
			return implode(' ',array($row['firstname'],$row['lastname']));
		} 
		
		return '';					  
	}
	
	/**
	@ function : getInfoBasic
	@ param : agent_id
	@ output : array
	**/
	
	public function getInfoBasic($agent_id = 0) {
		$row = $this->getRow('SELECT agt.*,
									(SELECT r1.name FROM '.$this->getTable('regions').' AS r1 WHERE r1.region_id = agt.state) AS state_name,
									(SELECT r2.name FROM '.$this->getTable('regions').' AS r2 WHERE r2.region_id = agt.country) AS country_name
							  FROM '.$this->getTable().' AS agt
							  WHERE agt.agent_id = '.$agent_id,true);
							  
		if (is_array($row) && count($row) > 0) {
			return $row;
		}
		
		return array();					  
	}

	public function getSMSNumber($email = ''){
		$row = $this->getRow('SELECT agt.telephone,agt.mobilephone,
									 agt_com.telephone as company_telephone,
									 agt_type.title as type_title
							  FROM '.$this->getTable().' AS agt
							  LEFT JOIN `agent_company` As agt_com
							  	   ON agt_com.agent_id = agt.agent_id
							  LEFT JOIN `agent_type` As agt_type
							  	   ON agt_type.agent_type_id = agt.type_id
							  WHERE agt.email_address = "'.$email.'"',true);
		if (is_array($row) && count($row) > 0) {
			if($row['type_title'] == 'agent'){
				//return $row['company_telephone'];
				return !empty($row['mobilephone']) ? $row['mobilephone'] : $row['telephone'];
			}else{
				return !empty($row['mobilephone']) ? $row['mobilephone'] : $row['telephone'];
			}
		}
		return '';
	}
}