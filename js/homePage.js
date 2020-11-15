function getApproval(){
  document.getElementById("userStatus").style.display = "flex";
  document.getElementById("employeeList").style.display = "none";
}

function getEmployees(){
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "flex";
}

document.getElementById("reg").addEventListener("click", getApproval);
document.getElementById("emp").addEventListener("click", getEmployees);
