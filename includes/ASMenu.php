<article class="homeMain">
<nav>
  <ul>
    <li><button class="homeButton" id="home" type="button" name="home">welcome</button></li>
    <?php
    if($_SESSION['sessionRole']==1){
      echo "<li><button class='homeButton' id='reg' type='button' name='registration'>Registration</button></li>";
    }
     ?>
    <li><button class="homeButton" id="pat_reg" type="button" name="pat_registratin">Patient Registration</button></li>
    <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
    <?php
    if ($_SESSION['sessionRole']== 1) {
    echo "<li><button class='homeButton' id='newRole' type='button' name='newRoleForm'>Create New Role</button></li>";
    }
    ?>
    <li><button class="homeButton" id="ros" type="button" name="rosterForm">Create Roster</button></li>
    <li><a class="buttonLink" href="../views/viewRoster.php" class="homeButton">View Roster</a></li>
    <li><a class="buttonLink" href="../db/patients.php" class="homeButton">Patient Search</a></li>
    <li><button class="homeButton" id="doc_apt" type="button" name="doctor_appt">Create Doc Appointment</button></li>
    <li><a class="buttonLink" href="../db/billing.php" class="homeButton">Billing</a></li>
    <li><a class="buttonLink" href="../db/patient_report.php" class="homeButton">Admin Report</a></li>

    <script defer src="../js/homePage.js" type="text/javascript"></script>
  </ul>
