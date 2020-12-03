<?php
require 'db.php';
require "../includes/head.php";
require "../includes/header.php";

echo "<article class='patient_search'>";
if ((isset($_POST['pat_search']))&& $_SESSION['sessionRole']< 5) {

  $pat_id = $_POST['pat_id'];
  $lName = $_POST['lName'];
  $age = $_POST['age'];
  $em_con= $_POST['em_con'];
  $em_con_name= $_POST['em_con_name'];
  $now = new DateTime();

  if($pat_id != ""){
    $pat_id = (int)$pat_id;
    echo $pat_id;
    $sql = "SELECT p.pat_id,u.dob, u.first_name, u.last_name, u.phone, u.email, p.emergency_contact, p.emergency_contact_relation
            FROM patients p
            LEFT JOIN users u
            ON u.id = p.user_id
            WHERE p.pat_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $pat_id);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
  } elseif ($lName != "") {
    $lName = $lName."%";
    $sql = "SELECT u.first_name, u.last_name, u.phone, u.email, p.pat_id, u.dob, p.emergency_contact, p.emergency_contact_relation
            FROM users u
            LEFT JOIN patients p
            ON u.id = p.user_id
            WHERE u.last_name LIKE ?
            AND u.position_id = 5";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $lName);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
  } elseif ($age != "") {
    $age=(int)$age;
    $sql= "SELECT u.first_name, u.last_name, u.phone, u.email, p.pat_id, u.dob,
            p.emergency_contact, p.emergency_contact_relation
            FROM users u
            LEFT JOIN patients p
            ON u.id = p.user_id
            WHERE (year(CURRENT_TIMESTAMP) - year(u.dob)) = ?
            AND u.position_id = 5";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $age);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
  } elseif ($em_con_name != "") {
    $em_con_name = $em_con_name."%";
    $sql = "SELECT u.first_name, u.last_name, u.phone, u.email, p.pat_id, u.dob, p.emergency_contact, p.emergency_contact_relation
            FROM users u
            LEFT JOIN patients p
            ON u.id = p.user_id
            WHERE p.emergency_contact LIKE ?
            AND u.position_id = 5";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server em_con.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $em_con_name);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
  } elseif ($em_con != "") {
    $em_con = $em_con."%";
    $sql = "SELECT u.first_name, u.last_name, u.phone, u.email, p.pat_id, u.dob, p.emergency_contact, p.emergency_contact_relation
            FROM users u
            LEFT JOIN patients p
            ON u.id = p.user_id
            WHERE p.emergency_contact LIKE ?
            AND u.position_id = 5";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server em_con.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $em_con);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
    }
  }
  echo "<table class='data-table'>";
  echo "<thead><tr><th colspan='8'>Patient Results</th></tr></thead>";
  echo "<tr class='data-heading'>";
  echo "<td>patient id</td><td>first name</td><td>last name</td><td>dob</td><td>phone</td><td>email</td><td>emergency contact</td><td>relation</td></tr>";
  while ($row = mysqli_fetch_array($res)) {
    echo "<tr class='table-data'><td>".$row['pat_id']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['dob']."</td><td>".$row['phone']."</td><td>".$row['email']."</td><td>".$row['emergency_contact']."</td><td>".$row['emergency_contact_relation']."</td></tr>";
  }
  echo "</table>";
} elseif ($em_con_name !="") {
  $em_con_name = $em_con_name."%";
  $sql = "SELECT u.first_name, u.last_name, u.phone, u.email, p.pat_id, u.dob, p.emergency_contact, p.emergency_contact_relation
          FROM users u
          LEFT JOIN patients p
          ON u.id = p.user_id
          WHERE u.emergency_contact LIKE ?
          AND u.position_id = 5";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $em_con_name);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
  }
}
if ($_SESSION['sessionRole'] < 5){

  echo <<< "PAT"
  <h2>Patient Search</h2>
    <form class='homeForm' method='post'>
      <label for="pat_id">Patient Id</label>
        <input type="number" name="pat_id" value="">
      <label for="lName">Last Name</label>
        <input type="text" name="lName" value="">
      <label for="age">Age</label>
        <input type="number" name="age" value="">
      <label for="em_con">Emergency Contact Relation</label>
        <input type="text" name="em_con" value="">
      <label for="em_con_name">Emergency Contact Name</label>
        <input type="text" name="em_con_name" value="">
      <input class="buttonLink" type="submit" name="pat_search" value="Search">
    </form>
  PAT;
}
echo "</article>";
require "../includes/footer.php";
?>
