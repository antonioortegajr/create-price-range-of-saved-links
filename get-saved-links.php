<html>
<head>
<title>Make up some links</title>
</head>
<script>
		function send(n){
		var current_location = window.location.href;

		//change location href to next expected file
		var create = current_location.replace('get-saved-links.php','create-links.php');
		var str = document.getElementById('pass_this_'+n).innerHTML;
		var q = str.replace(/amp;/g,'');
								window.location = create+'?'+q;
		}
</script>
<body>
<h1>Create a price range of Saved links</h1>
<p>Choose a saved link below to create a price range of saved link</p>
<p>The output will be the saved link with hp and lp ranges set to:<br>
	100000 to 200000<br>
	200000 to 300000<br>
	300000 to 400000<br>
	400000 to 500000<br>
</p>
<?php

//Set API key as llave(spanish for key!)
 $llave = 'YourAPIkeyHere';


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

						 $i=0;
//loop through the saved links and create a link that passes the saved link info via url string
foreach($response as $sl){

	$qs_string = $sl["queryString"];

	echo 'Link Name: ' . $sl["linkName"] . '<br>Link Query: ' . $qs_string
	. '<br>UID: ' . $sl["uid"] . '<br><div id="pass_this_'.$i.'">ln=' . $sl["linkName"] . '&qs='.$qs_string.
	'&uid=' . $sl["uid"] . '&key=' . $llave . '</div><button onclick="send('.$i.')">Create links</button><br><hr><br>';
	$i++;

}

?>
