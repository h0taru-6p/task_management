<?php
session_start();
require("dbconnect.php");

if (!empty($_POST)){
  $user = $db->prepare("
  select * from users where email = ?;
  ");
  $user->execute([
    $_POST["email"],
  ]);
  $member = $user->fetch();
  if (password_verify($_POST["password"], $member["password"])){
    $_SESSION["id"] = $member["id"];
    header("Location: task/index.php");
    exit();
  }
  $error["login"] = "failed";
  
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>タスク管理アプリ</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>ログイン</h1>
<nav>
  <a href="index.php">戻る</a>
</nav>
</header>
<main>
  <form action="" method="post">
    <?php if (!empty($error)): ?>
      <p class="error">メールアドレスかパスワードが違います</p>
    <?php endif; ?>
    <dl>
      <dt>メールアドレスを入力してください</dt>
      <dd>
      <input type="text" name="email" size="30" maxlength="100">
      </dd>
      <dt>パスワードを入力してください</dt>
      <dd>
      <input type="password" name="password" size="30" maxlength="100">
      </dd>
    </dl>
    <button type="submit" class="btn">ログイン</button>
  </form>
</main>
</body>
</html>