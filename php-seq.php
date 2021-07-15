<?php

//requires php-curl module
//define these variables
$seq_server_url = "https://yourserverhere.com"; //can also include port number
$api_key = ""; //if your seq server is set to enforce API keys, you should fill this in

//log levels defined by SEQ are:
//#TODO from SEQ doc

//you should set $apploglevel at an application level and then pass it to this function
//you should manually specify loglevel each time you log a message
//this just passes a simple message to the log at a specific log level
function log_to_seq_basic($apploglevel = "Informational", $loglevel = "Informational", $message)
{
	global $seq_server_url;
	global $api_key;
	//#TODO add loglevel
	//#TODO compare loglevel with apploglevel

	if($message == "")
	{
		return("Message must be defined");
	}

	//#TODO check SEQ URL is OK. Remove anything ancillary.
	if(true)
	{
		$seq_api_url = $seq_server_url . "/api/events/raw?clef";
	}
	else
	{
		return("Malformed SEQ URL - do not add anything on to the end of the URL");
	}
	$ch = curl_init();

	$post_headers = [
	    'ContentType: application/vnd.serilog.clef',
	    'X-Seq-ApiKey: ' . $api_key,
	];

	//#TODO add extra log level and other features
	$post_body = '{"@t":"'. date('Y-m-d H:i:s') .'","@m":"' . $message . '"}';

	$ch = curl_init($seq_api_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $post_headers);


	$response = curl_exec($ch);

	if(curl_errno($ch))
	{
		$error_msg = curl_error($ch);
	}

	curl_close($ch);

	if(isset($error_msg))
	{
		return $error_msg;
	}
	else
	{
		return $response;
	}
}

function log_to_seq_advanced($apploglevel, $loglevel, $message, $json)
{

}


?>
