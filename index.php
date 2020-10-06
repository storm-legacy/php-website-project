<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'].'/php-backend/config.php'); //download confiuration


if(isset($_SESSION['id_user'])) {
  require(get_template_path());


//if user is not registered
} else {

  if($_GET['page'] != "register" && $_GET['page'] != "login")
    $_GET['page'] = 'login';

  require(get_login_template_path());
  
}