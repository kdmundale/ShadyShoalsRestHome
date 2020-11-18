var empInfo = document.getElementById("empInfo");
var usersView = document.getElementById("usersView");

function getApproval(){
  document.getElementById("userStatus").style.display = "flex";
  document.getElementById("employeeList").style.display = "none";
  document.getElementById("home_div").style.display = "none";
  document.getElementById("newRoleForm").style.display= "none";

  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "inline-block";
  }
}

function getEmployees(){
  document.getElementById("employeeList").style.display = "flex";
  document.getElementById("newRoleForm").style.display= "none";
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("home_div").style.display = "none";

  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "inline-block";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
}

function viewHome(){
  document.getElementById("home_div").style.display = "inline-block";
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "none";
  document.getElementById("newRoleForm").style.display= "none";

  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
}

function viewNewRole(){
  document.getElementById("newRoleForm").style.display= "flex";
  document.getElementById("home_div").style.display = "none";
  document.getElementById("userStatus").style.display = "none";
  document.getElementById("employeeList").style.display = "none";

  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
}

document.getElementById("reg").addEventListener("click", getApproval);
document.getElementById("emp").addEventListener("click", getEmployees);
document.getElementById("home").addEventListener("click", viewHome);
document.getElementById("newRole").addEventListener("click", viewNewRole);
