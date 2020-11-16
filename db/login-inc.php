<?php
require "../includes/head.php";
require "../includes/header.php";

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
      session_regenerate_id();
      $_SESSION['sessionId']= $row['id'];
      $_SESSION['userName']=$row['first_name']." ".$row['last_name'];
      $_SESSION['status']= $row['status'];
      $approved = $_SESSION['status'];
      $position_id= $row['position_id'];
      $sql = "SELECT sec_level FROM role_security WHERE position_id = ?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error with the server 1.";
        echo "<br/>";
        echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $position_id);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['sessionRole'] = $row['sec_level'];
      } else {
        echo "There was an issue setting session security level.";
      }
      }
      setcookie("name",$_SESSION['userName'],time()+3600);
      setcookie("role",$_SESSION['sessionRole'],time()+3600);

      if ($approved == 0) {
        echo "<h1>Thanks for stopping by, ".$_SESSION['userName'].", but your account has not yet been approved.<br> Please check back later.<h1>";
        echo "<br>";
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
