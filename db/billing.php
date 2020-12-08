<?php
require "../includes/head.php";
require "../includes/header.php";
require "../db/db.php";

echo "<h1>Patient Billing</h1>";

if (isset($_POST['sub_payment'])){

  $amt_paid = (int)$_POST['amt_paid'];
  $pat_id = (int)$_POST['pat_id'];
  $paid = (int)$_POST['paid'];
  $grand_total = (int)$_POST['grand_total'];

  $total_payments = $amt_paid + $paid;

  $sql = "UPDATE patients SET total_due =?, total_paid=?
          WHERE pat_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "iii", $grand_total, $total_payments, $pat_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}


echo "<article class='homeMain'>";
if (isset($_POST['pat_id_doc'])){

  $pat_id = (int)$_POST['pat_id'];

  $sql= "SELECT p.pat_id, u.first_name, u.last_name
          FROM users u
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
      $full_name = $row['first_name']." ".$row['last_name'];
      $pat_id = $row['pat_id'];
    }
    mysqli_stmt_close($stmt);
  }
}

echo <<<"FORM"
  <div id="home_page_content" class="homeContent">
  <form id="pat_billing_id" class="homeForm" action="" method="post">
    <label for="pat_id">Patient ID</label>
    <input type="number" name="pat_id" value="">
    <input type="submit" name="pat_id_doc" value="Get Patient">
  </form>
  <form id="create_appt" class="homeForm" action="" method="post">
FORM;

if (isset($full_name)){
  echo "<h2>Billing for: ".$full_name."</h2>";

  echo "<table class='data-table'>";

  $now = new DateTime();
  $today = date_format($now, 'Y-m-d');

  $sql="SELECT DATEDIFF(?, admission) as days
        FROM patients
        WHERE pat_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "si", $today, $pat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_array($result)) {
      if($row['days']) {
        $days = $row['days'];
        echo "<tr><td>Days</td><td>";
        echo $days."</td>";
        $total_days_billing = $days * 10;
        echo "<td>Total:</td><td> $".$total_days_billing."</td></tr>";

    } else {
      echo "<tr><td>Patient has not been admitted yet.</td></tr>";
    }
    mysqli_stmt_close($stmt);
}
}
$sql="SELECT COUNT(*) as total
      FROM appointments
      WHERE pat_id = ?
      AND seen = 1";
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
    if($row['total']) {
      $total_appts = $row['total'];
      echo "<tr><td>Appointments</td><td>";
      echo $total_appts."</td>";
      $total_appts_billing = $total_appts * 50;
      echo "<td>Total:</td><td> $".$total_appts_billing."</td></tr>";

  } else {
    echo "<tr><td>Patient has not been seen.</td><tr>";
  }
  mysqli_stmt_close($stmt);

}
}
$sql="SELECT COUNT(morn_med) as total_morn,
      COUNT(aft_med) as total_aft,
      COUNT(night_med) as total_night
      FROM appointments
      WHERE pat_id = ?
      AND seen = 1";
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
    if($row['total_morn']) {
      $morn = $row['total_morn'];
      echo "<tr><td>AM meds</td><td>";
      echo $morn."</td></tr>";
    } else {
      echo "<tr><td colspan='2'>no AM meds</td></tr>";
    }
    if($row['total_aft']) {
      $aft = $row['total_aft'];
      echo "<tr><td>PM meds</td><td>";
      echo $aft."</td></tr>";
    } else {
      echo "<tr><td colspan='2>No PM meds</td></tr>";
    }
    if($row['total_night']) {
      $night = $row['total_night'];
      echo "<tr><td>Night meds</td><td>";
      echo $night."</td></tr>";
    } else {
      echo "<tr><td colspan='2'>No Night meds</td></tr>";
    }
    $total_meds = ($morn + $aft + $night) * 5;
    echo "<tr><td></td><td></td><td>total meds:</td><td> $".$total_meds."</td></tr></table>";
  mysqli_stmt_close($stmt);

  $grand_total = $total_meds+$total_days_billing+$total_appts_billing;
  echo "<h2> Total Billing: $".$grand_total."</h2>";

}
}
$sql= "SELECT total_paid
        FROM patients
        WHERE pat_id = ?";
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
    $paid = $row['total_paid'];
    echo "Amount Paid: $".$paid;
  }
  $owed= $grand_total - $paid;
  echo "<h2>Total Owed: $".$owed."</h2>";
  mysqli_stmt_close($stmt);
}
}

echo<<< "FORM"
    <label for="amt_paid">Payment Amount</label>
    <input type="number" min="0.01" step="0.01" name="amt_paid" placeholder="0.00">
    <input type="hidden" name="pat_id" value="$pat_id">
    <input type="hidden" name="paid" value="$paid">
    <input type="hidden" name="grand_total" value="$grand_total">
    <input type="submit" name="sub_payment" value="Submit Payment">


FORM;
echo "</form>";




echo "</div></article>";
require "../includes/footer.php";
 ?>
