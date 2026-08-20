<?php
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

?>