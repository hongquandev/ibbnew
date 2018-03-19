<?php
class Property_entity_option extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'property_entity_option';
		$this->id = 'property_entity_option_id';
		$this->fields = array('property_entity_option_id' => 0,
							'title' => '',
							'code' => '',
							'value' => '',
							'order' => 0,
							'parent_id' => 0,
							'active' => 1,
                            'for_agent'=>'');
	}
	
	public function getChildsByParentCode($code = ''){
		$rows = $this->getRows("a.parent_id = (SELECT {$this->id} FROM ".$this->getTable()." AS b
		WHERE b.code = '".$this->escape($code)."') AND a.active = 1");
		return $rows;
	}
	
	/**
	**/
	
	public function getItem($id = 0, $field = '') {
		$row = $this->getRow($this->id .' = '. $id);
		if (is_array($row) && count($row) > 0 && strlen($field) > 0) {
			return @$row[$field];
		}
		return null;
	}
	
	/**
	**/
	
	public function getItemByField($field, $value, $result = array()) {
		$row = $this->getRow("`$field` = '$value'");
		if (is_array($row) && count($row) > 0) {
			if (is_array($result)) {
				return $row;
			} else {
				return $row[$result];
			}
		}
		return null;
	}
}
?>