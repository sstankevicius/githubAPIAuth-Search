<?php

require 'init.php';

fetchData();
if (!isset($_SESSION['user'])){
    header("location: index.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="margin-top: 200px; text-align: center;">
    <div>
        <?php var_dump($_SESSION['payload']) ?>
        <a href="logout.php">Log Out</a>
    </div>
</body>
</html>
