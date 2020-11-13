<?php
if (isset($_POST['submit'])) {

  require 'db.php';
  require "../includes/head.php";
  require "../includes/header.php";

  $approval = $_POST['approval'];

  if ($approval==1) {
    $pageTitle = "Already Approved";
  } else {
    $pageTitle = "Pending Approval";
  }

  if(mysqli_connect_errno()){
    die("connection failed: "
        . mysqli_connect_error()
        . " (" . mysqli_connect_errno()
        . ")");
}
//get results from database
$sql = "SELECT id, first_name, last_name, role, email, phone, dob, approved FROM users WHERE approved = ?";
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
//showing property

echo "<h1>Users ".$pageTitle."</h1>";
echo '<table class="data-table">
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
    echo "<td style='font-size:18; font-weight:bold'>" . $property->name . '</td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
echo "<td style='font-size:18; font-weight:bold'></td>";
// echo "<td style='font-size:18; font-weight:bold'> change </td>";
echo '</tr>'; //end tr tag
//showing all data
while ($row = mysqli_fetch_array($result)) {
    echo '<tr><form action="changeUser.php" method="post">';
    foreach ($all_property as $item) {
        echo "<td style='border:1px solid black; font-size:18; padding:5px'>" . $row[$item] . '</td>'; //get items using property value
    }
    echo "<td> <div><input type='checkbox' id='yes' name='yes' value='yes' checked><label for='yes'>Approved</label></div><div><input type='checkbox' id='no' name='no' value='no'><label for='no'>Not Approved</label></div></td>";
    echo "<td><input id='userId' name='id' type='hidden' value=".$row['id']."></td>";
    echo "</tr>";
}
echo "</table>";
echo "<button type='submit' name='submit'>change</button></form>";
}
}
require "../includes/footer.php";

?>
