<?php
  require 'db.php';
  require "../includes/head.php";
  require "../includes/header.php";
  session_start();
if ((isset($_POST['empSubmit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)) {

  $empSelect = $_POST['empSelect'];

  if ($empSelect!="All"){
    $sql = "SELECT u.id, u.first_name, u.last_name,u.email, u.phone, u.dob, e.salary, e.group_id
    FROM users u, employees e
    WHERE u.id = e.emp_id
    AND status = 1
    AND position = ?";
    $all_property = array();  //declare an array for saving property
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "i", $empSelect);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
    }

  }
  echo <<< "NEW"
  <h1>Welcome, admin!</h1>
  <a href="../db/logout.php">Logout</a>
  <section class="homeMain">
  <nav>
    <ul>
      <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
      <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
      <li><a class="navLink" href="">Roster</a></li>
      <li><a class="navLink" href="">Patients</a></li>
      <script defer src="../js/homePage.js" type="text/javascript"></script>
    </ul>
  </nav>
  <div id="home_page_content" class="homeContent">
    <form id="userStatus" class="" action="../db/approve.php" method="post">
      <label for="approval">View all users who are </label>
      <select id="approval" class="" name="approval">
        <option value=3>Pending Approval</option>
        <option value=1>Approved</option>
        <option value=0>Deactivated</option>
      </select>
      <button class="homeButton" type="submit" name="submit">View Users</button>
    </form>
    <form id="employeeList" class="homeForm" action="../db/employees.php" method="post">
      <label for="empList">View employees </label>
      <select id="empSelect" class="" name="empSelect">
        <option value=1>Admin</option>
        <option value=2>Supervisor</option>
        <option value=3>Doctor</option>
        <option value=4>Caregiver</option>
        <option value=8>All</option>
      </select>
      <button class="homeButton" type="submit" name="empSubmit">View Employees</button>
    </form>
  NEW;
  echo "<h1 style='margin-top:20px;'>".$pageTitle."</h1>";
  echo '<table class="data-table">
          <tr class="data-heading">';  //initialize table tag
  while ($property = mysqli_fetch_field($result)) {
      echo "<td>" . $property->name . '</td>';  //get field name for header
      array_push($all_property, $property->name);  //save those to array
  }
  echo "<td></td>";
  // echo "<td style='font-size:18; font-weight:bold'> change </td>";
  echo '</tr>'; //end tr tag
  //showing all data
  while ($row = mysqli_fetch_array($result)) {
      echo '<tr class="table-data"><form action="editUsers.php" method="post">';
      foreach ($all_property as $item) {
        $newId = $row['id'];
        echo "<td>" . $row[$item] . "</td>"; //get items using property value
      }
      // echo "<td><select id='approval' name='approve[]'><option value=''>Action</option><option value='approve'>Approve</option><option value='deactivate'>Deactivate</option><input id='userId' name='ids[]' type='hidden' value=".$newId."></td>";
      echo "</tr>";
  }
  echo "</table>";
  }
  if ($_SESSION['sessionRole']==1){
    echo <<< "EMP"
    <br/>
    <form id="editSal" class="empEdit" action="..db/edit_salary.php" method="post">
    <label for="empId">Employee ID</label>
    <input type="number" name="empID" placeholder="Emp ID"></imput>
    <label for="empSal">Employee Salary</label>
    <input type="number" name="empSal" placeholder="New Salary"></imput>
    <button class="homeButton" type="submit" name="salSubmit">Change Salary</button>
    </form>
    <br/>
    <form id="empGroupEdit" class="empEdit" action="..db/edit_emp_group.php" method="post">
    <label for="empId">Employee ID</label>
    <input type="number" name="empID" placeholder="Emp ID"></imput>
    <label for="empSal">Employee Group</label>
    <input type="number" name="empGroup" placeholder="New Group"></imput>
    <button class="homeButton" type="submit" name="salSubmit">Change Group</button>
    </form>
    EMP;
  } elseif ($_SESSION['sessionRole'] == 2) {
  echo <<< "EMP2"
    <form id="empGroupEdit" class="empEdit" action="..db/edit_emp_group.php" method="post">
    <label for="empId">Employee ID</label>
    <input type="number" name="empID" placeholder="Emp ID"></imput>
    <label for="empSal">Employee Group</label>
    <input type="number" name="empGroup" placeholder="New Group"></imput>
    <button class="homeButton" type="submit" name="grpSubmit">Change Group</button>
    </form>
    EMP2;
  }
  echo <<< "NEW2"
  </div>
  </section>
  NEW2;
  require "../includes/footer.php";


?>
