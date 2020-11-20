<a href="../db/logout.php">Logout</a>
<article class="homeMain">
<nav>
  <ul>
    <li><button class="homeButton" id="home" type="button" name="home">Home</button></li>
    <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
    <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
    <?php
    if ($_SESSION['sessionRole']== 1) {
    echo "<li><button class='homeButton' id='newRole' type='button' name='newRoleForm'>Create New Role</button></li>";
    }
    ?>
    <li><button class="homeButton" id="ros" type="button" name="rosterForm">Create Roster</button></li>
    <li><a class="buttonLink" href="../views/viewRoster.php" class="homeButton">View Roster</a></li>
    <script defer src="../js/homePage.js" type="text/javascript"></script>
  </ul>
</nav>
<div id="home_page_content" class="homeContent">
  <div id="home_div" class="homeForm">
    <h3>This is the home page</h3>
  </div>
  <form id="userStatus" class="homeForm" action="../db/approve.php" method="post">
    <label for="approval">Select User Status</label>
    <select id="approval" class="" name="approval">
      <option value=3>Pending Approval</option>
      <option value=1>Approved</option>
      <option value=0>Deactivated</option>
    </select>
    <button class="homeButton" type="submit" name="submit">View Users</button>
  </form>
  <?php
  if ($_SESSION['sessionRole']== 1) {

  require "../db/db.php";
  echo "<div id='role_list'><h2>Portal Roles</h2>";
  $sql3 = "SELECT * FROM role_security;";
  $stmt3 = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt3,$sql3)){
    echo "There was an error with the server 1.";
    echo "<br/>";
    echo "<a href='../index.php'>Go back</a>";
    exit();
  } else {
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    echo "<table class='data-table'><tr class='data-heading'>";
    echo "<td>position id</td><td>role     </td><td>security level</td></tr>";
    while ($row3 = mysqli_fetch_array($result3)) {
      echo '<tr class="table-data">';
      echo "<td>".$row3['position_id']."</td><td>".$row3['position']."</td><td>".$row3['sec_level']."</td></tr>";
    }
    echo "</table></div>";
    mysqli_stmt_close($stmt3);
  }
  echo <<< "ROLE"
  <form id="newRoleForm" class="homeForm" action="../db/new_role.php" method="post">
    <label for="newPosName">Create New Role</label>
    <input type="text" name="newPosName" placeholder="New Role Name">
    <label for="secLevel">Set Access/Permissions Level</label>
    <select name="secLevel">
      <option value="">Set Level</option>
      <option value=6>6</option>
      <option value=5>5</option>
      <option value=4>4</option>
      <option value=3>3</option>
      <option value=2>2</option>
      <option value=1>1</option>
    </select>
    <button class="homeButton" type="submit" name="roleSubmit">Add Role</button>
  </form>
  ROLE;
  }
  ?>
  <form id="employeeList" class="homeForm" action="../db/employees.php" method="post">
      <label for="regSelect">View Employees By Position</label>
      <?php
      require "../db/db.php";

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
      echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button>";
      echo "</form>";
      }

      echo <<< "ROSTER"
        <form id="newRoster" class="homeForm" action="../db/roster.php" method="post">
        <h2>Create Daily Roster</h2>
        <label class='rosForm' for="careDate">Care Date</label>
        <input class='rosForm' type="date" name="careDate" value="">

        ROSTER;

        require "../db/db.php";

        function empDropdown ($positionID, $name, $display){
          require "../db/db.php";
          $sql = "SELECT u.id, u.first_name, u.last_name, e.emp_id FROM users u LEFT JOIN  employees e on u.id = e.user_id WHERE u.position_id = ? AND u.status =1";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt,$sql)){
            echo "There was an error with the server 1.";
            echo "<br/>";
            echo "<a href='../index.php'>Go back</a>";
            exit();
          } else {
            mysqli_stmt_bind_param($stmt,"i", $positionID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            echo "<select class='rosForm' id=".$name." name=".$name.">";
            echo "<option>Select ".$display."</option>";
            while ($row = mysqli_fetch_array($result)) {
              echo "<option value =".$row['id'].">Emp ID:".$row['emp_id']."   ".$row['first_name']." ".$row['last_name']."</option>";
            }
            echo "</select>";
            mysqli_stmt_close($stmt);
          }
        }

        echo "<label class='rosForm' for='supervisor'>Supervisor</label>";
        $positionID = 2;
        $name = 'supervisor';
        $display = "Supervisor";
        empDropdown($positionID, $name, $display);

        echo "<label for='doctor'>Doctor</label>";
        $positionID = 3;
        $name = 'doctor';
        $display = "Doctor";
        empDropdown($positionID, $name, $display);

        echo "<label for='care1'>Caregiver 1</label>";
        $positionID = 4;
        $name ='care1';
        $display = 'Caregiver 1';
        empDropdown($positionID, $name, $display);

        echo "<label for='care2'>Caregiver 2</label>";
        $positionID = 4;
        $name ='care2';
        $display = 'Caregiver 2';
        empDropdown($positionID, $name, $display);

        echo "<label for='care3'>Caregiver 3</label>";
        $positionID = 4;
        $name ='care3';
        $display = 'Caregiver 3';
        empDropdown($positionID, $name, $display);

        echo "<label for='care4'>Caregiver 4</label>";
        $positionID = 4;
        $name ='care4';
        $display = 'Caregiver 4';
        empDropdown($positionID, $name, $display);

        echo "<button class='homeButton' type='submit' name='rosSubmit'>Add Roster</button></form>";
         ?>
