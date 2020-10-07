<?php
  //Return from file if user is not signed in
  if(!isset($_SESSION['id_user'])) {
    header("Location: ../../index.php?page=login");
    exit();
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo(get_config('name')); ?> | <?php echo(strtoupper($_GET['page'])); ?></title>
  <link rel="stylesheet" href="../../styles/main.css">
  <link rel="stylesheet" href="../../styles/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="../../scripts/functions.js"></script>
  <script src="../../scripts/main.js"></script>
</head>
<body>
  <div class="mainGrid">

    <header>
      <span class="submenu-button-header fa fa-bars"></span>
      <div class="logo">
        <a href="?page=home"><span>Kitcat<i>Tube</i></span></a>
      </div>
      <form action="../../php-backend/logout-script.php" method="POST">
        <input type="submit" name="logut-submit" value="Logout">
      </form>
      <nav>
        <ul class="menu">
          <?php
            generate_menu();
          ?>
        </ul>
      </nav>
    </header>

    <div class="middleGrid">
      <div class="submenu">
        <aside>

        </aside>
      </div>
      <div class="content">
        <main>

        </main>
      </div>
    </div>

    <footer>
      <div class="footerGrid">
        <div class="firstOne">
        </div>
        <div class="middle">
          <span>© by <?php echo(get_config('author')); ?></span>
        </div>
        <div class="lastOne">
        </div>
      </div>
    </footer>
  </div>
</body>
</html>

