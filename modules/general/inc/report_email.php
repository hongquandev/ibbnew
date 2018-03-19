<?php
include_once 'report_email.class.php';
if (!isset($report_email_cls) or !($report_email_cls instanceof ReportEmail)) {
	$report_email_cls = new ReportEmail();
}

function StaticsReport($type = '', $send_number = 1) {
	global $report_email_cls;
	$time = date("Y-m-d");
	$data = array();
	$wh = '';
	switch ($type) {
		case 'bids':
			$wh_str = "title = 'bids'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

			$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);
					//die($report_email_cls->sql);
				} else { // Insert
					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'bids',
													 'send_number' => 1
											  ));
				}

		break;
		case 'makeof':
			$wh_str ="title = 'makeof'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

				$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);
				} else { // Insert
					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'makeof',
													 'send_number' => 1
											  ));
				}

		break;
		case 'send_friend':

			$wh_str ="title = 'send_friend'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

				$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);

				} else { // Insert
					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'send_friend',
													 'send_number' => 1
											  ));
				}

		break;
		case 'alertemail':
			$wh_str ="title = 'alertemail'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

			$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);
				} else { // Insert

					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'alertemail',
													 'send_number' => 1
											  ));
				}
		break;
		case 'contact_vendor':
			$wh_str ="title = 'contact_vendor'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

			$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);
				} else { // Insert
					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'contact_vendor',
													 'send_number' => 1
											  ));
				}
		break;
		case 'register_agent':
			$wh_str ="title = 'register_agent'";
			$data['send_number'] = array('fnc' => 'send_number+1');
			$data['date_create'] = date('Y-m-d');

			$rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
				if (is_array($rows) && count($rows) > 0) { 	// Update
					$report_email_cls->update($data,$wh_str);
				} else { // Insert

					$report_email_cls->insert(array ('date_create' => date("Y-m-d"),
													 'title' => 'register_agent',
													 'send_number' => 1
											  ));
				}
		break;
        case 'email_total':
            $wh_str =" title = 'email_total' AND date_create = '".date('Y-m-d')."'";
            $send_number = ((int)$send_number < 1) ? 1 : (int)$send_number ;
            $data['send_number'] = array('fnc' => "send_number + {$send_number} ");
            $data['date_create'] = date('Y-m-d');
            $rows = $report_email_cls->getRow('SELECT * FROM '.$report_email_cls->getTable().' WHERE '.$wh_str.' ',true);
            if (is_array($rows) && count($rows) > 0) { 	// Update
                $report_email_cls->update($data,$wh_str);
            } else { // Insert
                $report_email_cls->insert(array ('date_create' => date("Y-m-d"),
                    'title' => 'email_total',
                    'send_number' => 1
                ));
            }
            break;
	}

}
?>