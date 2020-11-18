<a href="../db/logout.php">Logout</a>
<article class="homeMain">
<nav>
  <ul>
    <li><button class="homeButton" id="home" type="button" name="home">Home</button></li>
    <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
    <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
    <li><button class="homeButton" id="newRole" type="button" name="newRoleForm">Create New Role</button></li>
    <li><button class="homeButton" id="ros" type="button" name="rosterForm">View Roster</button></li>
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
  <form id="newRoleForm" class="homeForm" action="" method="post">
    <label for="newPosName">Create New Role</label>
    <input type="text" name="newPosName" placeholder="New Role Name">
    <label for="secLevel">Set Access/Permissions Level</label>
    <select name="secLevel">
      <option value="">Set Level</option>
      <option value=5>5</option>
      <option value=4>4</option>
      <option value=3>3</option>
      <option value=2>2</option>
      <option value=1>1</option>
    </select>
    <button class="homeButton" type="submit" name="roleSubmit">View Users</button>
  </form>
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
      echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button></form>";

      }
      ?>
