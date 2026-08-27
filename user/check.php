<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
if (!empty($_POST)){
  header("Location: add.php");
  exit();
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
  <h1>入力内容確認</h1>
  <nav>
    <a href="create.php?action=rewrite">修正</a>
  </nav>
</header>
<main>
  <form action="" method="post">
    <input type="hidden" name="action">
    <dl>
      <dt>ユーザ名</dt>
      <dd>
        <?php echo hsc($_SESSION["join"]["name"]) ?>
      </dd>
      <dt>メールアドレス</dt>
      <dd>
        <?php echo hsc($_SESSION["join"]["email"]) ?>
      </dd>
      <dt>ユーザ名</dt>
      <dd>
        <?php echo "【パスワードは非表示】" ?>
      </dd>
    </dl>
    <button type="submit" class="btn">登録</button>
  </form>
</main>
</body>
</html>