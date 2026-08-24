<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

$stmt = $db->prepare("
select * from users where id = ?;
");
$stmt->execute([
  $_SESSION["id"]
]);
$user = $stmt->fetch();
print_r($user);

// 値チェック
if (!empty($_POST)){
  // 入力値画面確認用
  print_r($_POST);
  echo strlen($_POST["email"]);

  // ユーザ名
  $name_error = validate_name($_POST["name"]);
  if ($name_error != ""){
    $error["name"] = $name_error;
  }
  // メールアドレス
  $email_error = validate_email($_POST["email"]);
  if ($email_error == ""){
    $email_error = duplicate_email($_POST["email"]);
  }
  if ($email_error != ""){
    $error["email"] = $email_error;
  }
  // パスワード
  $password_error = validate_password($_POST["password"]);
  if ($password_error != ""){
    $error["password"] = $password_error;
  }

  // エラーがない場合更新
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
  <nav>
    <a href="index.php">戻る</a>
  </nav>
</header>
<main>
  <form action="" method="post">
    <dl>
      <dt>ユーザ名（現在）</dt>
      <dd>
        <?php echo hsc($user["name"] ?? "");?> 
      </dd>
      <dt>ユーザ名（変更内容）</dt>
      <dd>
        <input type="text" name="name" value="<?php echo hsc($_POST["name"] ?? "") ?>" size="30" maxlength="30"> 
        <?php if (($error["name"] ?? "") == "blank"): ?>
          <p class="error">入力が空です</p>
        <?php endif; ?>
        <?php if (($error["name"] ?? "") == "too_long"): ?>
          <p class="error">30文字以内で入力してください</p>
        <?php endif; ?>
      </dd>
      <dt> メールアドレス（現在）</dt>
      <dd>
        <?php echo hsc($user["email"] ?? ""); ?>
      </dd>
      <dt> メールアドレス（変更内容）</dt>
      <dd>
        <input type="text" name="email" value="<?php echo hsc($_POST["email"] ?? "") ?>" size="30" maxlength="255">
        <?php if (($error["email"] ?? "") == "blank"): ?>
          <p class="error">入力が空です</p>
        <?php endif; ?>
        <?php if (($error["email"] ?? "") == "too_long"): ?>
          <p class="error">入力が長すぎます</p>
        <?php endif; ?>
        <?php if (($error["email"] ?? "") == "invalid"): ?>
          <p class="error">メールアドレスの形式があっていません</p>
        <?php endif; ?>
        <?php if (($error["email"] ?? "") == "duplicate"): ?>
          <p class="error">すでに登録されているメールアドレスです</p>
        <?php endif; ?>
      </dd>
      <dt> パスワード（現在）</dt>
      <dd>
        <?php echo "【非表示】" ?>
      </dd>
      <dt>パスワード（変更内容）</dt>
      <dd>
        <p>英数字記号（ !@#$%^&*()_\-+= ）可能</p>
        <input type="password" name="password" value="<?php echo hsc($_POST["password"] ?? "") ?>" size="30" minlength="8" maxlength="100">
        <?php if (($error["password"] ?? "") == "blank"): ?>
          <p class="error">入力が空です</p>
        <?php endif; ?> 
        <?php if (($error["password"] ?? "") == "length_error"): ?>
          <p class="error">8文字以上100文字以内で入力してください</p>
        <?php endif; ?>
        <?php if (($error["password"] ?? "") == "invalid"): ?>
          <p class="error">半角英数字記号のみで入力してください</p>
        <?php endif; ?>
      </dd>
    </dl>
    <input type="submit" value="変更">
  </form>
</main>
</body>
</html>