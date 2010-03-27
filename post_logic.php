<?php

$source    = $_REQUEST['source'];
$type      = $_REQUEST['type'];
$content   = $_REQUEST['content'];

// SELECT * FROM rules WHERE account = $_SESSION['account']

// Iterate through rules
foreach($results as $row)
{
	// If the rule applies to this content
	if($type == $row['type'] && $source == $row['source'])
	{
		// Get the destination for this rule
		$destinations = explode(':?:', $row['destinations']);
		
		// Iterate through destinations
		foreach($destinations as $destination)
		{
			// Send content to destination
			sendTo($destination, $type, $content);
		{
	}
}

function sendTo($destination, $type, $content)
{
	switch($destination)
	{
		
		case "blogger" :
			sendToBlogger($type, $content);
			break;
		
		case "facebook" :
			sendToFacebook($type, $content);
			break;
		
		case "flickr" :
			sendToFlickr($type, $content);
			break;
		
		case "friendfeed" :
			sendToFriendfeed($type, $content);
			break;
		
		case "lastfm" :
			sendToLastfm($type, $content);
			break;
		
		case "picasa" :
			sendToPicasa($type, $content);
			break;
		
		case "posterous" :
			sendToPosterous($type, $content);
			break;
		
		case "tumblr" :
			sendToTumblr($type, $content);
			break;
		
		case "twitter" :
			sendToTwitter($type, $content);
			break;
		
		case "youtube" :
			sendToYoutube($type, $content);
			break;
	}
}

// Formats the array of destinations like "Dest1, Dest2, Dest3 and Dest4." for display on page
for($i = 0, $size = count($destinations); $i < $size; $i++)
{
	switch($i)
	{
		case ($i < $size - 3):
			$string .= ucfirst($destinations[$i]) . ', ';
			break;
		
		case ($i == $size - 2):
			$string .= ucfirst($destinations[$i]) . ' and ';
			break;
			
		case ($i == $size - 1):
			$string .= ucfirst($destinations[$i]) . '.';
			break;
	}
}

?>