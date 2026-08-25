<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

$task = $db->prepare("
delete from tasks where id = ?;
");
$task->execute([
  $_REQUEST["id"]
]);
header("Location: index.php");
exit();
?>