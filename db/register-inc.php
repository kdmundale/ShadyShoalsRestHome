<?php
if(isset($_POST['submit'])){
 require 'db.php';

 $regRole = $_POST['regRole'];
 $fName = trim($_POST['fName']);
 $lName = trim($_POST['lName']);
 $email = trim($_POST['email']);
 $phone = trim($_POST['tel']);
 $DOB = $_POST['DOB'];
 $password = trim($_POST['password']);
 $confirmPass = trim($_POST['confirmPass']);
 $famCode = $_POST['famCode'];
 $emCon = trim($_POST['emCon']);
 $patRel = trim($_POST['patRel']);
 $now = new DateTime();
 $givenDOB = new DateTime($DOB);

 if (empty($fName)||(empty($lName))||(empty($email))||(empty($phone))||(empty($DOB))||empty($password)||empty($confirmPass)){
   echo "One or more fields were left empty.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } elseif (is_numeric($phone) == 0 ) {
   echo "Please make sure the phone number is a valid number with numeric digits only.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } elseif ($regRole == 5 && (!preg_match("/^[0-9]*/", $famCode)) && strlen($famCode)!=6) {
   echo "Check to make sure the family code was a valid 6 digit number.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } elseif ($givenDOB > $now) {
   echo "The date of birth was invalid.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } elseif (strpos($email, '@')== false) {
   echo "The email wasn't valid.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } elseif ($password !== $confirmPass) {
   echo "Passwords did not match.";
   echo "<br/>";
   echo "<a href='../register.php'>Go back</a>";
   exit();
 } else {
   $sql = "SELECT email FROM users WHERE email = ?;";
   $stmt = mysqli_stmt_init($conn);
   if(!mysqli_stmt_prepare($stmt,$sql)){
     echo "There was a problem checking the email.";
     echo "<br/>";
     echo "<a href='../register.php'>Go back</a>";
     exit();
   } else {
     mysqli_stmt_bind_param($stmt,"s",$email);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_store_result($stmt);
     $rowCount = mysqli_stmt_num_rows($stmt);
     mysqli_stmt_close($stmt);

     if ($rowCount> 0) {
       echo "That email already has an account";
       echo "<br/>";
       echo "<a href='../register.php'>Go back</a>";
       exit();
     } else {
       $sql = "INSERT INTO users (role, first_name, last_name, email, phone, dob, pass) VALUES (?,?,?,?,?,?,?)";
       $stmt = mysqli_stmt_init($conn);
       if(!mysqli_stmt_prepare($stmt,$sql)){
         echo "There was a problem inserting the data.";
         echo "<br/>";
         echo "<a href='../register.php'>Go back</a>";
         exit();
      } else {
        $hashedpass =password_hash($password,PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt,"issssss",$regRole, $fName, $lName, $email, $phone, $DOB, $hashedpass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($regRole == 5) {
          $sql = "SELECT id FROM users WHERE email = ?";
          $stmt = mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt,$sql)){
            echo "There was an issue finding pat_id 1.";
            echo "<br/>";
            echo "<a href='../register.php'>Go back</a>";
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            if ($row = mysqli_fetch_assoc($res)) {
              $pat_id = $row['id'];
              echo "BANG!!!!!!!!!!",$pat_id;
              $sql = "INSERT INTO patients (pat_id, family_code, emergency_contact, emergency_contact_relation) VALUES (?,?,?,?)";
              $stmt = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was a problem with inserting patient information.";
                echo "<br/>";
                echo "<a href='../register.php'>Go back</a>";
                exit();
              } else {
               mysqli_stmt_bind_param($stmt, "isss", $pat_id, $famCode, $emCon, $patRel);
               mysqli_stmt_execute($stmt);
               mysqli_stmt_close($stmt);
               header("Location: ../index.php?success=registered");
               exit();
          }
        } else {
          echo "There was an issue finding pat_id 1.";
          echo "<br/>";
          echo "<a href='../register.php'>Go back</a>";
        }
      }
    } else {
      echo "You have been registered!";
      echo "<a href='../index.php'>Log In!</a>";
    }
   }
 }

}
}
mysqli_close($conn);
}
?>
