<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
  session_start();

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";
  require "../includes/ASMenu.php";

  $sql = "SELECT position FROM role_security WHERE sec_level < 5;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    echo "<a href='../index.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<select id='roleSelect' class='regSelect' name='position'>";
    echo "<option>Select Position</option>";
    echo "<option id='allPos' value='allPos'>All Positions</option>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<option id=".$row['position']." value =".$row['position'].">" . $row['position'] . "</option>";
    }
    echo "</select>";
  echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button></form>";

  }
  echo "</div>";
  echo "</section>";

  require "../includes/footer.php"
  ?>
