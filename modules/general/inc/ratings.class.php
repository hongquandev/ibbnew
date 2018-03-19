<?php
class Ratings extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'ratings';
		$this->id = 'rating_id';
		$this->fields = array('rating_id' => 0,
							'title' => '',
							'value' => '',
							'order' => 0,
							'parent_id' => 0,
							'active' => 1);
	}
	
	/**
	get child row by parent code
	*/
	public function getChildByParentCode($code = ''){
		/*
		$this->sql = "SELECT a.* 
						FROM ".$this->getTable()." AS a 
						WHERE a.parent_id = (SELECT b.rating_id FROM ".$this->getTable()." AS b WHERE b.code='".$this->escape($code)."')
						ORDER BY a.`order` ASC";
		$rows = $this->db->GetAssoc($this->sql);
		$this->printError();
		*/
		
		$rows = $this->getRows("parent_id = (SELECT b.rating_id FROM ".$this->getTable()." AS b WHERE b.code='".$this->escape($code)."') ORDER BY `order` ASC");
		return $rows;
	}
	
	
	public function getOptionsByParentCode($code = '', $key = 'rating_id', $val = 'title'){
		$rows = $this->getChildByParentCode($code);
		$options = array(0 => 'Select...');	
		if (is_array($rows) and count($rows) > 0) {
			foreach ($rows as $row) {
				$options[$row[$key]] = $row[$val];
			}
		}
		return $options;
	}
	
	/*
	Ex:$code = 'livability_rating' => get child of child of it
	*/
	
	/*
	public function getLevel3ByLevel1($code = ''){
		$rs = array();
		$rows = $this->getChildByParentCode($code);
		if (is_array($rows) and count($rows) > 0) {
			
			foreach ($rows as $row) {
				$rows2 = $this->getChildByParentCode($row['code']);	
			}
		}
		
		return $rs;
	}
	*/
}
?>