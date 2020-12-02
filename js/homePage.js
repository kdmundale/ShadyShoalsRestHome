let emp_list = document.getElementById('employeeList');
let home_div = document.getElementById("home_div");
let new_role = document.getElementById("newRoleForm");
let role_list = document.getElementById("role_list");
let roster_view = document.getElementById("viewRoster");
let pat_reg = document.getElementById("pat_reg_form");
let new_roster = document.getElementById('newRoster');
let pat_reg_form = document.getElementById("pat_reg_form");

let page_elms = [emp_list,home_div,new_role,role_list,roster_view,pat_reg,new_roster, pat_reg_form];
let len = page_elms.length;

function hide_elm (elm) {
  if (elm.style.display != "none"){
    elm.style.display = "none";
  } else {
    elm.style.display = "none";
  }
};

function show_elm_block (elm) {
  if (elm.style.display != "inline-block"){
    elm.style.display = "inline-block";
  } else {
    elm.style.display = "inline-block";
  }
};

function show_elm_flex (elm) {
  if (elm.style.display != "flex"){
    elm.style.display = "flex";
  } else {
    elm.style.display = "flex";
  }
}

function getApproval () {
  for (i=0; i < len; i++){
    if (page_elms[i]== userStatus){
      show_elm_flex(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "inline-block";
  }
};

function view_pat_reg () {
  for (i=0; i < len; i++){
    if (page_elms[i]== pat_reg_form){
      show_elm_block(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }

};

function getEmployees ()  {
  for (i=0; i < len; i++){
    if (page_elms[i]== emp_list){
      show_elm_flex(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "inline-block";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
};

function viewHome ()  {
  for (i=0; i < len; i++){
    if (page_elms[i]== home_div){
      show_elm_block(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
};

function viewNewRole ()  {
  for (i=0; i < len; i++){
    if (page_elms[i]== role_list){
      show_elm_block(page_elms[i]);
    } else if (page_elms[i]== new_role){
      show_elm_flex(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
};

function viewRosterForm () {
  for (i=0; i < len; i++){
    if (page_elms[i]== new_roster){
      show_elm_flex(page_elms[i]);
    } else {
      hide_elm(page_elms[i]);
    }
  }
  if(typeof(empInfo) != 'undefined' && empInfo != null){
      document.getElementById("empInfo").style.display = "none";
  }
  if(typeof(usersView) != 'undefined' && usersView != null){
      document.getElementById("usersView").style.display = "none";
  }
};

document.getElementById('ros').addEventListener("click", viewRosterForm);
document.getElementById("reg").addEventListener("click", getApproval);
document.getElementById("emp").addEventListener("click", getEmployees);
document.getElementById("home").addEventListener("click", viewHome);
document.getElementById("newRole").addEventListener("click", viewNewRole);
document.getElementById("pat_reg").addEventListener("click", view_pat_reg);
