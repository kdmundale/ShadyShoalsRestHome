<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
  session_start();

  if ((isset($_POST['careSubmit'])) && ($_SESSION['sessionRole'] < 5)){

    $DOC = $_POST['careDate'];

    $sql = "SELECT supervisor_id, doctor_id, caregiver1_id, caregiver2_id, caregiver3_id, caregiver4_id FROM roster where care_date = ?";
    $stmt = mysqli_stmt_init($conn);
    $ids = array();
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"s", $DOC);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($property = mysqli_fetch_field($result)) {
        array_push($ids, $property->name);  //save those to array
      }
      mysqli_stmt_close($stmt);
  }
}

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  echo <<< "VIEW"
  <form class="homeForm" action="" method="post">
    <label for="careDate">Date of Care</label>
    <input type="date" name="careDate">
    <button class="homeButton" type="submit" name="careSubmit">View Date</button>
    </form>
  VIEW;

  function getFullName ($id){
    require "../db/db.php";
    $sql = "SELECT  first_name, last_name FROM users WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt,"i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_array($result)) {
        echo $row['first_name']." ".$row['last_name'];
        echo "<br>";
      }
      mysqli_stmt_close($stmt);
    }
  }

  if (isset($ids)){
    $viewDate = date("M j, Y", strtotime($DOC));
    echo "<table class='data-table'><tr class='data-heading'>";
    echo "<thead><tr><th colspan='7'>".$viewDate."</th></tr></thead>";
    echo "<td>Supervisor</td><td>Doctor</td><td>Cargiver 1</td><td>Cargiver 2</td><td>Cargiver 3</td><td>Cargiver 4</td></tr>";

    while ($row = mysqli_fetch_array($result)) {
      echo '<tr class="table-data">';
      foreach ($ids as $id){
        echo "<td>";
        getFullName($row[$id]);
        echo "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}

  require "../includes/footer.php";

  ?>