</nav>
<div id="home_page_content" class="homeContent">
  <div id="home_div" class="homeForm">

    <?php
    if ($_SESSION['sessionRole']== 1) {

    require "../db/db.php";
    $sql5 = "SELECT COUNT(*)
            FROM users
            WHERE status IS NULL;";
    $stmt5 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt5,$sql5)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_execute($stmt5);
      $result5 = mysqli_stmt_get_result($stmt5);
      while ($row5 = mysqli_fetch_array($result5)) {
        echo "<h3>".$row5[0]." users awaiting approval</h3>";
      }
      mysqli_stmt_close($stmt5);
    }
    $sql5 = "SELECT COUNT(*)
            FROM employees e
            LEFT JOIN users u
            ON u.id=e.user_id
            WHERE u.status=1
            AND e.salary IS NULL;";
    $stmt5 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt5,$sql5)){
      echo "There was an error with the server 2.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_execute($stmt5);
      $result5 = mysqli_stmt_get_result($stmt5);
      while ($row5 = mysqli_fetch_array($result5)) {
        echo "<h3>".$row5[0]." employess salaries for review</h3>";
      }
      mysqli_stmt_close($stmt5);
    }
  }

    $sql5 = "SELECT COUNT(*)
            FROM patients p
            LEFT JOIN users u
            ON u.id=p.user_id
            WHERE u.status=1
            AND p.admission IS NULL;";
    $stmt5 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt5,$sql5)){
      echo "There was an error with the server 2.";
      echo "<br/>";
      exit();
    } else {
      mysqli_stmt_execute($stmt5);
      $result5 = mysqli_stmt_get_result($stmt5);
      while ($row5 = mysqli_fetch_array($result5)) {
        echo "<h3>".$row5[0]." patients pending admission</h3>";
      }
      mysqli_stmt_close($stmt5);
    }
     ?>
  </div>
  <form id="userStatus" class="homeForm" action="../db/approve.php" method="post">
    <h3>View Users Awaiting Approval / Approved / Deactivated</h3>
    <label for="approval">Select User Status</label>
    <select id="approval" class="" name="approval">
      <option value=3>Pending Approval</option>
      <option value=1>Approved</option>
      <option value=0>Deactivated</option>
    </select>
    <button class="homeButton" type="submit" name="submit">View Users</button>
  </form>
  <form id="pat_reg_form" class="homeForm" action="../views/aHome.php" method="post">
    <?php
    if (($_SESSION['sessionRole']== 1) || ($_SESSION['sessionRole']== 2) ){

    require "../db/db.php";
    $sql4 = "SELECT p.pat_id , u.first_name, u.last_name
              FROM patients p
              LEFT JOIN users u
              ON u.id= p.user_id
              WHERE p.admission IS NULL
              AND u.status =1;";
    $stmt4 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt4,$sql4)){
      echo "There was an error with the server 1.";
      echo "<br/>";
      echo "<a href='../index.php'>Go back</a>";
      exit();
    } else {
      mysqli_stmt_execute($stmt4);
      $result4 = mysqli_stmt_get_result($stmt4);
      echo "<table class='data-table'>";
      echo "<thead><tr><th colspan='3'>Admit Patients</th></tr></thead>";
      echo "<tr class='data-heading'>";
      echo "<td>patient id</td><td>first name</td><td>last name</td></tr>";
      while ($row4 = mysqli_fetch_array($result4)) {
        echo '<tr class="table-data">';
        echo "<td>".$row4['pat_id']."</td><td>".$row4['first_name']."</td><td>".$row4['last_name']."</td></tr>";
      }
      echo "</table>";
      mysqli_stmt_close($stmt4);
    }
    }
    ?>
    <label class="form-label" for="pat_id">Patient ID</label>
    <input class="form-input" type="number" name="pat_id" value="">
    <label class="form-label" for="lName">Patient Last Name</label>
    <input class="form-input" type="text" name="lName" placeholder="Last Name">
    <label class="form-label" for="group">Group</label>
    <select class="form-input" class="" name="group">
      <option value="">Group #</option>
      <option value=1>1</option>
      <option value=2>2</option>
      <option value=3>3</option>
      <option value=4>4</option>

    </select>
    <label class="form-label" for="a_date">Admission Date</label>
    <input class="form-input" type="date" name="a_date" value="">
    <button class="other" type="submit" name="pat_reg_submit">Admit Patient</button>
  </form>
  <?php
  if ($_SESSION['sessionRole']== 1) {

  require "../db/db.php";

  echo "<div id='role_list'>";
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
    echo "<table class='data-table'>";
    echo "<thead><tr><th colspan='3'>Current Roles</th></tr></thead>";
    echo "<tr class='data-heading'>";
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

      echo "<form id='employeeList' class='homeForm' action='../views/aHome.php' method='post'>";
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
        $pat_appt_id = $row['pat_id'];
      }
      mysqli_stmt_close($stmt);
    }
  }
  ?>
    <form id="appt_pat_id" class="homeForm" action="" method="post">
      <label for="pat_id">Patient ID</label>
      <input type="number" name="pat_id" value="">
      <input type="submit" name="pat_id_doc" value="Get Patient">
    </form>
    <form id="create_appt" class="homeForm" action="" method="post">
  <?php
      if(isset($full_name)) {
        echo "<h2>".$full_name."</h2>";
      }
      if(isset($_POST['new_appt'])){

        $doc_id = (int)$_POST['doctor'];
        $appt_date = $_POST['appt_date'];
        $pat_appt_id = (int)$_POST['pat_id'];

        $sql = "INSERT INTO appointments (pat_id, doctor_id, appt_date)
                VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
          echo "There was an error with the server 6.";
          echo "<br/>";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "iis", $pat_appt_id, $doc_id, $appt_date);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
          echo "Appointment has been created.";
        }
      }
  ?>
    <label for="appt_date">Appointment Date</label>
    <input type="date" name="appt_date" value="">
    <?php
    echo "<input type='hidden' name='pat_id' value=".$pat_appt_id.">";
    echo "<label for='doctor'>Doctor</label>";
    $positionID = 3;
    $name = 'doctor';
    $display = "Doctor";
    empDropdown($positionID, $name, $display);
   ?>
    <input type="submit" name="new_appt" value="Create Appointment">
    </form>
