<?php
session_start();
require("../dbconnect.php");
require("../functions.php");

if (!empty($_POST)){
  // 値チェック
  if ($_POST["name"] == ""){
    $error["name"] = "blank";
  }
  if ($_POST["email"] == ""){
    $error["email"] = "blank";
  }elseif ($_POST["email"] != ""){
    $data = $db->prepare("
    select count(*) as cnt from users where email = ?;
    ");
    $data->execute([
      ($_POST["email"])
    ]);
    $count = $data->fetch();
    // print_r($count);
    if ($count["cnt"] > 0){
      $error["email"] = "duplicate"; 
    }
  }
    if ($_POST["password"] == ""){
      $error["password"] = "blank";
 }
  
  if (empty($error)){
    // 問題なければすすむ
    $_SESSION["join"] = $_POST;
    header("Location: check.php");
    exit();
    }
  }
if ($_REQUEST["action"] ?? "" == "rewrite"){
  $_POST = $_SESSION["join"];
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
  <h1>ユーザ登録</h1>
</header>
<nav>
  <a href="../index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>ユーザ名を入力してください</dt>
    <dd>
      <input type="text" name="name" value="<?php echo hsc($_POST["name"] ?? ""); ?>" size="30" maxlength="100" >
      <?php if (($error["name"] ?? "") == "blank"): ?>
      <p class="error">入力が空です</p>
      <?php endif; ?>
    </dd>
    <dt>メールアドレスを入力してください</dt>
    <dd>
      <input type="text" name="email" value="<?php echo hsc($_POST["email"] ?? ""); ?>" size="30" maxlength="100" >
      <?php if (($error["email"] ?? "") == "blank"): ?>
      <p class="error">入力が空です</p>
      <?php endif; ?>
      <?php if (($error["email"] ?? "") == "duplicate"): ?>
      <p class="error">すでに登録されているメールアドレスです</p>
      <?php endif; ?>
    </dd>
    <dt>パスワードを入力してください</dt>
    <dd>
      <input type="password" name="password" value="<?php echo hsc($_POST["password"] ?? ""); ?>" size="30" maxlength="100" >
      <?php if (($error["password"] ?? "") == "blank"): ?>
      <p class="error">入力が空です</p>
      <?php endif; ?>
    </dd>
  </dl>
  <input type="submit" value="確認">
</form>

</body>
</html>