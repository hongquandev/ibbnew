<?php
class Config extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'config';
		$this->id = 'config_id';
		$this->fields = array('config_id' => 0,
								'key' => '',
								'value' => '');
	}
	
	public function getKey($key = '') {
		/*
		if (file_exists(ROOTPATH.'/modules/cache/config_fix.xml')) {
			$reader = new XMLReader();
			$reader->xml(file_get_contents(ROOTPATH.'/modules/cache/config_fix.xml'));
			while ( $reader->read() ) {
				if ($reader->nodeType == XMLReader::ELEMENT && $reader->localName == $key) {
					$reader->read();
					return $reader->value;
				}
			}
		}
		*/
		if (file_exists(ROOTPATH.'/modules/cache/config.cache')) {
			$rows = Cache_get(ROOTPATH.'/modules/cache/config.cache');
			foreach ($rows as $row) {
				if (isset($row[$key])) {
					return $row['value'];
				}
			}
		}
		
		$row = $this->getRow("`key` = '".$key."'");
		if (is_array($row) && count($row) > 0) {
			return $row['value'];
		}
		return '';
	}
}

if (!isset($config_cls) || !($config_cls instanceof Config)) {
		$config_cls = new Config();
}
?>