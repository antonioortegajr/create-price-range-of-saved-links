<?php

//default variables from url string and default prices

$llave ='';
$save_link_id ='';
$saved_link_base_string ='';
$default_lp= '100000';
$default_hp ='200000';
$linkName ='';
$pageTitle ='';
$linkTitle ='';
$queryString ='';

//loop for prices begins here.. when I write it.



// access URL and request method
$url = 'https://api.idxbroker.com/clients/savedlinks';
$data = array(
    'linkName'=>'$linkName', // the link's url
    'pageTitle'=>'$pageTitle', // the title tag
    'linkTitle'=>'$linkTitle', // how the link displays
    'queryString'=>array($queryString)
);
$data = http_build_query($data); // encode and & delineate
$method = 'PUT';

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

if ($method != 'GET')
    curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);

// send the data
curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference
$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code >= 200 || $code < 300)
    $response = json_decode(response,true);
else
    $error = $code;


//echo http code so I know what is going on
echo 'http code: ' . $code . '<br><br>';




?>
