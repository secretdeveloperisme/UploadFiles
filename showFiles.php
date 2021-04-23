<?php
  $currentDirectory = "./";
  function readDirectory($parentDir,$dirTarget){
    if($parentDir == ""){
      $parentDir = ".";
    }
    if($parentDir == "././"){
      $parentDir = ".";
    }
  
    if(is_dir($parentDir."/".$dirTarget)){
      if(preg_match("/^\.{1,2}$/",$dirTarget)!=1&&!empty($dirTarget)){
        $dir = "";
        $dir = opendir($parentDir."/".$dirTarget);
        echo "<div class='directory-container'>";
        echo "<h3 class='directory' isOpen='true'>".$parentDir."/".$dirTarget."</h3>";
        echo "<uL>";
        while($file = readdir($dir)){
          readDirectory($parentDir."/".$dirTarget,$file);
        }
        echo "</uL>";
        closedir($dir);
        echo "</div>";
      }
      
    }
    else{
      echo "<li class='file'>"."<a href='$parentDir/$dirTarget'>".$dirTarget."</a>"."</li>";
      return;
    }
  }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show Files</title>
  <style>
    .directory{
      color: red;
    }
    a{
      text-decoration: none;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <script>
    $(document).ready(function () {
      $(".directory").each((index,element)=>{
        if($(element).attr("isOpen")=="true"){
          $(element).prepend("<i class='fas fa-minus'>");
        }
        $(element).click(event=>{
          if($(event.target).attr("isOpen")=="true"){
            $(event.target).attr("isOpen","false")
            $(event.target).children().filter("i").attr("class","fas fa-plus")
          }
          else{
            $(event.target).attr("isOpen","true")
            $(event.target).children().filter("i").attr("class","fas fa-minus")
          }
            $(event.target).siblings("ul").slideToggle(1000);
        })
        console.log(element);
      })
    });
  </script>
</head>
<body>
  <h1>Directory contents</h1>
  <?php
    readDirectory("",$currentDirectory);
  ?>
</body>
</html>