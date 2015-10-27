<?php
    echo '<h1>Saved links with range of prices</h1>';
  $n = $_GET["q"];
  $file = file_get_contents('params.json');
  $file = json_decode($file, true);

  //default variables from url string
  $llave = $_GET["key"];   
  $saved_link_base_string = $file[$n]["query_string"];
  $linkName = $file[$n]["link_name"];
  //defaults
  $default_lp= 0;
  $default_hp = 100000;
  $price = 100000;
  $pageTitle = '';
  $linkTitle = '';


  echo 'key = '.$llave .'<br>Original url string = '.$saved_link_base_string.'<br>link name = '.$linkName;
  // use wildcard to remove any &hp=*&  or &lp=*& values inside the existing url string variable
  $saved_link_base_string = preg_replace('/&hp=.*?&/', '&', $saved_link_base_string);
  $saved_link_base_string = preg_replace('/&lp=.*?&/', '&', $saved_link_base_string);
  
  
    //check if it's a polygon
  $pos = strpos($saved_link_base_string, 'polygon');
 
    if ($pos == true){

        $saved_link_base_string = str_replace("+"," ",$saved_link_base_string); 
        echo '<br><br>Replaced plus signs with spaces to allow for encoding quirk with IDX Broker polygon links. Documented here: <a href="https://github.com/antonioortegajr/Create-IDX-Broker-Polygon-Saved-link">on GitHub</a><br><br>';

    }

    //new string with no hp or lp values
    echo "<br>New array: ".$saved_link_base_string;
  
    //replace for submission since I dont' really want to use http_build_query()
    $saved_link_base_string = str_replace("&","&queryString%5B",$saved_link_base_string);
    $saved_link_base_string = str_replace("=","%5D=",$saved_link_base_string); 


    while ($price < 500000){
    
        $lp = "&queryString%5Blp%5D=".$price;
        $price = $price + 100000;
        $hp = "&queryString%5Bhp%5D=".$price;
        $price_100k_less = $price - 100000;


    
        // access URL and request method
        $url = 'https://api.idxbroker.com/clients/savedlinks';
       
        $names = $linkName.'-'.$price_100k_less . '-to-' . $price;

        $data = "linkName=".$names."&pageTitle=".$names."&linkTitle=".$names."&queryString%5B".$saved_link_base_string.$lp.$hp;


        $method = 'PUT';
        // headers (required and optional)
        $headers = array(
    'Content-Type: application/x-www-form-urlencoded', // required
    'accesskey: ' . $llave, // required - replace with your own
    'outputtype: json',
    'apiversion: 1.1.1'// optional - overrides the preferences in our API control page
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
    echo '<br><br>Returned code: ' . $code . '<br> If 200 returned the link ' . $linkName . $price_100k_less . 'to' . $price . ' was added.<br>';

    }

 ?>
