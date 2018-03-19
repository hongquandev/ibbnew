<?php
class Property_rating_mark extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'property_rating_mark';
		$this->id = 'property_rating_result_id';
		$this->fields = array('property_rating_result_id' => 0,
						'property_id' => 0,
						'livability_rating_mark' => 0,
						'green_rating_mark' => 0);
	}
}
?>