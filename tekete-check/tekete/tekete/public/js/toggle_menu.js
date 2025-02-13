function next() {
  var page = "2";
  window.location.href = "index.php?page=" + page;
}
function prev() {
  var page = "0";
  window.location.href = "index.php?page=" + page;
}

function view(id) {
  var x = document.getElementById(id);

  if (window.getComputedStyle(x).display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function openSide() {
  document.getElementById("sideba2").style.display = "block";
  document.getElementById("sidebarClose").style.display = "block";
  document.getElementById("sidebarToggleTop").style.display = "none";
}

function openClose() {
  document.getElementById("sideba2").style.display = "none";
  document.getElementById("sidebarClose").style.display = "none";
  document.getElementById("sidebarToggleTop").style.display = "block";}
function changeValue(id){
    document.getElementById('idValue').value=id;
}

function changeValue(id) {
  document.getElementById("idValue").value = id;
}
