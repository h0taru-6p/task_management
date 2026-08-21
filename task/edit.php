<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

$data = $db->prepare("
select * from tasks where id = ?;
");
$data->execute([
  ($_REQUEST["id"] ?? "")
]);
$task = $data->fetch();

if (!empty($_POST)){
  if (($_POST["title"] ?? "") == ""){
    $error["title"] = "blank";
  }
  if (($_POST["completed"] ?? "") == ""){
  $error["completed"] = "blank";
  }
  if (empty($error)){
    $update = $db->prepare("
    update tasks set title = ?, description = ?, due_date = ?, completed = ? where id = ?;
    ");
    $update->execute([
      $_POST["title"],
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
      <input type="text" name="title" value="<?php echo hsc($task["title"]); ?>" size="30" maxlength="30">
      <?php if (($error["title"] ?? "") == "blank"): ?>
      <p class="error">タイトルは必須です</p>
      <?php endif; ?>
    </dd>
  </dl>
  <dl>
    <dt>説明文を編集(任意)</dt>
    <dd>
      <textarea name="description" cols="30" rows="3"><?php echo hsc($task["description"]); ?></textarea>
    </dd>
  </dl>
  <dl>
    <dt>期限日を編集（任意）</dt>
    <dd>
      <input type="date" name="due_date" value="<?php echo hsc(date("Y-m-d", strtotime($task["due_date"]))); ?>">
    </dd>
  </dl>
  <dl>
    <dt>完了/未完了
      (現在の設定：<?php echo hsc($task["completed"] == 0 ? "未完了" : "完了") ; ?>)
    </dt>
    <dd>
      <input type="radio" id="choice1" name="completed" value="1">
      <label for="choice1">完了</label>
      <input type="radio" id="choice2" name="completed" value="0">
      <label for="choice2">未完了</label>
      <?php if (($error["completed"] ?? "") == "blank"): ?>
        <p class="error">完了/未完了は必須です</p>
      <?php endif; ?>
    </dd>
  </dl>
  <input type="submit" value="変更">
</form>
<a href="delete.php?id=<?php echo hsc($_REQUEST["id"]) ?>">削除</a>

</body>
</html>