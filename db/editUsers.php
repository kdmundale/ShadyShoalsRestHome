<?php
require 'db.php';
session_start();
if ((isset($_POST['submit'])) && ($_SESSION['sessionRole']==1 || $_SESSION['sessionRole']==2)){

  $approved = $_POST['approve'];
  $ids= $_POST['ids'];

  print_r($approved);
  print_r($ids);

}

 ?>
