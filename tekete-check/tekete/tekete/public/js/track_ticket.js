function active() {
  document.getElementById("active").style.display = "block";
  document.getElementById("submted").style.display = "none";
}

function submited() {
  document.getElementById("active").style.display = "none";
  document.getElementById("submted").style.display = "block";
}

function refresh() {
  var size = 765;
  var w = window.innerWidth;
  if (w > size) {
    document.getElementById("sideba").style.display = "block";
    document.getElementById("sidebarClose").style.display = "block";
    document.getElementById("sidebarToggleTop").style.display = "none";
  }
}

setInterval(refresh, 1500);

function openProfile() {
  document.getElementById("side5").style.display = "block";
}

function closeProfile() {
  document.getElementById("side5").style.display = "none";
}
