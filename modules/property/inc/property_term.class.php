<?php
class Property_term extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_term';
		$this->id = 'property_term_id';
		$this->fields = array('property_term_id' => 0,
							'property_id' => 0,
							'auction_term_id' => 0,
							'auction_term_parent_id' => 0,
							'value' => '');
	}
	
	public function isExist($property_id = 0) {
		$rows = $this->getRows('property_id = '.$property_id);
		if (is_array($rows) && count($rows) > 0) {
			return true;
		}
		return false;
	}
}
?>