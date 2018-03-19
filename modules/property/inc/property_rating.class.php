<?php
class Property_rating extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_rating';
		$this->id = 'property_rating_id';
		$this->fields = array('property_rating_id' => 0,
							'property_id' => 0,
							'rating_parent_id' => 0,
							'rating_id' => 0,
							'active' => 1);
	}
	
}
?>