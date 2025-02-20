  /*window.onload = function () {
    document.getElementById("date").value = datestring;
    document.getElementById("date2").value = datestring;
  };
  var todaydate = new Date();
  var day = todaydate.getDate();
  var month = todaydate.getMonth() + 1;
  var year = todaydate.getFullYear();
  var datestring = day + "/" + month + "/" + year;*/
  document.addEventListener('DOMContentLoaded', function () {
    var todaydate = new Date();
    var day = todaydate.getDate();
    var month = todaydate.getMonth() + 1;
    var year = todaydate.getFullYear();
    var datestring = day + "/" + month + "/" + year;

    document.getElementById("date").value = datestring;
    document.getElementById("date2").value = datestring;
  });

  document.addEventListener("DOMContentLoaded", function () {
    let dateField = document.getElementById("date");
    if (dateField) {
        let today = new Date().toISOString().split('T')[0]; // Get YYYY-MM-DD format
        dateField.value = today;
    } else {
        console.error("Element with ID 'date' not found.");
    }
});

  
  function clearField() {
    document.getElementById("operating-system").value = "";
    document.getElementById("department").value = "";
    document.getElementById("description").value = "";
    document.getElementById("attachment").value = "";
    document.getElementById("other_te").setAttribute("hidden", "");
  }
  function clearField2() {
    document.getElementById("operating-system2").value = "";
    document.getElementById("department2").value = "";
    document.getElementById("description2").value = "";
    document.getElementById("attachment2").value = "";
    document.getElementById("other_te2").setAttribute("hidden", "");
  }
  
  function otherVal() {
    document.getElementById("Other").value = "Other";
    document.getElementById("otherValue").value = "";
  
    if (document.getElementById("description").value === "Other") {
      document.getElementById("other_te").removeAttribute("hidden");
      document.getElementById("otherValue").setAttribute("required", "");
    } else {
      document.getElementById("otherValue").removeAttribute("required");
      document.getElementById("other_te").hidden = "true";
    }
  }
  
  function otherVal2() {
    document.getElementById("Other2").value = "Other";
    document.getElementById("otherValue2").value = "";
  
    if (document.getElementById("description2").value === "Other") {
      document.getElementById("other_te2").removeAttribute("hidden");
      document.getElementById("otherValue2").setAttribute("required", "");
    } else {
      document.getElementById("otherValue2").removeAttribute("required");
      document.getElementById("other_te2").hidden = "true";
    }
  }
  
  function changeValue() {
    if (document.getElementById("otherValue").value != "") {
      document.getElementById("Other").value =
        document.getElementById("otherValue").value;
      //document.getElementById('Other').innerHTML=document.getElementById('otherValue').value;
    }
  
    //alert(document.getElementById('Other').value);
  }
  function changeValue2() {
    if (document.getElementById("otherValue").value != "") {
      document.getElementById("Other").value =
        document.getElementById("otherValue").value;
      //document.getElementById('Other').innerHTML=document.getElementById('otherValue').value;
    }
  
    //alert(document.getElementById('Other').value);
  }
  
  function fetch() {
    var val = document.getElementById("file").files[0].name;
    //alert(val);
    document.getElementById("file_name").value = val;
  }
  
  function openSide() {
    document.getElementById("sideba").style.display = "block";
    document.getElementById("sidebarClose").style.display = "block";
    document.getElementById("sidebarToggleTop").style.display = "none";
  }
  
  function openClose() {
    document.getElementById("sideba").style.display = "none";
    document.getElementById("sidebarClose").style.display = "none";
    document.getElementById("sidebarToggleTop").style.display = "block";
  }
  
  function openProfile() {
    document.getElementById("side5").style.display = "block";
  }
  
  function closeProfile() {
    document.getElementById("side5").style.display = "none";
  }
  
   function toggleOtherField() {
        var description = document.getElementById("description").value;
        var otherField = document.getElementById("other_te");
        
        if (description === "Other") {
            otherField.style.display = "table-row";
        } else {
            otherField.style.display = "none";
        }
    }