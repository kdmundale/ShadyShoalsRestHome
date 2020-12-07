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

  if (isset($_POST['next'])){

    if ($_POST['next_date'] != ""){
      $next_date = $_POST['next_date'];
    } else {
      $next_date = $today;
    }
    if ($_POST['from_date'] != ""){
      $from_date = $_POST['from_date'];
    } else {
      $from_date = $today;
    }
  } else {
    $from_date = $today;
    $next_date = $today;
  }


  $sql = "SELECT a.pat_id, u.first_name, u.last_name, a.appt_date
          FROM appointments a
          left join patients p
          on a.pat_id = p.pat_id
          left join users u
          on p.user_id = u.id
          where a.doctor_id =?
          AND a.appt_date BETWEEN ? AND ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "iss", $doc_id,$from_date,$next_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<table id='pat_table'>";
    echo "<thead><tr><th id='pat_table_head' colspan='5'>Appointment List<form action='' method='post'><input class='apt_date' type='date' name='from_date'><input class='apt_date' type='date' name='next_date'><input class='b2' type='submit' name='next' value='view'></form></th></tr></thead>";
    echo "<tr class='data-heading'>";
    echo "<tbody id='pat_table_body'>";
    echo "<td>patient id</td><td>first name</td><td>last name</td><td>appointment</td><td>view records</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<form action='../db/doc_view.php' method='post'><tr id='pat-t-d' class='table-data'><td>".$row['pat_id']."<input type='hidden' name='pat_id' value=".$row['pat_id']."</td>";
      echo "<td>".$row['first_name']."</td>";
      echo "<td>".$row['last_name']."</td>";
      echo "<td>".$row['appt_date']."</td>";
      echo "<td><button class='b2' type='submit' name='pat_submit' value=''>view</button></tr></form>";
    }
    mysqli_stmt_close($stmt);
    echo "</table>";
  }
    echo "</div></article>";


  require "../includes/footer.php";

  ?>
