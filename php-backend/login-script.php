<?php
$LOGIN_PAGE = "../../index.php?page=login";
$HOME = "../../index.php?page=home";

//CHECK IF USER ACCESSED PAGE VIA PROVIDED FORM
if(isset($_POST['login-submit'])) {

  require('database-conn.php');

  $usermail = $_POST['usermail'];
  $password = $_POST['passwd'];


  // * ERROR CHECK
  $errorMsg = "";
  if(empty($usermail)) {
    $errorMsg .= "uE#";
  }

  if(empty($password)) {
    $errorMsg .= "pE#";
  }

  //Inform user about errors or proceed when none
  if(!empty($errorMsg)) {
    $connection->close();
    header("Location: $LOGIN_PAGE&error=$errorMsg");
    exit();
  }


  // * CHECK FOR CORESPONDING USER OR EMAIL
  // for more info check register script
  $sqlQuery = "SELECT * FROM users WHERE user_username=? OR user_email=?";

  $stmt = mysqli_stmt_init($connection);
  if(!$stmt->prepare($sqlQuery)) {

    $stmt->close();
    $connection->close();
    header("Location: $LOGIN_PAGE&error=sqlerr");
    exit();

  } else {

    $stmt->bind_param("ss", $usermail, $usermail);
    $stmt->execute();

    $result = $stmt->get_result();
    //store results in array or in case of no results close connection
    if($row = $result->fetch_assoc()) {

      //check if passwords are comparable
      if(!password_verify($password, $row['user_password'])) {//returns true if passwords matches
        $result->free();
        $stmt->close();
        $connection->close();
        header("Location: $LOGIN_PAGE&error=invalidlogin");
        exit();

        //store userdata in session
      } else {
        // ? START SESSION AND STORE USER INFORMATIONS
        session_start(); // start session
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['username'] = $row['user_username'];
        $_SESSION['email'] = $row['user_email'];
      }

      
    } else {
      $result->free();
      $stmt->close();
      $connection->close();
      header("Location: $LOGIN_PAGE&error=invalidlogin");
    }

    $result->free();
    $stmt->close();
    $connection->close();
    header("Location: $HOME");
    exit();
  }



} else {
  header("Location: $LOGIN_PAGE");
  exit();
}