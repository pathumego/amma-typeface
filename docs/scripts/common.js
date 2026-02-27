// configs.
var lsKey = "amma-str";
window.canvasDataUrl = null;

$(document).ready(function () {
  // Read localStorage
  var str = getFromLocalStorage();
  if (str !== null) {
    $("#textbox").val(str);
    draw();
  }
});

function triggerTextAreaChange() {
  setTimeout(function () {
    var str = $("#textbox").val();
    setLocalStorage(str);
    draw();
  }, 0);
}

function setLocalStorage(str) {
  window.localStorage.setItem(lsKey, str);
}

function getFromLocalStorage() {
  var str = window.localStorage.getItem(lsKey);
  return str;
}

function resetSession() {
  window.localStorage.removeItem(lsKey);
  resetCanvas();
  $("#textbox").val("අම්මා");
  draw();
}

function draw() {
    var text = document.getElementById("textbox").value;
    var canvas = document.getElementById("input_canvas");
    canvas.width = window.innerWidth;
    var ctx = canvas.getContext("2d");
    ctx.font = "50px Amma-Regular";
    ctx.fillStyle = "red";
    // ctx.textAlign = "center";
    ctx.fillText(text, 10, 50);
}

function resetCanvas() {
  var canvas = document.getElementById("input_canvas");
  const ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// function download() {
//   var canvas = document.getElementById("input_canvas");
//   window.canvasDataUrl = canvas.toDataURL("image/jpeg");
//   this.href = window.canvasDataUrl;
// }
// downloadLnk.addEventListener("click", download, false);

function commandBackspace() {
  $("#textbox").val(function (index, value) {
    return value.substr(0, value.length - 1);
  });
  draw();
}

function print() {
    var text = document.getElementById("textbox").value;
    postEntry(text, window.lang);

    // Print
    var canvas = document.getElementById('input_canvas');
    var imgData = canvas.toDataURL("image/jpeg", 1.0);
    var pdf = new jsPDF();
    

    pdf.addImage(imgData, 'JPEG', 0, 0);
    pdf.save("download.pdf");
    // pdf.autoPrint();
}

function postEntry(text, lang) {
    axios({
        method: 'post',
        url: 'http://localhost:5050/entries',
        data: { text: text, lang: lang }
    });
}
