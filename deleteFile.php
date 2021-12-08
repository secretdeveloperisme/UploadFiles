<?php
  $response = "";
  $path = $_POST["path"];
  if(unlink($path)){
    $response = array("code" => 0, "status" => "success" );
  }
  else{
    $response = array("code" => 1, "status" => "success" );
  }
  echo  json_encode($response);

?>