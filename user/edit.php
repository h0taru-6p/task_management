<?php
session_start();

if (!empty($_POST)){
  $_SESSION["join"] = $_POST;
  header("Location: index.php");
  exit();
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
  <h1>ユーザ編集画面</h1>
</header>
<nav>
  <a href="index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>ユーザ名（現在）</dt>
    <dd>
      <?php echo $_SESSION["join"]["name"]?> 
    </dd>
    <dt>ユーザ名（変更内容）</dt>
    <dd>
      <input type="text" name="name" value="edit1" size="30" maxlength="100"> 
    </dd>
    <dt> メールアドレス（現在）</dt>
    <dd>
      <?php echo $_SESSION["join"]["name"] ?>
    </dd>
    <dt> メールアドレス（変更内容）</dt>
    <dd>
      <input type="text" name="email" value="edit2" size="30" maxlength="100"> 
    </dd>
    <dt> パスワード（現在）</dt>
    <dd>
      <?php echo "【非表示】" ?>
    </dd>
    <dt>パスワード（変更内容）</dt>
    <dd>
      <input type="password" name="password" value="edit3" size="30" maxlength="100"> 
    </dd>
  </dl>
  <input type="submit" value="変更">
</form>



</body>
</html>