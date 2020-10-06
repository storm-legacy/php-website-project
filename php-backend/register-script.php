<?php
$REG_PAGE = "../../index.php?page=register";
$LOGIN_PAGE = "../../index.php?page=login";

if(isset($_POST['register-submit'])) {

  // * DATABASE connection
  require("database-conn.php");

  // * GET FIELDS 
  $username = $_POST['username'];
  $email = $_POST['email'];
  $passwd_1 = $_POST['passwd_1'];
  $passwd_2 = $_POST['passwd_2'];
  $termsOfUsage = $_POST['acceptTerms'];


  // * ERROR CHECK 
  //region errorcheck
  $errorMsg = "";

  //CHECK FOR EMAIL ERRORS:
  if(empty($email)) {
    $errorMsg .= "eE#"; //[e]mail [E]MPTY
    $email = "";
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMsg .= "eI#"; //[e]mail [I]NVALID
    $email = "";
  }

  //CHECK FOR USERNAME ERRORS
  if(empty($username)) {
    $errorMsg .= "uE#"; //[u]sername [E]MPTY
    $username = "";
  }
  else if(!preg_match("/^[a-zA-Z0-9]{4,30}$/", $username)) { // only A-z and 0-9 at lest 4 no more than 30
    $errorMsg .= "uI#"; //[u]sername [I]NVALID
    $username = "";
  } 

  //PASSWORD VALIDATION
  if (empty($passwd_1) || empty($passwd_2))
    $errorMsg .= "pE#"; // [p]assword [E]MPTY
  else if($passwd_1 !== $passwd_2)
    $errorMsg .= "pM#"; // [p]assword [M]ISSMATCH
  else if(!preg_match("/^(?=^.{8,50}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?![.\n]).*$/", $passwd_1)) // [8-50] letters at least one: number, uppercase, lowercase, '\n' prohibited
    $errorMsg .= "pI#"; // [p]assword [I]nvalid

  //TERMS OF USAGE ACCEPTED
  if(empty($termsOfUsage)) {
    $errorMsg .= "tD#"; // [t]erms DENIED
  }

  // return errors
  if(!empty($errorMsg)) {
    mysqli_close($connection); //disconnect from database
    header("Location: $REG_PAGE&error=$errorMsg&email=$email&username=$username"); //! fields errors
    exit();
  }
    //IN CASE OF NO ERRORS CONTINUE

  // ! sum hard to understand code ahead

  //QUERY FOR CHECKING EXISTING USERS AND EMAILS
  $sqlQueryUsername = "SELECT id_user FROM users WHERE user_username=?"; //check if user or email exist in database
  $sqlQueryEmail = "SELECT id_user FROM users WHERE user_email=?"; //check if user or email exist in database

  // ? CHECK FOR FOR EXISTING USERNAMES
  $stmt = mysqli_stmt_init($connection); //add connection to $statement

  //In case of problems return to screen with 'sqlerror'
  if(!mysqli_stmt_prepare($stmt, $sqlQueryUsername)) {
    //inform about error
    mysqli_stmt_close($stmt); //disconnect from database
    mysqli_close($connection);
    header("Location $REG_PAGE&error=sqlerr");  //! error 'sqlerr'
    exit();
  //Execute if everything is in order
  } else {

    mysqli_stmt_bind_param($stmt, "s", $username); // replace '?' with username and email
    mysqli_stmt_execute($stmt); //execute searching
    mysqli_stmt_store_result($stmt); //store reading reasult inside '$stmt'

    $foundRows = mysqli_stmt_num_rows($stmt); // number of matching rows
    if($foundRows > 0) {
      $errorMsg .= "uT#"; // ! error 'uT' [u]ser [T]AKEN
      $username = "";
    }
  }

  // ? CHECK FOR EXISTING EMAILS
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $sqlQueryEmail)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    header("Location $REG_PAGE&error=sqlerr");  //! error 'sqlerr'
    exit();

  } else {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $foundRows = mysqli_stmt_num_rows($stmt);
    if ($foundRows > 0){
      $errorMsg .= "eT#"; // ! error 'eT' [e]mail [T]AKEN
      $email = "";
    }
  }

  // ? IN CASE OF RECURSION
  if(!empty($errorMsg)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    header("Location: $REG_PAGE&error=$errorMsg&email=$email&username=$username"); 
    exit();
  }

  //endregion errorcheck
  
  // * ADD USER TO DATABASE
  //region adduser
  $sqlQueryInsert = "INSERT INTO users (user_username, user_email, user_password)  VALUES (?, ?, ?)";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $sqlQueryInsert)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    header("Location: $REG_PAGE&error=sqlerr&username=$username&email=$email");
    exit();

  } else {
    $encryptedPasswd = password_hash($passwd_1, PASSWORD_BCRYPT); //password encryption
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $encryptedPasswd);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    header("Location: $LOGIN_PAGE&regstatus=success");
    exit();
  }
  //endregion adduser
  
  
  //return to login if opend from browser
} else {
  header("Location: $REG_PAGE");
  exit();
}