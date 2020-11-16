<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }
  require('../modules/init.php');

  $edits['title'] = htmlentities($_POST['title']);

  $edits['username'] = htmlentities($_POST['username']);
  
  $edits['email'] = htmlentities($_POST['email']);
  $edits['confirmEmail'] = htmlentities($_POST['confirmEmail']);

  $edits['passwd'] = htmlentities($_POST['passwd']);
  $edits['confirmPasswd'] = htmlentities($_POST['confirmPasswd']);

  $edits['avatar'] = $_FILES['avatar_img'];

  $operations = [];
  $proceed = FALSE;
  foreach($edits as $edit => $value) {
    if(!empty($value)) {
      $proceed = TRUE;
      $operations[$edit] = TRUE;
    }
  }

  //cancel operations if no edits needed
  if(!$proceed) {
    print(0); //return false for no operations
    exit();
  }
  const TITLE_REGEX = "/^[a-zA-Z0-9 _]{4,30}$/";
  const USERNAME_REGEX = "/^[a-zA-Z0-9]{4,30}$/";
  const PASSWD_REGEX = "/^(?=^.{8,50}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?![.\n]).*$/";
  const ALLOWED_IMG_FORMATS = ['png', 'jpeg', 'jpg'];

  
  $user_id = $_SESSION['id_user'];
  
  require('../modules/db.php');
  $db = new Database();
  
  //Print error info and end script
  function err($string = '0') {
    global $db;
    print($string);
    $db->close();
    exit();
  }

  //Inform about success and exit
  function success() {
    global $db;
    print(1);
    $db->close();
    exit();
  }

  //only one needed at the time
  //EDIT TITLE
  if(isset($operations['title']) && $operations['title'] == TRUE) {
    if(preg_match(TITLE_REGEX, $edits['title'])) 
      if($db->query('UPDATE usersInfo SET title=? WHERE id_user=?', $edits['title'], $user_id)) {
        $_SESSION['title'] = $edits['title'];
        success();

      } else {
        err();
      }
    else {
      err('Prohibited characters in title!');
    } 

  //EDIT USERNAME
  } else if (isset($operations['username']) && $operations['username'] == TRUE) {
    if(preg_match(USERNAME_REGEX, $edits['username']))
      if($db->query('SELECT id_user FROM users WHERE user_username=?', $edits['username'])) {
        $db->store_result();
        if($db->num_rows() > 0) {
          err('Username taken!');

        } else {
          if($db->query('UPDATE users SET user_username=? WHERE id_user=?', $edits['username'], $user_id)) {
            $_SESSION['username'] = $edits['username'];
            success();
            
          } else {
            err();
          }
        }

      } else {
        err();
      }
    else {
      err('Prohibited characters in title!'); 
    }
    

  //EDIT EMAIL
  } else if (isset($operations['email']) && $operations['email'] == TRUE && isset($operations['confirmEmail']) && $operations['confirmEmail'] == TRUE) {
    if($edits['email'] == $edits['confirmEmail']) {
      if(filter_var($edits['email'], FILTER_VALIDATE_EMAIL)) {
        if($_SESSION['email'] == $edits['email']) {
          err('Email have not changed!');
        } else {
          $db->query('SELECT id_user FROM users WHERE user_email=?', $edits['email'])->store_result();
          if($db->num_rows() > 0) {
            err('Email already taken!');
          } else {
            if($db->query('UPDATE users SET user_email=? WHERE id_user=?', $edits['email'], $user_id)) {
              $_SESSION['email'] = $edits['email'];
              print(1);
              exit();
            } else {
              err();
            }
          }
        }
      } else {
        err('Invalid email!');
      }
    } else {
      err('Emails are mismatched!');
    }

  } else if (isset($operations['passwd']) && $operations['passwd'] == TRUE && isset($operations['confirmPasswd']) && $operations['confirmPasswd'] == TRUE) {
    // echo $edits['passwd'];
    // echo ' ';
    // echo $edits['confirmPasswd'];
    if($edits['passwd'] == $edits['confirmPasswd']) {
      if(preg_match(PASSWD_REGEX, $edits['passwd'])) {
        $encryptedPasswd = password_hash($edits['passwd'], PASSWORD_BCRYPT);
        $db->query('UPDATE users SET user_password=? WHERE id_user=?', $encryptedPasswd, $user_id);
        success();
      } else {
        err('Wrong password pattern!');
      }
    } else {
      err('Password mismatch!');
    }

  } else if (isset($operations['avatar']) && $operations['avatar'] == TRUE){
    $avatar = $edits['avatar'];
    $avatar['extension'] = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
    //CHECK FILE
    //format of displaying
    if(!in_array($avatar['extension'], ALLOWED_IMG_FORMATS)) {
      err('User can only use PNG or JPG format');
    }
    //check if file isn't too large
    if(filesize($avatar['tmp_name']) > 512000000) {
      err('File is too large!');
    }

    if($db->justQuery('SELECT avatar_code as code FROM avatarsFiles ORDER BY id_avatar DESC LIMIT 1')) {
      $db->store_result();
      if($db->num_rows() == 1) {
        $result = $db->fetchRow();
        $i = 1;
        do {
          $avatar['code'] = intval($result['code']) + $i++;
          $avatar['code'] = strval($avatar['code']);
          $length = strlen($avatar['code']);
          for($i = 8; $i > $length; $i--) {
            $avatar['code'] = '0' . $avatar['code'];
          }
          $avatar['destination'] = AVATARS_FOLDER . $avatar['code'] . '.' . $avatar['extension'];
        } while(file_exists($avatar['destination']));
        
        if($db->query('INSERT INTO avatarsFiles(avatar_code, file_extension) VALUES (?, ?)', $avatar['code'], $avatar['extension'])) {
          move_uploaded_file($avatar['tmp_name'], $avatar['destination']);
        } else {
          err('Could not add avatar to database!');
        }

        if($db->query('SELECT id_avatar as id FROM avatarsFiles WHERE avatar_code=?', $avatar['code'])) {
          $db->store_result();
          if($db->num_rows() == 1) {
            $result = $db->fetchRow();
            $avatar['id'] = $result['id'];
          } else 
            err('Duplicated or missing codes!');
        }

        $getAvatarImageSQL ='
          SELECT
            CONCAT(a.avatar_code, ".", a.file_extension) as "avatar_img"
          FROM
            users as u
            INNER JOIN usersInfo as ui ON u.id_user=ui.id_user
            INNER JOIN avatarsFiles as a ON ui.avatar_id=a.id_avatar
          WHERE u.id_user=?';

        if($db->query('UPDATE usersInfo SET avatar_id=? WHERE id_user=?', $avatar['id'], $_SESSION['id_user'])) {
          $db->query($getAvatarImageSQL, $_SESSION['id_user'])->store_result();
          $_SESSION['avatar_img'] = $db->fetchRow()['avatar_img'];
          success();
        } else {
          err('Could not update user profile. Please try again later.');
        }


      } else {
        err('Missing avatars!');
      }
    } else {
      err();
    }
    

  } else {
    err();
  }


  //EDIT PASSWORD