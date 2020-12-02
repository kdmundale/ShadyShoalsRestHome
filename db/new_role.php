<?php
require 'db.php';
require "../includes/head.php";
require "../includes/header.php";

if ((isset($_POST['roleSubmit'])) && ($_SESSION['sessionRole']==1)){

  $newPosName = $_POST['newPosName'];
  $secLevel = $_POST['secLevel'];

  $sql = "INSERT INTO role_security (position, sec_level) VALUES (?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was a problem with inserting patient information.";
    echo "<br/>";
    echo "<a href='../register.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt,"si", $newPosName, $secLevel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<h1>Success! The role has been added.</h1>";
    echo "<button style='font-sixe: 20px; padding: 5px; margin-bottom:80px' id='go-back'>Go back!</button>";
    echo "<script>document.getElementById('go-back').addEventListener('click', () => {history.back();});</script>";
  }
  require "../includes/footer.php";
}
?>
