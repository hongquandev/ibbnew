<?php
class PartnerRegister extends Model{
	/**
	construct
	*/
	public function __construct(){
		parent::__construct();
		
		$this->table = 'partner_register';
		
		$this->id = 'partner_id';
		
		$this->fields = array('partner_id' => 0,
							'agent_id' => 0,
							'partner_logo' => '',
							'register_number' => '',
							'postal_address' => '',
                            'postal_state' => '',
                            'postal_other_state' => '',
                            'postal_postcode' => '',
                            'postal_suburb' => '',
                            'postal_country' => '',
							'partner_references' => '',
							'contact_references' => 0,
							'debit_card' => 0,
							'description' => ''
							);
	}
}
class Partner_region extends Model{
	/**
	construct
	*/
	public function __construct(){
		parent::__construct();

		$this->table = 'partner_regions';

		$this->id = 'ID';

		$this->fields = array('agent_id' => 0,
							'suburb' => '',
							'state' => '',
							'other_state' => '',
                            'postcode' => '',
                            'country' => ''
							);
	}
}
class Partner_reference extends Model{
	/**
	construct
	*/
	public function __construct(){
		parent::__construct();

		$this->table = 'partner_reference';

		$this->id = 'ref_id';

		$this->fields = array('agent_id' => 0,
							'company_name' => '',
							'address' => '',
							'email_address' => '',
                            'telephone' => ''
							);
	}
}
