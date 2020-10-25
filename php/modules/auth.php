<?php
  require("db.php");
  //KEYWORDS
  define("USERNAME", 2);
  define("EMAIL", 3);


  const loginSQL ='
    SELECT
      u.id_user,
      u.user_username as "username",
      u.user_email as "email",
      u.user_password as password,
      ui.title as "title",
      CONCAT(a.avatar_code, ".", a.file_extension) as "avatar_img",
      p.cpanel_access as "cpanel",
      p.perm_modifyUsers as "modifyUsers",
      p.perm_modifyVideos as "modifyVideos"
    FROM
      users as u, 
      usersInfo as ui, 
      avatarsFiles as a, 
      usersPermissions as p
    WHERE
      u.id_user=ui.id_user AND
      ui.avatar_id=a.id_avatar AND
      u.id_user=p.id_user AND
      u.user_username=? OR u.user_email=?;';

  // [8-50] letters at least one: number, uppercase, lowercase, '\n' prohibited
  const PASSWD_REGEX = "/^(?=^.{8,50}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?![.\n]).*$/";

  // only A-z and 0-9 at lest 4 no more than 30
  const USERNAME_REGEX = "/^[a-zA-Z0-9]{4,30}$/";

  class Login {
    private $usermail = "";
    private $passwd = "";
    private $data = null;
    public $err = "";
    private $login_status = false;
    private $db;

    function __construct($usermail, $passwd) {
      $this->usermail = $usermail;
      $this->passwd = $passwd;
    }

    //Check if user properly inputed informations
    //RETURNS TRUE / FALSE
    public function check() {
      $errorMsg = "";
      if(empty($this->usermail)) {
        $errorMsg .= "uE^";
        $usermail = "";
      }

      if(empty($this->passwd)) {
        $errorMsg .= "pE^";
      }

      if(!empty($errorMsg)) {
        $this->err = $errorMsg;
        return false;

      } else {
        return true;
      }
    }

    //Try to login with specific credentials
    // return TRUE / FALSE
    public function login() {
      
      $this->db = new Database();
      $this->db->query(loginSQL, $this->usermail, $this->usermail)->store_result();
      $row = $this->db->fetchRow();
      if($row == null || !password_verify($this->passwd, $row['password'])) {
        $this->err = "invalidlogin";
        $this->db->close();
        return false;

      } else {
        $this->db->close();
        $this->data = $row;
        $this->login_status = TRUE;
        return true;
      }
    }

    public function start_session() {
      if($this->login_status) {
        session_start();
        $_SESSION['id_user'] = $this->data['id_user'];
        $_SESSION['username'] = $this->data['username'];
        $_SESSION['email'] = $this->data['email'];
        $_SESSION['avatar_img'] = $this->data['avatar_img'];
        $_SESSION['title'] = $this->data['title'];
  
        //PERMISSIONS
        $_SESSION['cpanel'] = $this->data['cpanel'];
        $_SESSION['modifyUsers'] = $this->data['modifyUsers'];
        $_SESSION['modifyVideos'] = $this->data['modifyVideos'];

      } else {
        $this->err = "invalidlogin";
        $this->close();

        throw new Exception("Login with unauthorized user is prohibited!");
      }
    }
  }

  class Register {
    
    private $db;
    private $username;
    private $email;
    private $passwd;
    private $confirmPasswd;
    public $err;
    private $allow_register = false;

    function __construct($username, $email, $passwd, $confirmPasswd, $termsOfUse) {
      $this->username = $username;
      $this->email = $email;
      $this->passwd = $passwd;
      $this->confirmPasswd = $confirmPasswd;
      $this->termsOfUse = $termsOfUse;
    }

    //RETURN TRUE/FALSE
    //if error occurs insert error to $this->err
    public function check() {
      $errorMsg = "";
      //CHECK FOR EMAIL ERRORS:

      $this->_openDb();

      if(empty($this->email)) {
        $errorMsg .= "eE^"; //[e]mail [E]MPTY
        $email = "";
      } else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "eI^"; //[e]mail [I]NVALID
        $email = "";
      } else if(!$this->_redundancyCheck(EMAIL)){
        $errorMsg .= "eT^"; //[e]mail [I]NVALID
        $email = "";
      }

      //CHECK FOR USERNAME ERRORS
      if(empty($this->username)) {
        $errorMsg .= "uE^"; //[u]sername [E]MPTY
        $username = "";
      }
      else if(!preg_match(USERNAME_REGEX, $this->username)) {
        $errorMsg .= "uI^"; //[u]sername [I]NVALID
        $username = "";
      } else if(!$this->_redundancyCheck(USERNAME)) {
        $errorMsg .= "uT^"; //[u]sername [I]NVALID
        $username = "";
      }

      //PASSWORD VALIDATION
      if (empty($this->passwd) || empty($this->confirmPasswd))
        $errorMsg .= "pE^"; // [p]assword [E]MPTY
      else if($this->passwd !== $this->confirmPasswd)
        $errorMsg .= "pM^"; // [p]assword [M]ISSMATCH
      else if(!preg_match(PASSWD_REGEX, $this->passwd))
        $errorMsg .= "pI^"; // [p]assword [I]nvalid

      //TERMS OF USAGE ACCEPTED
      if(empty($this->termsOfUse)) {
        $errorMsg .= "tD^"; // [t]erms DENIED
      }

      if(!empty($errorMsg)) {
        $this->err = $errorMsg;
        return false;
      } else {
        $this->allow_register = TRUE;
        return true;
      }

      if(empty($errorMsg)) {
        $this->allow_register = TRUE;
        return true;
      } else {
        $this->err = $errorMsg[0]."^".$errorMsg[1]."&username=$username&email=$email";
        $this->_closeDb();
        return false;
      }
    }

    public function register() {
      if($this->allow_register) {
        $encryptedPasswd = password_hash($this->passwd, PASSWORD_BCRYPT);

        $this->db->setAutocommit(FALSE);
        $this->db->query("INSERT INTO users (user_username, user_email, user_password) VALUES (?, ?, ?)", $this->username, $this->email, $encryptedPasswd);
        $this->db->query("INSERT INTO usersPermissions (id_user) VALUES ((SELECT id_user FROM users WHERE user_username=?))", $this->username);
        $this->db->query("INSERT INTO usersInfo (id_user, title) VALUES ((SELECT id_user FROM users WHERE user_username=?), ?)", $this->username, $this->username);
        $this->db->commit();

      } else {
        throw Exception("Registeretion prohibited due to incorrect credentials");
      }
     }

    //false if exists - true if green light
    function _redundancyCheck($item) {
      if($item == USERNAME) {
        $this->db->query("SELECT id_user FROM users WHERE user_username=?", $this->username)->store_result();
        if($this->db->num_rows() > 0)
          return false;
        else
          return true;

      } else if($item == EMAIL) {
        $this->db->query("SELECT id_user FROM users WHERE user_email=?", $this->email)->store_result();
        if($this->db->num_rows() > 0)
          return false;
        else
          return true;
      }

    }

    function _closeDb() {
      $this->db->close();
    }

    function _openDb() {
      $this->db = new Database();
    }
  }

  function logout() {
    session_start(); //beacause session must be started
    session_unset(); //delete active session variables
    session_destroy(); //stop session
    header("Location: ../../index.php"); //return to login screen
  }