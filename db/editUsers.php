<?php
require 'db.php';
session_start();
if ((isset($_POST['submit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)){

  $approved = $_POST['approve'];
  $ids= $_POST['ids'];

  foreach ($approved as $key => $value) {
    $user = $ids[$key];
    if ($value == "approve"){
    $sql = "UPDATE users SET status = 1 WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an issue updating the table.";
      echo "<br/>";
      echo "<a href='approve.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $user);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  } elseif ($value == "deactivate"){
    $sql = "UPDATE users SET status = 0 WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an issue updating the table.";
      echo "<br/>";
      echo "<a href='approve.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $user);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }
}
}

 ?>
