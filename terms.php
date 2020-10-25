<?php
  require("php/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php print_name(); ?> | Terms of Use</title>
  <link rel="stylesheet" href="styles/terms.css">
  
</head>
<body>
  <header>
    <div class="logo">
      <span><?php echo(get_name(1)."<i>".get_name(2)."</i/>"); ?></span>
    </div>
  </header>
  <?php

    print_content("terms-of-use");

  ?>
</body>
</html>