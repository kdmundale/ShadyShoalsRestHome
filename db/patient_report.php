<?php
require "../includes/head.php";
require "../includes/header.php";
require "../db/db.php";

if ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2){

echo "<h1>Admin Report</h1>";
echo "<article class='homeMain'>";
echo "<div id='home_page_content' class='homeContent'>";

echo <<< "DATE"
  <form id="ad-rep-date" class="homeForm" action='' method="post">
  <label class='rosForm' for="careDate">Select Care Date</label>
  <input class='rosForm' type="date" name="careDate" value="">
  <input type='submit' name='get_date' value="see day">
  </form>
  DATE;
  if (isset($_POST['get_date'])) {

    $date = $_POST['careDate'];
    $d = new DateTime($date);
    $day = date_format($d, 'm/d/Y');

  function get_name ($id) {
    require "../db/db.php";
    $sql = "SELECT first_name, last_name
      FROM users
      WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        $name = $row['first_name']." ".$row['last_name'];
      }
      mysqli_stmt_close($stmt);
      return $name;
    }
  }

  function get_pat_name($pat_id) {
    require "../db/db.php";
    $sql = "SELECT u.first_name, u.last_name
          FROM users u
          LEFT JOIN patients p
          ON p.user_id = u.id
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
        $name = $row['first_name']." ".$row['last_name'];
      }
      mysqli_stmt_close($stmt);
      return $name;
    }
  }

  function yes_no ($var){
    if ($var==1){
      $res = 'yes';
    } else if ($var == 0){
      $res = 'no';
    } else {
      $res= 'n/a';
    }
    return $res;
  }
  echo "<div class='admin-reports'>";

  $sql = "SELECT pat_id, doctor_id, seen
          FROM appointments
          WHERE appt_date = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $docs= array();
    $was_seen = array();
    $pats = array();
    while ($row = mysqli_fetch_array($result)) {
      array_push($pats, $row['pat_id']);
      array_push($docs, get_name($row['doctor_id']));
      array_push($was_seen, yes_no($row['seen']));
    }
    mysqli_stmt_close($stmt);
  }

  $sql = "SELECT * FROM daily WHERE care_date = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    echo "<table id='pat_table' class='ad-rep'>";
    echo "<thead><tr><th id='pat_table_head' colspan=''>Care Report for ".$day."</th></tr></thead>";
    echo "<tr class='data-heading'>";
    echo "<tbody id='pat_table_body' class='ad-rep-body'>";
    echo "<td>patient</td><td>doc appt</td><td>seen</td><td>caregiver</td><td>am med</td><td>pm med</td><td>night med</td><td>breakfast</td><td>lunch</td><td>dinner</td></tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr id='pat-t-d' class='table-data'><td>".get_pat_name($row['pat_id'])."</td>";
      if (array_search($row['pat_id'], $pats) != False){
        $x = array_search($row['pat_id'], $pats);
        echo "<td>".$docs[$x]."</td><td>".$was_seen[$x]."</td>";
      } else {
        echo "<td> n/a </td><td> n/a </td>";
      }
      echo "<td>".get_name($row['caregiver_id'])."</td>";
      echo "<td>".yes_no($row['morn_med'])."</td><td>".yes_no($row['aft_med'])."</td><td>".yes_no($row['night_med'])."</td>";
      echo "<td>".yes_no($row['breakfast'])."</td><td>".yes_no($row['lunch'])."</td><td>".yes_no($row['dinner'])."</td></tr>";
    }
    mysqli_stmt_close($stmt);
    echo "</tbody></table>";
  }
}


echo "</div></div></article>";
}
require "../includes/footer.php";
?>
