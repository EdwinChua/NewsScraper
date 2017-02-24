<?php
function CurlToDB($article)
{
  $post_string ="";
  $curl_connection = curl_init('http://localhost/PHPServerConnection/addpost.php');
  //$curl_connection = curl_init('http://edwinchua.tech/Articles/php/addpost.php');

  foreach ($article as $name => $value)
  {
      $post_items[] = $name . '=' . $value;
  }
  $post_string = $post_string . implode ('&', $post_items);
  curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
  $result = curl_exec($curl_connection);
  curl_close($curl_connection);
}
