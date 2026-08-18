<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
$data = $db->prepare("
select * from tasks where id = ?;
");
$data->execute([
  hsc($_REQUEST["id"] ?? "")
]);
$task = $data->fetch();

if (!empty($_POST)){
  if ($_POST["title"] ?? "" == ""){
    $error["title"] = "blank";
  }
  if (empty($error)){
    $update = $db->prepare("
    update tasks set title = ?, description = ?, due_date = ?, completed = ? where id = ?;
    ");
    $update->execute([
      $_POST["name"],
      $_POST["description"],
      $_POST["due_date"],
      $_POST["completed"],
      $_REQUEST["id"]
    ]);
    header("Location: index.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>タスク管理アプリ</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
  <h1>タスク編集</h1>
</header>
<nav>
  <a href="index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>タイトルを編集</dt>
    <dd>
      <input type="text" name="title" value="<?php echo $task["title"]; ?>" size="30" maxlength="100">
      <?php if ($_error["title"] ?? "" == "blank"): ?>
      <p class="error">タイトルは必須</p>
      <?php endif; ?>
    </dd>
  </dl>
  <dl>
    <dt>説明文を編集(任意)</dt>
    <dd>
      <textarea name="description" cols="30" rows="3"><?php echo $task["description"]; ?></textarea>
    </dd>
  </dl>
  <dl>
    <dt>期限日を編集（任意）</dt>
    <dd>
      <input type="date" name="deadline" value="<?php echo date("Y-m-d", strtotime($task["due_date"])); ?>">
    </dd>
  </dl>
  <input type="submit" value="変更">
</form>
<a href="#">削除</a>

</body>
</html>