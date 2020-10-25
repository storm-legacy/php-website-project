<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  class Database {

    private $conn;
    private $stmt;
    public $query_count = 0;
    public $query_closed = TRUE;
    private $autocommit = TRUE;
    private $show_errors = TRUE;
    private $connection_closed = FALSE;
    private $result_stored = false;

    function __construct ($host='mysql',$user='root',$passwd='root',$db="cloneTube", $charset="utf8") {
      $this->conn = new mysqli($host, $user, $passwd, $db)
      or die('Could not connect to MySQL database' . $conn-> connect_error);
      $this->conn->set_charset($charset);
    }

    function __destruct () {
      if(!$this->connection_closed) {
        $this->conn->close();
      }
    }

    public function query($sqlQuery) {
      if(isset($this->result))
        unset($this->result);

      if($this->stmt = $this->conn->prepare($sqlQuery)) {
        $args = array_slice(func_get_args(), 1);
				$types = '';
        $args_ref = [];
        foreach ($args as $key => &$value) {
          $types .= $this->_gettype($value);
          $args_ref[] = &$value;
        }
        array_unshift($args_ref, $types); //insert $types before array
        call_user_func_array(array($this->stmt, 'bind_param'), $args_ref); //execute function and pass arguments

        $this->stmt->execute();
        
        if($this->stmt->errno) {
          $this->error('Unable to process mysql query (check your params) - ' . $this->stmt->error);
        }


        $this->query_closed = FALSE;
        $this->query_count++;
      } else
        $this->error('Unable to prepare MySQL statement (check your syntax) - '. $this->conn->error);
        
      return $this;
    }
    
    public function setAutocommit($tf) {
      $this->autocommit = $tf;
      $this->conn->autocommit($tf);
    }

    public function commit() {
      $this->conn->commit();
      $this->_stmtClose();
    }

    public function store_result() {
      $this->result = $this->stmt->get_result();
      $this->_stmtClose();
    }

    public function fetchRow() {
      $arr = [];

      if($this->result->num_rows < 1)
        return null;
      else
        if($arr = $this->result->fetch_assoc())
          return $arr;
        else
          return null;
    }

    public function fetchAll() {
      $arr = [];

      if($this->result->num_rows < 1)
        return null;
      else
        if($arr = $this->result->fetch_all(MYSQLI_ASSOC))
          return $arr;
        else
          return null;
    }

    public function num_rows() {
      return $this->result->num_rows;
    }

    function _gettype($var) {
    
      if (is_string($var)) return 's';
	    if (is_float($var)) return 'd';
	    if (is_int($var)) return 'i';
	    return 'b';
    }

    public function close() {
      $this->connection_closed = TRUE;
      $this->conn->close();
    }

    function _stmtClose() {
      $this->stmt->close();
      $this->query_closed = TRUE;
      $this->query_count = 0;
    }

    public function error($error) {
      if ($this->show_errors) {
        exit($error);
      }
    }
  }