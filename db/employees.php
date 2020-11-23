<?php
  require 'db.php';
  require "../includes/head.php";
  require "../includes/header.php";
  session_start();


if ((isset($_POST['empSubmit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)) {

  $empSelect = $_POST['position'];

  if ($empSelect!="allPos"){
    $sql = "SELECT u.id, r.position,u.first_name, u.last_name,u.email, u.phone, u.dob, e.salary
    FROM role_security r
    LEFT JOIN users u on u.position_id = r.position_id
    LEFT JOIN employees e on u.id = e.user_id
    WHERE u.status = 1
    AND r.position = ?";
    $all_property = array();  //declare an array for saving property
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $empSelect);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
    }

  } elseif ($empSelect == "allPos") {
    $sql = "SELECT u.id, r.position,u.first_name, u.last_name,u.email, u.phone, u.dob, e.salary
    FROM role_security r
    LEFT JOIN users u on u.position_id = r.position_id
    LEFT JOIN employees e on u.id = e.user_id
    WHERE u.status = 1
    AND r.position NOT IN ('Patient', 'Family Member')";
    $all_property = array();  //declare an array for saving property
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $empSelect = "All Positions";
    }

  }
  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";
  require "../includes/ASMenu.php";

  echo "<section id='empInfo'>";
  echo "<table class='data-table'>";
  echo "<thead><tr><th colspan='8'>".$empSelect."</th></tr></thead>";
  echo "<tr class='data-heading'>";  //initialize table tag
  while ($property = mysqli_fetch_field($result)) {
      echo "<td>" . $property->name."</td>";  //get field name for header
      array_push($all_property, $property->name);  //save those to array
  }
  echo "<td></td>";
  // echo "<td style='font-size:18; font-weight:bold'> change </td>";
  echo '</tr>'; //end tr tag
  //showing all data
  while ($row = mysqli_fetch_array($result)) {
      echo '<tr class="table-data">';
      foreach ($all_property as $item) {
        echo "<td>" . $row[$item] . "</td>"; //get items using property value
      }
      echo "</tr>";
  }
  echo "</table>";
  mysqli_stmt_close($stmt);
  }
  if ($_SESSION['sessionRole']==1){
    echo <<< "EMP"
    <br/>
    <form id="editSal" class="empEdit" action="" method="post">
    <label for="empID">Employee ID</label>
    <input type="number" name="empID" placeholder="Emp ID"></input>
    <label for="empSal">Employee Salary</label>
    <input type="number" name="empSal" placeholder="New Salary"></input>
    <button id="salSub" class="homeButton" type="submit" name="salSubmit">Change Salary</button>
    </form>
    EMP;

    if ((isset($_POST["salSubmit"])) && ($_SESSION['sessionRole']== 1)) {

      $empID = $_POST['empID'];
      $empSalary = $_POST['empSal'];

      $sql = "UPDATE employees SET salary = ? WHERE user_id = ?";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an issue updating the table.";
        echo "<br/>";
        echo "<a href='approve.php'>Go back</a>";
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "ii", $empSalary, $empID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        // header('Location: '.$_SERVER['REQUEST_URI']);
        echo "<h1>Success! The salary has been changed.</h1>";
        echo "<button style='font-sixe: 20px; padding: 5px; margin-bottom:80px' id='go-back'>Go back!</button>";
        echo "<script>document.getElementById('go-back').addEventListener('click', () => {history.back();});</script>";
      }
    }
  }
echo "</section>";

echo <<< "NEW2"

</div>
</article>
NEW2;
require "../includes/footer.php";


?>
