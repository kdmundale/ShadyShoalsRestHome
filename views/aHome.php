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
      <li><a class="navLink" href="">Roster</a></li>
      <li><a class="navLink" href="">Patients</a></li>
      <script defer src="../js/homePage.js" type="text/javascript"></script>
    </ul>
  </nav>
  <div id="home_page_content" class="homeContent">
    <form id="userStatus" class="" action="../db/approve.php" method="post">
      <label for="approval">View all users who are </label>
      <select id="approval" class="" name="approval">
        <option value=0>Not Approved</option>
        <option value=1>Approved</option>
      </select>
      <button class="homeButton" type="submit" name="submit">View Users</button>
    </form>
    <form id="employeeList" class="" action="" method="post">
      <label for="empList">View employees </label>
      <select id="approval" class="" name="approval">
        <option value=1>Admin</option>
        <option value=2>Supervisor</option>
        <option value=3>Doctor</option>
        <option value=4>Caregiver</option>
        <option value=8>All</option>
      </select>
      <button class="homeButton" type="submit" name="submit">View Employees</button>
    </form>
  </div>
  </section>
 <?php
   require "../includes/footer.php"
  ?>
