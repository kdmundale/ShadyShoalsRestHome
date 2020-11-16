<?php
  require "includes/head.php";
  require "includes/header.php";
  require "db/db.php"
 ?>
    <h1>Register</h1>
    <p>Already have a login? <a href="index.php">LOGIN</a></p>
    <p>Please fill out all fields.</p>

    <form class="register" action="db/register-inc.php" method="post">
      <label class="regLabel" for="regSelect">Login Role</label>
      <?php
      $sql = "SELECT * FROM role_security";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error with the server 1.";
        echo "<br/>";
        echo "<a href='../index.php'>Go back</a>";
        exit();
      } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        echo "<select id='roleSelect' class='regSelect' name='regRole'>";
        echo "<option>Select Position</option>";
        while ($row = mysqli_fetch_array($result)) {
          echo "<option id=".$row['position']." value =".$row['position'].">" . $row['position'] . "</option>";
        }
      }
       ?>
      <script defer src="js/regDropDn.js" type="text/javascript"></script>
      <label class="regLabel" for="fName">First Name</label>
      <input class="regInput" type="text" name="fName" placeholder="First Name">

      <label class="regLabel" for="lName">Last Name</label>
      <input class="regInput" type="text" name="lName" placeholder="Last Name">

      <label class="regLabel" for="email">Email</label>
      <input class="regInput" type="text" name="email" placeholder="Email">

      <label class="regLabel" for="phone">Phone Number (digits ONLY)</label>
      <input class="regInput" type="text" name="tel" placeholder="Phone Number">

      <label class="regLabel" for="DOB">Date of Birth</label>
      <input class="regInput" type="date" name="DOB" placeholder="Date of Birth">
      <div id="patInfo">
        <label class="regLabel" for="famCode">Family Code - 6 Digits</label>
        <input class="regInput" type="number" name="famCode" placeholder="6 Digit Family Code">
        <label class="regLabel" for="emCon">Emergency Contact</label>
        <input class="regInput" type="text" name="emCon" placeholder="Emergency Contact Name">
        <label class="regLabel" for="patRel">Relationship to Patient</label>
        <input class="regInput" type="text" name="patRel" placeholder="Relationship">
      </div>
      <label class="regLabel" for="password">Password</label>
      <input class="regInput" type="password" name="password" placeholder="Password">

      <label class="regLabel" for="confirmPass">Confirm Password</label>
      <input class="regInput" type="password" name="confirmPass" placeholder="Confirm Password">
      <button class="regButton" type="submit" name="submit">Register</button>
    </form>

    <p class="homeP">Upon completing this form, your registration will be sent for approval.
    Check your email for notification!</p>

<?php
  require "includes/footer.php";
 ?>
