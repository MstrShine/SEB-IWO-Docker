<?php
require_once('./php/session.php');

$title = "Fletnix";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo ($title) ?></title>
    <meta name="author" content="Mstr.Shine">

    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/carousel.css">
    <link rel="stylesheet" href="./styles/variables.css">
</head>

<body>
    <?php require_once('./pages/modules/navbar.php'); ?>
    <main id="grid-body">
        <?php
        if (isset($_SESSION['loggedIn'])) {
            include('./html/carousel.html');
        } else {
            include_once('./pages/login.php');
        }
        ?>
    </main>

    <?php require_once('html/svg.html') ?>
</body>

</html>