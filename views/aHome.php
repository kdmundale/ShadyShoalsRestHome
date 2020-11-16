<?php
  require "../includes/head.php";
  require "../includes/header.php";
 ?>
  <h1>Welcome, admin!</h1>
  <a href="../db/logout.php">Logout</a>
  <section class="homeMain">
  <nav>
    <ul>
      <li><button class="homeButton" id="reg" type="button" name="registratin">Registration</button></li>
      <li><button class="homeButton" id="emp" type="button" name="employee">Employee Information</button></li>
      <li><button class="homeButton" id="newRole" type="button" name="newRoleForm">Employee Information</button></li>
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
      <label for="empList">View employees </label>
      <select id="empSelect" class="" name="empSelect">
        <option value="Administrator">Admin</option>
        <option value="Supervisor">Supervisor</option>
        <option value="Doctor">Doctor</option>
        <option value="Caregiver">Caregiver</option>
        <option value="All">All</option>
      </select>
      <button class="homeButton" type="submit" name="empSubmit">View Employees</button>
    </form>
  </div>
  </section>
 <?php
   require "../includes/footer.php"
  ?>
