function getApproval(){
  document.getElementById("userStatus").style.display = "flex";
  document.getElementById("employeeList").style.display = "none";
  document.getElementById("home_div").style.display = "none";
}

function getEmployees(){
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "flex";
  document.getElementById("home_div").style.display = "none";
}

function viewHome(){
  document.getElementById("home_div").style.display = "inline-block";
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "none";
}

document.getElementById("reg").addEventListener("click", getApproval);
document.getElementById("emp").addEventListener("click", getEmployees);
document.getElementById("home").addEventListener("click", viewHome);
