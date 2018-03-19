<?php
#ini_set('display_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/src/Google_Client.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/src/contrib/Google_YouTubeService.php';

$OAUTH2_CLIENT_ID = '78628894233-4idhaf0rla3524laepqf0e017f2dc775.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'kVGBRrxvb1sy6-xClJ27JlJO';

//$redirect = 'http://' . $_SERVER['HTTP_HOST'].'/modules/general/youtube.php';
//$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$redirect = 'http://' . $_SERVER['HTTP_HOST'].'/?module=property&action=register&step=3';
$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setRedirectUri($redirect);
//$client->setScopes('https://www.googleapis.com/auth/youtube');
// YouTube object used to make all API requests.
$youtube = new Google_YoutubeService($client);	

if (isset($_GET['code'])) {
	if (strval($_SESSION['state']) !== strval($_GET['state'])) {
		//die('The session state did not match.');
	}
	
	$client->authenticate();
	$_SESSION['token'] = $client->getAccessToken();
	header('Location: ' . $redirect);
}
$_SESSION['token'] = '{"access_token":"ya29.1.AADtN_X2eUhPb_x2aUqQWHnxgKSyMzd40ZhhJSwbqWvtBnx-P5eYlCmCQ9mjzg","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/4a2_tQntNsrEHYlSApoRGhgz61d4w6amP5eSr7VL7O0","created":1394771794}';
if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}

/*
$htmlBody = 'testing';
// Check if access token successfully acquired

if ($client->getAccessToken()) {
	try{
		// REPLACE with the path to your file that you want to upload
		//$videoPath = "/path/to/file.mp4";
		$videoPath = $_SERVER['DOCUMENT_ROOT'].'/b.flv';
		// Create a snipet with title, description, tags and category id
		$snippet = new Google_VideoSnippet();
		$snippet->setTitle("Test title");
		$snippet->setDescription("Test description");
		$snippet->setTags(array("tag1", "tag2"));
	
		// Numeric video category. See
		// https://developers.google.com/youtube/v3/docs/videoCategories/list 
		$snippet->setCategoryId("22");
	
		// Create a video status with privacy status. Options are "public", "private" and "unlisted".
		$status = new Google_VideoStatus();
		$status->privacyStatus = "public";
	
		// Create a YouTube video with snippet and status
		$video = new Google_Video();
		$video->setSnippet($snippet);
		$video->setStatus($status);
	
		// Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
		// for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
		$chunkSizeBytes = 1 * 1024 * 1024;
	
		// Create a MediaFileUpload with resumable uploads
		$media = new Google_MediaFileUpload('video/*', null, true, $chunkSizeBytes);
		$media->setFileSize(filesize($videoPath));
	
		// Create a video insert request
		$insertResponse = $youtube->videos->insert("status,snippet", $video,
			array('mediaUpload' => $media));
	
		$uploadStatus = false;
	
		// Read file and upload chunk by chunk
		$handle = fopen($videoPath, "rb");
		while (!$uploadStatus && !feof($handle)) {
		  $chunk = fread($handle, $chunkSizeBytes);
		  $uploadStatus = $media->nextChunk($insertResponse, $chunk);
		}
	
		fclose($handle);
	
	
		$htmlBody .= "<h3>Video Uploaded</h3><ul>";
		$htmlBody .= sprintf('<li>%s (%s) <img src="%s"/></li>',
			$uploadStatus['snippet']['title'],
			$uploadStatus['id'],
			$uploadStatus['snippet']['thumbnails']['default']['url']);
	
		$htmlBody .= '</ul>';
	} catch (Google_ServiceException $e) {
		$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
	} catch (Google_Exception $e) {
		$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
	}
	
	$_SESSION['token'] = $client->getAccessToken();

} else {
	// If the user hasn't authorized the app, initiate the OAuth flow
	$state = mt_rand();
	$client->setState($state);
	$_SESSION['state'] = $state;
	
	$authUrl = $client->createAuthUrl();
	$htmlBody = "<h3>Authorization Required</h3>
	<p>You need to <a href=".$authUrl.">authorize access</a> before proceeding.<p>";
}
*/

function ytCheckAndForm($client) {
	$rs = '';
	$state = mt_rand();
	$client->setState($state);
	$_SESSION['state'] = $state;
	$authUrl = $client->createAuthUrl();
	if ($client->getAccessToken()) {
	} else {
		$rs = '
		<h3>Authorization Required to upload Video</h3>
		<p>You need to click <a href="'.$authUrl.'">here</a> before proceeding.<p>
		';
	}
	
	return $rs;
}

/**
$arg : filePath, client, youtube, title, 
**/

