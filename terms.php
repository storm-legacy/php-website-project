<?php
  require("php-backend/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo(get_config("name")) ?> | Terms of Use</title>
  <link rel="stylesheet" href="styles/terms.css">
  
</head>
<body>
  <?php

    print_content("terms-of-use");

  ?>
</body>
</html>