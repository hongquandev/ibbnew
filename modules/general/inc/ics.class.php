<?php
class ICS{
	public function __construct() {
	}
	
	public function getLayout($data) {
		$dtstart = '';
		if (isset($data['dtstart'])) {
			$dtstart = $data['dtstart'];
		}
		
		$dtend = '';
		if (isset($data['dtend'])) {
			$dtend = $data['dtend'];
		}
		
		$title = '';
		if (isset($data['title'])) {
			$title = $data['title'];
		}
		
		$description = '';
		if (isset($data['description'])) {
			$description = $data['description'];
		}
		
		$location = '';
		if (isset($data['location'])) {
			$location = $data['location'];
		}
		
		$rs = 'BEGIN:VCALENDAR
				PRODID:-//Calendar//Calendar Event//EN
				CALSCALE:GREGORIAN
				METHOD:PUBLISH
				DTSTAMP:'.$dtstart.'
				BEGIN:VEVENT
				DTSTART:'.$dtstart.'
				DTEND:'.$dtend.'
				SUMMARY:'.$title.'
				DESCRIPTION:'.$description.'
				LOCATION:'.$location.'
				SEQUENCE:0
				END:VEVENT
				END:VCALENDAR';
		return $rs;
	}
}
?>