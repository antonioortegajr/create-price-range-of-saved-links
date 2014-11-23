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

    <h1>Saved links with range of prices</h1>
    <?php

    //default variables from url string and default prices

    $llave = $_GET["key"];
    $save_link_id = $_GET["uid"];

    //change the dashes back to amps
    $saved_link_base_string = str_replace("-", "&", $_GET["qs"]);

    $default_lp= '0';
    $default_hp ='100000';
    $linkName = $_GET["ln"];
    $pageTitle = '';
    $linkTitle = '';
    $hp = 100000;
    $lp = 0;


    echo 'key = ' . $llave . '<br>saved link ID = ' . $save_link_id . '<br>url string = ' . $saved_link_base_string
    . '<br>link name = ' . $linkName;

    //loop for priceranges begins here.. when I write it.


    if ($hp == 500000){

      //kill loop


    }

    else {



      $hp = $hp + 100000;
      $lp = $lp + 100000;


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
      echo '<br>http code: ' . $code . '<br><br>';
    }


    ?>


    <br><br>
    <div id="plats">
      <img src="http://antoniowp.idxsandbox.com/SEO/images/lt(150)_300.png"><img src="http://antoniowp.idxsandbox.com/SEO/images/pt(150)_300.png">
    </div>
  </center>
</body>
</html>
