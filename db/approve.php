<?php
  require 'db.php';
  require "../includes/head.php";
  require "../includes/header.php";
  session_start();
if ((isset($_POST['submit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)) {

  $approval = $_POST['approval'];

  if ($approval==1) {
    $pageTitle = "Already Approved";
  } elseif ($approval==3) {
    $pageTitle = "Pending Approval";
  } elseif ($approval == 0) {
    $pageTitle = "Deactivated";
  }

  if(mysqli_connect_errno()){
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")");
}
//get results from database
if ($approval==1 || $approval==0){
$sql = "SELECT u.id, r.sec_level, r.position, u.first_name, u.last_name, u.email, u.phone, u.dob, u.status FROM users u, role_security r WHERE u.position_id = r.position_id AND status = ?";
$all_property = array();  //declare an array for saving property
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt,$sql)){
  echo "There was an error with the server 1.";
  echo "<br/>";
  echo "<a href='../index.php'>Go back</a>";
  exit();
} else {
  mysqli_stmt_bind_param($stmt, "i", $approval);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
}
} else {
$sql = "SELECT u.id, r.sec_level, r.position, u.first_name, u.last_name, u.email, u.phone, u.dob, u.status FROM users u, role_security r WHERE u.position_id = r.position_id AND status is NULL";
$all_property = array();  //declare an array for saving property
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt,$sql)){
  echo "There was an error with the server 1.";
  echo "<br/>";
  echo "<a href='../index.php'>Go back</a>";
  exit();
} else {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
}
}
echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";
require "../includes/ASMenu.php";

echo "<form id='employeeList' class='homeForm' action='../db/employees.php' method='post'>";
echo "<label for='empList'>View employees </label>";
$sql2 = "SELECT position FROM role_security WHERE sec_level < 5;";
$stmt2 = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt2,$sql2)){
  echo "There was an error with the server 1.";
  echo "<br/>";
  echo "<a href='../index.php'>Go back</a>";
  exit();
} else {
  mysqli_stmt_execute($stmt2);
  $result2 = mysqli_stmt_get_result($stmt2);
  echo "<select id='roleSelect' class='regSelect' name='position'>";
  echo "<option>Select Position</option>";
  echo "<option id='allPos' value=20>All Positions</option>";
  while ($row2 = mysqli_fetch_array($result2)) {
    echo "<option id=".$row2['position']." value =".$row2['position'].">" . $row2['position'] . "</option>";
  }
  echo "</select>";
  echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button></form>";

  }


echo "<h1 style='margin-top:20px;'>Users ".$pageTitle."</h1>";
echo '<table class="data-table">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
    echo "<td>" . $property->name . '</td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
echo "<td></td>";
// echo "<td style='font-size:18; font-weight:bold'> change </td>";
echo '</tr>'; //end tr tag
//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo '<tr class="table-data"><form action="editUsers.php" method="post">';
    foreach ($all_property as $item) {
      $newId = $row['id'];
      echo "<td>" . $row[$item] . '</td>'; //get items using property value
    }
    echo "<td><select id='approval' name='approve[]'><option value=''>Action</option><option value='approve'>Approve</option><option value='deactivate'>Deactivate</option><input id='userId' name='ids[]' type='hidden' value=".$newId."></td>";
    echo "</tr>";
}
echo "</table>";
echo "<button style='font-size: 14px;font-weight:bold;padding: 3px;width: 130px;background: linear-gradient(#e95e34,#e98f34,#e95e34);' type='submit' name='submit'>change</button></form>";
// echo "<a style='font-size: 14px;font-weight:bold;margin-bottom: 20px;border: 1px solid #493a7e;border-radius: 25% 10%;text-align:center;text-shadow: #acd4c3 1px 0 10px;padding: 2px;width: 130px;background: linear-gradient(#acd4c3,#6d86c4,#acd4c3);' href='../views/aHome.php'>HOME</a>";
}
echo <<< "NEW2"
</div>
</section>
NEW2;
require "../includes/footer.php";

?>
