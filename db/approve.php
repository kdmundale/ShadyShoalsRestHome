<?php
  require 'db.php';
  require "../includes/head.php";
  require "../includes/header.php";

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
  mysqli_stmt_close($stmt);

}
} else {
$sql = "SELECT u.id, r.sec_level, r.position, u.first_name, u.last_name, u.email, u.phone, u.dob, u.status FROM users u LEFT JOIN role_security r ON u.position_id = r.position_id WHERE status is NULL";
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
  mysqli_stmt_close($stmt);

}
}

echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";
require "../includes/ASMenu.php";

echo "<section id='usersView'>";
echo "<table class='data-table'>";
echo "<thead><tr><th colspan='10'>".$pageTitle."</th></tr></thead>";
echo "<tr class='data-heading'>";  //initialize table tag
while ($property = mysqli_fetch_field($result)) {
    echo "<td>" . $property->name . '</td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
echo "<td></td>";
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
echo "<button class='other' type='submit' name='submit'>change</button></form>";
echo "</section>";
}
echo <<< "NEW2"
  </div>
  </article>
  NEW2;
require "../includes/footer.php";

?>
