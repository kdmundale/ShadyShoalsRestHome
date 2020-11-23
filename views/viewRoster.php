<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
  session_start();

  if (isset($_POST['editRos'])) {

    $date_id = $_POST['date_id'];
    $super= $_POST['supervisor'];
    $doctor = $_POST['doctor'];
    $care1 = $_POST['care1'];
    $care2 = $_POST['care2'];
    $care3 = $_POST['care3'];
    $care4 = $_POST['care4'];

    $sql = "UPDATE roster SET supervisor_id = ?, doctor_id = ?, caregiver1_id = ?, caregiver2_id = ?, caregiver3_id = ?, caregiver4_id = ? WHERE daily_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error inserting data.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"iiiiiii",$super,$doctor,$care1,$care2,$care3,$care4, $date_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
}

  if ((isset($_POST['careSubmit'])) && ($_SESSION['sessionRole'] < 5)){

    $DOC = $_POST['careDate'];

    $sql = "SELECT daily_id FROM roster WHERE care_date =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"s", $DOC);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        $daily_id = $row['daily_id'];
    }
      mysqli_stmt_close($stmt);
    }

    $sql = "SELECT supervisor_id, doctor_id, caregiver1_id, caregiver2_id, caregiver3_id, caregiver4_id FROM roster where care_date = ?";
    $stmt = mysqli_stmt_init($conn);
    $ids = array();
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"s", $DOC);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($property = mysqli_fetch_field($result)) {
        array_push($ids, $property->name);  //save those to array
      }
      mysqli_stmt_close($stmt);
  }
}

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  echo <<< "VIEW"
  <form class="homeForm" action="" method="post">
    <label for="careDate">Date of Care</label>
    <input type="date" name="careDate">
    <button class="homeButton" type="submit" name="careSubmit">View Date</button>
    </form>
  VIEW;

  function getFullName ($id){
    require "../db/db.php";
    $sql = "SELECT  first_name, last_name FROM users WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        echo $row['first_name']." ".$row['last_name'];
        echo "<br>";
      }
      mysqli_stmt_close($stmt);
    }
  }

  echo "<section class='roster-table'>";
  if (isset($ids)){
    $viewDate = date("M j, Y", strtotime($DOC));
    echo "<table class='data-table'><tr class='data-heading'>";
    echo "<thead><tr><th colspan='7'>".$viewDate."</th></tr></thead>";
    echo "<td>Supervisor</td><td>Doctor</td><td>Cargiver 1</td><td>Cargiver 2</td><td>Cargiver 3</td><td>Cargiver 4</td></tr>";

    while ($row = mysqli_fetch_array($result)) {
      echo '<tr class="table-data">';
      foreach ($ids as $id){
        echo "<td>";
        getFullName($row[$id]);
        echo "</td>";
    }
    echo "</tr>";
  }
echo "</table>";

$future= new Datetime($DOC);
$now = new DateTime();
if (($future > $now) && (($_SESSION['sessionRole']==1)||($_SESSION['sessionRole']==2))) {
echo <<< "FORM"
<form class="homeForm" action="" method="post">
<h2>Edit Daily Roster</h2>
<input class='rosForm' type="hidden" name="date_id" value="$daily_id">

FORM;

  function empDropdown ($positionID, $name, $display){
    require "../db/db.php";
    $sql = "SELECT u.id, u.first_name, u.last_name, e.emp_id FROM users u LEFT JOIN  employees e on u.id = e.user_id WHERE u.position_id = ? AND u.status =1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"i", $positionID);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      echo "<select class='rosForm' id=".$name." name=".$name.">";
      echo "<option>Select ".$display."</option>";
      while ($row = mysqli_fetch_array($result)) {
        echo "<option value =".$row['id'].">Emp ID:".$row['emp_id']."   ".$row['first_name']." ".$row['last_name']."</option>";
      }
      echo "</select>";
      mysqli_stmt_close($stmt);
    }
  }

echo "<label class='rosForm' for='supervisor'>Supervisor</label>";
$positionID = 2;
$name = 'supervisor';
$display = "Supervisor";
empDropdown($positionID, $name, $display);

echo "<label for='doctor'>Doctor</label>";
$positionID = 3;
$name = 'doctor';
$display = "Doctor";
empDropdown($positionID, $name, $display);

echo "<label for='care1'>Caregiver 1</label>";
$positionID = 4;
$name ='care1';
$display = 'Caregiver 1';
empDropdown($positionID, $name, $display);

echo "<label for='care2'>Caregiver 2</label>";
$positionID = 4;
$name ='care2';
$display = 'Caregiver 2';
empDropdown($positionID, $name, $display);

echo "<label for='care3'>Caregiver 3</label>";
$positionID = 4;
$name ='care3';
$display = 'Caregiver 3';
empDropdown($positionID, $name, $display);

echo "<label for='care4'>Caregiver 4</label>";
$positionID = 4;
$name ='care4';
$display = 'Caregiver 4';
empDropdown($positionID, $name, $display);

echo "<button class='homeButton' type='submit' name='editRos'>Edit Roster</button></form>";

  }
}
echo "</section>";

  require "../includes/footer.php";

  ?>
