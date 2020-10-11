<?php

session_start(); //beacause session must be started
session_unset(); //delete active session variables
session_destroy(); //stop session
header("Location: ../../index.php"); //return to login screen