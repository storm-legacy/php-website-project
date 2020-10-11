<?php
  //if user doesn't have admin rights inform and return to main
  if($_SESSION['admin'] != true) {
    header("Location: ../../index.php?page=home&error=insufficientpermissions");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php print_name(); ?> | ADMIN PANEL</title>
  <link rel="stylesheet" href="../../styles/cpanel.css">
  <link rel="stylesheet" href="../../styles/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="../../scripts/functions.js"></script>
  <script src="../../scripts/cpanel.js"></script>
</head>
<body>
  <header>
    <div class="logo noselect">
      <span><?php echo(get_name(1)."<i>".get_name(2)."</i>"); ?></span>
      <span class="cpanelLogo">CPanel</span>
    </div>

    <!-- <span class="exitButton">
      <a href="?page=home">
        <i class="fa fa-undo"></i>
      </a>
    </span> -->
  </header>

  <aside>
    <ul>
      <li>
        <a href="?page=admin-cpanel&panel=statistics">
          <i class="fa fa-bar-chart"></i> Statistics
        </a>
      </li>
      <li>
        <a href="?page=admin-cpanel&panel=users">
          <i class="fa fa-user"></i> Users
        </a>
      </li>
      <li>
        <a href="?page=admin-cpanel&panel=videos">
          <i class="fa fa-play-circle"></i> Videos
        </a>
      </li>
      <li>
        <a href="?page=home">
          <i class="fa fa-undo"></i> Return
        </a>
      </li>
    </ul>
  </aside>

  <main>

  </main>

  <footer>
  
  </footer>

</body>
</html>