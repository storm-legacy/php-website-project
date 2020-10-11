<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../styles/login.css">
  <script src="../../scripts/functions.js"></script>
  <?php
    if($_GET['page'] == "login") 
      echo("<script src=\"../scripts/login-page.js\"></script>");

    else if($_GET['page'] == "register") 
      echo("<script src=\"../scripts/register-page.js\"></script>");
  ?>
  <title><?php print_name(); ?>: <?php echo strtoupper($_GET['page'])  ?></title>
</head>
<body>
  <header>
    <div class="logo noselect">
      <span><?php echo(get_name(1)."<i>".get_name(2)."</i>"); ?></span>
    </div>
  </header>

  <main>
    <?php
      if($_GET['page'] == "login") 
        print_content('login');

      else if($_GET['page'] == "register") 
        print_content('register');
    ?>
  </main>

  <footer>
    <div class="footerGrid">
      <div class="left">

      </div>
      <div class="middle">
        <span><?php echo(get_config('name')."© by ".get_config('author')); ?></span>
      </div>
      <div class="right">

      </div>
    </div>
  </footer>
</body>
</html>