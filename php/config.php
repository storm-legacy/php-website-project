<?php 
  //Variables
  require("modules/init.php");

// ------------------------------------------------ \\
//                  CONFIGURATION
// ------------------------------------------------ //
  const CONF = [
    "name" => ["Kitcat", "Tube"],
    "author" => "storm-legacy",
  ];

  //MAIN WEBPAGE TEMPLATES
  const TEMPLATES_FILES = [
    "main" => TEMPLATES_FOLDER."main.php",
    "login" => TEMPLATES_FOLDER."login.php",
    "cpanel" => TEMPLATES_FOLDER."cpanel.php"
  ];

  const ERROR_FILES = [
    404 => ERRORS_FOLDER."404.phtml",
  ];
  
  //Content to be placed inside templates
  const CONTENT_FILES = [
    // ! ONLY TO BE USED with login-template
    "login" => SUBPAGES_FOLDER."login.phtml",
    "register" => SUBPAGES_FOLDER."register.phtml",
    "terms-of-use" => SUBPAGES_FOLDER."terms-of-use.phtml",
    
    //Normal pages
    "browse" => SUBPAGES_FOLDER."browse.phtml",
  ];

  const DYNAMIC_PAGES = [
    "video" => SUBPAGES_FOLDER."video.php",
    "profile" => SUBPAGES_FOLDER."profile.php",
    "upload" => SUBPAGES_FOLDER."upload.php",
    "profile-edit" => SUBPAGES_FOLDER."profile-edit.php"
  ];

// ------------------------------------------------------------------ \\
//                           DANGER ZONE
// ------------------------------------------------------------------ //

  function print_name() {
    echo(CONF['name'][0].CONF['name'][1]);
  }

  function get_name($part) {
    $part -= 1;
    return isset(CONF['name'][$part]) ? CONF['name'][$part] : null;
  }

  function get_author() {
    return isset(CONF['author']) ? CONF['author'] : null;
  }

  function get_config($key) {
    return isset(CONF[$key]) ? CONF[$key] : null;
  }

  function get_template_path($template) {
    return isset(TEMPLATES_FILES[$template]) ? TEMPLATES_FILES[$template] : null;
  }

  // * PRINT FROM CONTENT_FOLDER TO SITE
  function print_content($page) {

    if(!empty(CONTENT_FILES[$page]) && file_exists(CONTENT_FILES[$page]))
      print(file_get_contents(CONTENT_FILES[$page]));

    else if(!empty(DYNAMIC_PAGES[$page]) && file_exists(DYNAMIC_PAGES[$page]))
      require(DYNAMIC_PAGES[$page]);
      
    else 
      print(file_get_contents(ERROR_FILES['404']));
  }

  function print_error($code) {
    switch($code) {
      case 404:
        file_get_contents(ERROR_FILES[$code]);
      break;
    }
  }

  function generate_submenu() {
    foreach (SUBMENU as $key => $value) {
      echo("<li><a class=\"$key\" href=\"?page=$key\"><i class=\"fa $value[1]\"></i>$value[0]</a></li>");
    }

    //CHECK IF USER IS ADMINISTRATOR
    if($_SESSION['cpanel'] == true)
      echo("<li><a class=\"admin-cpanel\" href=\"?page=admin-cpanel\"><i class=\"fa fa-gear\"></i> Admin CPanel</a></li>");
  }

  // * SESSION PRINT
  function print_title() {
    echo !empty($_SESSION['title']) ? $_SESSION['title'] : $_SESSION['username'];
  }

  function print_username() {
    echo !empty($_SESSION['username']) ? $_SESSION['username'] : 'null';
  }

  function print_avatar() {
    echo $_SESSION['avatar_img'];
  }

  function print_email() {
    echo $_SESSION['email'];
  }

