<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
$data = $db->prepare("
select * from users where id = ?;
");
$data->execute([
  $_SESSION["id"]
]);
$member = $data->fetch();
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
  <h1>マイページ</h1>
  <nav>
    <a href="../task/index.php">タスク一覧</a>
  </nav>
</header>
<main>
  <dl>
    <dt>ユーザ名</dt>
    <dd>
      <?php echo hsc($member["name"]) ?>
    </dd>
    <dt>メールアドレス</dt>
    <dd>
      <?php echo hsc($member["email"]) ?>
    </dd>
    <dt>ユーザ名</dt>
    <dd>
      <?php echo "【パスワードは非表示】" ?>
    </dd>
  </dl>
  <a href="edit.php">編集</a>
</main>
</body>
</html>