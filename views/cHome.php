<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
 ?>
  <h1>Caregiver Home</h1>
  <article class="homeMain">
  <nav>
    <ul>
      <li><a class="buttonLink" href="../db/patients.php" class="homeButton">Patient Search</a></li>
    </ul>
  </nav>
  <div id="home_page_content" class="homeContent">
    <?php

    if (isset($_POST['ent_care'])) {

      $pat_id = $_POST['pat_id'];
      $care_id = $_SESSION['sessionId'];
      $now = new DateTime();
      $today = date_format($now, 'Y-m-d');

      if(isset($_POST['brk'])){
        $brk = 1;
      } else {
        $brk = 0;
      }
      if(isset($_POST['lnch'])){
        $lnch = 1;
      } else {
        $lnch = 0;
      }
      if(isset($_POST['din'])){
        $din = 1;
      } else {
        $din = 0;
      }
      if(isset($_POST['am'])){
        $am = 1;
      } else {
        $am = 0;
      }
      if(isset($_POST['pm'])){
        $pm = 1;
      } else {
        $pm = 0;
      }
      if(isset($_POST['night'])){
        $night = 1;
      } else {
        $night = 0;
      }

      $sql = "INSERT INTO daily (caregiver_id, pat_id, care_date, morn_med,
        aft_med, night_med, breakfast, lunch, dinner)
        VALUES (?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was a problem inserting the data.";
        echo "<br/>";
        echo "<a href='../register.php'>Go back</a>";
        exit();
      } else {
        mysqli_stmt_bind_param($stmt,"iisiiiiii",$care_id,$pat_id,$today,$am,$pm,$night,$brk,$lnch,$din);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

    if(isset($_POST['pat_care'])) {

      $pat_id = $_POST['pat_id'];
      $fName = $_POST['fName'];
      $lName = $_POST['lName'];

      echo "<form actin='' method='post'><table class='data-table'>";
      echo "<thead><tr><th colspan='6'>".$fName." ".$lName."</th></tr></thead>";
      echo "<tr class='data-heading'>";
      echo "<td>breakfast</td><td>lunch</td><td>dinner</td><td>am med</td><td>pm med</td><td>night med</td></tr>";
      echo "<tr class='table-data'><input type='hidden' name='pat_id' value=".$pat_id.">";
      echo "<td><input type='checkbox' name='brk' value=1></td>";
      echo "<td><input type='checkbox' name='lnch' value=1></td>";
      echo "<td><input type='checkbox' name='din' value=1></td>";
      echo "<td><input type='checkbox' name='am' value=1></td>";
      echo "<td><input type='checkbox' name='pm' value=1></td>";
      echo "<td><input type='checkbox' name='night' value=1></td></tr>";
      echo "<tr><td colspan='6'><input type='submit' name='ent_care' value='enter'></td></tr>";
      echo "</table></form>";
    }

    $now = new DateTime();
    $today = date_format($now, 'Y-m-d');
    $dToday = date_format($now, 'm/d/Y');
    $care_id = $_SESSION['sessionId'];

    $sql= "SELECT * FROM roster
          WHERE ?
          IN (caregiver1_id, caregiver2_id, caregiver3_id, caregiver4_id)
          AND care_date = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "is", $care_id, $today);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        if ($row['caregiver1_id']==$care_id){
          $group = 1;
        } else if ($row['caregiver2_id']==$care_id){
          $group = 2;
        } else if ($row['caregiver3_id']==$care_id){
          $group = 3;
        } else if ($row['caregiver4_id']==$care_id){
          $group = 4;
        } else {
          echo "You are not on the roster for today.";
        }
      }
      mysqli_stmt_close($stmt);
    }

    $sql = "SELECT u.first_name, u.last_name, p.pat_id
          FROM users u
          LEFT JOIN patients p
          ON u.id = p.user_id
          WHERE group_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 2.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $group);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      echo "<table class='data-table'>";
      echo "<thead><tr><th colspan='4'> Patients On: ".$dToday."</th></tr></thead>";
      echo "<tr class='data-heading'><td>id</td><td>first</td><td>last</td></tr>";
      while ($row = mysqli_fetch_array($result)) {
        echo "<tr class='table-data'><form action='' method='post'>";
        echo "<td><input type='hidden' name='pat_id' value=".$row['pat_id'].">".$row['pat_id']."</td>";
        echo "<td><input type='hidden' name='fName' value=".$row['first_name'].">".$row['first_name']."</td>";
        echo "<td><input type='hidden' name='lName' value=".$row['last_name'].">".$row['last_name']."</td>";
        echo "<td><input type='submit' name='pat_care' value='view'></td></form></tr>";
    }
    echo "</table>";
    mysqli_stmt_close($stmt);
  }
     ?>

  </div>
</article>
 <?php
   require "../includes/footer.php"
  ?>
