<?php
class Property_option extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_option';
		$this->id = 'property_option_id';
		$this->fields = array('property_option_id' => 0,
							'property_id' => 0,
							'option_id' => 0,
							'value' => '');
	}
}
?>