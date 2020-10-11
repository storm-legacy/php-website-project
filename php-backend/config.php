<?php 
  //Variables
  require("init-variables.php");

// ------------------------------------------------ \\
//                  CONFIGURATION
// ------------------------------------------------ //
  const CONF = [
    "name" => ["Kitcat", "Tube"],
    "author" => "storm-legacy",
  ];

  //Menu definition referencing CONTENT_FILES array
  // "reference_name" => ["button_name", "icon from FA4"]
  const SUBMENU = [
    "profile" => ["Profile", "fa-user"],
    "browse" => ["Browse", "fa-eye"],
    "upload" => ["Upload", "fa-arrow-up"]
  ];

  //MAIN WEBPAGE TEMPLATES
  const TEMPLATES_FILES = [
    "main" => TEMPLATES_FOLDER."main.php",
    "login" => TEMPLATES_FOLDER."login.php",
    "cpanel" => TEMPLATES_FOLDER."cpanel.php"
  ];
  
  //Content to be placed inside templates
  const CONTENT_FILES = [
    // ! ONLY TO BE USED with login-template
    "login" => CONTENT_FOLDER."login.phtml",
    "register" => CONTENT_FOLDER."register.phtml",
    "terms-of-use" => CONTENT_FOLDER."terms-of-use.phtml",
    
    // * ERROR PAGES
    "404" => ERRORS_FOLDER."404.phtml",
    
    // * OTHER PAGES
    "upload" => CONTENT_FOLDER."upload.phtml",
    "home" => CONTENT_FOLDER."home.phtml",
    "browse" => CONTENT_FOLDER."browse.php",
    "video" => CONTENT_FOLDER."video.php"
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
    //check if specified
    $page_tmp = isset(CONTENT_FILES[$page]) ? CONTENT_FILES[$page] : "404";
    //check if file corelated with page exists
    if(file_exists($page_tmp))
      echo(file_get_contents($page_tmp));
    else
      echo(file_get_contents(CONTENT_FILES['404']));
  }

  function generate_submenu() {
    foreach (SUBMENU as $key => $value) {
      echo("<li><a class=\"$key\" href=\"?page=$key\"><i class=\"fa $value[1]\"></i>$value[0]</a></li>");
    }

    //CHECK IF USER IS ADMINISTRATOR
    if($_SESSION['admin'] == true)
      echo("<li><a class=\"admin-cpanel\" href=\"?page=admin-cpanel\"><i class=\"fa fa-gear\"></i> Admin CPanel</a></li>");
  }

  // * SESSION PRINT
  function print_userTitle() {
    echo isset($_SESSION['title']) ? $_SESSION['title'] : $_SESSION['username'];
  }

  function print_username() {
    echo isset($_SESSION['username']) ? '@'.$_SESSION['username'] : '@null';
  }