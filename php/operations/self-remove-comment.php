<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }

  $commentID = htmlentities($_POST['commentID']);

  if(empty($commentID)) {
    print(0);
  }
  
  require("../modules/db.php");
  $db = new Database();
  $db->query("DELETE FROM comments WHERE id_comment=?", $commentID);
  $db->close();
  print(1);
