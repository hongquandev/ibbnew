<?php
class Regions extends Model{
	/**
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'regions';
		
		$this->id = 'region_id';
		
		$this->fields = array('region_id'=>0,
							'code'=>'',
							'name'=>'',
							'parent_id'=>0,
							'order'=>0,
							'active'=>1);
	}
	
	/**
	Get countries
	*/
	public function getCountries(){
		$rows = $this->getRows('parent_id=0 AND active>0 ORDER BY `order` ASC');
		if(!$this->hasError()){
			return $rows;
		}
		return array();
	}
	
	/**
	Get all state by country
	*/
	public function getStates($country_id = 0){
		$rows = $this->getRows('parent_id='.$country_id.' AND active>0 ORDER BY `order` ASC');
		if(!$this->hasError()){
			return $rows;
		}
		return array();
	
	}
}
?>