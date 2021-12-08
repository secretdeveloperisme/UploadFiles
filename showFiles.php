<?php
  $currentDirectory = "uploads";
  function readDirectory($dirTarget){
        $dir = "";
        $dir = opendir($dirTarget);
        echo "<div class='directory-container'>";
        echo "<h3 class='directory' isOpen='true'>".basename($dirTarget)."</h3>";
        echo "<ul>";
        $files = array();
        while($file = readdir($dir)){
          if(filetype($dirTarget."/".$file) == "dir"){
            $file_content = array("name"=>$file,"type"=>"dir", "path"=>$dirTarget."/".$file);
            array_unshift($files,$file_content);
          }
          else{
            $file_content = array("name"=>$file,"type"=>"f", "path"=>$dirTarget."/".$file);
            array_push($files, $file_content);
          }
        }
        foreach($files as $index => $value){
          if(preg_match("/^\.{1,2}$/",$value["name"]) != 1){
            if($value["type"] == "dir"){
              readDirectory($value["path"]);
            }
            else{
              $path = $value["path"];
              echo "<li class='file'>"."<a href='$path'>".$value["name"]."</a>"."<button class='btnDelFile'>delete</button>"."</li>";
            }
          }
        }
        // var_dump($files);
        // while($file = readdir($dir)){
        //   if(filetype($dirTarget.$file) == "dir"){
            
        //   }
        //   echo "<li class='file'>"."<a href='$dirTarget'>".$dirTarget."</a>"."</li>";
        // }
        echo "</uL>";
        echo "</div>";
        closedir($dir);
      return;
  }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show Files</title>
  <style>
    .directory-container:hover{
      cursor: pointer;
    }
    .directory{
      color: red;
      padding-left: 20px;
    }
    a{
      text-decoration: none;
    }
    .btnDelFile{
      background-color: red;
      outline: none;
      border: none;
      color: white;
      margin-left: 5px;
    }
    .btnDelFile:hover{
      opacity: 0.7;
    }
    .btnDelFile:active{
      background-color: #4d82cb;
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
      })
      $(".btnDelFile").each((index, element)=>{
        $(element).on("click", (event)=>{
          console.log($(event.target).prev())
          $.ajax({
            url : "deleteFile.php",
            type : "POST",
            data : {
              path : $(event.target).prev("a").attr("href")
            },
            dataType : "text",
            success : (response)=>{
              responseObject = JSON.parse(response);
              if(responseObject.code == 0){
                $(event.target).parent().remove();
              }
            }
          })
        })
      })
    });

  </script>
</head>
<body>
  <h1>Directory contents</h1>
  <?php
    readDirectory($currentDirectory);
  ?>
</body>
</html>