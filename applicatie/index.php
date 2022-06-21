<?php
$title = 'Fletnix';
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('./pages/modules/head.php'); ?>

<body>
    <?php require_once('./pages/modules/navbar.php'); ?>
    <main id="grid-body">
        <?php
        include('./html/carousel.html');
        ?>
    </main>

    <?php require_once('html/svg.html') ?>
</body>

</html>