<?php
require 'db.php';
require "../includes/head.php";
require "../includes/header.php";

if ((isset($_POST['rosSubmit'])) && ($_SESSION['sessionRole']==1)){

  $careDate = $_POST['careDate'];
  $super= $_POST['supervisor'];
  $doctor = $_POST['doctor'];
  $care1 = $_POST['care1'];
  $care2 = $_POST['care2'];
  $care3 = $_POST['care3'];
  $care4 = $_POST['care4'];
  $now = new DateTime();
  $newCareDate = new DateTime($careDate);

  if ($newCareDate < $now){
    echo "<h1>Please enter a future care date.</h1>";
    echo "<br/>";
    echo "<button style='font-sixe: 20px; padding: 5px; margin-bottom:80px' id='go-back'>Go back!</button>";
    echo "<script>document.getElementById('go-back').addEventListener('click', () => {history.back();});</script>";
  } else {

  $sql = "INSERT INTO roster (care_date, supervisor_id, doctor_id, caregiver1_id, caregiver2_id, caregiver3_id, caregiver4_id) VALUES (?,?,?,?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was a problem with inserting patient information.";
    echo "<br/>";
    echo "<a href='../register.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt,"siiiiii", $careDate, $super, $doctor, $care1, $care2, $care3, $care4);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<h1>Success! The day has been added to the roster.</h1>";
    echo "<button style='font-sixe: 20px; padding: 5px; margin-bottom:80px' id='go-back'>Go back!</button>";
    echo "<script>document.getElementById('go-back').addEventListener('click', () => {history.back();});</script>";
  }
}
  require "../includes/footer.php";
}
 ?>
