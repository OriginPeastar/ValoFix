// main.js
// 作成者：OriginPeastar
// 作成日：2025/07/19

let hideTimer = null;

function showInfo(e, comment, url, point_x, point_y) {
  const info = document.getElementById("info");
  if (url != "") {
    info.innerHTML = `${comment}<br>
    <a href="${url}" target="_blank">watch video</a>`;
  } else info.innerHTML = `${comment}`;
  info.style.left = point_x + 2 + "%";
  if (point_y > 70) info.style.top = point_y - 12 + "%";
  else info.style.top = point_y + 2 + "%";
  info.style.display = "block";
}

function cancelHideInfo() {
  clearTimeout(hideTimer);
}

function hideInfo() {
  hideTimer = setTimeout(() => {
    document.getElementById("info").style.display = "none";
  }, 300);
}

// マクロ登録
const map = document.getElementById("map");
const formPopup = document.getElementById("formPopup");
const popup_point_x = document.getElementById("popup_point_x");
const popup_point_y = document.getElementById("popup_point_y");

map.addEventListener("click", function (e) {
  const rect = map.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;

  const xPer = ((x / rect.width) * 100).toFixed(2);
  const yPer = ((y / rect.height) * 100).toFixed(2);

  //計算した座標をformに送る
  document.querySelector("input[name='point_x']").value = xPer;
  document.querySelector("input[name='point_y']").value = yPer;

  const prot = document.querySelector(".prot");

  prot.style.display = "block";
  prot.style.left = `${xPer}%`;
  prot.style.top = `${yPer}%`;

  formPopup.style.display = "block";
  formPopup.style.left = parseFloat(xPer) + 2 + "%";
  if (parseFloat(yPer) > 65) formPopup.style.top = parseFloat(yPer) - 28 + "%";
  else formPopup.style.top = parseFloat(yPer) + 2 + "%";
});

function closePopup() {
  const formPopup = document.getElementById("formPopup");
  const prot = document.querySelector(".prot");
  formPopup.style.display = "none";
  prot.style.display = "none";
}