function ytUpload($arg) {
	$filePath = $arg['filePath'];
	$client = $arg['client'];
	$youtube = $arg['youtube'];
	$title = isset($arg['title']) ? 'eBidda ['.$arg['title'].']' : 'eBidda property';
	
	$rs = array('file' => $filePath);
	if ($client->getAccessToken()) {
		//$videoPath = $_SERVER['DOCUMENT_ROOT'].'/b.flv';
		$videoPath = $filePath;
		// Create a snipet with title, description, tags and category id
		$snippet = new Google_VideoSnippet();
		$snippet->setTitle($title);
		$snippet->setDescription("eBidda property");
		$snippet->setTags(array("ebidda1", "ebidda2"));
	
		// Numeric video category. See
		// https://developers.google.com/youtube/v3/docs/videoCategories/list 
		$snippet->setCategoryId("22");
	
		// Create a video status with privacy status. Options are "public", "private" and "unlisted".
		$status = new Google_VideoStatus();
		$status->privacyStatus = "public";
		//$status->privacyStatus = "private";
	
		// Create a YouTube video with snippet and status
		$video = new Google_Video();
		$video->setSnippet($snippet);
		$video->setStatus($status);
	
		// Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
		// for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
		$chunkSizeBytes = 1 * 1024 * 1024;
	
		// Create a MediaFileUpload with resumable uploads
		$media = new Google_MediaFileUpload('video/*', null, true, $chunkSizeBytes);
		$media->setFileSize(filesize($videoPath));
	
		// Create a video insert request
		$insertResponse = $youtube->videos->insert("status,snippet", $video,
			array('mediaUpload' => $media));
			//array('data' => file_get_contents($videoPath), "mimeType" => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $videoPath)));
	
		$uploadStatus = false;
	
		// Read file and upload chunk by chunk
		$handle = fopen($videoPath, "rb");
		while (!$uploadStatus && !feof($handle)) {
			$chunk = fread($handle, $chunkSizeBytes);
			$uploadStatus = $media->nextChunk($insertResponse, $chunk);
		}
	
		fclose($handle);
	
	
		$rs = array('title' => $uploadStatus['snippet']['title'], 
		'id' => $uploadStatus['id'],
		'url' => $uploadStatus['snippet']['thumbnails']['default']['url']);
	}
	return $rs;
}

function ytUpload_($arg) {
	$filePath = $arg['filePath'];
	$client = $arg['client'];
	$youtube = $arg['youtube'];
	$title = isset($arg['title']) ? 'eBidda ['.$arg['title'].']' : 'eBidda property';
	
	$rs = array('file' => $filePath);
	if ($client->getAccessToken()) {
		$videoPath = $filePath;
		// Create a snipet with title, description, tags and category id
		$snippet = new Google_VideoSnippet();
		$snippet->setTitle($title);
		$snippet->setDescription("eBidda property");
		$snippet->setTags(array("ebidda1", "ebidda2"));
	

	
		// Numeric video category. See
		// https://developers.google.com/youtube/v3/docs/videoCategories/list 
		$snippet->setCategoryId("22");
	
		// Set the video's status to "public". Valid statuses are "public",
		// "private" and "unlisted".
		$status = new Google_VideoStatus();
		$status->privacyStatus = "public";
	
		// Associate the snippet and status objects with a new video resource.
		$video = new Google_Video();
		$video->setSnippet($snippet);
		$video->setStatus($status);
	
		// Specify the size of each chunk of data, in bytes. Set a higher value for
		// reliable connection as fewer chunks lead to faster uploads. Set a lower
		// value for better recovery on less reliable connections.
		$chunkSizeBytes = 1 * 1024 * 1024;
	
		// Setting the defer flag to true tells the client to return a request which can be called
		// with ->execute(); instead of making the API call immediately.
		//$client->setDefer(true);
	
		// Create a request for the API's videos.insert method to create and upload the video.
		$insertRequest = $youtube->videos->insert("status,snippet", $video);
	
		// Create a MediaFileUpload object for resumable uploads.
		$media = new Google_MediaFileUpload(
			$client,
			$insertRequest,
			'video/*',
			null,
			true,
			$chunkSizeBytes
		);
		$media->setFileSize(filesize($videoPath));
	
	
		// Read the media file and upload it chunk by chunk.
		$status = false;
		$handle = fopen($videoPath, "rb");
		while (!$status && !feof($handle)) {
		  $chunk = fread($handle, $chunkSizeBytes);
		  $status = $media->nextChunk($chunk);
		}
	
		fclose($handle);
	
		// If you want to make other calls after the file upload, set setDefer back to false
		$client->setDefer(false);


	
	
		$rs = array('title' => $status['snippet']['title'], 
		'id' => $status['id'],
		'url' => $status['snippet']['thumbnails']['default']['url']);
	}
	return $rs;
}

/*
$_arg = array('client' => $client, 'youtube' => $youtube, 'id' => $row['file_name']);
*/
function ytDelete($arg) {
	if (isset($arg['id']) && isset($arg['youtube'])) {
		$youtube = $arg['youtube'];
		$youtube->videos->delete($arg['id']);
	}
}
?>
