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
$sql = "SELECT id, first_name, last_name, role, email, phone, dob, status FROM users WHERE status = ?";
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
$sql = "SELECT id, first_name, last_name, role, email, phone, dob, status FROM users WHERE status is NULL";
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
echo <<< "NEW"
<h1>Welcome, admin!</h1>
<a href="../db/logout.php">Logout</a>
<section class="homeMain">
<nav>
  <ul>
    <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
    <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
    <li><a class="navLink" href="">Roster</a></li>
    <li><a class="navLink" href="">Patients</a></li>
    <script defer src="../js/homePage.js" type="text/javascript"></script>
  </ul>
</nav>
<div id="home_page_content" class="homeContent">
  <form id="userStatus" class="" action="../db/approve.php" method="post">
    <label for="approval">View all users who are </label>
    <select id="approval" class="" name="approval">
      <option value=3>Pending Approval</option>
      <option value=1>Approved</option>
      <option value=0>Deactivated</option>
    </select>
    <button class="homeButton" type="submit" name="submit">View Users</button>
  </form>
  <form id="employeeList" class="homeForm" action="" method="post">
    <label for="empList">View employees </label>
    <select id="approval" class="" name="approval">
      <option value=1>Admin</option>
      <option value=2>Supervisor</option>
      <option value=3>Doctor</option>
      <option value=4>Caregiver</option>
      <option value=8>All</option>
    </select>
    <button class="homeButton" type="submit" name="submit">View Employees</button>
  </form>
NEW;

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
