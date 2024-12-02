<?php

   function connectdb() {
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=todo_list;charset=utf8", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // echo "Connected successfully";
    } catch(PDOException $e) {
     // echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
   }
  
?>
