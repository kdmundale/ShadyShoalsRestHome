<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";

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

  echo "<h1> Welcome, ".$_SESSION['userName']."</h1>";
  echo "<article class='homeMain'><div id='home_page_content' class='homeContent'>";
  $user_id = $_SESSION['sessionId'];

  if ($_SESSION['sessionRole']==5) {

    if (isset($_POST['get_date'])) {
      $date = $_POST['careDate'];
      $d = new DateTime($date);
      $day = date_format($d, 'm/d/Y');
    } else {
      $now = new DateTime();
      $date = date_format($now, 'Y-m-d');
      $day = date_format($now, 'm/d/Y');
    }

    $sql = "SELECT pat_id FROM patients WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $user_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        $pat_id = $row['pat_id'];
      }
    }
    echo "<h2> Patient Id: ".$pat_id."</h2>";

    $sql = "SELECT doctor_id, seen
            FROM appointments
            WHERE appt_date = ?
            AND pat_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "si", $date, $pat_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($result) {
      while ($row = mysqli_fetch_array($result)) {
        $doc=get_name($row['doctor_id']);
        $was_seen=yes_no($row['seen']);
        }
      } else {
        $doc ="n/a";
        $was_seen="n/a";
      }
      mysqli_stmt_close($stmt);
    }

    $sql = "SELECT * FROM daily WHERE care_date = ? AND pat_id =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "si", $date, $pat_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      echo "<table class='data-table'>";
      echo "<thead><tr><th colspan='9'>Care Report for ".$day."</th></tr></thead>";
      echo "<tr class='data-heading'>";
      echo "<td>doctor</td><td>seen</td><td>caregiver</td><td>am med</td><td>pm med</td><td>night med</td><td>breakfast</td><td>lunch</td><td>dinner</td></tr>";
      while ($row = mysqli_fetch_array($result)) {
        echo "<tr class='table-data'>";
        echo "<td>".$doc."</td><td>".$was_seen."</td>";
        echo "<td>".get_name($row['caregiver_id'])."</td>";
        echo "<td>".yes_no($row['morn_med'])."</td><td>".yes_no($row['aft_med'])."</td><td>".yes_no($row['night_med'])."</td>";
        echo "<td>".yes_no($row['breakfast'])."</td><td>".yes_no($row['lunch'])."</td><td>".yes_no($row['dinner'])."</td></tr>";
      }
      mysqli_stmt_close($stmt);
      echo "</table>";
    }

  echo <<<"FORM"
      <form id="ad-rep-date" class="homeForm" action='' method="post">
        <label class='rosForm' for="careDate">Select Care Date</label>
          <input class='rosForm' type="date" name="careDate" value="">
          <input type='submit' name='get_date' value="see day">
      </form>
  FORM;

} else if ($_SESSION['sessionRole'] == 6) {

  if (isset($_POST['get_date_fam'])) {

    $pat_id = $_POST['pat_id'];
    $code = $_POST['code'];
    $date = $_POST['careDate'];
    $d = new DateTime($date);
    $day = date_format($d, 'm/d/Y');

    $sql = "SELECT * FROM patients WHERE pat_id =? AND family_code = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "is", $pat_id, $code);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      mysqli_stmt_close($stmt);
      if ($result) {
        $sql = "SELECT doctor_id, seen
                FROM appointments
                WHERE appt_date = ?
                AND pat_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
          echo "There was an error with the server 1.";
          echo "<br/>";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "si", $date, $pat_id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if ($result) {
          while ($row = mysqli_fetch_array($result)) {
            $doc=get_name($row['doctor_id']);
            $was_seen=yes_no($row['seen']);
            }
          } else {
            $doc ="n/a";
            $was_seen="n/a";
          }
          mysqli_stmt_close($stmt);
        }

        $sql = "SELECT * FROM daily WHERE care_date = ? AND pat_id =?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
          echo "There was an error with the server 1.";
          echo "<br/>";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "si", $date, $pat_id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          echo "<table class='data-table'>";
          echo "<thead><tr><th colspan='9'>Care Report for ".get_pat_name($pat_id)." on ".$day."</th></tr></thead>";
          echo "<tr class='data-heading'>";
          echo "<td>doctor</td><td>seen</td><td>caregiver</td><td>am med</td><td>pm med</td><td>night med</td><td>breakfast</td><td>lunch</td><td>dinner</td></tr>";
          while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='table-data'>";
            echo "<td>".$doc."</td><td>".$was_seen."</td>";
            echo "<td>".get_name($row['caregiver_id'])."</td>";
            echo "<td>".yes_no($row['morn_med'])."</td><td>".yes_no($row['aft_med'])."</td><td>".yes_no($row['night_med'])."</td>";
            echo "<td>".yes_no($row['breakfast'])."</td><td>".yes_no($row['lunch'])."</td><td>".yes_no($row['dinner'])."</td></tr>";
          }
          mysqli_stmt_close($stmt);
          echo "</table>";
        }
      } else {
        echo "Either the patient id or family code was incorrect.";
      }
  }
}
  echo <<<"UGH"
    <form class='homeForm' action='' method='post'>
        <table>
          <tr><td><label for="pat_id">Patient Id</label></td><td><input type="number" name="pat_id" value=""></td></tr>
          <tr><td><label for="code">Family Code</label></td><td><input type="text" name="code" value=""></td></tr>
          <tr><td><label class='rosForm' for="careDate">Select Care Date</label></td><td><input class='rosForm' type="date" name="careDate" value=""></td></tr>
          <tr><td><input type='submit' name='get_date_fam' value="see day"></td></tr>
        </table>
      </form>
  UGH;

}
echo "</div></article>";
require "../includes/footer.php";
?>
