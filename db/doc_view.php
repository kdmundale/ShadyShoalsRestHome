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

if(isset($_POST['new_record'])) {

  $comment = $_POST['comment'];
  $morn_med = $_POST['morn_med'];
  $aft_med = $_POST['aft_med'];
  $night_med = $_POST['night_med'];
  $apt_id = (int)$_POST['apt_id'];
  $doctor_id = $_SESSION['sessionId'];
  $pat_id = $_POST['pat_id'];
  $fName = $_POST['fName'];
  $lName = $_POST['lName'];
  $dob = $_POST['dob'];
  if (isset($_POST['seen'])){
    $seen = $_POST['seen'];
  } else {
    $seen = 0;
  }
  $sql = "UPDATE appointments
          SET comments = ?, morn_med = ?, aft_med = ?, night_med = ?, seen = ?
          WHERE appt_id = ? ";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 6.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "ssssii", $comment, $morn_med, $aft_med, $night_med, $seen, $apt_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  $sql = "SELECT * FROM appointments WHERE pat_id=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $pat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dates = array();
    $appt_ids = array();

    echo "<h2>".$fName." ".$lName."</h2>";
    echo "<h3> DOB: ".$dob."</h3>";

    echo "<table id='pat_table'>";
    echo "<thead><tr><th id='pat_table_head' colspan='5'>Records</th></tr></thead>";
    echo "<tr class='data-heading'>";
    echo "<tbody id='pat_table_body'>";
    echo "<td>doctor</td><td>appt date</td><td>was seen</td><td>comments</td><td>morning med</td><td>aftternoon med</td><td>night med</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr id='pat-t-d' class='table-data'><td>".$row['doctor_id']."</td>";
      echo "<td>".$row['appt_date']."</td>";
      array_push($dates, $row['appt_date']);
      array_push($appt_ids, $row['appt_id']);
      if ($row['seen']==1){
        $seen = 'yes';
      } else {
        $seen = 'no';
      }
      echo "<td>".$seen."</td>";
      echo "<td>".$row['comments']."</td>";
      echo "<td>".$row['morn_med']."</td>";
      echo "<td>".$row['aft_med']."</td>";
      echo "<td>".$row['night_med']."</td></tr>";
    }
    mysqli_stmt_close($stmt);
    echo "</table>";
  }
}
if ((isset($_POST['pat_submit'])) && ($_SESSION['sessionRole']==3)){

  $pat_id = (int)$_POST['pat_id'];

  $sql="SELECT * FROM users u
        LEFT JOIN patients p
        ON u.id=p.user_id
        WHERE p.pat_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $pat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_array($result)) {
      $fName = $row['first_name'];
      $lName = $row['last_name'];
      $dob= $row['dob'];
      echo "<h2>".$fName." ".$lName."</h2>";
      echo "<h3> DOB: ".$dob."</h3>";
    }
    mysqli_stmt_close($stmt);
  }

  $sql = "SELECT * FROM appointments WHERE pat_id=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "i", $pat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dates = array();
    $appt_ids = array();
    echo "<table id='pat_table'>";
    echo "<thead><tr><th id='pat_table_head' colspan='5'>Records</th></tr></thead>";
    echo "<tr class='data-heading'>";
    echo "<tbody id='pat_table_body'>";
    echo "<td>doctor</td><td>appt date</td><td>seen</td><td>comments</td><td>morning med</td><td>aftternoon med</td><td>night med</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr id='pat-t-d' class='table-data'><td>".$row['doctor_id']."</td>";
      echo "<td>".$row['appt_date']."</td>";
      array_push($dates, $row['appt_date']);
      array_push($appt_ids, $row['appt_id']);
      if ($row['seen']==1){
        $seen = 'yes';
      } else {
        $seen = 'no';
      }
      echo "<td>".$seen."</td>";
      echo "<td>".$row['comments']."</td>";
      echo "<td>".$row['morn_med']."</td>";
      echo "<td>".$row['aft_med']."</td>";
      echo "<td>".$row['night_med']."</td></tr>";
    }
    mysqli_stmt_close($stmt);
    echo "</table>";

    $now = new DateTime();
    $today = date_format($now, 'Y-m-d');
    if (array_search($today, $dates)){

      $key = array_search($today, $dates);
      $apt_id = $appt_ids[$key];

      echo <<< "NEW"
        <form class='homeForm2' action='' method='post'>
          <table>
            <tr><th colspan='2'>Appointment Notes</th></tr>
          <tr><td><label for='seen'>Was patient seen?</label></td><td><input type='checkbox' name='seen' value=1></td></tr>
          <tr>
            <td>
              <input type='hidden' name='apt_id' value="$apt_id">
              <input type='hidden' name='pat_id' value="$pat_id">
              <input type='hidden' name='fName' value="$fName">
              <input type='hidden' name='lName' value="$lName">
              <input type='hidden' name='dob' value="$dob">
              <label for='comment'>comment</label>
            </td><td>
              <input type='text' name='comment' placeholder='enter comments'>
            </td></tr>
            <tr><td>
              <label for='morn_med'>morning med</label>
            </td><td>
              <input type='text' name='morn_med' placeholder='morning medication'>
            </td></tr>
            <tr><td>
              <label for='aft_med'>afternoon med</label>
            </td><td>
              <input type='text' name='aft_med' placeholder='aftternoon medication'>
            </td></tr>
            <tr><td>
              <label for='night_med'>night med</label>
            </td><td>
              <input type='text' name='night_med' placeholder='night medication'>
            </td></tr>
            <tr><td colspan='2'>
              <input type='submit' name='new_record' value='enter appointment'>
            </td></tr>
          </table>
        </form>
      NEW;

    }

  }
}
echo "</div></article>";
require "../includes/footer.php";

 ?>
