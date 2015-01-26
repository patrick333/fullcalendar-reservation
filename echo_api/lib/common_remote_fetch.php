<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function do_post_request($url, $data, $optional_headers = null)
{
  $php_errormsg="post request failed.";
  $params = array('http' => array(
              'method' => 'POST',
              // 'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
              //   . "Content-Length: " . strlen($data) . "\r\n",
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}

function do_get_request($url, $data, $optional_headers = null)
{
  $php_errormsg="get request failed.";
  $params = array('http' => array(
              'method' => 'GET',
              // 'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
              //   . "Content-Length: " . strlen($data) . "\r\n",
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}

function read_request($url){
  $handle = fopen($url, "rb");
    $contents = stream_get_contents($handle);
  fclose($handle);

  echo $contents;
}



?>