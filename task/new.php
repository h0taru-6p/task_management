<?php
session_start();
require("../common/dbconnect.php");
require("../common/functions.php");
login_check($_SESSION["id"]);

if (!empty($_POST)){
  // タイトルチェック
  $title_error = validate_title($_POST["title"]);
  if ($title_error != ""){
    $error["title"] = $title_error;
  }
  // エラーなければ更新
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
    $_SESSION["message"] = "タスクを登録しました";
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
  <nav>
    <a href="index.php">戻る</a>
  </nav>
</header>
<main>
  <form action="" method="post">
    <dl>
      <dt>タイトルを入力</dt>
      <dd>
        <input type="text" name="title" value="<?= hsc($_POST["name"] ?? ""); ?>" size="30" maxlength="30">
        <?php if (($error["title"] ?? "") == "blank"): ?>
        <p class="error">タイトルは必須です</p>
        <?php endif; ?>
        <?php if (($error["title"] ?? "") == "too_long"): ?>
        <p class="error">長すぎます</p>
        <?php endif; ?>
      </dd>
      <dt>説明文を入力（任意）</dt>
      <dd>
        <textarea name="description" cols="31" rows="5"><?= hsc($_POST["description"] ?? ""); ?></textarea>
      </dd>
      <dt>期限日を入力（任意）</dt>
      <dd>
        <input type="date" name="due_date" min="1700-01-01" max="2099-12-31" value="<?= hsc($_POST["due_date"] ?? ""); ?>">
      </dd>
    </dl>
    <button type="submit" class="btn">登録</button>
  </form>
</main>
</body>
</html>