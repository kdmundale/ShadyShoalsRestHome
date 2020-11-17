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
    }

  }
  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";
  require "../includes/ASMenu.php";

  echo "<form id='employeeList' class='homeForm' action='../db/employees.php' method='post'>";
  echo "<label for='empList'>View employees </label>";
  $sql2 = "SELECT position FROM role_security WHERE sec_level < 5;";
  $stmt2 = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt2,$sql2)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    echo "<a href='../index.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    echo "<select id='roleSelect' class='regSelect' name='position'>";
    echo "<option>Select Position</option>";
    echo "<option id='allPos' value='allPos'>All Positions</option>";
    while ($row2 = mysqli_fetch_array($result2)) {
      echo "<option id=".$row2['position']." value =".$row2['position'].">" . $row2['position'] . "</option>";
    }
    echo "</select>";
    mysqli_stmt_close($stmt2);
  echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button></form>";

  }

  echo "<h1 style='margin-top:20px;'></h1>";
  echo '<table class="data-table">
          <tr class="data-heading">';  //initialize table tag
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
    <form id="editSal" class="empEdit" action="edit_salary.php" method="post">
    <label for="empID">Employee ID</label>
    <input type="number" name="empID" placeholder="Emp ID"></input>
    <label for="empSal">Employee Salary</label>
    <input type="number" name="empSal" placeholder="New Salary"></input>
    <button id="salSub" class="homeButton" type="submit" name="salSubmit">Change Salary</button>
    </form>
    EMP;
  }
  echo <<< "NEW2"
  </div>
  </section>
  NEW2;
  require "../includes/footer.php";


?>
