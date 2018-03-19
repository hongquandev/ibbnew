<?php
$youtube_email = $config_cls->getKey('youtube_email'); // Change this to your youtube sign in email.
$youtube_password = $config_cls->getKey('youtube_password'); // Change this to your youtube sign in password.
$key = $config_cls->getKey('youtube_application_key');
$source = $config_cls->getKey('youtube_application_source'); 
 
 
//echo $youtube_email.'-'.$youtube_password.'-'.$source.'-'.$key; 
$postdata = "Email=".$youtube_email."&Passwd=".$youtube_password."&service=youtube&source=".$source;
$curl = curl_init("https://www.google.com/youtube/accounts/ClientLogin");
curl_setopt($curl, CURLOPT_HEADER, "Content-Type:application/x-www-form-urlencoded");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
$response = curl_exec($curl);
curl_close($curl);
 
list($auth, $youtubeuser) = explode("\n", $response);
list($authlabel, $authvalue) = array_map("trim", explode("=", $auth));
list($youtubeuserlabel, $youtubeuservalue) = array_map("trim", explode("=", $youtubeuser));
 
$youtube_video_title = "IBB"; // This is the uploading video title.
$youtube_video_description = "IBB"; // This is the uploading video description.
$youtube_video_category = "News"; // This is the uploading video category.
$youtube_video_keywords = "example, video"; // This is the uploading video keywords.
 
$data = '<?xml version="1.0"?>
			<entry xmlns="http://www.w3.org/2005/Atom"
			  xmlns:media="http://search.yahoo.com/mrss/"
			  xmlns:yt="http://gdata.youtube.com/schemas/2007">
			  <media:group>
				<media:title type="plain">'.$youtube_video_title.'</media:title>
				<media:description type="plain">'.$youtube_video_description.'</media:description>
				<media:category
				  scheme="http://gdata.youtube.com/schemas/2007/categories.cat">'.$youtube_video_category.'</media:category>
				<media:keywords>'.$youtube_video_keywords.'</media:keywords>
			  </media:group>
			</entry>';
 

 
$headers = array("Authorization: GoogleLogin auth=".$authvalue,
				 "GData-Version: 2",
				 "X-GData-Key: key=".$key,
				 "Content-length: ".strlen($data),
				 "Content-Type: application/atom+xml; charset=UTF-8");
 
$curl = curl_init("http://gdata.youtube.com/action/GetUploadToken");
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_REFERER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_HEADER, 0);

$response = simplexml_load_string(curl_exec($curl));
curl_close($curl);	
$nexturl = str_replace('http:',(@$_SERVER['HTTPS'] == 'on' ? 'https' : 'http').':',ROOTURL).'/modules/property/yt.php';
//onsubmit="return yt.checkForFile();"
$str = '<form action="'.$response->url.'?nexturl='.urlencode($nexturl).'" method="post" enctype="multipart/form-data"  id="yt_form" name="yt_form" target="yt_if_target">
	<input id="yt_file" type="file" name="file" class="yt-button" size="8"/>
	<input type="hidden" name="token" value="'.$response->token.'"/>
	<input type="button" value="Upload" class="yt-button" onclick="yt.prePackage()"/>
	</form><iframe src="'.$nexturl.'" id="yt_if_target" name="yt_if_target"  style="display:none"></iframe>';
//onload="getYTId()"	
die($str);	
?>