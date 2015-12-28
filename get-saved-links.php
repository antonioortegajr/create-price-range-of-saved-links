		<html>
		<head>
		<title>Make up some links</title>
		</head>
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
		// $llave = 'YourKeyHere';
		$llave = $_POST["llave"];

                if ($llave != NULL){
		//Get current saved links in account

		// access URL and request method
		$url = 'https://api.idxbroker.com/clients/savedlinks';
		$method = 'GET';

		// headers (required and optional)
		$headers = array(
			'Content-Type: application/x-www-form-urlencoded', // required
			'accesskey: ' . $llave, // required - replace with your own
			'outputtype: json',
			'apiversion: 1.2.1' // optional - overrides the preferences in our API control page// optional - overrides the preferences in our API control page
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
                $params = array();  
		//echo http code so I know what is going on
		echo 'http code: ' . $code . '<br><br>';

                 $i=0;
		//loop through the saved links and create a link that passes the saved link info via url string
		foreach($response as $sl){ 
		
		         $saved_link = array("link_name"=>$sl["linkName"],"query_string"=>$sl["queryString"]);                  
			
			$qs_string = $sl["queryString"];

			echo 'Link Name: ' 
			. $sl["linkName"] . '<br>Link Query: ' . $qs_string
			. '<br>UID: ' . $sl["uid"] . '<br><a href="create-links.php?q='.$i.'&key='.$llave.'"><button>Create links from '.$sl["linkName"].'</button></a><br><hr><br>';
			$i++;
			array_push($params,$saved_link);
			
			
			

		}
		
		file_put_contents('params.json',json_encode($params));
               }
               else{
                   echo'<form method="post" action="">
                   <input type="text" name="llave" placeholder="API Key" />
                   <input type="submit" name="btnSendForm" value="Get Saved Links" />
                   </form>';
               }
		?>
