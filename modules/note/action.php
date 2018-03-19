<?php 
session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include 'lang/note.en.lang.php';

$action = getParam('action');

if (eregi('-',$action)) {
	$action_ar = explode('-',$action);
	switch ($action_ar[1]) {
		case 'note':
			include_once ROOTPATH.'/modules/note/inc/note.php';
			
			$result = array();
			$property_id = restrictArgs(getParam('property_id',0),'[^0-9]');
			
			if ($property_id <= 0 || $_SESSION['agent']['id'] <=0 ) { return ;}
			
			switch ($action_ar[0]) {
				case 'add':
					$content = getParam('content');
					if (strlen($content) > 0) {
						$note_cls->insert(array('content' => $content,
										'time' => date('Y-m-d H:i:s'),
										'entity_id_to' => $property_id,
										'entity_id_from' => $_SESSION['agent']['id'],
										'type' => 'customer2property'));
					}
				break;
				case 'delete':
					$note_id = restrictArgs(getParam('note_id',0),'[^0-9]');
					if ($note_id > 0) {
						$note_cls->delete('note_id = '.$note_id.' 
									AND entity_id_from = '.$_SESSION['agent']['id']);
					}
				break;
			}
			
			
			$rows = $note_cls->getRows('entity_id_to = '.$property_id.' 
								AND entity_id_from = '.$_SESSION['agent']['id']." 
								AND type = 'customer2property' 
								ORDER BY note_id DESC");
								
			if (is_array($rows) && count($rows) > 0 ) {
				$data = array();
				foreach ($rows as $row) {
					$dt = new DateTime($row['time']);
					$data[] = array('note_id' => $row['note_id'],
									'time' => $dt->format('d M Y H:i:s'),
									'content' => $row['content']);
				}
				$result['notes'] = $data;
			}
			
			die(_response($result));
		break;
	}
} 
?>