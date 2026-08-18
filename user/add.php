<?php
session_start();
require("../dbconnect.php");
$user = $db->prepare("
insert into users (name, email, password)
values(?, ?, ?);
");
$user->execute([
  $_SESSION["join"]["name"],
  $_SESSION["join"]["email"],
  password_hash($_SESSION["join"]["password"], PASSWORD_DEFAULT)
]);
unset($_SESSION["join"]);
header("Location: ../login.php");
exit();
?>