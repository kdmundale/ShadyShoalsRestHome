function isPatient(regRole){
    if(regRole){
        patRoleValue = document.getElementById("patRole").value;
        selectValue = document.getElementById("roleSelect").value;
        if(patRoleValue == selectValue){
            document.getElementById("patInfo").style.display = "flex";
        }
        else{
            document.getElementById("patInfo").style.display = "none";
        }
    }
    else{
        document.getElementById("patInfo").style.display = "none";
    }
}

document.getElementById('roleSelect').addEventListener('change', isPatient);
