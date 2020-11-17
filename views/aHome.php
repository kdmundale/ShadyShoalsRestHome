<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
echo <<< "HOME"
    <h1>Welcome, admin!</h1>
    <a href="../db/logout.php">Logout</a>
    <section class="homeMain">
    <nav>
      <ul>
        <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
        <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
        <li><button class="homeButton" id="newRole" type="button" name="newRoleForm">Create New Role</button></li>
        <li><a class="navLink" href="">Patients</a></li>
        <script defer src="../js/homePage.js" type="text/javascript"></script>
      </ul>
    </nav>
    <div id="home_page_content" class="homeContent">
      <form id="userStatus" class="homeForm" action="../db/approve.php" method="post">
        <label for="approval">Select User Status</label>
        <select id="approval" class="" name="approval">
          <option value=3>Pending Approval</option>
          <option value=1>Approved</option>
          <option value=0>Deactivated</option>
        </select>
        <button class="homeButton" type="submit" name="submit">View Users</button>
      </form>
      <br/>
      <form id="employeeList" class="homeForm" action="../db/employees.php" method="post">
        <form class="register" action="db/register-inc.php" method="post">
          <label class="regLabel" for="regSelect">View Employees By Position</label>
HOME;
        $sql = "SELECT position FROM role_security WHERE sec_level < 5;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
          echo "There was an error with the server 1.";
          echo "<br/>";
          echo "<a href='../index.php'>Go back</a>";
          exit();
        } else {
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          echo "<select id='roleSelect' class='regSelect' name='position'>";
          echo "<option>Select Position</option>";
          echo "<option id='allPos' value='allPos'>All Positions</option>";
          while ($row = mysqli_fetch_array($result)) {
            echo "<option id=".$row['position']." value =".$row['position'].">" . $row['position'] . "</option>";
          }
          echo "</select>";
        echo "<button class='homeButton' type='submit' name='empSubmit'>View Employees</button></form>";

        }
        echo "</div>";
        echo "</section>";

         require "../includes/footer.php"
  ?>
