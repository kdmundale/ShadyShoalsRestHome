<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  require "../includes/ASMenu.php";

  if ((isset($_POST['pat_reg_submit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)) {

    $pat_id = (int)$_POST['pat_id'];
    $last_name = $_POST['lName'];
    $group = (int)$_POST['group'];
    $a_date = $_POST['a_date'];

    $sql = "SELECT u.last_name
            FROM users u
            LEFT JOIN patients p
            ON u.id=p.user_id
            WHERE p.pat_id =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $pat_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
      while ($row = mysqli_fetch_array($result)) {
        if ($row['last_name'] == $last_name){
          $sql = "UPDATE patients
                  SET group_id = ?, admission = ?
                  WHERE pat_id = ?";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt,$sql)){
            echo "There was a problem inserting the data.";
            echo "<br/>";
            exit();
          } else {
            mysqli_stmt_bind_param($stmt,"isi",$group,$a_date,$pat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
          }
        }
      }
    }
  }

  echo "</div>";
  echo "</article>";

  require "../includes/footer.php";


  ?>
