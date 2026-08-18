<?php
// セキュリティ　受け取り値のhtmlコード無効化
function hsc($value){
  return htmlspecialchars($value, ENT_QUOTES);
}
?>