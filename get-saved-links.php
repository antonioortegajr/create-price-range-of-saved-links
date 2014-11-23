<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	</head>
	<body>
		<center><div id="branding">
			<a href="http://idxbroker.com" id="idx_logo"><img src="http://www.idxbroker.com/images/brands/idx.png"></a><img src="http://antoniowp.idxsandbox.com/api/images/devs.png">
		</div>
		<br>
		<br>
		<div id="green"></div>
		<h1>Create a price range of Saved links</h1>
		<p>Choose a saved link below to create a price range of saved link</p>
		<p>The output will be the saved link with hp and lp ranges set to:<br>
			100000 to 200000<br>
			200000 to 300000<br>
			300000 to 400000<br>
			400000 to 500000<br>
		</p>
		<?php

		//Set API key as llave(spanish for key)
		//  $llave = 'yourkeyhere';
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

			//tossed this variable in to change the amps to dashes before it's sent via url to the next script
			$qs_string = $sl["queryString"];

			echo 'Link Name: ' . $sl["linkName"] . '<br>Link Query: ' . $sl["queryString"]
			. '<br>UID: ' . $sl["uid"] . '<br><a href="post_saved_links.php?ln=' . $sl["linkName"] . '&qs=' . str_replace("&", "-", $qs_string) .
			'&uid=' . $sl["uid"] . '&key=' . $llave . '" target="_blank">Create price range links from this link</a>' . '<br><hr><br>';



		}

		?>

		<br><br>
		<div id="plats">
			<img src="http://antoniowp.idxsandbox.com/SEO/images/lt(150)_300.png"><img src="http://antoniowp.idxsandbox.com/SEO/images/pt(150)_300.png">
		</div>
	</center>
</body>
</html>
