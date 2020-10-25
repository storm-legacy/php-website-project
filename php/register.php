<?php
  require('modules/auth.php');

  $username = htmlentities($_POST['username']);
  $email = htmlentities($_POST['email']);
  $password = htmlentities($_POST['passwd_1']);
  $confirmPassword = htmlentities($_POST['passwd_2']);
  $termsOfUse = isset($_POST['acceptTerms']) ? htmlentities($_POST['acceptTerms']) : null;

  $register = new Register($username, $email, $password, $confirmPassword, $termsOfUse);

  if($register->check()) {
    
    try {
      $register->register();
    } catch (exception $e) {
      die("Database insertion problem ".$e->getMessage());
      exit();

    } finally {
      header("Location: ../index.php?page=login&regstatus=success");
      exit();

    }

  } else {
    header("Location: ../index.php?page=register&error=".$register->err);
    exit();
  }
