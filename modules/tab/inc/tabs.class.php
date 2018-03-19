<?php
class Tabs extends Model{
	/**
	Construct
	*/
	public function __construct() {
		parent::__construct();
		$this->table = 'tabs';
		$this->id = 'tab_id';
		$this->fields = array('tab_id' => 0,
						'title' => '',
						'uri' => '',
						'order' => 0,
						'parent_id' => 0,
						'active' => 1,
                        'img_path'=>'');
	}
	
	/**
	Get array with tree structure
	*/
	public function getTabsTree($parent_id = 0,$sp = '&nbsp;&nbsp;',$level = 0) {
		$rs = array();
		$rows = $this->getRows('parent_id = '.$parent_id.' AND active > 0 ORDER BY `order` ASC');
		
		if ($rows !== false) {
			foreach ($rows as $row) {
				
				$rs[$row['tab_id']] = str_repeat($sp,$level).$row['title'];
				
				$rs_tmp = $this->getTabsTree($row['tab_id'],$sp,$level+1);
				
				if (is_array($rs_tmp) and count($rs_tmp)>0) {
					foreach ($rs_tmp as $key_tmp => $val_tmp) {
						$rs[$key_tmp] = $val_tmp;
					}
				}
				//$rs = array_merge($rs,$this->getTabsTree($row['id'],$level+1));
			}
		}
		
		return $rs;
	}
	
	/**
	Menu structure
	*/
	public function getTabsMenu($parent_id = 0, $level = 1) {
		$rs = array();
		$rows = $this->getRows('parent_id = '.$parent_id.' AND active > 0 ORDER BY `order` ASC');
		
		if ($rows !== false) {
			foreach ($rows as $row) {
				$rs[$row['tab_id']] = array();
				$rs[$row['tab_id']]['infos'] = $row;
				
				$rs_tmp = $this->getTabsMenu($row['tab_id'],$level+1);
				
				if (is_array($rs_tmp) and count($rs_tmp) > 0) {
					$rs[$row['tab_id']]['childs'] = $rs_tmp;
				}
				
				$rs[$row['tab_id']]['level'] = $level;
			}
		}
		
		return $rs;
	
	}
	
	/**
	Get array
	*/
	public function getTabsLevel($parent_id = 0) {
		$rs = array();
		$sql = 'SELECT a.tab_id,a.title,a.`order`,a.active,a.uri,
						(SELECT b.title FROM '.$this->getTable().' as b WHERE b.tab_id = a.parent_id) AS parent_name
				FROM '.$this->getTable().' AS a 
				WHERE a.parent_id = '.$parent_id.' 
				ORDER BY a.`order` ASC';
				
		$rows = $this->getRows($sql, true);
		if ($rows !== false) {
			foreach ($rows as $row) {
				$rs[] = $row;
				
				$rs_tmp = $this->getTabsLevel($row['tab_id']);
				
				if (is_array($rs_tmp) and count($rs_tmp)) {
					foreach ($rs_tmp as $row_tmp) {
						$rs[] = $row_tmp;
					}
				}
			}
		}
		
		return $rs;
	}
	
	/**
	Get row by id
	*/
	public function getRowById($id = 0) {
		$row = $this->getRow('tab_id = '.$id);						
		if (is_array($row) and count($row)) {
			return $row;
		}
		return false;
	}
}
?>