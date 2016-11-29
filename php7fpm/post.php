<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>XSS Site</title>
  </head>
  <body>

<?php
        if(!isset($_POST["data"]) || empty($_POST["data"])){
            echo "<p>no data</p>";
        }
        else{
            echo $_POST["data"];
        }
        echo "<button onClick=\"history.back()\">Back</button>";
?>

  </body>
</html>
