let empInfo = document.getElementById('empInfo');
let user_status = document.getElementById('userStatus');
let usersView = document.getElementById('usersView');
let emp_list = document.getElementById('employeeList');
let home_div = document.getElementById("home_div");
let new_role = document.getElementById("newRoleForm");
let role_list = document.getElementById("role_list");
let roster_view = document.getElementById("viewRoster");
let new_roster = document.getElementById('newRoster');
let pat_reg_form = document.getElementById("pat_reg_form");

const page_elms = [emp_list,home_div,role_list,roster_view,new_roster,
  pat_reg_form, user_status, new_role, empInfo, usersView];

const len = page_elms.length;

function hide_elm (elm) {
  if(typeof(elm) != 'undefined' && elm != null){
  if (elm.style.display == "flex"){
    elm.style.display = "none";
  } else if (elm.style.display == "inline-block"){
    elm.style.display = "none";
  } else {
    elm.style.display = "none";
  }
  }
};

function show_elm_block (elm) {
  if(typeof(elm) != 'undefined' && elm != null){
  if (elm.style.display == "none"){
    elm.style.display = "inline-block";
  } else {
    elm.style.display = "inline-block";
  }
}
};

function show_elm_flex (elm) {
  if(typeof(elm) != 'undefined' && elm != null){
  console.log("BANG");
  if (elm.style.display == "none"){
    elm.style.display = "flex";
    console.log("BANG BANG");
  } else {
    elm.style.display = "flex";
    console.log("BANG BANG BANG");
  }
}
};

function getApproval () {

  for (i=0; i < len; i++){
    if (page_elms[i]== user_status){
      show_elm_flex(page_elms[i]);
    }else if (page_elms[i] == usersView){
      show_elm_block(usersView);
    } else {
      hide_elm(page_elms[i]);
    }
  }

};

function view_pat_reg () {

  for (i=0; i < len; i++){
    if (page_elms[i]== pat_reg_form){
      show_elm_block(pat_reg_form);
    } else {
      hide_elm(page_elms[i]);
    }
  }
};

function getEmployees ()  {

  for (i=0; i < len; i++){
    if (page_elms[i]== emp_list){
      show_elm_flex(emp_list);
    } else if (page_elms[i]== empInfo){
      show_elm_block(empInfo);
    } else {
      hide_elm(page_elms[i]);
    }
  }
};

function viewHome ()  {

  for (i=0; i < len; i++){
    if (page_elms[i]== home_div){
      show_elm_block(home_div);
    } else {
      hide_elm(page_elms[i]);
    }
  }
};

function viewNewRole ()  {

  for (i=0; i < len; i++){
    if (page_elms[i]== role_list){
      show_elm_block(role_list);
  } else if (page_elms[i]== new_role){
    show_elm_flex(new_role);
  } else {
    hide_elm(page_elms[i]);
    }
  }
};

function viewRosterForm () {

  for (i=0; i < len; i++){
    if (page_elms[i] == new_roster){
      show_elm_flex(new_roster);
    } else {
      hide_elm(page_elms[i]);
    }
  }
};

if (typeof document.getElementById('ros') !== 'undefined' && document.getElementById('ros') != null) {
  let ros = document.getElementById('ros');
}

if (typeof document.getElementById("reg") !== 'undefined' && document.getElementById("reg") != null) {
  let reg = document.getElementById("reg");
}

if (typeof document.getElementById("emp") !== 'undefined' && document.getElementById("emp") != null) {
  let emp = document.getElementById("emp");
}

if (typeof document.getElementById("newRole") !== 'undefined' && document.getElementById("newRole") != null) {
  let rewRole = document.getElementById("newRole");

}

let home = document.getElementById("home");
let pat_reg = document.getElementById("pat_reg");

if (typeof ros !== 'undefined' && ros != null) {
  ros.addEventListener("click", viewRosterForm);
}
if (typeof reg !== 'undefined' && reg != null) {
  reg.addEventListener("click", getApproval);
}
if (typeof emp !== 'undefined' && emp != null) {
  emp.addEventListener("click", getEmployees);
}
if (typeof home !== 'undefined' && home != null) {
  home.addEventListener("click", viewHome);
}
if (typeof newRole !== 'undefined' && newRole != null) {
  newRole.addEventListener("click", viewNewRole);
}
if (typeof pat_reg !== 'undefined' && pat_reg != null) {
  pat_reg.addEventListener("click", view_pat_reg);
}
