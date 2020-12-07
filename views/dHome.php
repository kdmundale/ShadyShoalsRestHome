<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  echo<<<"DOC"
    <article class="homeMain">
      <nav>
        <ul>
          <li><button class='homeButton' id='doc_home'>welcome</button></li>
          <li><button class='homeButton' id='appt'>appointments</button></li>
          <li><a class="buttonLink" href="../views/viewRoster.php" class="homeButton">View Roster</a></li>
          <li><a class="buttonLink" href="../db/patients.php" class="homeButton">Patient<br>Search</a></li>
        </ul>
      </nav>
      <div id="home_page_content" class="homeContent">
  DOC;

  $now = new DateTime();
  $today = date_format($now, 'Y-m-d');
  $h_date = date_format($now, 'm-d-Y');
  $doc_id = (int)$_SESSION['sessionId'];

  $sql = "SELECT DISTINCT a.pat_id, u.first_name, u.last_name, u.dob, p.group_id
          FROM appointments a
          left join patients p
          on a.pat_id = p.pat_id
          left join users u
          on p.user_id = u.id
          where a.doctor_id =?
          ORDER BY a.pat_id ASC";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $doc_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<table id='pat_table'>";
    echo "<thead><tr><th id='pat_table_head' colspan='5'>Patient List</th></tr></thead>";
    echo "<tr class='data-heading'>";
    echo "<tbody id='pat_table_body'>";
    echo "<td>patient id</td><td>first name</td><td>last name</td><td>dob</td><td>group</td><td>view records</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<form><tr id='pat-t-d' class='table-data'><td>".$row['pat_id']."<input type='hidden' name='pat_id' value=".$row['pat_id']."</td>";
      echo "<td>".$row['first_name']."</td>";
      echo "<td>".$row['last_name']."</td>";
      echo "<td>".$row['dob']."</td>";
      echo "<td>".$row['group_id']."</td>";
      echo "<td><button class='b2' type='submit' name='pat_submit' value=''>view</button></tr></form>";
    }
    mysqli_stmt_close($stmt);
    echo "</div></article>";
  }




  ?>
