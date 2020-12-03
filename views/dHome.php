<?php
  require "../includes/head.php";
  require "../includes/header.php";
  require "../db/db.php";

  echo "<h1>Welcome, ".$_SESSION['userName']."</h1>";

  echo<<<"DOC"
    <article class="homeMain">
      <nav>
        <ul>
          <li><button class='homeButton' id='doc_home'>welcome</button></li>
          <li><button class='homeButton' id='appt'>appointments</button></li>
          <li><a class="buttonLink" href="../views/viewRoster.php" class="homeButton">View Roster</a></li>
          <li><a class="buttonLink" href="../db/patients.php" class="homeButton">Patient<br>Search</a></li>
        </ul>
      </nav>
      <div id="home_page_content" class="homeContent">;
  DOC;

  echo "</div></article>";
  require "../includes/footer.php"
  ?>
