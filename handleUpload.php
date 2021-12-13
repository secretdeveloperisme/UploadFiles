<?php
  if(isset($_POST["submit"])){
    $targetDir = $_POST["directory"];
    if(!is_dir($targetDir)){
      $targetDir="uploads/".$targetDir."/" ;
      mkdir($targetDir,0775,true);
    }
      
    $numberOfFile = count($_FILES["fileToUpload"]["name"]);
    for($i = 0; $i < $numberOfFile; $i++){
      $targeFile = $targetDir.basename($_FILES["fileToUpload"]["name"][$i]);
      if(!file_exists($targeFile)){
        //do some thing if file not exist on directory
        if($_FILES["fileToUpload"]["size"][$i] > 5000000){
          echo $targeFile . " is beyond 5MB<br>";
        }
        else{
          if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i],$targeFile)){
            echo "upload file ".htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i]))." successfully <br>";
          }
          else{
            echo "upload file ".htmlspecialchars(basename($_FILES["fileToUpload"]["name"][$i]))." failed <br>";
          }
        }
      }
      else{
        echo $targeFile." is exist<br>";
      }
    }
  }
?>