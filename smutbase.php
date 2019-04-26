<?php

$url = "https://smutstone.com/api/";

$headers = array(
    "Host: smutstone.com",
    "Referer: https://smutstone.com/",
    "X-CSRFToken: ma6MHMntKMCurE3ACNXCRi7VK1cIvaEvAvQfq8H7Kjb6WJSuMVOnYRtW5VIh8Kss",
    "Content-Type: multipart/form-data; boundary=---------------------------192520159919198852745478152",
    "Cookie: csrftoken=ma6MHMntKMCurE3ACNXCRi7VK1cIvaEvAvQfq8H7Kjb6WJSuMVOnYRtW5VIh8Kss; sessionid=4gghp7itz7m365efr8iwyowf01pwhvls; abg=dungeon:b; cook=r5umtghcvwhlhgg8getcf1u6d7rheald"
);

$base_data = "-----------------------------192520159919198852745478152\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{{CONTENT}}\r\n-----------------------------192520159919198852745478152--\r\n";
$fight_data1 = str_replace("{{CONTENT}}", '{"method":"pvp.battle.start","args":{},"v":48}', $base_data);
$fight_data2 = str_replace("{{CONTENT}}", '{"method":"pvp.battle.fight","args":{"deck":1},"v":48}', $base_data);

function post($url, $headers, $body)
{
  //open connection
  $ch = curl_init();

  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $body);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  //execute post
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

function fight()
{
  global $url, $headers, $fight_data1, $fight_data2;
  post($url, $headers, $fight_data1);
  return post($url, $headers, $fight_data2);
}

function open_chest($id)
{
  global $url, $headers, $base_data;
  $chest_data = str_replace("{{CONTENT}}", '{"method":"pvp.chest.claim","args":{"id":'.$id.',"unlock":true},"v":48}', $base_data);
  return post($url, $headers, $chest_data);
}
