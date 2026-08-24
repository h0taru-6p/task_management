<?php
session_start();
require("../dbconnect.php");
require("../functions.php");
login_check($_SESSION["id"]);

// 検索・絞り込み考慮したタスク一覧取得
$keyword = ($_REQUEST["keyword"] ?? "");
$sort = sorted($_REQUEST["sort"] ?? "");
$completed = $_REQUEST["completed"] ?? "";
$tasks = $db->prepare("
select * from tasks where user_id = ? and (title like ? or description like ?) and completed = ? order by $sort;
");
$tasks->execute([
  $_SESSION["id"],
  "%" . $keyword . "%",
  "%" . $keyword . "%",
  $completed
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
    <nav>
      <a href="../user/index.php">マイページ</a>
      <a href="new.php">タスク登録</a>
      <form method="get">
        <input type="text" name="keyword" value="<?= hsc(($_REQUEST["keyword"] ?? "")); ?>">
        <select name="sort">
            <option value="created_at">登録日順</option>
            <option value="due_date">期限日順</option>
            <option value="title">タイトル順</option>
          </select>
          <select name="completed">
            <option value="1">完了</option>
            <option value="0" selected>未完了</option>
          </select>
        <button type="submit">検索・ソート</button>
      </form>
      <a href="../logout.php">ログアウト</a>
    </nav>
  </header>
  <main>
    <div class="task-list">
      <?php foreach ($tasks as $task): ?>
        <?php
        // 完了/未完了のステータス
        $status = hsc($task["completed"] == 0 ? "未完了" : "完了");
        ?>
        <article class="task-card">
          <a href="edit.php?id=<?= hsc($task["id"]); ?>">
            <p>タイトル： <?= $task["title"]; ?></p>
          </a>
          <p>説明文： <?= hsc($task["description"] ?? ""); ?></p>
          <p>期限日： <span class="<?= strtotime("now") > strtotime($task["due_date"]) ? "red":""; ?>"><?= hsc(date("Y-m-d", strtotime($task["due_date"]))); ?></span></p>
          <p>完了/未完了： <span class="<?= $status == "未完了" ? "red" : "green"; ?>"><?= $status;?></span></p>
        </article> 
      <?php endforeach; ?>
    </div> 
  </main>

</body>
</html>
