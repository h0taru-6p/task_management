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
  <h1>タスク編集</h1>
</header>
<nav>
  <a href="index.php">戻る</a>
</nav>
<form action="" method="post">
  <dl>
    <dt>タイトルを編集</dt>
    <dd>
      <input type="text" name="title" value="task1" size="30" maxlength="100">
    </dd>
  </dl>
  <dl>
    <dt>説明文を編集</dt>
    <dd>
      <textarea name="description" cols="30" rows="3">task2</textarea>
    </dd>
  </dl>
  <dl>
    <dt>期限日を編集（任意）</dt>
    <dd>
      <input type="date" name="deadline">
    </dd>
  </dl>
  <input type="submit" value="変更">
</form>
<a href="#">削除</a>


</body>
</html>