<?php
require("dbconnect.php");
// セキュリティ　受け取り値のhtmlコード無効化
function hsc($value){
  return htmlspecialchars($value, ENT_QUOTES);
}

// ログインチェック　なければログイン画面に戻す
function login_check($id){
  if (!isset($id)){
    header("Location: ../login.php");
    exit();
  }
}
// ユーザ名チェック（バリデーション）
function validate_name($name){
  if (($name ?? "") == ""){
    // 空文字
    return "blank";
  }elseif(mb_strlen($name) > 30){
    // 30文字以内
    return "too_long";
  }else{
    return "";
  }
}
// メールアドレスチェック（バリデーション）
function validate_email($email){
  $pattern = '/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD';
  if (($email ?? "") == ""){
    // 空文字
    return "blank";
  }elseif(strlen($email) >= 255){
    // 255文字以内
    return "too_long";
  }elseif(!preg_match($pattern, $email)){
    // 形式エラー
    return "invalid";
  }else{
    return "";
  }
}
// メールアドレスチェック（重複）
function duplicate_email($email){
  global $db;// これがないとdbconnect.phpから読み込めない
  $stmt = $db->prepare("
    select count(*) as cnt from users where email = ?;
    ");
    $stmt->execute([
      $email
    ]);
    $count = $stmt->fetch();
    if ($count["cnt"] > 0){
      return "duplicate";
    }else{
      return "";
    }
}
// パスワードチェック（バリデーション）
function validate_password($password){
  $pattern = '/^[a-zA-Z0-9!@#$%^&*()_\-+=]+$/';
  if (($password ?? "") == ""){
    return "blank";
  }elseif(strlen($password) >= 100 and mb_strlen($password) <= 8){
    return "length_error";
  }elseif(!preg_match($pattern, $password)){
    return "invalid";
  }else{
    return "";
  }
}
// タイトルチェック（バリデーション）
function validate_title($title){
  if (($title ?? "") == ""){
    // 空文字
    return "blank";
  }elseif(mb_strlen($title) > 30){
    // 30文字以内
    return "too_long";
  }else{
    return "";
  }
}
// 期限日チェック（バリデーション）
function validate_due_date($due_date){
  if (($due_date ?? "") == ""){
    // 空文字
    return "blank";
  }else{
    return "";
  }
}
// 完了/未完了チェック（バリデーション）
function validate_completed($completed){
  if (($completed ?? "") == ""){
    // 空文字
    return "blank";
  }else{
    return "";
  }
}

// ソート機能振り分け
function sorted($sort){
  switch ($sort){
    case "created_at":
      $order = "created_at";
      break;
    case "due_date":
      $order = "due_date";
      break;
    case "completed":
      $order = "completed";
      break;
    case "title":
      $order = "title";
      break;
    default:
      $order = "created_at";
  }
  return $order;
}

?>