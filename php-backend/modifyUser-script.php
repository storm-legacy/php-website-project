<?php 
  if(isset($_POST['send'])) {
    require("database-conn.php");
    session_start();

    $tmpFolder = "../tmp/";
    $destFolder = "../usr_files/avatars";

    $title = empty($_POST['title']) ? $_SESSION['title'] : $_POST['title'];
    $email = empty($_POST['email']) ? $_SESSION['email'] : $_POST['email'];
    $confirmEmail = empty($_POST['confirmEmail']) ? $_SESSION['email'] : $_POST['confirmEmail'];

    $id_user = $_SESSION['id_user'];

    $errorMsg = "";

    //Check if at lest one field is filled corectly
    if($title == null && $email == null)
      $errorMsg .= "etE";
    else {
      if($email != null)
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
          $errorMsg .= "eI^";
        else if($email != $confirmEmail)
          $errorMsg .= "eM";

      if($title != null)
        if(!preg_match("/^[a-zA-Z0-9_ ]{4,60}$/", $title))
          $errorMsg .= "tI";
    }

    if (!empty($errorMsg)) {
      $connection->close();
      header("Location: ../index.php?page=profile&error=$errorMsg&email=$email");
      exit();
    }

    $SQL = "UPDATE users as u, usersInfo as ui SET u.user_email=?, ui.title=? WHERE u.id_user=ui.id_user AND u.id_user=$id_user;";

    $connection->autocommit(FALSE);
    $stmt = $connection->stmt_init();
    if(!$stmt->prepare($SQL)) {
      $connection->close();
      header("Location: ../index.php?page=profile&error=sqlerr");
      exit();
    }

    $stmt->bind_param("ss", $email, $title);

    $stmt->execute();
    $connection->commit();

    $connection->close();


    $_SESSION['title'] = $title;
    $_SESSION['email'] = $email;

    header("Location: ../index.php?page=profile&success=true");
    exit();



  } else {
    header("Location: ../index.php?page=home");
    exit();
  }
  