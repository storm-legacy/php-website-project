<?php 
  //Variables
  require("init-variables.php");


// ------------------------------------------------ \\
//                  CONFIGURATION
// ------------------------------------------------ //
  const CONF = [
    "name" => "KitcatTube",
    "author" => "storm-legacy",
  ];

  //Menu definition referencing CONTENT_FILES array
  // "reference_name" => ["button_name", "icon from FA4"]
  const MENU = [
    "browse" => ["", "fa-eye"],
    "upload" => ["", "fa-arrow-up"]
  ];

  //MAIN WEBPAGE TEMPLATES
  const TEMPLATES_FILES = [
    "template" => TEMPLATES_FOLDER."template.php",
    "login-template" => TEMPLATES_FOLDER."login-template.php",
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
    "home" => CONTENT_FOLDER."home.phtml",
    "browse" => CONTENT_FOLDER."browse.php",
  ];

// ------------------------------------------------------------------ \\
//                           DANGER ZONE
// ------------------------------------------------------------------ //
  function print_name() {
    echo(CONF['name']);
  }

  function print_author() {
    echo(CONF['author']);
  }

  function get_config($key) {
    return CONF[$key];
  }

  // * GET PATH FILE TO LOGIN TEMPLATE
  function get_login_template_path() {
    return isset(TEMPLATES_FILES['login-template']) ? TEMPLATES_FILES['login-template'] : null;
  }

  // * GET PATH FILE TO TEMPLATE
  function get_template_path() {
    return isset(TEMPLATES_FILES['template']) ? TEMPLATES_FILES['template'] : null;
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

  // * GENEREATE EACH MENU ITEM
  function generate_menu() {
    //class needed for js menu tab coloring
    foreach(MENU as $key => $items)
      echo("<li><a href=\"?page=$key\" class=\"$key\"><i class=\"fa $items[1]\"></i> $items[0]</a></li>");
  }

  // function create_menu() {

  // }