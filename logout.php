<?php 
session_start();

// $_SESSIONの値を空にする
$_SESSION = array();
// セッションの破壊
session_destroy();
header("Location: login.php");
exit();
?>