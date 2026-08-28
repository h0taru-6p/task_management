<?php
session_start();
require("../common/dbconnect.php");
require("../common/functions.php");
login_check($_SESSION["id"]);

$stmt = $db->prepare("
select * from tasks where id = ?;
");
$stmt->execute([
  ($_REQUEST["id"] ?? "")
]);
$task = $stmt->fetch();
$status = hsc($task["completed"] == 0 ? "未完了" : "完了");

if (!empty($_POST)){
  // タイトルチェック
  $title_error = validate_title($_POST["title"]);
  if (($title_error ?? "") != ""){
    $error["title"] = $title_error;
  }
  // 完了/未完了チェック
  $completed_error = validate_completed($_POST["completed"]);
  if (($completed_error ?? "") != ""){
  $error["completed"] = $completed_error;
  }

  // エラーなければ更新
  if (empty($error)){
    $update = $db->prepare("
    update tasks set title = ?, description = ?, due_date = ?, completed = ? where id = ?;
    ");
    $update->execute([
      $_POST["title"],
      $_POST["description"],
      $_POST["due_date"],
      $_POST["completed"],
      $_REQUEST["id"]
    ]);
    $_SESSION["message"] = "タスクを編集しました";
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
  <script src="../js/main.js" defer></script> <!-- deferは非同期処理の指定　headにscriptタグを入れるときに必要 -->
</head>
<body>
<header>
  <h1>タスク編集</h1>
  <nav>
    <a href="index.php">戻る</a>
  </nav>
</header>
<main>
  <form action="" method="post">
    <dl>
      <dt>タイトルを編集</dt>
      <dd>
        <input type="text" name="title" value="<?php echo hsc($task["title"]); ?>" size="30" maxlength="30">
        <?php if (($error["title"] ?? "") == "blank"): ?>
        <p class="error">タイトルは必須です</p>
        <?php endif; ?>
        <?php if (($error["title"] ?? "") == "too_long"): ?>
        <p class="error">長すぎます</p>
        <?php endif; ?>
      </dd>
      <dt>説明文を編集(任意)</dt>
      <dd>
        <textarea name="description" cols="30" rows="3"><?php echo hsc($task["description"]); ?></textarea>
      </dd>
      <dt>期限日を編集（任意）</dt>
      <dd>
        <input type="date" name="due_date" value="<?php echo hsc(date("Y-m-d", strtotime($task["due_date"]))); ?>">
      </dd>
      <dt>完了/未完了
        (現在の設定：<?= $status; ?>)
      </dt>
      <dd>
        <input type="radio" id="choice1" name="completed" value="1" <?= $status == "完了"? "checked" : ""; ?>>
        <label for="choice1">完了</label>
        <input type="radio" id="choice2" name="completed" value="0" <?= $status == "未完了"? "checked" : ""; ?>>
        <label for="choice2">未完了</label>
        <?php if (($error["completed"] ?? "") == "blank"): ?>
          <p class="error">完了/未完了は必須です</p>
        <?php endif; ?>
      </dd>
    </dl>
    <button type="submit" class="btn">変更</button>
  </form>

  <!-- <a href="delete.php?id=<?php //echo hsc($_REQUEST["id"]) ?>" class="btn">削除</a> -->
  <button type="button" id="delete-button" class="btn">削除</button>
  <!-- モーダル表示 -->
  <div id="confirm-modal" class="modal"> <!-- ここでjsにより中のコンテンツをon,offする -->
    <div class="modal-content">
      <p>削除しますか？</p>
      <button type="button" id="cancel-button">キャンセル</button>
      
      <form action="delete.php" method="post">
        <input type="hidden" name="task_id" value="<?= hsc($_REQUEST["id"]); ?>">
        <button type="submit">削除する</button>
      </form>
    </div>
  </div>
</main>
</body>
</html>