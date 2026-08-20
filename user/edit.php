<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

$data = $db->prepare("
select * from users where id = ?;
");
$data->execute([
  $_SESSION["id"]
]);
$user = $data->fetch();
print_r($user);

if (!empty($_POST)){
  // 値チェック
  if ($_POST["name"] ?? "" == ""){
    $error["name"] = "blank";
  }
  if ($_POST["email"] ?? "" == ""){
    $error["email"] = "blank";
  }
  if ($_POST["email"] ?? "" != ""){
    $check = $db->prepare("
    select count(*) as cnt from users where email = ?;
    ");
    $count = $check->execute([
      $_POST["email"]
    ]);
    if ($count["cnt"] > 0){
      $error["email"] = "duplicate";
    }
  }
  if ($_POST["password"] ?? "" == ""){
    $error["password"] = "blank";
  }

  if (empty($error)){
    $update = $db->prepare("
    update users set name = ?, email = ?, password = ?
    where id = ?;
    ");
    $update->execute([
      $_POST["name"],
      $_POST["email"],
      password_hash($_POST["password"], PASSWORD_DEFAULT),
      $_SESSION["id"]
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
  <h1>ユーザ編集画面</h1>
</header>
<nav>
  <a href="index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>ユーザ名（現在）</dt>
    <dd>
      <?php echo hsc($user["name"] ?? "");?> 
    </dd>
    <dt>ユーザ名（変更内容）</dt>
    <dd>
      <input type="text" name="name" value="edit1" size="30" maxlength="100"> 
    </dd>
    <dt> メールアドレス（現在）</dt>
    <dd>
      <?php echo hsc($user["email"] ?? ""); ?>
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