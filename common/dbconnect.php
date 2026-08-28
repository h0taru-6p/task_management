<?php
try{
  $db = new PDO("mysql:dbname=task;host=127.0.0.1;charset=utf8", "root", "");
  // DB接続
  }catch (PDOException $e){
    echo "DB接続エラー： ". $e->getMessage();
  }
?>