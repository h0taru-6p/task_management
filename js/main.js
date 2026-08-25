// タスクカードの列数変更
function changeColumns(columns){
  const taskList = document.getElementById("task-list"); // HTMLのIDから検索し情報参照
  taskList.className = "columns-" + columns; // 参照したタブのクラス名を動的に変更
}
