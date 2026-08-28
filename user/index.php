<?php
session_start();
require("../common/dbconnect.php");
require("../common/functions.php");
require("../common/toast.php"); // トースト表示
login_check($_SESSION["id"]);

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
  <script src="../js/main.js" defer></script> <!-- deferは非同期処理の指定　headにscriptタグを入れるときに必要 --> 
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
  <a href="edit.php" class="btn">編集</a>
</main>
</body>
</html>