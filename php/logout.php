<?php
  require("modules/auth.php");

  logout();
  header("Location: ../index.php?page=login");
  exit();