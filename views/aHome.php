<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";
  session_start();

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  require "../includes/ASMenu.php";

  echo "</div>";
  echo "</article>";

  require "../includes/footer.php";

  ?>
