<?php
require "db.php";
session_start();

if ((isset($_POST["salSubmit"])) && ($_SESSION['sessionRole']== 1)) {

  $empID = $_POST['empID'];
  $empSalary = $_POST['empSal'];

  $sql = "UPDATE employees SET salary = ? WHERE user_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an issue updating the table.";
    echo "<br/>";
    echo "<a href='approve.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ii", $empSalary, $empID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  header("Location: employees.php");
}
?>
