function getApproval(){
  document.getElementById("userStatus").style.display = "inline-block";
  document.getElementById("employeeList").style.display = "none";
}

function getEmployees(){
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "inline-block";
}

document.getElementById("reg").addEventListener("click", getApproval);
document.getElementById("emp").addEventListener("click", getEmployees);
