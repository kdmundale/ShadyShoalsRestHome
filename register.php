<?php
  require "includes/head.php";
  require "includes/header.php";
 ?>
    <h1>Register</h1>
    <p>Already have a login? <a href="index.php">LOGIN</a></p>
    <p>Please fill out all fields.</p>

    <form class="register" action="" method="post">
      <label class="regLabel" for="regSelect">Login Role</label>
      <select id="roleSelect" class="regSelect" name="regRole">
        <option value="6">Family Member</option>
        <option id="patRole" value="5">Patient</option>
        <option value="4">Doctor</option>
        <option value="3">Caregiver</option>
        <option value="2">Supervisor</option>
        <option value="1">Administrator</option>
      </select>
      <script defer src="js/regDropDn.js" type="text/javascript"></script>
      <label class="regLabel" for="fName">First Name</label>
      <input class="regInput" type="text" name="fName" placeholder="First Name">

      <label class="regLabel" for="lName">Last Name</label>
      <input class="regInput" type="text" name="lName" placeholder="Last Name">

      <label class="regLabel" for="email">Email</label>
      <input class="regInput" type="text" name="email" placeholder="Email">

      <label class="regLabel" for="phone">Phone Number</label>
      <input class="regInput" type="phone" name="tel" placeholder="Phone Number">

      <label class="regLabel" for="DOB">Date of Birth</label>
      <input class="regInput" type="date" name="DOB" placeholder="Date of Birth">
      <div id="patInfo">
        <label class="regLabel" for="DOB">Family Code - 6 Digits</label>
        <input class="regInput" type="number" name="famCode" placeholder="6 Digit Family Code">
        <label class="regLabel" for="DOB">Emergency Contact</label>
        <input class="regInput" type="text" name="emCon" placeholder="Emergency Contact Name">
        <label class="regLabel" for="DOB">Relationship to Patient</label>
        <input class="regInput" type="text" name="patRel" placeholder="Relationship">
      </div>
      <label class="regLabel" for="password">Password</label>
      <input class="regInput" type="password" name="password" placeholder="Password">

      <label class="regLabel" for="confirmPass">Confirm Password</label>
      <input class="regInput" type="password" name="confirmPpass" placeholder="Confirm Password">
      <button class="regButton" type="submit" name="submit">Login</button>
    </form>

    <p class="homeP">Upon completing this form, your registration will be sent for approval.
    Check your email for notification!</p>

<?php
  require "includes/footer.php"
 ?>
