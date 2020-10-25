<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/php/config.php'); //download confiuration


if(isset($_SESSION['id_user'])) {
  if(!isset($_GET['page']))
    $_GET['page'] = 'home';
    
  //check for logout link
  if(isset($_GET['page']) && $_GET['page'] == "logout")
    header("Location: php/logout.php");

  else if ($_GET['page'] == 'admin-cpanel') 
    require(get_template_path('cpanel'));

  else
    require(get_template_path('main'));


//if user is not registered
} else {

  if(!isset($_GET['page']) || ($_GET['page'] != "register" && $_GET['page'] != "login")) {
    $_GET['page'] = 'login';
  }

  require(get_template_path('login'));
  
}