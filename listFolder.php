<?php
  $currentDirectory = "uploads";
  $directoryNames = array();
  function readDirectory($dirTarget){
    $dir = "";
    $dir = opendir($dirTarget);
    global $directoryNames;
    $files = array();
    array_push($directoryNames, $dirTarget);
    while ($file = readdir($dir)) {
      if (filetype($dirTarget . "/" . $file) == "dir") {
        $file_content = array("name" => $file, "type" => "dir", "path" => $dirTarget . "/" . $file);
        array_unshift($files, $file_content);
      } else {
        $file_content = array("name" => $file, "type" => "f", "path" => $dirTarget . "/" . $file);
        array_push($files, $file_content);
      }
    }
    foreach ($files as $index => $value) {
      if (preg_match("/^\.{1,2}$/", $value["name"]) != 1) {
        if ($value["type"] == "dir") {
          readDirectory($value["path"]);
        }
      }
    }
    closedir($dir);
    return;
  }
  readDirectory($currentDirectory);
  echo json_encode($directoryNames);
  

?>