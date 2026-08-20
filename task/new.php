<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

if (!empty($_POST)){
  if ($_POST["title"] == ""){
    $error["title"] = "blank";
  }
  if (empty($error)){
    $task = $db->prepare("
    insert into tasks (user_id, title, description, due_date)
    values (?, ?, ?, ?);
    ");
    $task->execute([
      $_SESSION["id"],
      $_POST["title"],
      ($_POST["description"] ?? null),
      ($_POST["due_date"] ?? null)
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
  <h1>タスク登録</h1>
</header>
<nav>
  <a href="index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>タイトルを入力</dt>
    <dd>
      <input type="text" name="title" value="<?php echo hsc($_POST["name"] ?? ""); ?>" size="30" maxlength="100">
      <?php if (($error["title"] ?? "") == "blank"): ?>
      <p class="error">タイトルは必須です</p>
      <?php endif; ?>
    </dd>
  </dl>
  <dl>
    <dt>説明文を入力（任意）</dt>
    <dd>
      <textarea name="description" cols="30" rows="3"><?php echo hsc($_POST["description"] ?? ""); ?></textarea>
    </dd>
  </dl>
  <dl>
    <dt>期限日を入力（任意）</dt>
    <dd>
      <input type="date" name="due_date" value="<?php echo hsc($_POST["due_date"] ?? ""); ?>">
    </dd>
  </dl>
  <input type="submit" value="登録">
</form>

</body>
</html>