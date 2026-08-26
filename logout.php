<?php 
session_start();

// $_SESSIONの値を空にする
$_SESSION = array();
// セッションの破壊
session_destroy();

session_start();
$_SESSION["message"] = "ログアウトしました";
header("Location: login.php");
exit();
?>