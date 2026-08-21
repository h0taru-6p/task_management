<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

// 検索・絞り込み考慮したタスク一覧取得
$keyword = hsc(($_REQUEST["keyword"] ?? ""));
$tasks = $db->prepare("
select * from tasks where user_id = ? and (title like ? or description like ?);
");
$tasks->execute([
  $_SESSION["id"],
  "%" . $keyword . "%",
  "%" . $keyword . "%"
]);
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
    <h1>タスク一覧</h1>
  </header>
  <nav>
    <a href="../user/index.php">マイページ</a>
    |
    <a href="new.php">タスク登録</a>
    |
    <form action="" method="get">
    <input type="text" name="keyword" value="<?= hsc(($_REQUEST["keyword"] ?? "")); ?>">
    <button type="submit">検索・絞り込み</button>
  </form>
    |
    <a href="../logout.php">ログアウト</a>
  </nav>
  <main>
    <?php foreach ($tasks as $task): ?>
      <?php
      // 完了/未完了のステータス
      $status = hsc($task["completed"] == 0 ? "未完了" : "完了");
      echo $status;
      ?>
      <a href="edit.php?id=<?= hsc($task["id"]); ?>">
        <p>タイトル： <?= $task["title"]; ?></p>
      </a>
      <p>説明文： <?= hsc($task["description"] ?? ""); ?></p>
      <p>期限日： <?= hsc(date("Y-m-d", strtotime($task["due_date"]))); ?></p>
      <p>完了/未完了： <span class="<?= $status == "未完了" ? "red" : "green"; ?>"><?= $status;?></span></p>
      
    <?php endforeach; ?>
  </main>



</body>
</html>
