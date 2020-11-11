<?php
if (isset($_POST['submit'])) {

  require 'db.php';

  $email = $_POST['email'];
  $password = $_POST['password'];

  if(empty($email)||empty($password)){
    echo "Please fill out both fields when logging in.";
    echo "<br/>";
    echo "<a href='../index.php'>Go back</a>";
    exit();
  } else {
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
      $passCheck = password_verify($password,$row['pass']);
      if ($passCheck == false){
        echo "Either the email or password was incorrect.";
        echo "<br/>";
        echo "<a href='../index.php'>Go back</a>";
      exit();
    } elseif ($passCheck == True) {
      session_start();
      $_SESSION['sessionId']= $row['id'];
      $_SESSION['sessionRole']= $row['role'];
      $_SESSION['userName']=$row['first_name']." ".$row['last_name'];
      $_SESSION['approved']= $row['approved'];
      $approved = $_SESSION['approved'];
      if ($approved == 0) {
        echo "Thanks for stopping by, ".$_SESSION['userName'].", but your account has not yet been approved. Please check back later.";
        echo "<br/>";
        echo "<a href='../index.php'>Go back</a>";
        exit();
      } elseif ($approved == 1) {
        $role = $_SESSION['sessionRole'];
          if ($role ==1) {
          header("Location: ../views/aHome.php?success=login");
          exit();
        } elseif ($role == 2){
          header("Location: ../views/sHome.php?success=login");
          exit();
        } elseif ($role == 3) {
          header("Location: ../views/dHome.php?success=login");
          exit();
        } elseif ($role == 4) {
          header("Location: ../views/cHome.php?success=login");
          exit();
        } elseif ($role ==5 || $role ==6) {
          header("Location: ../views/oHome.php?success=login");
          exit();
        } else {
          echo "There was problem logging in.";
          echo "<br/>";
          echo "<a href='../index.php'>Go back</a>";
          exit();
        }
      }
    } else {
      echo "Either the email or password was incorrect.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    }
    } else {
      echo "There is no account with this email";
      echo $row['email'];
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    }
  }
  }

} else {
  echo "Please login to view.";
  echo "<br/>";
  echo "<a href='../index.php'>Go back</a>";
  exit();
}
 ?>
