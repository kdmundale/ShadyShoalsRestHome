<header>
  <div class="header-box">
    <p class="shadyLogo">Shady Shoals Rest Home</p>
      <?php
        session_start();
        echo "<nav class='nav-bar'><ul class='nav-bar-ul'>";
        if ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2){
        echo "<li><a class='nav-link' href='../views/aHome.php'>Home</a></li>";
        } elseif ($_SESSION['sessionRole']==3){
        echo "<li><a class='nav-link' href='../views/dHome.php'>Home</a></li>";
        } elseif ($_SESSION['sessionRole']==4){
        echo "<li><a class='nav-link' href='../views/cHome.php'>Home</a></li>";
        } elseif ($_SESSION['sessionRole']==5 || $_SESSION['sessionRole']==6) {
        echo "<li><a class='nav-link' href='../views/oHome.php'>Home</a></li>";
        }
        echo "</nav></ul>";
      ?>
  </div>

  <div id="ShadyShoalsBlur">
    <img id="shadyShoals" src="/ShadyShoalsRestHome/images/ShadyShoals.png"
          alt="Photo of Shady Shoals Rest Home in Bikini Bottom">
  </div>

</header>
<body>
