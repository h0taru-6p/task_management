<?php
session_start();
require("../common/dbconnect.php");
require("../common/functions.php");
require("../common/toast.php"); // トースト表示
login_check($_SESSION["id"]);
// 検索・絞り込み考慮したタスク一覧取得
$keyword = ($_REQUEST["keyword"] ?? "");
$sort = sorted($_REQUEST["sort"] ?? "");
$completed = $_REQUEST["completed"] ?? "";
$order = ordered($_REQUEST["order"] ?? "");
$tasks = $db->prepare("
select * from tasks where user_id = ? and (title like ? or description like ?) and completed = ? order by $sort $order;
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
  <script src="../js/main.js" defer></script> <!-- deferは非同期処理の指定　headにscriptタグを入れるときに必要 --> 
</head>
<body>
  
  <header>
    <h1>タスク一覧</h1>
    <nav>
      <div class="nav-links">
        <a href="../user/index.php">マイページ</a>
        <a href="new.php">タスク登録</a>
        <a href="../logout.php">ログアウト</a>
      </div>
      <div class="task-controls">
        <form method="get" class="controls-sort">
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
          <select name="order">
            <option value="asc" selected>昇順</option>
            <option value="desc">降順</option>
          </select>
          <button type="submit" class="btn">検索</button>
        </form>
      </div>
      <select id="column-select" onchange="changeColumns(this.value)">
        <option value="0" selected>表示：Auto</option>
        <option value="1">表示：1列</option>
        <option value="2">表示：2列</option>
      </select>
    </nav>
  </header>
  <main>
    <div id="task-list" class="columns-0">
      <?php foreach ($tasks as $task): ?>
        <?php
        // 完了/未完了のステータス
        $status = hsc($task["completed"] == 0 ? "未完了" : "完了");
        $due_date = hsc($task["due_date"] == "0000-00-00 00:00:00" ? "未設定" :  hsc(date("Y-m-d", strtotime($task["due_date"]))));
        ?>
        <article class="task-card" >
          <a href="edit.php?id=<?= hsc($task["id"]); ?>">
            <p>タイトル： <?= $task["title"]; ?></p>
          </a>
          <p>説明文： <?= hsc($task["description"] ?? ""); ?></p>
          <p>期限日： <span class="<?= strtotime("now") > strtotime($task["due_date"]) ? "red":""; ?>"><?= $due_date; ?></span></p>
          <p>完了/未完了： <span class="<?= $status == "未完了" ? "red" : "green"; ?>"><?= $status;?></span></p>
        </article> 
      <?php endforeach; ?>
    </div> 
  </main>

</body>
</html>
