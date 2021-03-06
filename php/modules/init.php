<?php
  define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/'); //get ROOT folder location
  define('INDEX_FILE', ROOT."/index.php");

  //TEMPLATES FOLDERS
  define('CONTENT_FOLDER', ROOT."content/");
  define('USERS_FILES', ROOT."usr_files/");
  define('TMP', USERS_FILES."tmp/");

  define('TEMPLATES_FOLDER', CONTENT_FOLDER."templates/");
  define("SUBPAGES_FOLDER", CONTENT_FOLDER."subpages/");
  define('ERRORS_FOLDER', CONTENT_FOLDER."errors/");

  define('AVATARS_FOLDER', USERS_FILES."avatars/");
  define('THUMBNAILS_FOLDER', USERS_FILES."thumbnails/");
  define('VIDEOS_FOLDER', USERS_FILES."videos/");
