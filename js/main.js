// タスクカードの列数変更
function changeColumns(columns){
  const taskList = document.getElementById("task-list"); // HTMLのIDから検索し情報参照
  taskList.className = "columns-" + columns; // 参照したタブのクラス名を動的に変更
}
// トースト表示
function showToast(){
  const toast = document.getElementById("toast");

  toast.classList.add("show");
  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000);
}
// toastIDのついた関数がある場合のみ実行。トーストメッセージがある場合のみ生まれるよう組んである(toast.php)
if (document.getElementById("toast")){
    showToast();
    // HTMLの読み込み後に実行。HTMLファイル内でscript実行する場合は必要（deferでjsを読み込んでいる場合）
    // document.addEventListener("DOMContentLoaded", () => {
    //   if (document.getElementById("toast")){
    //     showToast();
    //   }
    // })
  }

  // モーダル表示
function showModal(){
  const deleteButton = document.getElementById("delete-button");
  const modal = document.getElementById("confirm-modal");
  const cancelButton = document.getElementById("cancel-button");

  deleteButton.addEventListener("click", () => {
    modal.style.display = "flex";
  });
  cancelButton.addEventListener("click", () => {
    modal.style.display = "none";
  });
}
showModal(); // deferで読み込んでいるためDOMContentLoaded不要
// document.addEventListener("DOMContentLoaded", () => {
//   showModal();
// });


