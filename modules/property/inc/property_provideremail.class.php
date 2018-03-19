<?php
class Property_provideremail extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_provider_email';
		$this->id = 'property_provider_email_id';
		$this->fields = array('property_provider_email_id' => 0,
							'property_id' => 0,
							'email' => '');
	}
}
?>