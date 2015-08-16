  <h1>Saved links with range of prices</h1>

    <?php

    //default variables from url string and default prices

    $llave = $_GET["key"];
    $save_link_id = $_GET["uid"];

    //change the undersorces back to amps
    $saved_link_base_string = str_replace("_", "&", $_GET["qs"]);

    $default_lp= '0';
    $default_hp ='100000';
    $linkName = $_GET["ln"];
    $pageTitle = '';
    $linkTitle = '';
    $price = 100000;


    echo 'key = ' . $llave . '<br>saved link ID = ' . $save_link_id . '<br>url string = ' . $saved_link_base_string
    . '<br>link name = ' . $linkName;


    // use wildcard to remove any &hp=*&  or &lp=*& values inside the existing url string variable

    $saved_link_base_string = preg_replace('/&hp=.*?&/', '&', $saved_link_base_string);

    $saved_link_base_string = preg_replace('/&lp=.*?&/', '&', $saved_link_base_string);

    // remove any &hp= or &lp= at the shoudld they be at the end of the string

    $saved_link_base_string = preg_replace('/&hp=.*/', '', $saved_link_base_string);

    $saved_link_base_string = preg_replace('/&lp=.*/', '', $saved_link_base_string);

    // change all & and = to , and => for passing as an array in the API call also
  //  start using " so I can add ' to the query string array

    $values = $saved_link_base_string = preg_replace("/&/", "','", $saved_link_base_string);
    $values = $saved_link_base_string = preg_replace("/=/", "'=>'", $saved_link_base_string);
    //find + and replace with empty space to handle encoding quick in the IDX Broker API
    $values = $saved_link_base_string = str_replace("/+/", " ", $saved_link_base_string);



    //new string with no hp or lp values
    echo '<br>new string: ' . $saved_link_base_string;



    while ($price < 500000){


$lp = "','lp'=>'" . $price . "',";

      $price = $price + 100000;

$hp = "'hp'=>'" . $price . "'";



$q_string = "'" . $saved_link_base_string . $lp . $hp;

$price_100k_less = $price - 100000;


// access URL and request method
$url = 'https://api.idxbroker.com/clients/savedlinks';
$data = array(
'linkName'=>$linkName . $price_100k_less . 'to' . $price, // the link's url
'pageTitle'=>$linkName . $price_100k_less . 'to' . $price, // the title tag
'linkTitle'=>$linkName . $price_100k_less . 'to' . $price, // how the link displays
'queryString'=>array($q_string)
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



echo '<br><br>Returned code: ' . $code . '<br> If 200 returned the link ' . $linkName . $price_100k_less . 'to' . $price . ' was added<br>';




}




    ?>
