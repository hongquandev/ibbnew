<?php
class Menu extends Model {
	/**
	Construct
	*/
	public function __construct() {
		parent::__construct();
		$this->table = 'menu';
		$this->id = 'menu_id';
		$this->fields = array('menu_id' => 0,
						'title' => '',
						'url' => '',
						'iurl' => '',
						'views' => 0,
						'active' => 0,
						'parent_id' => 0,
						'level' => '',
						'area_ids' => '',
						'banner_area_ids' => '',
						'access' => '',
						'order' => 0,
                        'show_mobile'=>1);
	}
	
	/**
	@ function : isExist
	@ param : 
	@ output : 
	**/
	
	public function isExist($url = '') {
		$row = $this->getCRow(array('menu_id'), 'url = \''.$url.'\'');
		if (isset($row['menu_id']) && $row['menu_id'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	@ function :isExistExcludeId
	@ param :
	@ output :
	**/
	
	public function isExistExcludeId($url = '', $menu_id = 0) {
		$row = $this->getCRow(array('menu_id'), 'url = \''.$url.'\' AND menu_id != '.(int)$menu_id);
		if (isset($row['menu_id']) && $row['menu_id'] > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>