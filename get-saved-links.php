<?php

//Set API key as llave(spanish for key)
$llave = 'nb3aPvidEaSFgt6ncJHtGw';


//Get current saved links in account

// access URL and request method
$url = 'https://api.idxbroker.com/clients/savedlinks';
$method = 'GET';

// headers (required and optional)
$headers = array(
	'Content-Type: application/x-www-form-urlencoded', // required
	'accesskey: ' . $llave, // required - replace with your own
	'outputtype: json' // optional - overrides the preferences in our API control page
);

// set up cURL
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference
$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code >= 200 || $code < 300)
	$response = json_decode($response,true);
else
	$error = $code;

//echo http code so I know what is going on
echo 'http code: ' . $code . '<br><br>';


//loop through the saved links and create a link that passes the saved link info via url string
foreach($response as $sl){

	echo 'Link Name: ' . $sl["linkName"] . '<br>Link Query: ' . $sl["queryString"]
	. '<br>UID: ' . $sl["uid"] . '<br><a href="/post-saved-links.php?ln=' . $sl["linkName"] . 'qs=' . $sl["queryString"] .
	 'uid=' . $sl["uid"] . '" target="_blank">Create price range links from this link</a>' . '<br><hr><br>';


}

?>
