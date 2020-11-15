<?php
  require "includes/head.php";
  require "includes/header.php";
 ?>

    <h1>Login</h1>
    <p>Don't have a login? <a href="register.php">REGISTER</a></p>
    <form class="login" action="db/login-inc.php" method="post">
      <label class="regLabel" for="email">Email</label>
      <input class="loginInput" autocomplete="email" type="text" name="email" placeholder="Email">
      <label class="regLabel" for="password">Password</label>
      <input class="loginInput" type="password" autocomplete="current-password" name="password" placeholder="Password">
      <button class="loginButton" type="submit" name="submit">Login</button>
    </form>
    <p class="homeP">Welcome to Shady Shoals</p>
<?php
  require "includes/footer.php";
 ?>
