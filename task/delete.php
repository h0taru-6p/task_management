<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

$task = $db->prepare("
delete from tasks where id = ?;
");
$task->execute([
  $_POST["task_id"]
]);
$_SESSION["message"] = "タスクを削除しました";
header("Location: index.php");
exit();
?>