<?php
  if(isset($_POST['login-submit'])) {

    require('./modules/auth.php');

    $usermail = htmlentities($_POST['usermail']);
    $passwd = htmlentities($_POST['passwd']);

    $login = new Login($usermail, $passwd);
    
    //Check for fields emptiness
    if(!$login->check()) {
      header("Location: ../index.php?page=login&usermail=$usermail&error=".$login->err);
      exit();
    }
    
    //Try to login
    if(!$login->login()) {
      header("Location: ../index.php?page=login&error=".$login->err);
      exit();
    } else {

      //start session if everything is in order
      try {
        $login->start_session();
      } catch (Exception $e) {
        echo $e->getMessage();
      } finally {
        header("Location: ../index.php");
        exit();
      }
    }

  } else {

    header("Location: ../index.php?page=login");
    exit();
  }


