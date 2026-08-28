<?php
session_start();
require("../common/dbconnect.php");
require("../common/functions.php");

// 値チェック
if (!empty($_POST)){
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

  // 問題なければすすむ
  if (empty($error)){
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
  <nav>
    <a href="../index.php">戻る</a>
  </nav>
</header>
<main>
  <form action="" method="post">
    <dl>
      <dt>ユーザ名を入力してください</dt>
      <dd>
        <input type="text" name="name" value="<?php echo hsc($_POST["name"] ?? "") ?>" size="30" maxlength="30"> 
        <?php if (($error["name"] ?? "") == "blank"): ?>
          <p class="error">入力が空です</p>
        <?php endif; ?>
        <?php if (($error["name"] ?? "") == "too_long"): ?>
          <p class="error">30文字以内で入力してください</p>
        <?php endif; ?>
      </dd>
      <dt>メールアドレスを入力してください
      </dt>
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
      <dt>パスワードを入力してください</dt>
      <dd>
        <p class="note">英数字記号（ !@#$%^&*()_\-+= ）可能</p>
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
    <button type="submit" class="btn">確認</button>
  </form>
</main>
</body>
</html>