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
    $usermail = "";
  }

  if(empty($password)) {
    $errorMsg .= "pE#";
  }

  //Inform user about errors or proceed when none
  if(!empty($errorMsg)) {
    $connection->close();
    header("Location: $LOGIN_PAGE&error=$errorMsg&usermail=$usermail");
    exit();
  }


  // * CHECK FOR CORESPONDING USER OR EMAIL
  $SQL ='
  SELECT
    u.id_user,
      u.user_username as "username",
      u.user_email as "email",
      u.user_password as password,
      ui.title as "title",
      CONCAT(a.avatar_code, ".", a.file_extension) as "avatar_img",
      p.cpanel_access as "cpanel",
      p.perm_modifyUsers as "modifyUsers",
      p.perm_modifyVideos as "modifyVideos"
  FROM
    users as u, 
      usersInfo as ui, 
      avatarsFiles as a, 
      usersPermissions as p
  WHERE
    u.id_user=ui.id_user AND
      ui.avatar_id=a.id_avatar AND
      u.id_user=p.id_user AND
      u.user_username=? OR u.user_email=?;';

  $stmt = mysqli_stmt_init($connection);
  if(!$stmt->prepare($SQL)) {

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
      if(!password_verify($password, $row['password'])) {//returns true if passwords matches
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
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['avatar_img'] = $row['avatar_img'];
        $_SESSION['title'] = $row['title'];

        //PERMISSIONS
        $_SESSION['cpanel'] = $row['cpanel'];
        $_SESSION['modifyUsers'] = $row['modifyUsers'];
        $_SESSION['modifyVideos'] = $row['modifyVideos'];
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