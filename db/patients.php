<?php
require 'db.php';
require "../includes/head.php";
require "../includes/header.php";

echo "<article class='patient_search'>";

$sql = "SELECT p.pat_id,u.dob, u.first_name, u.last_name, u.phone, u.email, p.emergency_contact, p.emergency_contact_relation
        FROM patients p
        LEFT JOIN users u
        ON u.id = p.user_id
        WHERE u.status =1";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt,$sql)){
  echo "There was an error with the server 1.";
  echo "<br/>";
  exit();
} else {
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
}
echo "<table id ='all_pat_table' class='data-table'>";
echo "<thead class='pat_search_thead'><tr class='ugh'><th colspan='8'>All Patients</th></tr>";
echo "<tr><th class='data-heading2'>patient id</th><th class='data-heading2'>first name</th><th class='data-heading2'>last name</th><th class='data-heading2'>dob</th><th class='data-heading2'>phone</th><th class='data-heading2'>email</th><th class='data-heading2'>emergency contact</th><th class='data-heading2'>relation</th></tr></thead><tbody class='pat_search_tbody'>";
while ($row = mysqli_fetch_array($res)) {
  echo "<tr><td class='table-data2'>".$row['pat_id']."</td>";
  echo "<td class='table-data2'>".$row['first_name']."</td>";
  echo "<td class='table-data2'>".$row['last_name']."</td>";
  echo "<td class='table-data2'>".$row['dob']."</td>";
  echo "<td class='table-data2'>".$row['phone']."</td>";
  echo "<td class='table-data2'>".$row['email']."</td>";
  echo "<td class='table-data2'>".$row['emergency_contact']."</td>";
  echo "<td class='table-data2'>".$row['emergency_contact_relation']."</td></tr>";
}
echo "</tbody></table>";


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
  }elseif ($em_con_name !="") {
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
  echo "<table id ='pat_search_res' class='data-table'>";
  echo "<thead><tr><th colspan='8'>Patient Results</th></tr></thead>";
  echo "<tr class='data-heading'>";
  echo "<td>patient id</td><td>first name</td><td>last name</td><td>dob</td><td>phone</td><td>email</td><td>emergency contact</td><td>relation</td></tr>";
  while ($row = mysqli_fetch_array($res)) {
    echo "<tr class='table-data'><td>".$row['pat_id']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['dob']."</td><td>".$row['phone']."</td><td>".$row['email']."</td><td>".$row['emergency_contact']."</td><td>".$row['emergency_contact_relation']."</td></tr>";
  }
  echo "</table>";

}
if ($_SESSION['sessionRole'] < 5){

  echo <<< "PAT"
    <form class='homeForm2' method='post'>
    <h2>Patient Search</h2>
    <table class="t1" ><tbody>
      <tr class="td1">
      <td class="td1">
        <label for="pat_id">Patient Id</label>
        <input class="no_i" type="number" name="pat_id" value="">
      </td><td class="td1">
        <label for="lName">Last Name</label>
        <input type="text" name="lName" value="">
      </td>
      <td class="td1" class="no_i">
        <label for="age">Age</label>
        <input class="no_i" type="number" name="age" value="">
      </td></tr>
      <tr><td class="td1" colspan="3">
        <label for="em_con">Emergency Contact Relation</label>
        <input type="text" name="em_con" value="">
      </td></tr>
      <tr class="td1"><td colspan="3">
        <label for="em_con_name">Emergency Contact Name</label>
        <input type="text" name="em_con_name" value="">
      </td></tr>
      </tbody></table>
        <input class="buttonLink" type="submit" name="pat_search" value="Search">
    </form>
  PAT;
}
echo "</article>";
require "../includes/footer.php";
?>
